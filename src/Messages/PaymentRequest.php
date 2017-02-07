<?php namespace Omnipay\Payture\Message;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Payture\Message\RegisterResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

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
        // TODO: Implement getData() method.
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        // TODO: Implement sendData() method.
    }
}