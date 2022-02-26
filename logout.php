<?php
require 'library.php';
session_start();
logg('index',$_SESSION['Role'], $_SESSION['ID'], 'out');
terminate();