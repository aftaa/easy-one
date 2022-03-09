<?php

namespace app\services;

use app\services\sub\SubService1;

class TestService1
{
    public function __construct(
        private SubService1 $subService1,
    )
    {
    }

    public function test()
    {
        echo 'test';
    }
}