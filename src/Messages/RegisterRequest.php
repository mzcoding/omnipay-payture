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
            'Url' => $this->getParameter('url'),
            'Key' => $this->getParameter('Key'),
            'Amount' => $this->getParameter('Amount'),
            'OrderId' => $this->getParameter('OrderId'),
            'PayInfo' => $this->getParameter('PayInfo')
        ];

        return $data;
    }
    public function sendData($data)
    {
        $data = $this->getData();
        $this->response = new RegisterResponse($this, parent::sendData($data));

        return $this->response;
    }
}