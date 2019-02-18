<?php

namespace Main\Process;

use Main\DB\MySQLConnector;

class Questions
{
    private $DB;
    private $TableName = "questions";
    private $NumOfUseField = "num_of_uses";
    public $Questions;


    public function __construct($Complexity = [0, 100])
    {
        try
        {
            $this->DB = new MySQLConnector();

            $this->Questions = $this->prepareQuestions($Complexity);
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
        $result = $this->Questions;

        return $result;
    }

    /**
     * Метод подготовки вопросов
     *
     * @param array $Complexity
     * @return array
     * @throws \Exception
     * */
    protected function prepareQuestions($Complexity)
    {
        try
        {
            $questions = $this->getAllQuestions();
            $selectedQuestion = $this->selectionOfQuestions($questions);
            $result = $this->questionsEvaluation($selectedQuestion, $Complexity);

            $this->incrementNumOfUses(array_keys($selectedQuestion));

            return $result;
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Метод выбора вопросов
     * по алгоритму "Roulette wheel selection"
     *
     * @param array $questions
     * @return array
     * */
    protected function selectionOfQuestions($questions)
    {
        $result = [];
        // подготавливаем массив для алгоритма
        $uses = [];
        foreach ($questions as $id => $question)
        {
            $uses[$id] = $question[$this->NumOfUseField];
        }

        // Вычисляем веса для элементов.
        // Для этого инвертируем количество использований,
        // чтобы у элемента с наименьшим счетчиком был наибольший вес
        $usesSummMaxMin = max($uses) + min($uses);
        foreach ($uses as &$use) {
            $use = $usesSummMaxMin - $use;
        }
        // Сортируем массив по убыванию
        arsort($uses);
        // Считаем общую сумму весов
        $sumUses = array_sum($uses);

        // выбираем 40 значений
        for ($i = 0; $i < 40; $i++)
        {
            // генерируем случайное число от 0 до суммы весов
            $rand = mt_rand(0, $sumUses);
            $curId = null;
            // Уменьшаем полученное число на размеры весов,
            // пока оно не станет миньше или равным 0
            foreach ($uses as $id => $w)
            {
                $rand -= $w;
                if ($rand <= 0)
                {
                    // запоминаем id вопроса
                    $curId = $id;
                    break;
                }
            }
            // убираем из выборки вопрос и уменьшаем сумму весов на вес вопроса,
            // чтобы не попадались повторяющиеся вопросы
            $sumUses -= $uses[$curId];
            unset($uses[$curId]);

            $result[$curId] = $questions[$curId];
        }

        return $result;
    }

    /**
     * Метод проставляет вопросам сложность
     *
     * @param array $questions
     * @param array $complexity
     * @return array
     * */
    protected function questionsEvaluation($questions, $complexity)
    {

        foreach ($questions as &$question)
        {
            $rand = mt_rand($complexity[0],$complexity[1]);
            $question["complexity"] = $rand;
        }

        return $questions;
    }

    /**
     * Метод выборки вопросов
     *
     * @return array
     * @throws \Exception
     * */
    protected function getAllQuestions()
    {
        try
        {
            $result = [];
            $query = "SELECT * FROM `" . $this->TableName . "`";
            $res = $this->DB->query($query);
            foreach ($res as $row) {
                $result[$row["id"]] = $row;
            }
            return $result;
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Метод инкрементирует поле 'num_of_uses'
     *
     * @param array $questionsId
     * @return boolean
     * @throws \Exception
     * */
    protected function incrementNumOfUses($questionsId = [])
    {
        try
        {
            $query = "UPDATE `" . $this->TableName
                . "` SET `" . $this->NumOfUseField . "` = `"
                . $this->NumOfUseField . "` + 1 WHERE id IN ("
                . trim(implode(", ", $questionsId)) . ");";

            return $this->DB->query($query);
        }
        catch (\Exception $exception)
        {
            throw new \Exception($exception->getMessage());
        }
    }
}