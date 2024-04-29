<?php
    session_start();
    include('../assign/config.php');
    include('../assign/checklogin.php');
    check_login();
    if(isset($_POST['submit']))
    {
        $fullName=$_POST['fullname'];
        $userAdd=$_POST['address'];
        $city=$_POST['city'];
        $gender=$_POST['gender'];

        $qUser=mysql_query($dbcon,"UPDATE users SET fullname='$fullName', address='$userAddd', city='$city', gender='$gender' 
                                   WHERE id='".$_SESSION['id']."'");
        if($qUser)
        {
            $msg="Your Profile updated Successfully";
        }
    }
?>
<!-- edit profile -->
    <div class="container">
          <div class="row">
                <div class="col-md-12">
                      <div class="panel">
                            <div class="panel-heading">
                                  <h5 class="panel-title"><?php if($msg) { echo htmlentities($msg);} ?></h5>
                                  <div class="panel-body">
                                        <?php 
                                            $qUser=myqli_query($dbcon,"SELECT * FROM users WHERE ID='"$_SESSION['id']."'");
                                            while($result=mysqli_fetch_array($qUser))
                                            {
                                        ?>
                                        <h4><?php echo htmlentities($result['fullname']);?>'s Profile</h4>
                                        <p><b>Profile Registration Date: </b><?php echo htmlentities($result['regisDate']); ?></p>
                                        <?php if($result['updateDate']){?> 
                                         <p><b>Profile Last Updateion Date: </b><?php echo htmlentities($result['updateDate']); ?></p>
                                        <?php }?>
                                        <hr />
                                        <form name="edit" role="form" method="post">
                                               <div class="form-group">
                                                     <label for="FullName">User Name</label>
                                                     <input name="fullname" type="text" class="form-control" 
                                                            value="<?php echo htmlentities($result['fullName']);?>">
                                               </div>
                                               <div class="form-group">
                                                     <label for="Address">Address</label>
                                                     <textarea name="address" class="form-control">
                                                               <?php echo htmlentities($result['address']);?>
                                                     </textarea>
                                               </div>
                                               <div class="form-group">
                                                     <label for="City">City</div>
                                                     <input type="text" name="city" class="form-control" required="required"
                                                            value="<?php echo htmlentities($result['city']);?>">
                                               </div>
                                               <div class="form-group">
                                                     <label for="Gender">Gender</label>
                                                     <select name="gender" clas="form-control" required="required">
                                                            <option value="<?php echo htmlentities($result['gender']);?>">
                                                                    <?php echo htmlentities($result['gender']);?>
                                                            </option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                     </section>
                                               </div>
                                               <div class="form-group">
                                                     <label for="Email">User Email</label>
                                                     <input type="email" name="email" class="form-control" readonly="readonly"
                                                            value="<?php echo htmlentities($result['email']);?>">
                                                            <a href="changEmail.php">Update your email</a>
                                               </div>
                                               <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
                                        </form>
                                        <?php } ?>
                                  </div>
                            </div>
                      </div>
                </div>
          </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>