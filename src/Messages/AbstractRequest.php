<?php
/**
* http://mzcodig.com
 **/
namespace Omnipay\Payture\Message;


abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setParameter('Url', $url);
    }

    /**
     * @return string
     */
    public function getUrl(){
        return $this->getParameter('Url');
    }
    /**
     * @param $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        return $this->setParameter('Amount', $amount);
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->getParameter('Amount');
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        return $this->setParameter('Key', $key);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->getParameter('Key');
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        return $this->setParameter('Currency', $currency);
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->getParameter('Currency');
    }
    /**
     * @param $orderId
     * @return $this
     */
    public function  setOrderId($orderId)
    {
        return $this->setParameter('OrderId', $orderId);
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getParameter('OrderId');
    }


    /**
     * @param $payInfo
     * @return $this
     */
    public function setPaymentInfo($payInfo)
    {
        return $this->setParameter('PayInfo', $payInfo);
    }

    /**
     * @return mixed
     */
    public function getPaymentInfo()
    {
        return $this->getParameter('PayInfo');
    }

    /**
     * @param $sessionType
     * @return $this
     */
    public function setSessionType($sessionType)
    {
        return $this->setParameter('SessionType', $sessionType);
    }

    /**
     * @return mixed
     */
    public function getSessionType()
    {
        return $this->getParameter('SessionType');
    }
    /**
     * @param $session_id
     * @return $this
     */
    public function setSessionId($session_id)
    {
        return $this->setParameter('SessionId', $session_id);
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->getParameter('SessionId');
    }

    /**
     * @param $ip
     * @return $this
     */
    public function setIp($ip)
    {
        return $this->setParameter('Ip', $ip);
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->getParameter('Ip');
    }

    /**
     * @param $redirect_url
     * @return $this
     */
    public function setRedirectUrl($redirect_url)
    {
        return $this->setParameter('RedirectUrl', $redirect_url);
    }
    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->getParameter('RedirectUrl');
    }



    /**
     * @param $callback_url
     * @return $this
     */
    public function setCallbackUrl($callback_url)
    {
        return $this->setParameter('CallbackUrl', $callback_url);
    }

    /**
     * @return mixed
     */
    public function getCallbackUrl()
    {
        return $this->getParameter('CallbackUrl');
    }

    /**
     * @param $templateTeg
     * @return $this
     */
    public function setTemplateTag($templateTeg)
    {
        return $this->setParameter('TemplateTag', $templateTeg);
    }

    /**
     * @return mixed
     */
    public function getTemplateTag()
    {
        return $this->getParameter('TemplateTag');
    }

    /**
     * @param $language
     * @return $this
     */
    public function setLanguage($language)
    {
        return $this->setParameter('Language', $language);
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->getParameter('Language');
    }

    /**
     * @param $product
     * @return $this
     */
    public function setProduct($product)
    {
        return $this->setParameter('Product', $product);
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->getParameter('Product');
    }

    /**
     * @param $total
     * @return $this
     */
    public function setTotal($total)
    {
        return $this->setParameter('Total', $total);
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->getParameter('Total');
    }
    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        return $this->setParameter('Password', $password);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getParameter('Password');
    }

    /**
     * Set gateway test mode. Also changes URL
     *
     * @param bool $testMode
     * @return $this
     */
    public function setTestMode($testMode)
    {
        $this->setEndpoint($testMode ? self::TEST_MODE : false);
        return $this->setParameter('testMode', $testMode);
    }

    /**
     * Test Mode for example
     * @return mixed
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }



}