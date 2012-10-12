<?php
include_once ("../common/Objects.php");

if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['_loginUser']))
{
	header( 'Location: ../default/login.php' );
	exit;
}

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_prof_image = 'Edit Profile Image';
	$l_prof_perso = 'Personal Information';
	$l_prof_educa = 'Education History';
	$l_prof_emplo = 'Employment History';
	$l_prof_passw = 'Change Password';
}
else if($_SESSION['_language'] == 'zh') {
	$l_prof_image = '&#20462;&#25913; &#29031;&#29255;';
	$l_prof_perso = '&#20462;&#25913; &#20010;&#20154;&#20449;&#24687;';
	$l_prof_educa = '&#20462;&#25913; &#25945;&#32946;&#21382;&#21490;';
	$l_prof_emplo = '&#20462;&#25913; &#24037;&#20316;&#21382;&#21490;';
	$l_prof_passw = '&#20462;&#25913; &#30331;&#24405;&#20449;&#24687;';
}

//=========================================================================================================

?>
<style type="text/css">
a.bluelink{color:blue}
a.bluelink:hover{color:blue}
div#ppimg_div{text-align:left;margin-top:5px;margin-left:5px;height:80px;}
img#ppimg_img{width:65px;height:65px;margin-right:5px;border-top:1px solid #DDD;border-left:1px solid #DDD;border-bottom:2px solid #DDD;border-right:2px solid #DDD;}
label#ppimg_label{color:#184D94;font-size:.7em;margin-left:0px;font-weight:bold;}
</style>
<div id="ppimg_div">
<img id="ppimg_img" src="<?php echo $_SESSION['_loginUser']->pic?>" align="left" /><br>
<?php
$user = $_SESSION['_loginUser'];
$name = ($_SESSION['_language'] == 'zh') ? $user->lastname.$user->firstname : $user->firstname.' '.$user->lastname;
echo '<label id="ppimg_label">'.$name.'</label>';
?>
</div>
<div class="left_nav_item" style="margin-bottom:10px;"><a class="left_nav_list_outer bluelink" href="../home/image_picker.php"><?php echo $l_prof_image?></a></div>
<div class="left_nav_item"><a class="left_nav_list_outer bluelink" href="../home/personal_info.php"><?php echo $l_prof_perso?></a></div>
<div class="left_nav_item"><a class="left_nav_list_outer bluelink" href="../home/education_history.php"><?php echo $l_prof_educa?></a></div>
<div class="left_nav_item"><a class="left_nav_list_outer bluelink" href="../home/employment_history.php"><?php echo $l_prof_emplo?></a></div>
<div class="left_nav_item"><a class="left_nav_list_outer bluelink" href="../home/secure_info.php"><?php echo $l_prof_passw?></a></div>