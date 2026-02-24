<?php
session_start();
require_once "../functions/helpers.php";
session_unset();
redirect('auth/login.php');