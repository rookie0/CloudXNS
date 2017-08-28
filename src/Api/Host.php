<?php

namespace Rookie0\CloudXNS\Api;

class Host extends Base
{

    const API = 'host';

    /**
     * 主机记录列表
     * @param int    $domainId
     * @param int    $offset 记录开始的偏移，从 0 开始
     * @param int    $rowNum 获取的记录数量，最大 2000
     * @param string $hostName 主机记录名，可做搜索条件
     * @return mixed
     */
    public function list($domainId, $offset = 0, $rowNum = 30, $hostName = '')
    {
        return static::parseJson($this->apiGet(self::API . '/' . $domainId, [
            'offset'    => $offset,
            'row_num'   => $rowNum,
            'host_name' => $hostName,
        ]));
    }

    /**
     * 删除主机记录
     * @param int $hostId 主机记录ID
     * @return mixed
     */
    public function delete($hostId)
    {
        return static::parseJson($this->apiRequest('DELETE', $this->getFullApiUrl(self::API, $hostId)));
    }

}