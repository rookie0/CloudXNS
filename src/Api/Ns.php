<?php

namespace Rookie0\CloudXNS\Api;

class Ns extends Base
{

    const API = 'ns_server';

    /**
     * NS服务器列表
     * @return mixed
     */
    public function list()
    {
        return static::parseJson($this->apiGet(self::API));
    }

}