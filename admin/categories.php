<?php
/*
===============================================================
=== Category Page
===============================================================
*/

ob_start();
session_start();
$pageTitle = 'Categories';

if(isset($_SESSION['Username'])){
       include 'init.php';
       $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
       if ($do == 'Manage') {
              $sort = 'ASC';
              $sort_array = array('ASC','DESC');
              if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array )){
                     $sort = $_GET['sort'];
              }
              $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
              $stmt2->execute();
              $cats = $stmt2->fetchAll();?>
              <h1 class="text-center">Manage Categories</h1>
              <div class="container categories">
              <div class="col-sm-10">
                            <div class="card">
                            <div class="card-header">                           
                            <h4>  Manage Categories
                            <div class="ordering pull-right">
                                   <h6> Ordering : 
                                   <a class="<?php if($sort == 'ASC'){echo 'active';}    ?>" href="?sort=ASC" >ASC</a> |
                                   <a class="<?php if($sort == 'DESC'){echo 'active';}    ?>" href="?sort=DESC" >DESC</a>
                                   </h6>
                            </div>
                            </h4>
                            </div>
                            <div class="card-body">
                                   <?php
                                          foreach($cats as $cat){
                                                 echo "<div class='cat'>";
                                                        echo "<div class='hidden-buttons'>";
                                                               echo "<a href='categories.php?do=Edit&catid=".$cat["ID"]."' class='btn btn-xs btn-primary'>Edit</a>";
                                                               echo "<a href='categories.php?do=Delete&catid=".$cat["ID"]."' class='confirm btn btn-xs btn-danger'>Delete</a>";
                                                        echo "</div>";

                                                        echo "<h3>".$cat["Name"]."</h3>";
                                                        echo "<div class='full-view'>";
                                                               echo "<p>"; if($cat["Description"] == '')
                                                                      {echo 'This category has no description </p>';}
                                                                      else 
                                                                      {echo $cat["Description"].'</p>';};
                                                               if($cat["Visibility"] == 1)  {echo '<span class="visiblity">Hidden</span>';}
                                                               if($cat["Allow_Comment"] == 1){echo '<span class="commenting">Comment Disabled</span>';}
                                                               if($cat["Allow_Ads"] == 1){echo '<span class="ads">Ads Disabled</span>';} 
                                                        echo "</div>";                                        
                                                  echo "</div>";
                                                 echo "<hr>";
                                          }?>
                            </div>
                            </div>
                     </div>
                     <a class="add-cat btn btn-primary" href="categories.php?do=Add">Add New Category</a>
              </div>
       <?php
       } elseif ($do == 'Add') {// Add new Categorie Page?>
              <h1 class="text-center">Add New Category</h1>
              <div class="form-horizontal">
              <form action="?do=Insert" method="POST" class="center">
              <div class="mb-3 ">
                     <label for="exampleInputEmail1" class="form-label"  >Name</label>                                          <div class="col-md-12">
                            <div class="col-md-12">
                                   <input type="text" class="form-control"  
                                   name="name" id="exampleInputEmail1" placeholder="Name Off The Category" required="required">
                            </div>
                     </div>
                     </div>
                            
              <div class="mb-3">           
                     <label for="exampleInputPassword1" class="form-label" >Description</label>
                     <div class="col-md-12">
                     <input type="text" class=" description form-control"  name="description" placeholder="Describe Category" >
                     </div>
                     
              </div>
              <div class="mb-3">
                     <label for="exampleInputPassword1" class="form-label"  >Ordering</label>
                     <div class="col-md-12">
                     <input type="text"  name ="ordering" class="form-control   id="exampleInputPassword1 placeholder="Number To Arrange The Categories" >
                     </div>
              </div>

              <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Visible</label>
                     <div class="col-md-12">
                            <div class="">
                                   <input type="radio" id="vis-yes" name="visibility" value="0" checked>
                                   <label for="vis-yes">Yes</label>
                            </div>
                            <div class="">
                                   <input type="radio" id="vis-no" name="visibility" value="1" checked>
                                   <label for="vis-no">NO</label>
                            </div>
              </div>
              </div>
                     

              <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Allow Commenting</label>
                     <div class="col-md-12">
                            <div class="">
                                   <input type="radio" id="com-yes" name="commenting" value="0" checked>
                                   <label for="com-yes">Yes</label>
                            </div>
                            <div class="">
                                   <input type="radio" id="com-no" name="commenting" value="1" checked>
                                   <label for="com-no">NO</label>
                            </div>
              </div> 
              </div>
              <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Allow Ads</label>
                     <div class="col-md-12">
                            <div class="">
                                   <input type="radio" id="Ads-yes" name="ads" value="0" checked>
                                   <label for="Ads-yes">Yes</label>
                            </div>
                            <div class="">
                                   <input type="radio" id="Ads-no" name="ads" value="1" checked>
                                   <label for="com-no">NO</label>
                            </div>
              </div>
              </div>
              <div class="row g-3 align-items-center">
                     <div class="col-sm-offset-sm-10">
                     <input type="submit" value="+ Add Category" class="btn btn-primary btn-lg" aria-describedby="passwordHelpInline">
                     </div>
              </div>
              </form>
              </div>
       
               <?php 
       } elseif ($do == 'Insert') {
              // Insert To DB From 
              // Get varibles From The Form
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                     echo '<div class="container">';
                     echo '<h1 class="text-center">Update Member</h1>';

                     $name     = $_POST['name'];
                     $desc     = $_POST['description'];
                     $order    = $_POST['ordering'];
                     $visible  = $_POST['visibility'];
                     $comment  = $_POST['commenting'];
                     $ads      = $_POST['ads'];


                     // Validate Form 
                     // Check If Category Exist in Database
                     $check = checkItem("name", "categories ", $name); 
                     if($check == 1){
                          $msg =   'Sorry This Category Is Exist';
                            redirectHome($msg);

                     } else {
                           // Insert Category Infos To The DataBase 
                            $stmt = $con->prepare("INSERT INTO
                            categories ( Name,     Description  ,  Ordering,   Visibility  , Allow_Comment, Allow_Ads)
                            VALUES(      :zname , :zdescription  , :zordering, :zvisibility , :zcomment    , :zads )");

                            $stmt ->execute(array(

                                   'zname'           =>     $name ,
                                   'zdescription'    =>     $desc ,
                                   'zordering'        =>     $order ,
                                   'zvisibility'      =>     $visible,
                                   'zcomment'         =>     $comment,
                                   'zads'             =>     $ads ,
                                                 ));

                            // Echo Success Message 
                            $Msg = "<div class='alert alert-success'>". $stmt ->rowCount().' Recodre Updated</div>'; 
                            redirectHome($Msg, 'back'); 

                     }
                         
              }



       } elseif ($do == 'Edit') {
              // Check if Get Request catrid Is Nummeric & Get the Integer Value Of It 
              $catid =isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;
                    // Select All Data Depend On this ID 
                    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");
                    // Execute Query
                     $stmt  ->execute(array($catid));
                    // Fetch Data 
                     $cat  = $stmt->fetch();
                    // Row count
                     $count = $stmt->rowCount();   
                    // If There's Such ID Show Form
                     if($stmt->rowCount() > 0 ){?>
                     <h1 class="text-center">Edit Category</h1>
                     <div class="form-horizontal">
                            <form action="?do=Update" method="POST" class="center">
                            
                            <!-- hidden input to be send to the Uppdate page -->
                            <input type="hidden" name="catid" value="<?php echo $catid ?>">
                            <div class="mb-3 ">
                                   <label for="exampleInputEmail1" class="form-label"  >Name</label>                                          <div class="col-md-12">
                                          <div class="col-md-12">
                                                 <input type="text" class="form-control"  
                                                 name="name" id="exampleInputEmail1" placeholder="Name Off The Category" required="required" value="<?php echo  $cat['Name'];?>">
                                          </div>
                            </div>
                     </div>
                            
                     <div class="mb-3">           
                            <label for="exampleInputPassword1" class="form-label" >Description</label>
                            <div class="col-md-12">
                            <input type="text" class=" description form-control"  name="description" placeholder="Describe Category" value="<?php echo  $cat['Description']; ?>">
                            </div>
                            
                     </div>
                     <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label"  >Ordering</label>
                            <div class="col-md-12">
                            <input type="text"  name ="ordering" class="form-control   id="exampleInputPassword1 placeholder="Number To Arrange The Categories" value="<?php echo  $cat['Ordering']; ?>">
                            </div>
                     </div>
                     <div class="mb-3">
                     <label for="exampleInputPassword1" class="form-label">Visible</label>
                            <div class="col-md-12">
                                   <div class="">
                                          <input type="radio" id="vis-yes" name="visibility" value="0" <?php if($cat['Visibility'] == 0){ echo 'checked';} ?> />
                                          <label for="vis-yes">Yes</label>
                                   </div>
                                   <div class="">
                                          <input type="radio" id="vis-no" name="visibility" value="1" <?php if($cat['Visibility'] == 1){ echo 'checked';} ?> />
                                          <label for="vis-no">NO</label>
                                   </div>
                     </div>
                     </div>
                     <div class="mb-3">
                     <label for="exampleInputPassword1" class="form-label">Allow Commenting</label>
                            <div class="col-md-12">
                                   <div class="">
                                          <input type="radio" id="com-yes" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0){ echo 'checked';} ?>>
                                          <label for="com-yes">Yes</label>
                                   </div>
                                   <div class="">
                                          <input type="radio" id="com-no" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 0){ echo 'checked';} ?>>
                                          <label for="com-no">NO</label>
                                   </div>
                     </div> 
                     </div>
              <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Allow Ads</label>
                     <div class="col-md-12">
                            <div class="">
                                   <input type="radio" id="Ads-yes" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){ echo 'checked';} ?>>
                                   <label for="Ads-yes">Yes</label>
                            </div>
                            <div class="">
                                   <input type="radio" id="Ads-no" name="ads" value="1" <?php if($cat['Allow_Ads'] == 0){ echo 'checked';} ?>>
                                   <label for="com-no">NO</label>
                            </div>
              </div>
              </div>
              <div class="row g-3 align-items-center">
                     <div class="col-sm-offset-sm-10">
                     <input type="submit" value="Save" class="btn btn-primary btn-lg" aria-describedby="passwordHelpInline">
                     </div>
              </div>
              </form>
              </div>
              <?php  
                           // If ther's No Such Id Show Message
                     }else{ 
                                   echo "<div class='container'>";
                                   $Msg = "there is no such id"; 
                                   redirectHome($Msg , 'back');

                                   echo  "</div>";
                            
                            
                            
                            } 
       } elseif ($do == 'Update') {
              echo "<h1 class='text-center'>Update Category</h1>";
              echo "<div class='container'>";
              if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                     // GET VARIBLES FORM EDIT FORM 
                     $catid   = $_POST['catid'];
                     $catname = $_POST['name'];
                     $catdesc = $_POST['description'];
                     $catord  = $_POST['ordering'];
                     $catvis  = $_POST['visibility'];
                     $catcomt = $_POST['commenting'];
                     $catads  = $_POST['ads'];

                     // Update The Database  With This Info 
                     $stmt = $con->prepare("UPDATE categories SET Name =?, Description= ?,Ordering =?, Visibility=? ,Allow_Comment=?,Allow_Ads=? WHERE ID =?");
                     // Execute  Query 
                     $stmt->execute(array($catname,$catdesc,$catord,$catvis,$catcomt,$catads,$catid));
                     $msg = "<div class= 'alert alert-success'>".$stmt->rowCount(). "Record Updated </div>";
                     redirectHome($msg,'back');
              }       
              
              
              
              
              
              
              echo "</div>";

       } elseif ($do == 'Delete') {
              echo '<div class="container">';
              echo '<h1 class="text-center">Update Category</h1>';

              // Check if Get Request Catid Is Nummeric & Get the Integer Value Of It 
              $catid =isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;

              // Select All Data Depend On this ID 
              $stmt = $con->prepare("SELECT * FROM categories WHERE ID =  $catid  LIMIT 1");

              // Execute Query
              $stmt  ->execute(array($catid));

              // Row count
              $count = $stmt->rowCount();

              // If There's Such ID Show Form
              if($count>0){ 

                     $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zuser");
                     $stmt ->bindParam(":zuser", $catid); 
                     $stmt->execute();
          
              } 
                 // Echo Success Message 
                 $Msg = "<div class='alert alert-success'>". $stmt ->rowCount().' Recodre Updated</div>';  

                 redirectHome($Msg ,'back');
             echo "</div>";

       } 
       include $tpl .'footer.php';

 } else {
     echo $_SESSION['username'];
 }
 ob_end_flush();
?>
