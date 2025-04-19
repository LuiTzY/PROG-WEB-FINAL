<?php
session_start();
session_unset();
session_destroy();
header("Location: ./login.php"); // o login.php
exit();