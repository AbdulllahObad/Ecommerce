<?php

function lang( $phrase ){
       
      static $lang = array(
            // Navbar Dashboard Page

            'Home_Admin' => 'Home',
            'Cat'        => 'Categories',
            'items'      => 'Items',
            'memebers'   => 'Members',
            'statis'     => 'Statistics',
            'logs'       => 'Logs',
      );

 return $lang[$phrase];
} 