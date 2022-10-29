<?php
/*
  Categories => [ Mange | Edit | Update | Add | Insert | Delate | Stats ]

*/

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
// If the page is main page 
if($do== 'Manage'){
       echo 'Welcome You Are In Manage Category Page';
       echo '<a hred"?do=Insert">Add New Category</a>';

}