<?php namespace Omnipay\Payture\Message;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest;

class RegisterRequest extends AbstractRequest
{
    /**
     * RegisterRequest constructor.
     * @param ClientInterface $httpClient
     * @param HttpRequest $httpRequest
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);
    }



    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        dd($this->getParameters());
        $data = [
            'Key' => 'Merchant',
            'Amount' => '',
            'PayInfo' => ''
        ];

        /*      curl https://sandbox.payture.com/api/Pay \
      -d Key=Merchant \
          -d Amount=100 \
          -d OrderId=525725426015165144660440452620726054 \
          --data-urlencode "PayInfo= \
      PAN=4111111111111112; \
      EMonth=3; \
      EYear=19; \
      CardHolder=Ivan Ivanov; \
      SecureCode=123; \
      OrderId=525725426015165144660440452620726054; \
      Amount=100;" \
          --data-urlencode "CustomFields = \
      OrderId=7.2.236.72; \
      Product=ticket;" \*/
    }
    public function sendData($data)
    {
        $data = $this->getData();
    }
}