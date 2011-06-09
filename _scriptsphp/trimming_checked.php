<?php
require_once('session.inc');
session_start();
//if( unset($_SESSION ["thisChecked"]) &&  unset($_SESSION  ["hiddenRow" ])&&  unset($_SESSION ["margin"])&&  unset($_SESSION ["forprint"]))
unset($_SESSION ["thisChecked"], $_SESSION  ["hiddenRow" ], $_SESSION ["margin"], $_SESSION ["forprint"]);
echo "Успешно";
?>
