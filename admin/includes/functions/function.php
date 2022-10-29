<?php


function getTitle(){

       global $pageTitle;

       if(isset($pageTitle)){
              echo $pageTitle;
       }
       else {
              echo 'Default';
       }
}


/*
Home Redirect Function [This function Accept Parametrs] v1.0
$Msg = Echo The Message [Error | Success | Waring]
$seconde = Seconde Before Redircting*/

function redirectHome($Msg, $url = null ,$seconds=3){
     
       $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''? $_SERVER['HTTP_REFERER'] : 'index.php';
      
       echo $Msg;
       echo "<div class='alert alert-info'>You Will Be Redirected To Home page After $seconds If not, click <a href='$url'>here</a> </div>";
       header("refrech:$seconds;url= $url");


}


/* Function To Check Item In DB*/
function checkItem($select, $from, $value){
       global $con;
       $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
       $statment->execute(array($value));
       $count = $statment->rowCount();
       return  $count;

}

/*  Count Number of Item v1.0
Function To Count Number Of Items Rows
$Item = item To Count
$table = The Table To Choose From  */

function countItems($item,$table){

       global $con;

       $statment2 =$con->prepare("SELECT COUNT($item) FROM $table ");
       $statment2->execute();
       return  $statment2->fetchColumn();
       
}

/*

Get latest Records Function v1.0 
Function To Get Latest Item From DB
$select = Field To Select 
$table = The Table To Choose From
*/

function getLatest($select , $table, $order, $limite = 5){

       global $con;

       $getStmt =$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limite");

       $getStmt->execute();

       $rows = $getStmt->fetchAll();
       return $rows;
}