<?php namespace Omnipay\Payture\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class RegisterResponse extends AbstractResponse  implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     * In most cases if response is an array then it's successful
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return is_array($this->data);
    }
    public function getData()
    {
        return $this->data;
    }
    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return $this->isSuccessful();
    }
    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return "{$this->data['redirect_url']}?session={$this->data['session']}";
    }
    /**
     * Gateway Reference
     *
     * @return string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return $this->data['session'];
    }
    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }
    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array|bool
     */
    public function getRedirectData()
    {
        return false;
    }



    /**
     * Perform the required redirect.
     *
     * @return void
     */
    public function redirect()
    {
        return $this->redirect();
    }

    /**
     * Get the original request which generated this response
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->getRequest();
    }

    /**
     * Is the transaction cancelled by the user?
     *
     * @return boolean
     */
    public function isCancelled()
    {
        return $this->isCancelled();
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->getMessage();
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->getCode();
    }
}