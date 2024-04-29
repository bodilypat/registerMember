<?php
    require_once("../assign/config.php");
    if(!empty($_POST['email']))
    {
        $email=$_POST['email'];
        $qUser=mysqli_query($dbcon,"SELECT email FROM users WHERE email='$email' ");
        $cRow=mysqli_num_rows($qUser);
        if($cRow>0)
        {
            echo "<span style='color:red'>Email already exists.</script>";
            echo "<script>$('submit').prop('disabled', ture);</script>";
        } else {
            echo "<span style='color:green'>Email available for Registration.<span>";
            echo "<script>$('#submit').prop('disabled', false);</script>";
        }
    }
?>
