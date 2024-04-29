<?php
    session_start();
    include('../assign/config');
    error_reporting(0);
    if(isset($_POST['submit']))
    {
        $userName = $_POST['username'];
        $userPass = $_POST['password'];
        $qUser = mysqli_query($dbcon,"SELECT * FROM users WHERE userEmail='$userName' AND password='$userPass' ");
        $result=mysqli_fetch_array($qUser);

        if($result>0)
        {
            $_SESSION['login']=$_POST['username'];
            $_SESSION['id']=$result['id'];
            $userid=$result['id'];
            $userip=$_SERVER['REMOTE_ADDR'];
            $status=1;
            /* stroing log if user login successfull  */
            $log=mysqli_query($dbcon,"INSERT INTO userLogs(userid, username, userip , status) 
                                      VALUES('$userid','$userName','$userip','$status' )");
            header("location:dashboard.php")
        } else {
            /* for stroing log if user login unsuccessfull */
            $_SESSION['login']=$_POST['username'];
            $userip=$_SERVER['REMOTE_ADDR'];
            $status=0;
            mysqli_query($dbcon,"INSERT INTO userLog(username, userip, status)
                                 VALUES('$userName','$userip',$status') ");
            $_SESSION['errmsg']="Invalid username or password";
            header('location:userLog.php');
        }
    }
?>
<!-- login form -->
<div class="box-login">
    <form class="form-login" method="post">
        <fieldset>
                <legend>Sign in to account</legend>
                <p>Please enter your name and password to log in.<br>
                    <span style="color:red;"><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errmsg']="";?></span>
                </p>
                <div class="form-group">
                      <span class="input-icon">
                             <input type="text" name="username" class="form-control" placeholder="Username">
                             <i class="fa fa-user"></i>
                      </span>
                </div>
                <div class="form-group">
                      <span class="input-icon">
                            <input type="password" name="password" class="form-control password" placeholder="Password">
                            <i class="fa fa-lock"></i>
                      </span>
                      <a href="forgotPassword.php">Forgot Password ?</a>
                </div>
                <div class="form-actions">
                      <button name="submit" type="submit" class="btn btn-primary pull-right">
                            Login<i class="fa fa-arrow-right"></i>
                      </button>
                </div>
                <div class="new-account">Don't have an account yet?
                      <a href="registion.php">Create an account</a>
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
