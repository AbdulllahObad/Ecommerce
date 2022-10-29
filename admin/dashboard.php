<?php
session_start();

if(isset($_SESSION['Username'])){
       $pageTitle ="Dashboard";
       include 'init.php';
       // Start Dashboard Page

       $latestUsers = 5;// Number Of The Latest users
       $theLatest = getLatest("*", "users","userID" ,$latestUsers); // Latest users Array

        ?>
       
        <div class="container home-stats text-center">
              <h1>Dashboard</h1>
              <div class="row">
                     <div class="col-md-3">
                            <div class="stat st-members">
                                   Total Members
                                   <span ><a href="member.php"><?php echo countItems("userID","users")?></a></span>
                            </div>
                     </div>
                     <div class="col-md-3">
                            <div class="stat st-pending">
                                   Pending Members
                                   <span><a href="member.php?Page=Pending"><?php echo checkItem("RegStatus","users",0);  ?></a></span>
                            </div>
                     </div>
                     <div class="col-md-3 ">
                            <div class="stat st-items">
                                   Total Items
                                   <span>1500</span>
                            </div>
                     </div>
                     
                     <div class="col-md-3 ">
                            <div class="stat st-comments">
                                   Total Comments
                                   <span>1350</span>
                            </div>
                     </div>

              </div>
        </div>
        <div class="container latest">
              <div class="row">
                     <div class="col-sm-6">
                            <div class="card">
                              <div class="card-header">
                            👥
                                   Latest  <?php echo $latestUsers ?> Registed Users
                              </div>
                               <div class="card-body">
                                   <ul class="list-unstyled latest-users">
                                  <?php
                                   foreach ($theLatest as $user){
                                   echo '<li>';
                                   echo  $user['username'];
                                   echo "<a href='member.php?do=Edit&userid=" . $user['userID']."'>";
                                   echo '<span class="btn btn-success pull-right">'; 
                                   echo "🖌️Edite";
                                   if($user['RegStatus'] == 0){
                                          echo " <a href='member.php?do=Activate&userid=".$user['userID']."' class='btn btn-info pull-right'>Activate</a>";
  
                                           }
                                   echo "</span></li></a>";

 
                                   }  ?>
                                   </ul>
                              </div>
                            </div>
                     </div>
                     <div class="col-sm-6">
                            <div class="card">
                            <div class="card-header">
                            🔖
                                   Latest Items
                            </div>
                            <div class="card-body">
                                   Test
                            </div>
                            </div>
                     </div>
              </div>
       </div>



       <?php
       include $tpl."footer.php";
}else{
       header('Location: index.php');
       exit();
}