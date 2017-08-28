<?php

namespace Rookie0\CloudXNS\Api;

class Line extends Base
{

    const API        = 'line';
    const API_REGION = 'line/region';
    const API_ISP    = 'line/isp';

    /**
     * 线路列表
     * @return mixed
     */
    public function list()
    {
        return static::parseJson($this->apiGet(self::API));
    }

    /**
     * 区域列表
     * @return mixed
     */
    public function region()
    {
        return static::parseJson($this->apiGet(self::API_REGION));
    }

    /**
     * ISP列表
     * @return mixed
     */
    public function isp()
    {
        return static::parseJson($this->apiGet(self::API_ISP));
    }

}