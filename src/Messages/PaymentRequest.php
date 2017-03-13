<?php namespace Omnipay\Payture\Message;

use Omnipay\Payture\Message\AbstractRequest;

class PaymentRequest extends AbstractRequest
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
           'SessionId' => $this->getParameter('SessionId')
        ];

        return $data;
    }
    public function getRequestHeaders()
    {
        return array(
            'Accept' => 'application/x-www-form-urlencoded',
            'Content-Type' => 'application/x-www-form-urlencoded',
        );
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {

        $resultData = $this->httpClient->post($this->getUrl(), $this->getRequestHeaders(), $data);
        $this->response = new PaymentResponse($this, $resultData);
        $this->response->redirectTo = $this->getParameter('RedirectUrl');

        return $this->response;
    }

}