<?php

namespace Main\Process;

use Main\DB\MySQLConnector;

class Process
{
    protected $TableName = "results";
    protected $Intellect;
    protected $Complexity;
    protected $Questions;
    protected $Test;

    public function __construct($Intellect = 0, $Complexity = [0, 100])
    {
        try
        {
            $this->Intellect = $Intellect;
            $this->Complexity = $Complexity;
            $this->Questions = (new Questions($Complexity))->getData();
            $this->Test = $this->testEmulating()->getData();
            (new Results())->saveResults($this->Test, $this->Intellect, $this->Complexity);
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Метод отдает результат работы класса
     *
     * @return array
     * */
    public function getData()
    {
        $result = $this->Test;

        return $result;
    }

    /**
     * Метод создает экземпляр класса эмулятора
     *
     * @return Emulator
     * */
    protected function testEmulating()
    {
        return new Emulator($this->Intellect, $this->Questions);
    }
}