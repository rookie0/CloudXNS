<?php

namespace Rookie0\CloudXNS\Api;

use GuzzleHttp\RequestOptions;
use Leo108\SDK\AbstractApi;
use Psr\Http\Message\ResponseInterface;
use Rookie0\CloudXNS\CloudXNS;

abstract class Base extends AbstractApi
{

    /**
     * @var CloudXNS
     */
    protected $sdk;

    protected function getSDK()
    {
        return $this->sdk;
    }

    protected function getFullApiUrl($api, ...$extends)
    {
        $extend = '';
        foreach ($extends as $ext) {
            $extend .= "/{$ext}";
        }
        return "https://www.cloudxns.net/api2/{$api}{$extend}";
    }

    protected function apiRequest($method, $url, $options = [])
    {
        $data                             = isset($options[RequestOptions::QUERY]) ? $options[RequestOptions::QUERY] :
            (isset($options[RequestOptions::FORM_PARAMS]) ? $options[RequestOptions::FORM_PARAMS] : []);
        $header                           = $this->getHeader($url, $data);
        $options[RequestOptions::HEADERS] = isset($options[RequestOptions::HEADERS]) ? array_merge($options[RequestOptions::HEADERS], $header) : $header;

        return parent::apiRequest($method, $url, $options);
    }

    protected function getHeader($url, $data = [])
    {
        $date = date(DATE_RFC3339);
        $data = $data ? json_encode($data) : '';
        return [
            'API-KEY'          => $this->getSDK()->getApiKey(),
            'API-REQUEST-DATE' => $date,
            'API-HMAC'         => md5($this->getSDK()->getApiKey() . $url . $data . $date . $this->getSDK()->getSecretKey()),
            'API-FORMAT'       => 'json',
        ];
    }

    protected static function parseJson(ResponseInterface $response)
    {
        return \GuzzleHttp\json_decode($response->getBody(), true);
    }

}