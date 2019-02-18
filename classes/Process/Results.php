<?php

namespace Main\Process;

use Main\DB\MySQLConnector;

class Results
{
    protected $TableName = "results";

    /**
     * Метод сохраняет результаты теста
     *
     * @throws \Exception
     * */
    public function saveResults($test, $intellect, $complexity)
    {
        $resultsCount = count(
            array_filter(
                $test,
                function($val, $key)
                {
                    return $val["result"] ? true : false;
                },
                ARRAY_FILTER_USE_BOTH
            )
        );
        $data = [
            "intellect" => $intellect,
            "complexity_from" => $complexity[0],
            "complexity_to" => $complexity[1],
            "result" => $resultsCount
        ];

        try
        {
            $query = "INSERT INTO " . $this->TableName . "(" . implode(", ", array_keys($data))
                . ") VALUES (" . implode(", ", $data) . ")";
            $DB = new MySQLConnector();
            $DB->query($query);
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * Метод выборки результатов тестов
     *
     * @return boolean|array
     * @throws \Exception
     * */
    public function getResults()
    {
        try
        {
            $query = "SELECT * FROM `" . $this->TableName . "`";

            $DB = new MySQLConnector();
            return $DB->query($query);
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }

    }
}