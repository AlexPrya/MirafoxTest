<?php

namespace Main\Process;

class Process
{
    protected $Intellect;
    protected $Complexity;


    public function __construct($Intellect = 0, $Complexity = [0, 100])
    {
        $this->Intellect = $Intellect;
        $this->Complexity = $Complexity;
        $this->Questions = (new Questions($this->Complexity))->getData();
    }
}