<?php
declare (strict_types=1);

namespace morafish\snowflake\generator\meta;

use morafish\snowflake\generator\Generator;
use Exception;

class Redis extends Generator
{

    /** @var  \Redis */
    protected $redis;

    protected $redisKey;

    protected $workerId;

    protected $dataCenterId;

    public function __construct(\Redis $redis, $config)
    {
        parent::__construct($config);
        $this->redis    = $redis;
        $this->redisKey = $config['redisKey'] ? $config['redisKey'] : 'hardphp:snowflake:workerId';
    }

    public static function __make($config)
    {
        if (!extension_loaded('redis')) {
            throw new Exception('redis扩展未安装');
        }

        $func = $config['persistent'] ? 'pconnect' : 'connect';

        $redis = new \Redis;
        $redis->$func($config['host'], $config['port'], $config['timeout']);

        if ('' != $config['password']) {
            $redis->auth($config['password']);
        }

        return new self($redis, $config);
    }

    public function getDataCenterId(): int
    {
        $id                 = $this->redis->incr($this->redisKey);
        $this->dataCenterId = intval($id / $this->maxWorkerId()) % $this->maxDataCenterId();
        return $this->dataCenterId;
    }

    public function getWorkerId(): int
    {
        $id             = $this->redis->incr($this->redisKey);
        $this->workerId = $id % $this->maxWorkerId();
        return $this->workerId;
    }
}
