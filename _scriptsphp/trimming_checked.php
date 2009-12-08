<?php
require_once('session.inc');
session_start();
if(session_unregister ("thisChecked") && session_unregister ( "hiddenRow" ) && session_unregister ( "margin" ) && session_unregister ( "forprint" ))
echo "Успешно";
?>
