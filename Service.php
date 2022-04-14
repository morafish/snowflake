<?php
declare (strict_types=1);

namespace morafish\snowflake;

class Service extends \think\Service
{
    //向tinkphp中注册snowflake服务
    public function register()
    {
        $this->app->bind('snowflake', Snowflake::class);
    }
}
