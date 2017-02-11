<?php

namespace Omnipay\Payture\Message;

use Omnipay\Common\Message\AbstractResponse;


class PayStatusResponse extends AbstractResponse
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

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}