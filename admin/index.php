<?php
session_start(); 
$noNavbar ='';
$pageTitle ='login';
if (isset($_SESSION['Username'])){
       header('Location:dashboard.php');
}
include 'init.php';

// Check If User Coming From HTTP Post Request

if($_SERVER['REQUEST_METHOD']== 'POST'){

$username =$_POST['user'];
$pass =$_POST['pass'];
$hashedPass = sha1($pass);
// check If The User Exist In Database

$stmt = $con->prepare("SELECT Username, Password, UserID FROM users WHERE username = ? AND Password =? AND GroupID = 1 LIMIT 1");

$stmt  ->execute(array($username,$hashedPass));
$row   = $stmt->fetch();
$count = $stmt->rowCount();

// if count >0 so the DB contains record about this username  

if($count > 0){ 
       $_SESSION['Username'] =$username;// Register Session Name, We will use it in the other page(ex:memeber.php)
       $_SESSION['ID'] =$row['UserID'];// Register Session , we will use it to differenrtiate
       header('location: dashboard.php');// dashboard has the two session 
       exit();
}

}

?>

<form class='login' action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
       <h4 class="text-center">Admin login</h4>
       <input class="form-control input-lg" type="text" name="user" placeholder="username" autocomplete="off" />
       <input class="form-control input-lg" type="password" name='pass' placeholder="Password"/>
       <input class="btn btn-primary btn-block" type="submit" value="Login"/>
</form>

<?php include $tpl."footer.php";?>