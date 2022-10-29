<?php

function lang( $phrase ){
       
 static $lang = array(
      'Home_Admin' => 'HOME',
      'Cat'        => 'Categories',
      'items'      => 'Items',
      'memebers'   => 'Members',
      'statis'     => 'Statistics',
      'logs'       => 'Logs',
 );

 return $lang[$phrase];
}