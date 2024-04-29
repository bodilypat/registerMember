<?php
    session_start();
    include("../assign/config.php");
    include("../assign/checklogin.php");
    check_login();
    date_default_timezone_set('America/Los_Angels');
    $crrentTime = date('d-m-Y h:i:s A', time ());
    if(isset($_POST['submit']))
    {
        $qUser=mysqli_query($dbcon,"SELECT password FROM users WHERE password='".md5($_POST['cpass'])."' && id='".$_SESSION['id']."'");
        $result=mysql_fetch_array($qUser);
        if($result>0)
        {
            $editUser=mysqli_query($dbcon,"UPDATE users SET password='".md5($_POST['npass'])."', updateDate='$currentTime' 
                                           WHERE id='".$_SESSION['id']."'");
                $_SESSION['msg']="Password Changed Successfull !!";
        }
        else {
            $_SESSION['msg']="Old Password not match !!";
        }
    }
?>
<!-- validation script -->
<script type="text/javascript">
    function valid()
    {
        if(document.changpwd.cpass.value=="")
        {
            alert("Current Password Filed is Empty !! ");
            document.changpwd.cpass.focus();
            return false;
        } else if(document.changpwd.npass.value=="")
        {
            alert("New Password Filed is Empty !!");
            document.changpwd.npass.focus();
            return false;
        } else if(document.changpwd.cfpass.value=="")
        {
            alert('Confirm Password Filed is Empty !!');
            document.changpwd.cfpass.focus();
            return false;
        } else if(document.changpwd.npass.value != document.changpwd.cfpass.value)
        {
            document.changpwd.cfpass.focus();
            return false;
        }
        return true;
    }
</script>
<!-- section get email -->
<div class="change-email">
    <p style="color:red;">
        <?php echo htmlentities($_SESSION['msg']); ?>
        <?php echo htmlentities($_SESSION['msg']); ?>
    </p>
    <form name="changpwd" role="form" method="post" onSubmit="return valid(); ">
           <div class="form-group">
                <label for="CurrentPassword">Current Password</label>
                <input type="password" name="cpass" class="form-control" placeholder="Current Password">
           </div>
           <div class="form-group">
                 <label for="NewPassword">New Password</label>
                 <input type="password" name="npass" class="form-control" placeholder="New Password">
           </div>
           <div class="form-group">
                 <label for="ConfirmPassword">Confirm Password</label>
                 <input type="password" name="cfpass" class="form-control" placeholder="Confirm Password">
           </div>
           <button type="submit" name="submit" class="btn btn-o btn-primary">
                Submit
          </button>
    </form>
</div>
<!-- javascript -->
<script>
    jQuery(document).ready(function(){
        Main.init();
        FormElements.init();
    });
</script>