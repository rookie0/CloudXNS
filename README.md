
# CloudXNS

A better PHP SDK for using CloudXNS API.

Inspired by [leo108/php_sdk_skeleton](https://github.com/leo108/php_sdk_skeleton), 给鸿神献上膝盖.

## Installation

`composer require rookie0/cloudxns`

## Usage

参数及返回值详见[CloudXNS文档](https://www.cloudxns.net/Support/detail/id/1361.html)

```php
<?php

use Rookie0\CloudXNS\CloudXNS;

// CloudXNS API管理可见
$config = [
    'api_key'    => 'xxxxxx',
    'secret_key' => 'xxxxxx',
];

$xns = new CloudXNS($config);

// 域名列表
$resp = $xns->domain->list();

// 添加域名
$domain   = 'your-domain.com';
$resp     = $xns->domain->add($domain);
$domainId = $resp['id'];

// 删除域名
$resp = $xns->domain->delete($domainId);

// 添加解析记录
$value    = 'your-cname-domain.com';
$type     = 'CNAME';
$lineId   = 1; // 默认线路
$host     = 'www'; // 默认@
$resp     = $xns->record->add($domainId, $value, $type, $lineId, $host);
$recordId = $resp['record_id'][0];

// 更新解析
$resp = $xns->record->update($recordId, $domainId, $value, $type, $lineId, $host);

// 删除解析
$resp = $xns->record->delete($recordId, $domainId);

```
