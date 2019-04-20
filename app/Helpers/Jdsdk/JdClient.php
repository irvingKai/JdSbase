<?php
namespace app\Helpers\Jdsdk;
use GuzzleHttp\Client;

class JdClient{

    protected $appKey;
    protected $appSecret;
    protected $appUri;
    protected $params;

    protected function setKey($appKey){
        $this->appKey = $appKey;
    }

    protected function setSecret($appSecret){
        $this->appSecret = $appSecret;
    }

    protected function setUri($appUri){
        $this->appUri = $appUri;
    }

    protected function setParams($params){
        $this->params = $params;
    }

    protected function request(){
        try{
            $client = new Client();
            $result = $client->post($this->appUri,$this->params);
            return $result;
        }catch (\Exception $e){
           new \Exception('');
        }
    }

}