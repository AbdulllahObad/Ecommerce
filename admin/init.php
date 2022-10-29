<?php

include 'connect.php';

// Routes 
$tpl = 'includes/template/';// Template Directory
$lang= 'includes/laguages/';
$func = 'includes/functions/';

// iNclude the important files
include $func.'function.php';
include $lang.'english.php';
include $tpl. 'header.php';
// include navbar on all pages excepte the one with $noNavbar varible 

if(!(isset($noNavbar))){
       include $tpl. 'navbar.php';
}
