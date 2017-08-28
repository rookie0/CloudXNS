<?php

namespace Rookie0\CloudXNS\Api;

class Stat extends Base
{

    const API = 'domain_stat';

    /**
     * 解析量统计
     * @param int    $domainId
     * @param string $host 主机名，全部为 all
     * @param string $code 统计区域ID或ISP ID，全部为 all
     * @param string $startDate
     * @param string $endDate
     * @return mixed
     */
    public function list($domainId, $host = 'all', $code = 'all', $startDate = '', $endDate = '')
    {
        return static::parseJson($this->apiRequest('GET', $this->getFullApiUrl(self::API, $domainId), [
            'host'       => $host,
            'code'       => $code,
            'start_date' => $startDate ?: date('Y-M-D', strtotime('-7 days')),
            'end_date'   => $endDate ?: date('Y-M-D'),
        ]));
    }

}