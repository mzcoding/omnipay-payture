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

        $data = [
            'Key' => $this->getParameter('Key'),
            'Data' => $this->getParameter('Data')
        ];

        return $data;
    }


    public function sendData($data)
    {
        $objXML = $this->curlTest($data);


       /* $reqest = $this->httpClient->post($this->getParameter('url'));
        $reqest->setBody($data);
        $response = $reqest->send();*/

        unset($data);
        if($objXML) {
           if($objXML['Success'] == "False"){
               throw new \Exception($objXML['ErrCode']);
           }


           $data['Amount'] = $objXML['Amount'];
           $data['SessionId'] = $objXML['SessionId'];
           $data['OrderId'] = $objXML['OrderId'];
        }else{
            $data = false;
        }


        $this->response = new RegisterResponse($this, $data);

        return $this->response;
    }

    /**
     * @param array $data
     * @return bool|\SimpleXMLElement
     */
    public function curlTest(array $data)
    {
        $requestData = "";
        foreach($data as $key => $value){
            $requestData .=  $key."=".$value."&";
        }


        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $this->getParameter('url'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);
            $out = curl_exec($curl);

            if($out !== false) {

                $xml = new \SimpleXMLElement($out);

                curl_close($curl);

                return $xml;
            }
            curl_close($curl);

        }

        return false;
    }


}