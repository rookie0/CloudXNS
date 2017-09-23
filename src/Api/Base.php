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
        if (isset($options[RequestOptions::QUERY]) && ! empty($options[RequestOptions::QUERY])) {
            $url .= '?' . http_build_query($options[RequestOptions::QUERY]);
        }
        unset($options[RequestOptions::QUERY]);
        $data                             = isset($options[RequestOptions::JSON]) ? $options[RequestOptions::JSON] : [];
        $options[RequestOptions::HEADERS] = $this->getHeader($url, $data);

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