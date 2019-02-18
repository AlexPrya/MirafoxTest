<?php

namespace Main\DB;

class MySQLConnector extends DBConnector
{
    protected $DBConf = [
        "db_host" => "localhost",
        "db_name" => "mirafox",
        "db_login" => "root",
        "db_password" => "32768",
    ];
    protected $Connect;

    public function __construct()
    {
        try
        {
            $this->Connect = $this->connect($this->DBConf);
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }

    protected function connect()
    {
        try
        {
            $connect =  new \mysqli(
                $this->DBConf["db_host"],
                $this->DBConf["db_login"],
                $this->DBConf["db_password"],
                $this->DBConf["db_name"]
            );

            if ($connect->connect_errno)
            {
                throw new \Exception("ERROR " . $connect->connect_errno . ": " . $connect->connect_error);
            }

            return $connect;
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }

    public function query($query)
    {
        try
        {
            $responce = $this->Connect->query($query);
            $result = false;

            switch (gettype($responce))
            {
                case "object":
                    while ($row = $responce->fetch_assoc())
                    {
                        $result[] = $row;
                    }

                    break;
                case "boolean":
                    $result = $responce;

                    break;
                default:
                    throw new \Exception("Query error");

                    break;
            }

            return $result;
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }
}