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
     * Host url
     *
     * @var string
     */
    const HOST = 'Menateka';

    /**
     * PTEST MODE
     *
     * @var boolean
     */
    const TEST_MODE = true;

    protected $RESULT_STATUS = [
        'New' => 'Платеж зарегистрирован в шлюзе, но его обработка в процессинге не начата',
        'PreAuthorized3DS' =>	'Пользователь начал аутентификацию по протоколу 3D Secure, на этом операции по платежу завершились',
        'PreAuthorizedAF' =>	'Пользователь начал аутентификацию с помощью сервиса AntiFraud, на этом операции по платежу завершились',
        'Authorized' =>	 'Средства заблокированы, но не списаны (2-х стадийный платеж)',
        'Voided' =>	'Средства на карте были заблокированы и разблокированы (2-х стадийный платеж)',
        'Charged' => 'Денежные средства списаны с карты Пользователя, платёж завершен успешно',
        'Refunded' =>	'Успешно произведен полный возврат денежных средств на карту Пользователя',
        'Forwarded' =>	'Платеж был перенаправлен на терминал, указанный в скобках',
        'Rejected(Terminal)' =>	'Последняя операция по платежу отклонена',
        'Error' =>	'Последняя операция по платежу завершена с ошибкой'
    ];

    protected $ERRORS_STATUS = [
        'NONE'  =>	'Операция выполнена без ошибок',
        'ACCESS_DENIED' =>	'Доступ с текущего IP или по указанным параметрам запрещен',
        'AMOUNT_ERROR'  =>	'Неверно указана сумма транзакции',
        'AMOUNT_EXCEED' =>	'Сумма транзакции превышает доступный остаток средств на выбранном счете',
        'AMOUNT_EXCEED_BALANCE' =>	'Сумма транзакции превышает доступный остаток средств на выбранном счете',
        'API_NOT_ALLOWED'  =>	'Данный API не разрешен к использованию',
        'COMMUNICATE_ERROR' =>	'Ошибка возникла при передаче данных в МПС',
        'DUPLICATE_ORDER_ID' =>	'Номер заказа уже использовался ранее',
        'DUPLICATE_CARD' =>	'Карта уже зарегистрирована',
        'DUPLICATE_USER' =>	'Пользователь уже зарегистрирован',
        'EMPTY_RESPONSE' =>	'Ошибка процессинга',
        'FORMAT_ERROR'	=> 'Неверный формат переданных данных',
        'FRAUD_ERROR' =>	'Недопустимая транзакция согласно настройкам антифродового фильтра',
        'FRAUD_ERROR_BIN_LIMIT' =>	'Превышен лимит по карте(BINу, маске) согласно настройкам антифродового фильтра',
        'FRAUD_ERROR_BLACKLIST_BANKCOUNTRY' =>	'Страна данного BINа находится в черном списке или не находится в списке допустимых стран',
        'FRAUD_ERROR_BLACKLIST_AEROPORT' =>	'Аэропорт находится в черном списке',
        'FRAUD_ERROR_BLACKLIST_USERCOUNTRY' =>	'Страна данного IP находится в черном списке или не находится в списке допустимых стран',
        'FRAUD_ERROR_CRITICAL_CARD' =>	'Номер карты(BIN, маска) внесен в черный список антифродового фильтра',
        'FRAUD_ERROR_CRITICAL_CUSTOMER' =>	'IP-адрес внесен в черный список антифродового фильтра',
        'ILLEGAL_ORDER_STATE'	=> 'Попытка выполнения недопустимой операции для текущего состояния платежа',
        'INTERNAL_ERROR' =>	'Неправильный формат транзакции с точки зрения сети',
        'INVALID_FORMAT' =>	'Неправильный формат транзакции с точки зрения сети',
        'ISSUER_BLOCKED_CARD' =>	'Владелец карты пытается выполнить транзакцию, которая для него не разрешена банком-эмитентом, либо произошла внутренняя ошибка эмитента',
        'ISSUER_CARD_FAIL' =>	'Банк-эмитент запретил интернет транзакции по карте',
        'ISSUER_FAIL'	=> 'Владелец карты пытается выполнить транзакцию, которая для него не разрешена банком-эмитентом, либо внутренняя ошибка эмитента',
        'ISSUER_LIMIT_FAIL'  =>	'Предпринята попытка, превышающая ограничения банка-эмитента на сумму или количество операций в определенный промежуток времени',
        'ISSUER_LIMIT_AMOUNT_FAIL' => 'Предпринята попытка выполнить транзакцию на сумму, превышающую (дневной) лимит, заданный банком-эмитентом',
        'ISSUER_LIMIT_COUNT_FAIL' =>  'Превышен лимит на число транзакций: клиент выполнил максимально разрешенное число транзакций в течение лимитного цикла и пытается провести еще одну',
        'ISSUER_TIMEOUT' =>  'Нет связи с банком эмитентом',
        'LIMIT_EXCHAUST' =>	'Время или количество попыток, отведенное для ввода данных, исчерпано',
        'MERCHANT_RESTRICTION' => 'Превышен лимит Магазина или транзакции запрещены Магазину',
        'NOT_ALLOWED' => 'Отказ эмитента проводить транзакцию. Чаще всего возникает при запретах наложенных на карту',
        'OPERATION_NOT_ALLOWED' =>	'Действие запрещено',
        'ORDER_NOT_FOUND' =>	'Не найдена транзакция',
        'ORDER_TIME_OUT' =>	'Время платежа (сессии) истекло',
        'PROCESSING_ERROR' =>	'Ошибка функционирования системы, имеющая общий характер. Фиксируется платежной сетью или банком-эмитентом',
        'PROCESSING_TIME_OUT' => 'Таймаут в процессинге',
        'REAUTH_NOT_ALOWED' =>	'Изменение суммы авторизации не может быть выполнено',
        'REFUND_NOT_ALOWED' =>	'Возврат не может быть выполнен',
        'REFUSAL_BY_GATE' =>	'Отказ шлюза в выполнении операции',
        'RETRY_LIMIT_EXCEEDED' =>	'Превышено допустимое число попыток произвести возврат (Refund)',
        'THREE_DS_FAIL' =>	'Невозможно выполнить 3DS транзакцию',
        'THREE_DS_TIME_OUT' =>	'Срок действия транзакции был превышен к моменту ввода данных карты',
        'USER_NOT_FOUND' =>	'Пользователь не найден',
        'WRONG_AMOUNT' =>	'Сумма меньше минимального или больше максимального допустимого значения',
        'WRONG_CARD_INFO' =>	'Введены неверные параметры карты',
        'WRONG_CARD_PAN' =>	'Неверный номер карты',
        'WRONG_PAN' =>	'Неверный номер карты',
        'WRONG_CARDHOLDER_NAME' =>	'Недопустимое имя держателя карты',
        'WRONG_PARAMS'	=> 'Неверный набор или формат параметров',
        'WRONG_PAY_INFO' =>	'Некорректный параметр PayInfo (неправильно сформирован или нарушена криптограмма)',
        'WRONG_AUTH_CODE' =>	'Неверный код активации',
        'WRONG_CARD' => 'Переданы неверные параметры карты, либо карта в недопустимом состоянии',
        'WRONG_CONFIRM_CODE' =>	'Неверный код подтверждения',
        'WRONG_USER_PARAMS' =>	'Пользователь с такими параметрами не найден'
    ];



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
    public function getKey()
    {
        return $this->getParameter('Key');
    }

    public function setCurrency($currency)
    {
        return $this->setParameter('Currency', $currency);
    }
    public function getCurrency()
    {
        return $this->getParameter('Currency');
    }


    public function  setOrderId($orderId)
    {
       return $this->setParameter('OrderId', $orderId);
    }
    public function getOrderId()
    {
        return $this->getParameter('OrderId');
    }


    public function setPaymentInfo($payInfo)
    {
        return $this->setParameter('PayInfo', $payInfo);
    }
    public function getPaymentInfo()
    {
        return $this->getParameter('PayInfo');
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


   /* public function sendTest(array $data = array())
    {
        $url = $this->getUrl();
        $amount = isset($data['amount'])  ? $data['amount'] : $this->getAmount();

        if(self::TEST_MODE){
            $modeData = $this->getPayInfoTest($amount);
            $data['card'] = $modeData;
        }

       return $this;

    }*/
    public function register(array $parameters = array())
    {
      return $this->createRequest('\Omnipay\Payture\Message\RegisterRequest', $parameters);
    }


}