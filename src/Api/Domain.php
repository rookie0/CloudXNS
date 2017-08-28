<?php

namespace Rookie0\CloudXNS\Api;

class Domain extends Base
{

    const API = 'domain';

    /**
     * 域名列表
     * @return mixed
     */
    public function list()
    {
        return static::parseJson($this->apiGet(self::API));
    }

    /**
     * 添加域名
     * @param string $domain
     * @return mixed
     */
    public function add($domain)
    {
        return static::parseJson($this->apiPost(self::API, ['domain' => $domain]));
    }

    /**
     * 删除域名
     * @param int $domainId 域名ID
     * @return mixed
     */
    public function delete($domainId)
    {
        return static::parseJson($this->apiRequest('DELETE', $this->getFullApiUrl(self::API, $domainId)));
    }

}