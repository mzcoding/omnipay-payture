<?php

namespace Omnipay\Payture;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\AbstractGateway;
use Omnipay\Payture\Message\RegisterRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class Gateway.
 *
 * Works with Paytoure.ru gateway.
 * Supports test mode.
 * Implemented all methods from provided pdf instead of adding a card to SSL list
 * and payment through external payment system
 *
 * @author Stanislav Boyko (mzcoding)
 * @company BWA Group
 * @package Omnipay\Payture
 * @link http://payture.com/integration/api/
 *
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */

class Gateway extends AbstractGateway
{

    /**
     * PTEST MODE
     *
     * @var boolean
     */
    const TEST_MODE = true;


    /**
     * Gateway constructor.
     * @param ClientInterface|null $httpClient
     * @param HttpRequest|null $httpRequest
     */
    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null) {
        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * Create and initialize a request object
     *
     * This function is usually used to create objects of type
     * Omnipay\Common\Message\AbstractRequest (or a non-abstract subclass of it)
     * and initialise them with using existing parameters from this gateway.
     *
     * @see \Omnipay\Common\Message\AbstractRequest
     * @param string $class The request class name
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    protected function createRequest($class, array $parameters)
    {
        $obj = new $class($this->httpClient, $this->httpRequest);
        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }


    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Paytoure';
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
       return $this->setParameter('url', $url);
    }

    /**
     * @return string
     */
    public function getUrl(){
        return $this->getParameter('url');
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'Key' => '',
            'PayInfo' => '',
            'OrderId' => '',
            'Amount' => '',
            'PaytureId' => '',
            'CustomerKey'  => '',
            'CustomFields' => '',
        ];
    }

    /**
     * @return array
     */
    public function getPayInfoTest($amount)
    {
        return [
            'PAN' => '4111111111111112',
            'EMonth' => '12',
            'EYear' => '18',
            'CardHolder' => 'Test',
            'SecureCode' => '123',
            'OrderId' => md5(rand(1000, 7000)),
            'Amount' => $amount
        ];
    }

    /**
     * @return array
     */
    public function getPayInfo()
    {
        return [
            'PAN' => '',
            'EMonth' => '',
            'EYear' => '',
            'CardHolder' => '',
            'SecureCode' => '',
            'OrderId' => '',
            'Amount' => ''
        ];
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
     * @param array $params
     * @return string
     */
    private function initDataPay(array $params = array())
    {
        if(empty($params)){
            $params = [
               'SessionType='.$this->getSessionType(),
               'OrderId='. $this->getOrderId(),
               'Amount='.$this->getAmount(),
               'IP='.$this->getIp()
            ];

            if($this->getCallbackUrl()){
                $params[] = 'Url='.$this->getCallbackUrl();
            }
            if($this->getTemplateTag()){
                $params[] = 'TemplateTag='.$this->getTemplateTag();
            }
            if($this->getLanguage()){
                $params[] = 'Language='.$this->getLanguage();
            }
            if($this->getProduct()){
                $params[] = 'Product='.$this->getProduct();
            }
            if($this->getTotal()){
                $params[] = 'Total='.$this->getTotal();
            }
        }
        $params = urlencode(implode(';',$params));

        $this->setParameter('Data', $params);

    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return [
            'IP' => '',
            'Description' => ''
        ];
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

    /**
     * Returns endpoint address
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }
    /**
     * Set endpoint address
     *
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        return $this->setParameter('endpoint', $endpoint);
    }




    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function register(array $parameters = array())
    {
      $this->initDataPay();
      return $this->createRequest('\Omnipay\Payture\Message\RegisterRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function payment(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payture\Message\PaymentRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function charge(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payture\Message\ChargeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function unblock(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payture\Message\UnblockRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function payrefund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payture\Message\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function status(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payture\Message\PayStatusRequest', $parameters);
    }


}