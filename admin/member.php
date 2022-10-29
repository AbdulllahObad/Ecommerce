<?php
/*
==================================================================================
== Manage Members Page 
== You Can Add | Edit  | Delete Members From Here
=================================================================================== */

session_start();

$pageTitle = 'Members';

if(isset($_SESSION['Username'])){
       include 'init.php';

       $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

       // Start Manage Page 
       if($do == 'Manage'){// Manage Member Page 
              $query = '';
              if(isset($_GET['Page']) && $_GET['Page'] == "Pending"){
                     $query = 'And RegStatus = 0';    
              }

              // Select ALL Users Excepte Admin
              $stmt =$con->prepare ("SELECT * FROM users WHERE GroupID !=1 $query");
                     // Excute Statment
              $stmt->execute();
                     // Assign To Varible 

                     $rows = $stmt->fetchALL();





              ?>
                     <h1 class="text-center">Member Manage</h1>
                     <div class="container">
                            <?php
                            if(sizeof($rows)>0){?>
                                   <div class="table-responsive">
                                   <table class="main-table table align-middle text-center table-bordered">
                                   <tr>
                                   <td>#ID</td>
                                   <td >UserNmae</td>   
                                   <td>Email</td>
                                   <td>Full Name</td>
                                   <td>Registred Date</td>
                                   <td>Controle</td>
       
                                   </tr>
                               <?php
                            }else{
                                   echo "<div class='alert alert-danger text-center'>There Is No Members</div>";  

                            }
                            ?>
               
                            <?php
                            foreach ($rows as $row ){
                                   echo "<tr>";
                                   echo "<td>".$row['userID']."</td>";
                                   echo "<td>".$row['username']."</td>";
                                   echo "<td>".$row['Email']."</td>";
                                   echo "<td>".$row['FullName']."</td>"; 
                                   echo "<td>".$row['Date']."</td>";
                                   echo "<td>
                                          <a href='member.php?do=Edit&userid=".$row['userID']."'class='btn btn-success'>Edit</a>
                                          <a href='member.php?do=Delete&userid=".$row['userID']."' class='btn btn-danger confirm'>Delete</a>";
                                         
                                         if($row['RegStatus'] == 0){
                                        echo " <a href='member.php?do=Activate&userid=".$row['userID']."' class='btn btn-info'>Activate</a>";

                                         }
                                   echo  "</td>";
                                   
                                   echo "</tr>";
                            }



                                   ?>
                            </table>
                            <div>
                            <a href="member.php?do=Add" class="btn btn-primary">  + Add New Member </a>

                            </div>

                     </div> 
               
      <?php } 
      elseif($do == 'Add'){ // ADD Memeber Page To Be Send To Insert Page ?>
      
              <h1 class="text-center">Add new Memberr</h1>
              <div class="form-horizontal">
              <form class="center" action=" ?do=Insert" method= "POST">
                            <div class="mb-3 ">
                                   <label for="exampleInputEmail1" class="form-label"  >Username</label>                                          <div class="col-md-12">
                                   <div class="col-md-12">
                                   <input type="text" class="form-control"  
                                   name="username" id="exampleInputEmail1" placeholder="Username To Login Into Shop" required="required">
                                   </div>
                                   </div>
                            </div>
                     

                            <div class="mb-3">           
                                   <label for="exampleInputPassword1" class="form-label" >Password</label>
                                   <div class="col-md-12">
                                   <input type="password" class=" password form-control"  name="password" placeholder="Enter Your Password" >
                                   </div>
                                  
                            </div>
                            <div class="mb-3">
                                   <label for="exampleInputPassword1" class="form-label"  >Email</label>
                                   <div class="col-md-12">
                                   <input type="email"  name ="email" class="form-control   id="exampleInputPassword1 placeholder="ENter Your Email" required="required">
                                   </div>
                            </div>

                            <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Full Name</label>
                                   <div class="col-md-12">
                                   <input type="text" class="form-control" name ="full"  id="exampleInputPassword1" placeholder="Enter Your Full Name">
                                   </div>
                            </div>
                            <div class="row g-3 align-items-center">
                            <div class="col-sm-offset-sm-10">
                            <input type="submit" value="Add Member" class="btn btn-primary btn-lg" aria-describedby="passwordHelpInline">
                            </div>
                            </div>

              </form>


      <?php
       } elseif($do == 'Insert'){
              // Insert To DB From 
  
              // Get varibles From The Form
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                     echo '<div class="container">';
                     echo '<h1 class="text-center">Update Member</h1>';
                     $username = $_POST['username'];
                     $userpass = $_POST['password'];
                     $useremail = $_POST['email'];
                     $userfull = $_POST['full'];

                     $hashPass = sha1($_POST['password']);

                     // Validate Form 

                     $formErorrs = array();

                     if(empty($username)){
                            $formErorrs[] = 'User Name can\'t Be Empty'; }  

                     if(!empty($username)) {
                            if (strlen($username)<2){
                                   $formErorrs[] = 'User Name can\'t Be Less Than 2';}
                     }




                     if(empty($useremail)){
                            $formErorrs[] = 'User Email can\'t Be Empty'; }  

                     if(empty($userfull)){
                                   $formErorrs[] = 'User  Full Name can\'t Be Empty'; }   


                     foreach($formErorrs as $error){
                            echo "<div class='alert alert-danger'>$error</div>";
                     }
                            // Check If No Errors Proceed The Update Operation

                            if(empty($formErorrs)){

                                   // Check If User Exist In Database

                                   if( checkItem("username", "users", $username)){
                                          echo "This Usrenam Existe ";
                                   }else{

                                                 
                                          // Insert These Infos To The DataBase 
                                          $stmt = $con->prepare("INSERT INTO
                                          users ( username, Password, Email, FullName,RegStatus,Date  )
                                          VALUES(:zuser   , :zpass  ,:zemail, :zname ,1, now())");

                                          $stmt ->execute(array(
                                                 'zuser'         =>  $username,
                                                 'zpass'         =>  $hashPass,
                                                 'zemail'        =>  $useremail,
                                                 'zname'         =>  $userfull,
                                                               ));
                                          // Echo Success Message 
                                          $Msg = "<div class='alert alert-success'>". $stmt ->rowCount().' Recodre Updated</div>'; 
                                          redirectHome($Msg, 'back'); 

                                          
                                   }

              }else {
              $Msg = '<div class="alert alert-danger"> Sorry You Can\t Browse This Page Directly  </div>';
              redirectHome($Msg, 'back');

              echo '</div>';   
                     }

              }



       

       } elseif($do == 'Edit'){  // Edit page  

              // Check if Get Request userid Is Nummeric & Get the Integer Value Of It 
              $userid =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

              // Select All Data Depend On this ID 
              $stmt = $con->prepare("SELECT * FROM users WHERE UserID =  $userid  LIMIT 1");

              // Execute Query
              $stmt  ->execute(array($userid));

              // Fetch Data 
              $row   = $stmt->fetch();
              // Row count
              $count = $stmt->rowCount();

              // If There's Such ID Show Form
              if($stmt->rowCount()){?>

                            <h1 class="text-center">Edit Member</h1>
                            <div class="form-horizontal">
                            <form class="center" action=" ?do=Update" method= "POST">
                                          <!-- hidden input to be send to the Uppdate page -->
                                          <input type="hidden" name="userid" value="<?php echo$userid ?>">

                                          <div class="mb-3 ">
                                                 <label for="exampleInputEmail1" class="form-label">Username</label>                                          <div class="col-md-12">
                                                 <div class="col-md-12">
                                                 <input type="text" class="form-control" value="<?php echo $row['username']?>" 
                                                 name="username" id="exampleInputEmail1" required="required">
                                                 </div>
                                          </div>
                                   

                                          <div class="mb-3">           
                                                 <label for="exampleInputPassword1" class="form-label">Password</label>
                                                 <div class="col-md-12">
                                                 <!-- If New password ? Update It : take The old one -->
                                                 <input type="hidden" value="<?php echo $row['Password'];?>" name="oldpassword">
                                                 <input type="password" class="form-control"  name="newpassword">                                          </div>
                                                 </div>
                                          </div>
                                          <div class="mb-3">
                                                 <label for="exampleInputPassword1" class="form-label" >Email</label>
                                                 <div class="col-md-12">
                                                 <input type="email"  name ="email" class="form-control "value="<?php echo $row['Email']?>"  id="exampleInputPassword1" required="required">
                                                 </div>
                                          </div>

                                          <div class="mb-3">
                                          <label for="exampleInputPassword1" class="form-label">Full Name</label>
                                                 <div class="col-md-12">
                                                 <input type="text" class="form-control" name ="full" value="<?php echo $row['FullName']?>" id="exampleInputPassword1">
                                                 </div>
                                          </div>
                                          <div class="row g-3 align-items-center">
                                          <div class="col-sm-offset-sm-10">
                                          <input type="submit" value="Save" class="btn btn-primary btn-lg" aria-describedby="passwordHelpInline">
                                          </div>
                                          </div>

                            </form>


              
              <?php   
                     // If ther's No Such Id Show Message
                     }else{ 

                            echo "<div class='container'>";
                            $Msg = "there is no such id"; 
                            redirectHome($Msg , 'back');


                           echo  "</div>";
                     
                     
                     
                     } 



       } elseif($do == 'Update'){
       echo '<div class="container">';
       echo '<h1 class="text-center">Update Member</h1>';
       // Get varibles From The Form
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
              $userid = $_POST['userid'];
              $username = $_POST['username'];
              $useremail = $_POST['email'];
              $userfull = $_POST['full'];

       // Password Trick

       $pass= empty($_POST['newpassword'])? $_POST['oldpassword']:sha1($_POST['newpassword']);

       /* $pass = "";

       if(empty($_POST['newpassword'])){
              $pass = $_POST['oldpassword'];
       }else{
              $pass = sha1($_POST['newpassword']);

       }*/

       // Validate Form 

       $formErorrs = array();

       if(empty($username)){
              $formErorrs[] = 'User Name can\'t Be Empty'; }  

       if(!empty($username)) {
              if (strlen($username)<2){
                     $formErorrs[] = 'User Name can\'t Be Less Than 2';}
       }




       if(empty($useremail)){
              $formErorrs[] = 'User Email can\'t Be Empty'; }  

       if(empty($userfull)){
                     $formErorrs[] = 'User  Full Name can\'t Be Empty'; }   


       foreach($formErorrs as $error){
              echo "<div class='alert alert-danger'>$error</div>";
       }
              // Check If No Eroors Proceed The Update Operation

              if(empty($formErorrs)){
                     // Update The DataBase With This Info 
                     $stmt = $con->prepare("UPDATE users SET username =?, Email=? ,FullName= ? , Password = ? where userID= ? ");
                     $stmt ->execute(array($username,$useremail,$userfull,$pass,$userid));
                     // Echo Success Message 
                     $Msg = "<div class='alert alert-success'>". $stmt ->rowCount().' Recodre Updated</div>';  
                     redirectHome($Msg, 'back');
              }
              

       }else {
              $Msg = '<div class="alert alert-danger"> Sorry You Can\t Browse This Page Directly  </div>';
              redirectHome($Msg, 'back');
       }
       echo '</div>';   
       } elseif($do == 'Delete'){ // Delete Member Page 
              echo '<div class="container">';
              echo '<h1 class="text-center">Update Member</h1>';

              // Check if Get Request userid Is Nummeric & Get the Integer Value Of It 
              $userid =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

              // Select All Data Depend On this ID 
              $stmt = $con->prepare("SELECT * FROM users WHERE UserID =  $userid  LIMIT 1");

              // Execute Query
              $stmt  ->execute(array($userid));

              // Row count
              $count = $stmt->rowCount();

              // If There's Such ID Show Form
              if($stmt->rowCount()>0){ 

                     $stmt = $con->prepare("DELETE FROM users WHERE userID = :zuser");
                     $stmt ->bindParam(":zuser", $userid); 
                     $stmt->execute();
          
              } 
                 // Echo Success Message 
                 $Msg = "<div class='alert alert-success'>". $stmt ->rowCount().' Recodre Updated</div>';  

                 redirectHome($Msg ,'back');
             echo "</div>";

       }  elseif($do == 'Activate') {// Acivate Mebmber Page 
              echo '<div class="container">';
              echo '<h1 class="text-center">Activate Member</h1>';

              // Check if Get Request userid Is Nummeric & Get the Integer Value Of It 
              $userid =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

              // Select All Data Depend On this ID 
              $stmt = $con->prepare("SELECT * FROM users WHERE UserID =  $userid  LIMIT 1");

              // Execute Query
              $stmt  ->execute(array($userid));

              // Row count
              $count = $stmt->rowCount();

              // If There's Such ID Show Form
              if($stmt->rowCount()>0){ 

                     $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE  userID =  ?");
                     $stmt->execute(array($userid));
          
              } 
                 // Echo Success Message 
                 $Msg = "<div class='alert alert-success'>". $stmt ->rowCount().' Recodre Updated</div>';  

                 redirectHome($Msg ,'back');
             echo "</div>";


       }
         include $tpl.'footer.php';
}else{
header('Location:index.php');
exit();
}

?>
