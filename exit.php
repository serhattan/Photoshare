<?php
require_once "include/init.php";
redirectedIfNotLoggedIn();
session_start();
session_destroy();
header("Location: login.php");
?> 