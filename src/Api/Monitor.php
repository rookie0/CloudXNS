<?php

namespace Rookie0\CloudXNS\Api;

class Monitor extends Base
{

    const API       = 'monitor';
    const API_ALARM = 'monitor/alarmOp';

    /**
     * 监控列表
     * @param int $domainId
     * @param int $hostId
     * @param int $offset
     * @param int $rowNum
     * @return mixed
     */
    public function list($domainId, $hostId = 0, $offset = 0, $rowNum = 30)
    {
        return static::parseJson($this->apiGet(self::API, [
            'domain_id' => $domainId,
            'host_id'   => $hostId,
            'offset'    => $offset,
            'row_num'   => $rowNum,
        ]));
    }

    /**
     * 添加监控
     * @param int    $recordId
     * @param int    $type
     * @param string $url
     * @param int    $port
     * @param int    $callback
     * @return mixed
     */
    public function add($recordId, $type = 1, $url = '', $port = 80, $callback = 0)
    {
        return static::parseJson($this->apiPost(self::API, [
            'record_id'   => $recordId,
            'mon_type'    => $type,
            'mon_url'     => $url,
            'tcp_port'    => $port,
            'ic_callback' => $callback,
        ]));
    }

    /**
     * 删除监控
     * @param int $monitorId 监控ID
     * @return mixed
     */
    public function delete($monitorId)
    {
        return static::parseJson($this->apiRequest('DELETE', $this->getFullApiUrl(self::API, $monitorId)));
    }

    /**
     * 暂停、启用报警
     * @param int $monitorId
     * @param int $op
     * @return mixed
     */
    public function alarm($monitorId, $op = 0)
    {
        return static::parseJson($this->apiPost(self::API_ALARM, [
            'monitor_id' => $monitorId,
            'op'         => $op > 0 ? 1 : 0,
        ]));
    }

}