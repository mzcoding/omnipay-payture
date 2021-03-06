<?php namespace Omnipay\Payture\Message;

use Omnipay\Common\Message\AbstractResponse;


class UnblockResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }
    public function getData()
    {
        return $this->data;
    }
}