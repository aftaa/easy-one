<?php

namespace app\config\db\connection;

class Config
{
    public string $provider = 'mysql';
    public string $hostname = 'localhost';
    public string $username = 'symfony';
    public string $password = 'symfony';
    public string $database = 'symfony';

    public function __construct()
    {
        $mysqlHostname = $_ENV['MYSQL_HOSTNAME'] ?? 'localhost';
        $this->hostname = $mysqlHostname;
    }
}
