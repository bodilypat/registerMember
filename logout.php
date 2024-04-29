<?php
    session_start();
    include('../assign/config.php');
    $_SESSION['login']=="";
    date_default_timezone_set('America/Los_Angels');
    $lateDate=date('d-m-y h:i:s A', time() );
    mysqli_query($dbcon,"UPDATE userlog SET logout='$lateDate' WHERE uid='".$_SESSION['id']."' ORDER BY id DESC LIMIT 1");
    session_unset();
    /* session_destroy(); */
    $_SESSION['errmsg']="You have successfully logout";
?>
<script language="javascript">
    document.location="../userLogin.php";
</script>