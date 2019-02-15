<?php

namespace Main\Process;

use Main\DB\MySQLConnector;

class Questions
{
    private $DB;
    private $QuestionsTable = "questions";
    private $NumOfUseField = "num_of_uses";
    public $Questions;


    public function __construct($Complexity = [0, 100])
    {
        $this->DB = new MySQLConnector();

        $this->Questions = $this->prepareQuestions($Complexity);
    }

    public function getData()
    {
        return $this->Questions;
    }

    protected function prepareQuestions($Complexity)
    {
        $questions = $this->getAllQuestions();
        $selectedQuestion = $this->selectionOfQuestions($questions);
        $result = $this->questionsEvaluation($selectedQuestion, $Complexity);

        $this->incrementNumOfUses(array_keys($selectedQuestion));

        return $result;
    }

    /**
     * Функция выбора вопросов
     * по алгоритму "Roulette wheel selection"
     *
     * @param array $questions
     * @return array $return
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
            $rand = rand(0, $sumUses);
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

    protected function questionsEvaluation($questions, $complexity)
    {

        foreach ($questions as &$question)
        {
            $rand = rand($complexity[0],$complexity[1]);
            $question["complexity"] = $rand;
        }

        return $questions;
    }

    protected function getAllQuestions()
    {
        $query = "SELECT * FROM `" . $this->QuestionsTable . "`";

        return $this->DB->query($query);
    }

    protected function incrementNumOfUses($questionsId = [])
    {
        $query = "UPDATE `" . $this->QuestionsTable
            . "` SET `" . $this->NumOfUseField . "` = `"
            . $this->NumOfUseField . "` + 1 WHERE id IN ("
            . trim(implode(", ", $questionsId)) . ");";

        return $this->DB->query($query);
    }
}