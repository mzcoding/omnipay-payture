<?php

namespace Omnipay\Payture\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class PaymentResponse extends AbstractResponse  implements RedirectResponseInterface
{

    public $redirectTo = '';
    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
       return $this->redirectTo;
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        // TODO: Implement getRedirectMethod() method.
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array
     */
    public function getRedirectData()
    {
        // TODO: Implement getRedirectData() method.
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        if($this->redirectTo) return false;

        return true;
    }
    public function isRedirect()
    {
        if($this->redirectTo) return true;

        return false;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->data;
    }
}