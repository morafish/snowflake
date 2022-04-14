<?php
declare (strict_types=1);

namespace morafish\snowflake\generator\meta;

use morafish\snowflake\generator\Generator;

class Local extends Generator
{
    protected $dataCenterId;

    protected $workerId;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->dataCenterId = $config['dataCenterId'];
        $this->workerId     = $config['workerId'];
    }

    public function getDataCenterId(): int
    {
        return $this->dataCenterId;
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
    }
}
