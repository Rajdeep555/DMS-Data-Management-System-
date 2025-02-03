<?php
session_start();
ob_start();
/******     *Condition*                  *True*             *False***/
$user_id=isset($_SESSION["user_id"])?$_SESSION["user_id"]:"";
if($user_id==0 || $user_id=='')
{
	header("Location:authentication.php?module=Login");
}
//session_destroy();
?>
<? ob_end_flush();?>