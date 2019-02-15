<?php

namespace Main\DB;

abstract class DBConnector
{
    protected $DBConf;

    abstract public function __construct();

    abstract protected function connect();

    abstract public function query($query);
}