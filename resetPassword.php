<?php
    session_start();
    include('../assign/config.');
    /* updating password */
    if(isset($_POST['submit']))
    {
        $userName=$_POST['fullname'];
        $userEmail=$_POST['email'];
        $nPassword=md5($_POST['password']);
        $qUser=mysqli_query($dbcon,"SELECT users SET password='$nPass' WHERE fullName='$userName' AND email='$userEmail' ");
        if($qUsert)
        {
            echo "<script>alert('Password successfully update');</script>";
            echo "<script>widow.location.href='userLogin.php'</script>"
        }
    }
?>
<!-- validation script -->
<script type="text/javascript">
    function valid()
    {
        if(document.passwordreset.password.value != document.passwordreset.confimPassword.value)
        {
            alert('Pasword and Confirm Passwird Field do not match !! ');
            document.passwordreset.confirmPassword.focus();
            return false;
        }
        return true;
    }
</script>
<!-- section: form login -->
<div class="box-login">
    <form name="passwordreset" class="form-login" method="post" onSubmit="return valid();">
         <fieldset>
                 <legend>User Reset Password</legend>
                 <p>Please set your new password</br /></p>
                 <span style="color:red;">
                       <?php echo $_SESSION['errmsg']; ?>
                       <?php echo $_SESSION['errmsg']=""; ?>
                 </span>
                 <div class="form-group">
                       <span class="input-icon">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <i class="fa fa-lock"></i>
                       </span>
                 </div>
                 <div class="form-group">
                       <span class="input-icon">
                            <input type="password" name="conformPassword" id="confirmPassword" placeholder="Confirm Password" requried>
                            <i class="fa fa-lock"></i>
                       </span>
                 </div>
                 <div class="form-actions">
                       <button type="submit" name="change" class="btn btn-primary pull-right" >
                              Change<i class="fa fa-arrow-circle-right"></i>
                       </button>
                 </div>
                 <div class="new-account">
                        Already have an account? <a href="userLogin.php">Log-in</a>
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