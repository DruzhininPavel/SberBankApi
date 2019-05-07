# SberBankApi
Library for SberBank API Methods

This library need for easy to use SberBank Api

# To install:
add to your php file:
require_once('path/to/libs/SberBankAPI/SberBankAPI.php');

# To Use:
add to your php file:

// some code
$sb = new SberBankAPI('<TOKEN>');

$request = array(
  "amount" => intval(<SUM_TO_PAY>),
  "orderNumber" => "<orderNumber>",
  "returnUrl" => "<URL_TO_SUCCESS>",
  "failUrl" => "<URL_TO_FAIL>"
);

$response = $sb->setRegisterOrder($request);

// Do something for response
if($response->formUrl && $response->orderId)
{
  // Order success do redirect user to $response->formUrl for payment
} 
else 
{
  // Parse to $response->errorCode and $response->errorMessage
}
