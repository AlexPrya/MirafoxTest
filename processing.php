<?php
require("classes/include.php");

use Main\Process;

header('Content-Type: application/json');

switch ($_REQUEST["type"])
{
    case "process":
        $process = new Process\Process($_REQUEST["intellect"], $_REQUEST["complexity"]);

        echo json_encode(
            $process->getData()
        );

        break;
    case "history":
        echo json_encode(
            (new Process\Results())->getResults()
        );

        break;
    default:
        echo json_encode(["success" => false]);

        break;
}