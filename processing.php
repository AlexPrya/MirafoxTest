<?php
require("classes/include.php");

use Main\Process\Process;

ShowArray($_REQUEST);

$process = new Process($_REQUEST["intellect"], $_REQUEST["complexity"]);



