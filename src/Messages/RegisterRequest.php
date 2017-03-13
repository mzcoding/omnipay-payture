<?php namespace Omnipay\Payture\Message;

use Omnipay\Payture\Message\AbstractRequest;

class RegisterRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {

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
        $params = urlencode("Data=" .implode(';',$params));

        $data = [
            'Key' => $this->getParameter('Key'),
            'Data' => $params
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

    public function sendData($data)
    {
        $client = $this->httpClient->post($this->getUrl(), $this->getRequestHeaders(), $data)->send();

        $resultData = $client->xml();

        return $this->response = new RegisterResponse($this, $resultData);
    }


}