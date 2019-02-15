<?php
function ShowArray()
{
    echo '<pre style="font-size:11px;margin:0 0 15px 0;padding:5px;color:#000000 !important;background-color:#ededed;text-align:left !important;">'.htmlspecialchars(print_r(func_get_args(), true)).'</pre>';
}


require("DB/DBConnector.php");
require("DB/MySQLConnector.php");
require("Process/Process.php");
require("Process/Questions.php");