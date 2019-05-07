<?php
    abstract class SberBankAPIMain {
        
        protected $token = false;
        protected $login = false;
        protected $password = false;
        protected $language = false;
        protected $restMethod = 'GET';

        protected function setAuthData($token = false, $login = false, $password = false){
            $this->token = $token;
            $this->login = $login;
            $this->password = $password;
        }

        protected function sendSBRequest($method, $data, $test = false){
            
            $token = $this->token;
            $login = $this->login;
            $password = $this->password;

            /**
             * Задаем правильный урл для тестового и боевого доступа
             * а так-же метод обращения
             */
            if($test){
                $url = "https://3dsec.sberbank.ru/payment/rest/".$method."?";
            } else {
                $url = "https://securepayments.sberbank.ru/payment/rest/".$method."?";
            }

            $params = '';

            /**
             * Если у нас стоит токен, то ставим токен,
             * В противном случае ставим пароль и логин
             */
            if($token){
                $tokenQuery = "token=$token";
                $params .= $tokenQuery."&";
            } elseif($login && $password){
                $tokenQuery = "userName=$login&password=".urlencode($password);
                $params .= $tokenQuery."&";               
            } else {
                return false;
            }
            
            /**
             * Если проставлен язык, то ставим язык в запросе.
             */
            if($this->language)$params .= "language=".$this->language."&";
            
            $params .= http_build_query($data);
            
            switch($this->restMethod){
                case 'GET':
                    /**
                     * Формируем строку запроса.
                     */
                    $params .= http_build_query($data);
                    return self::RequestSBGet($url.$params);
                    break;
                case 'POST':
                    /**
                     * Формируем строку запроса.
                     */
                    return self::RequestSBPost($url, $params);
                    break;
                default:
                    return false;
                    break;
            }
        }

        private function RequestSBGet($url){
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $responseSB  = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($responseSB);

            return $response;
        }

        private function RequestSBPost($url, $params){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $responseSB  = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($responseSB);

            return $response;           
        }
    }
