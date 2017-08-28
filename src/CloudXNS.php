<?php

namespace Rookie0\CloudXNS;

use GuzzleHttp\ClientInterface;
use Leo108\SDK\SDK;
use Psr\Log\LoggerInterface;
use Rookie0\CloudXNS\Api\Domain;
use Rookie0\CloudXNS\Api\Host;
use Rookie0\CloudXNS\Api\Line;
use Rookie0\CloudXNS\Api\Monitor;
use Rookie0\CloudXNS\Api\Ns;
use Rookie0\CloudXNS\Api\Record;
use Rookie0\CloudXNS\Api\Stat;
use Rookie0\CloudXNS\Exceptions\InvalidArgumentException;

/**
 * Class CloudXNS
 * @package Rookie0\CloudXNS
 *
 * @property \Rookie0\CloudXNS\Api\Domain  $domain
 * @property \Rookie0\CloudXNS\Api\Host    $host
 * @property \Rookie0\CloudXNS\Api\Line    $line
 * @property \Rookie0\CloudXNS\Api\Monitor $monitor
 * @property \Rookie0\CloudXNS\Api\Ns      $ns
 * @property \Rookie0\CloudXNS\Api\Record  $record
 * @property \Rookie0\CloudXNS\Api\Stat    $stat
 */
class CloudXNS extends SDK
{
    protected $apiKey;

    protected $secretKey;

    public function __construct(array $config = [], ClientInterface $client = null, LoggerInterface $logger = null)
    {
        parent::__construct($config, $client, $logger);
        $this->parseConfig($config);
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getApiMap()
    {
        return [
            'domain'  => Domain::class,
            'host'    => Host::class,
            'line'    => Line::class,
            'monitor' => Monitor::class,
            'ns'      => Ns::class,
            'record'  => Record::class,
            'stat'    => Stat::class,
        ];
    }

    protected function parseConfig(array $config)
    {
        if (!isset($config['api_key'])) {
            throw new InvalidArgumentException('Missing argument api_key');
        }

        if (!isset($config['secret_key'])) {
            throw new InvalidArgumentException('Missing argument secret_key');
        }

        $this->apiKey    = $config['api_key'];
        $this->secretKey = $config['secret_key'];

        $this->config = $config;
    }

}