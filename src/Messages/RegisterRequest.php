<?php namespace Omnipay\Payture\Message;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Payture\Message\RegisterResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

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
        $data = [
            'Key' => $this->getParameter('Key'),
            'Data' => $this->getParameter('Data')
        ];

        return $data;
    }

    /**
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface|\Omnipay\Payture\Message\RegisterResponse
     */
    public function sendData($data)
    {
        $objXML = $this->curlTest($data);
        /*$reqest = $this->httpClient->post($this->getParameter('url'));
        $reqest->setBody($data);
        $response = $reqest->send();*/
        dd($objXML);


        $this->response = new RegisterResponse($this, $data);

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

            if($out !== false) {

                $xml = new \SimpleXMLElement($out);

                curl_close($curl);

                return $xml;
            }
            curl_close($curl);

        }

        return false;
    }
}