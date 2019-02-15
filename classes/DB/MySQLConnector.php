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
            echo($exception);
        }
    }

    protected function connect()
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

    public function query($query)
    {
        $result = null;
        $responce = $this->Connect->query($query);

        switch (gettype($responce))
        {
            case "object":
                while ($row = $responce->fetch_assoc())
                {
                    $result[$row["id"]] = $row;
                }

                break;
            default:
                $result = $responce;

                break;
        }

        return $result;
    }
}