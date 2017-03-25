<?php


namespace Omnipay\Payture\Message;


use Omnipay\Payture\Message\AbstractRequest;
use Omnipay\Payture\Message\PayStatusResponse;


class PayStatusRequest extends AbstractRequest
{
    public function getRequestHeaders()
    {
        return array(
            'Accept' => 'application/x-www-form-urlencoded',
            'Content-Type' => 'application/x-www-form-urlencoded',
        );
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
        $client = $this->httpClient->post($this->getUrl(), $this->getRequestHeaders(), $data)->send();
        $resultData = $client->xml();

        return $this->response = new PayStatusResponse($this, $resultData);

    }

}
