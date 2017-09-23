<?php

namespace Rookie0\CloudXNS\Api;

use GuzzleHttp\RequestOptions;

class Record extends Base
{

    const API       = 'record';
    const API_SPARE = 'record/spare';
    const API_PAUSE = 'record/pause';
    const API_AI    = 'record/ai';
    const API_TYPE  = 'type';
    const API_DDNS  = 'ddns';

    /**
     * 解析记录列表
     * @param int    $domainId
     * @param int    $hostId   主机记录ID，0 查全部
     * @param int    $offset
     * @param int    $rowNum
     * @param string $hostName 主机记录名 与hostId不能同时使用
     * @return mixed
     */
    public function list($domainId, $hostId = 0, $offset = 0, $rowNum = 30, $hostName = '')
    {
        $query = [
            'host_id' => $hostId,
            'offset'  => $offset,
            'row_num' => $rowNum,
        ];
        if ($hostName) {
            $query['host_name'] = $hostName;
            unset($query['host_id']);
        }

        return static::parseJson($this->apiGet(self::API . '/' . $domainId, $query));
    }

    /**
     * 新增解析记录
     * @param int    $domainId
     * @param string $value  记录值，IP:8.8.8.8 CNAME:your.domain.com ...
     * @param string $type   记录类型
     * @param int    $lineId 线路ID
     * @param string $host   主机记录名称，默认 @
     * @param int    $mx     优先级 1-100，记录类型为 MX|AX|CNAMEX 时有效且必选
     * @param int    $ttl    TTL 60-3600
     * @return mixed
     */
    public function add($domainId, $value, $type, $lineId = 1, $host = '@', $mx = 10, $ttl = 600)
    {
        return static::parseJson($this->apiJson(self::API, [
            'domain_id' => $domainId,
            'host'      => $host,
            'value'     => $value,
            'type'      => $type,
            'mx'        => $mx,
            'line_id'   => $lineId,
            'ttl'       => $ttl,
        ]));
    }

    /**
     * 新增备记录，仅 A|AX 解析记录支持添加
     * @param $domainId
     * @param $hostId
     * @param $recordId
     * @param $value
     * @return mixed
     */
    public function addSpare($domainId, $hostId, $recordId, $value)
    {
        return static::parseJson($this->apiJson(self::API_SPARE, [
            'domain_id' => $domainId,
            'host_id'   => $hostId,
            'record_id' => $recordId,
            'value'     => $value,
        ]));
    }

    /**
     * 更新解析记录
     * @param int    $recordId
     * @param int    $domainId
     * @param string $value
     * @param string $type
     * @param int    $lineId
     * @param string $host
     * @param int    $mx
     * @param int    $ttl
     * @param string $bakIp
     * @return mixed
     */
    public function update($recordId, $domainId, $value = '', $type = '', $lineId = 1, $host = '@', $mx = 10, $ttl = 600, $bakIp = '')
    {
        return static::parseJson($this->apiRequest('PUT', $this->getFullApiUrl(self::API, $recordId), [
            RequestOptions::JSON => [
                'domain_id' => $domainId,
                'host'     => $host,
                'value'    => $value,
                'mx'       => $mx,
                'ttl'      => $ttl,
                'type'     => $type,
                'line_id'  => $lineId,
                'bak_ip'   => $bakIp,
            ],
        ]));
    }

    /**
     * 删除解析记录
     * @param $recordId
     * @param $domainId
     * @return mixed
     */
    public function delete($recordId, $domainId)
    {
        return static::parseJson($this->apiRequest('DELETE', $this->getFullApiUrl(self::API, $recordId, $domainId)));
    }

    /**
     * 暂停、启用解析
     * @param int $recordId
     * @param int $domainId
     * @param int $status 0|1 暂停|启用
     * @return mixed
     */
    public function pause($recordId, $domainId, $status = 0)
    {
        return static::parseJson($this->apiJson(self::API_PAUSE, [
            'id'        => $recordId,
            'domain_id' => $domainId,
            'status'    => $status > 0 ? 1 : 0,
        ]));
    }

    /**
     * 暂停、启用X优化
     * @param int $recordId
     * @param int $domainId
     * @param int $status
     * @return mixed
     */
    public function ai($recordId, $domainId, $status = 0)
    {
        return static::parseJson($this->apiJson(self::API_AI, [
            'id'        => $recordId,
            'domain_id' => $domainId,
            'status'    => $status > 0 ? 1 : 0,
        ]));
    }

    /**
     * 记录类型列表
     * @return mixed
     */
    public function type()
    {
        return static::parseJson($this->apiGet(self::API_TYPE));
    }

    /**
     * DDNS快速修改解析记录
     * @param string $domain
     * @param string $ip
     * @param int    $lineId
     * @return mixed
     */
    public function ddns($domain, $ip = '', $lineId = 1)
    {
        return static::parseJson($this->apiJson(self::API_DDNS, [
            'domain'  => $domain,
            'ip'      => $ip,
            'line_id' => $lineId,
        ]));
    }

}