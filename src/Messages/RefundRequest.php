<?php namespace Omnipay\Payture\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Payture\Message\RefundResponse;


class RefundRequest extends AbstractRequest
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
            'Password' => $this->getParameter('Password'),
            'OrderId' => $this->getParameter('OrderId'),
            'Amount' => $this->getParameter('Amount')
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
        $this->response = new RefundResponse($this, $resultResponse);

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