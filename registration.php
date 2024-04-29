<?php
    include_once('../assign/config.php');
    if(isset($_POST['submit']))
    {
        $userName=$_POST['fullname'];
        $userAdd=$_POST['address'];
        $userCity=$_POST['city'];
        $userGen=$_POST['gender'];
        $userEmail=$_POST['email'];
        $userPass=$_POST['password'];

        $qUser=mysqli_query($dbcon,"INSERT INTO users(fullname, address, city, gender, password)
                                    VALUES('$userName','$userAdd','$userCity','$userGen','$userEmail','$userPass' ");
        if($qUser)
        {
            echo "<script>alert('Successfully Registered. you can login now');</script>";
        }
    }
?>
<!-- script validate data -->
<script type="text/javascript">
    function valid()
    {
        if(document.registration.password.value != document.registration.cfpassword.value)
        {
            alert("Password and Confirm Password Filed do not match !! ");
            document.registration.password.focus();
            return false;
        }
        return turn;
    }
</script>
<!--section: register box  -->
<div class="box-register">
    <form name="registration" id="registration" method="post" onSubmit="return valid();">
         <fieldset>
                <legend>Sign Up</legend>
                <p>Enter your personal detail below: </p>
                <div class="form-group">
                      <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                      <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
                <div class="form-group">
                      <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>
                <div class="form-group">
                      <label class="block">Gender</label>
                      <div class="clip-radio radio-primary">
                            <input type="radio" id="rg-female" name="gender" value="female">
                            <label for="rg-female">Female</label>
                            <input type="radio" id="rg-male" name="gender" value="male">
                            <label for="rg-male">Male<label>
                      </div>
                </div>
                <div class="form-group">
                      <span class="input-icon">
                            <input type="email" name="email" id="email" class="form-control" onBlur="userAvailability()" placeholder="Email" required>
                            <i class="fa fa-envelope"></i>
                      </span>
                      <span id="user-availability-status" style="font-size:12px; "></span>
                </div>
                <div class="form-group">
                      <span class="input-icon">
                             <input type="password" name="password" id="password" class="form-control" placeholder="Password" required >
                             <i class="fa fa-loch"></i>
                      </span>
                </div>
                <div class="form-group">
                       <span class="input-icon">
                            <input type="password" name="cfpassword" id="cfpassword" class="form-control" placeholder="Confirm Password" required>
                            <i class="fa fa-lock"></i>
                       </span>
                </div>
                <div class="form-group">
                       <div class="checkbox clip-check check-primary">
                             <input type="checkbox" id="agree" id="agree" value="agree" checked="true" readonly="true">
                             <label for="agree">I agree</label>
                       </div>
                </div>
                <div class="form-actions">
                       <p>Already have an account? <a href="userLogin.php">Log-in</a></p>
                       <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">
                              Submit<i class="fa fa-arrow-circle-right"></i>
                       </button>
                </div>
         </fieldset>
    </form>
</div>
<!-- javascript -->
<script>
    jQuery.(document).ready(function(){
        jQuery.init();
        Login.init();
    });
</script>
<!-- ajax -->
<script>
    function userAvailability(){
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "checkAvailability.php",
            data: 'email='+$('#email').val(),
            type= "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $('#loaderIcon').hide();
            },
            error:function() {}
        });
    }
</script>
