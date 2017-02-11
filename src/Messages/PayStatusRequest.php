<?php


namespace Omnipay\Payture\Message;


use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Payture\Message\PayStatusResponse;
use Omnipay\Common\Message\ResponseInterface;

class PayStatusRequest extends AbstractRequest
{

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
            'OrderId' => $this->getParameter('OrderId')
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
        $resultResponse = $this->curlTest($data);
        $this->response = new UnblockResponse($this, $resultResponse);

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