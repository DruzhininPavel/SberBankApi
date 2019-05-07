<?php
    require_once(__DIR__.'/SberBankAPIMain.php');
    class SberBankAPI extends SberBankAPIMain {

        /**
         * @param String $token, [Sting $login, String $password]
         */
        public function __construct($token = false, $login = false, $password = false)
        {
            self::setAuthData($token, $login, $password);
        }

        public function setToken($token)
        {
            $this->token = $token;
        }
        
        public function setLoginPassword($login,$password)
        {
            $this->login = $login;
            $this->password = $password;
        }

        public function setLaguage($language)
        {
            $this->language = $language;
        }
        
        public function getLaguage()
        {
           return $this->language;
        }

        public function setRestMethod($restMethod)
        {
            $this->restMethod = $restMethod;
        }

        public function getRestMethod()
        {
           return $this->restMethod;
        }

        public function setRegisterOrder($data,$test = false)
        {
            return self::sendSBRequest("register.do",$data,$test);
        }

        public function setRegisterOrderPreAuth($data,$test = false)
        {
            return self::sendSBRequest("registerPreAuth.do", $data, $test);
        }

        /**
         * Запрос завершения oплаты заказа
         * Принимаевый параметр:
         * @param $orderId String - номер заказа в системе оплаты
         * @param $amount Int - Сумма возврата в копейках
         */
        public function setDepositOrder($orderId, $amount, $test = false)
        {
            $data = array(
                "orderId" => $orderId,
                "amount" => intval($amount)
            );
            return self::sendSBRequest("deposit.do", $data, $test);
        }

        /**
         * Отмена платежа
         * Принимаевый параметр:
         * @param $orderId String - номер заказа в системе оплаты
         */
        public function setReverseOrder($orderId, $test = false)
        {
            $data = array(
                "orderId" => $orderId
            );
            return self::sendSBRequest("reverse.do", $data, $test);
        }

       /**
         * Возврат средств
         * Принимаевый параметр:
         * @param $orderId String - номер заказа в системе оплаты
         * @param $amount Int - Сумма возврата в копейках
         */
        public function setRfoundOrder($orderId, $amount, $test = false)
        {
            $data = array(
                "orderId" => $orderId,
                "amount" => intval($amount)
            );
            return self::sendSBRequest("refund.do", $data, $test);
        }

        /**
         * Статус заказа
         * Принимаевый параметр:
         * @param $orderId String - номер заказа в системе оплаты
         */        
        public function getOrderStatus($orderId,$test = false)
        {
            $data = array(
                "orderId" => $orderId
            );
            return self::sendSBRequest("getOrderStatus.do",$data,$test);
        }

        /**
         * Расширенный стстус заказа
         * Принимаевый параметр:
         * @param $orderId String - номер заказа в системе оплаты
         */        
        public function getOrderStatusExtended($orderId,$test = false)
        {
            $data = array(
                "orderId" => $orderId
            );
            return self::sendSBRequest("getOrderStatusExtended.do",$data,$test);
        }

        /**
         * Запрос статистики по платежам за период
         * Принимаевый параметр: * обозначены обязательные
         * @param $from String - YYYYMMDDHHmmss - Дата начала периода *
         * @param $to String - YYYYMMDDHHmmss - Дата окончания периода *
         * @param $transactionStates List - В этом блоке необходимо перечислить требуемые состояния заказов. Только заказы, находящиеся в одном из указанных состояний, попадут в отчёт. Несколько значений указываются через запятую.
         *  - Default = 'CREATED,APPROVED,DEPOSITED,DECLINED,REVERSED,REFUNDED'
         * @param $merchants List - Список мерчнтов по котрым нужна статистика, если оставить пустым в статистику попадут все  *
         * @param $page Int - Номер страницы, начинается с 0 Default = 0
         * @param $size Int - Количество итемов на странице, максимально 200 Default = 100
         * @param $searchByCreatedDate Boolean - Сортировка списка по дате создания заказов Default = false
         */       
        public function getLastOrdersForMerchants($from, $to, $transactionStates = 'CREATED,APPROVED,DEPOSITED,DECLINED,REVERSED,REFUNDED', $merchants = '',$page = 0, $size = 100, $searchByCreatedDate = false, $test = false)
        {
            $data = array(
                "from" => $from,
                "to" => $to,
                "transactionStates" => $transactionStates,
                "merchants" => $merchants,
                "page" => $page,
                "size" => $size,
                "searchByCreatedDate" => $searchByCreatedDate
            );

            return self::sendSBRequest("getLastOrdersForMerchants.do",$data,$test);
        }

        /**
         * Запрос проверки вовлечённости карты в 3DS
         * Принимаевый параметр:
         * @param $pan String - номер карты
         */ 
        public function getVerifyEnrollment($pan,$test){
            $data = array(
                "pan" => $pan
            );
            return self::sendSBRequest("verifyEnrollment.do",$data,$test);
        }

        /**
         * Запрос  добавления карты в список SSL-карт
            * Принимаевый параметр:
         * @param $mdorder String - Номера заказа в котором учавствовала карта оплаты
         */ 
        public function updateSSLCardList($mdorder,$test){
            $data = array(
                "mdorder" => $mdorder
            );
            return self::sendSBRequest("updateSSLCardList.do",$data,$test);
        }
    }
