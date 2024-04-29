<?php
    session_start();
    error_reporting(0);
    include('../assign/config.php');
    /* checking detail password */
    if(isset($_POST['submit']))
    {
        $userName=$_POST['fullname'];
        $userEmail=$_POST['eMAIL'];
        $qMem=mysqli_query($dbcon,"SELECT id from users WHERE fullName='$userName' AND email='$userEmail' ");
        $cRows=mysqli_num_rows($qMem);

        if(cRows>0)
        {
            $_SESSION['name']=$userName;
            $_SESSION['email']=$userEmail;
            heaader('location:resetPassword.php');
        } else 
        {
            echo "<script>alert('Invalid data. Please try valid data ');</script>";
            echo "<script>window.location.href='forgotPassword.php'</script>";
        }
    }
?>
 <!-- section : login form -->
 <div class="box-login">
    <form class="form-login" method="post">
         <fieldset>
              <legend>User password recovery</legend>
              <p>Please enter email and password to recover your password</p>
              <div class="form-group">
                    <span class="input-icon">
                          <input type="text" name="fullname" class="form-control" placeholder="Registred full Name">
                          <i class="fa fa-lock"></i>
                    </span>
              </div>
              <div class="form-group">
                    <span class="input-icon">
                         <input type="email" name="email" class="form-control" placeholder="registered email">
                         <i class="fa fa-user"></i>
                    </span>
              </div>
              <div class="form-action">
                    <button type="submit" name="submit" class="btn btn-primary pull-right">
                        Reset<i class="fa fa-arrow-circle-right"></i>
                    </button>
              </div>
              <div class="new-accout">
                    Already have an account <a href="userLogin.php" >Log-in</a>
              </div>
         </fieldset>
    </form>
 </div>
 <!-- javascript -->
 <script>
    jQuery(document).ready(function(){
        Main.init();
        Login.init();
    });
 </script>