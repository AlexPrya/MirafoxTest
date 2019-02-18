<?php

namespace Main\Process;

class Emulator
{
    protected $Intellect;
    protected $Questions;
    protected $Result;

    public function __construct($Intellect, $Questions)
    {
        $this->Intellect = $Intellect;
        $this->Questions = $Questions;

        $this->emulate();
    }

    /**
     * Метод отдает результат работы класса
     *
     * @return array
     * */
    public function getData()
    {
        $result = $this->Result;

        return $result;
    }

    /**
     * Метод эмулирует выполнение теста
     *
     * */
    protected function emulate()
    {
        $result = [];

        foreach ($this->Questions as $question)
        {
            $result[] = [
                "question_id" => $question["id"],
                "question_num_of_uses" => $question["num_of_uses"],
                "question_complexity" => $question["complexity"],
                "result" => $this->test($question["complexity"]),
            ];
        }

        $this->Result = $result;
    }

    /**
     * Метод тестирует вопрос в соответствии с интеллектом
     *
     * @param integer $complexity
     * @return boolean
     * */
    protected function test($complexity)
    {
        $result = false;
        $i = 1 - $this->Intellect/100;
        $c = 1 - $complexity/100;
        $invert_intellect = 100 - $this->Intellect;
        $invert_complexity = 100 - $complexity;
        $bias = $invert_intellect - $invert_complexity;
        $rand = mt_rand(0 + $bias, 100 + $bias) / 100;

        $func = $i * $c * $rand - ($i - $c / 2);

        if ($func < 0)
            $result = true;

        return $result;
    }
}