<?php namespace Omnipay\Payture\Message;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Payture\Message\PaymentResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class PaymentRequest extends AbstractRequest
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
        $data = [
           'SessionId' => $this->getParameter('SessionId')
        ];

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {

        $objHtml = $this->curlTest($data);
        $this->response = new PaymentResponse($this, $objHtml);
        $this->response->redirectTo = $this->getParameter('RedirectUrl');

        return $this->response;
    }
    /**
     * @param array $data
     * @return bool|\SimpleXMLElement
     */
    public function curlTest(array $data)
    {
        $requestData = "";
        foreach($data as $key => $value){
            $requestData .=  $key."=".$value."&";
        }


        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $this->getParameter('url'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);
            $out = curl_exec($curl);



            curl_close($curl);
            return $out;
        }

        return false;
    }
}