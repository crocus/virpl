<?php
require_once ('session.inc');
session_start();
session_unset();
setcookie("_filedir", null, 0, "/");
setcookie("report", null, 0, "/");
setcookie("inquery", null, 0, "/");
session_regenerate_id(true);
?>