<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Create New Workpackage | ProjNote';

	$l_create = 'Create a new';
	$l_create_wp = 'Workpackage';
	$l_req_field = '- Required fileds are labled with';
	$l_info = 'In ProjNote，a Workpackage could belong to a 
			   <span class="proj_info_obj" title="Helps to break down a project into detailed parts. e.g. it could be a project department group, a milestone, a project phase and etc.">Project Component</span> or directly to a 
			   <span class="proj_info_obj" title="Carefully plan, design and manage a set of work to achieve a particular aim.">Project</span>，itself contains many 
			   <span class="proj_info_obj" title="A single action or activity to achieve a goal.">Workitems</span>.';
	$l_nwp_name = 'Summary';
	$l_nwp_owner = 'Owner';
	$l_nwp_pc_blong = 'Project Component belongs to';
	$l_nwp_deadline = 'End Date';
	$l_nwp_descript = 'Description';
	$l_nwp_submit = 'Submit';

	$l_err_1 = '- Workpackage already exist.';
	$l_err_2 = '- Workpackage <span class="error_message_italic">End Date</span> must be after today.';
	$l_err_3 = '- System is temporarily busy, please try again later.';
	$l_err_4 = '- Please select a Project or a Project Component to create Workpackage for.';
	$l_err_5 = '- You do NOT have enough privilige to create Workpackage.';
	$l_err_6 = '- The <span class="error_message_italic">Workpackage Summary</span> field could NOT be empty.';
	$l_err_7 = '- The Workpackage <span class="error_message_italic">Owner</span> field could NOT be empty.';
	$l_err_8 = '- The <span class="error_message_italic">Owner</span> you specified for this Workpackage does NOT exist.';
	$l_err_9 = '- The Workpackage <span class="error_message_italic">Deadline</span> field could NOT be empty.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#26032;&#24314;&#24037;&#20316;&#21253; | ProjNote';
	
	$l_create = '&#26032;&#24314;';
	$l_create_wp = '&#24037;&#20316;&#21253;';
	$l_req_field = '&#8212; &#24517;&#39035;&#22635;&#20889;&#30340;&#20869;&#23481;';
	$l_info = '&#22312;ProjNote&#65292;&#19968;&#20010;&#24037;&#20316;&#21253;&#21487;&#20197;&#23646;&#20110;&#26576;&#20010;
			   <span class="proj_info_obj" title="&#23558;&#39033;&#30446;&#32452;&#25104;&#37096;&#20998;&#32454;&#33410;&#21270;&#65292;&#21487;&#20197;&#26159;&#19968;&#20010;&#39033;&#30446;&#37096;&#38376;&#65292;&#19968;&#20010;&#39033;&#30446;&#37324;&#31243;&#30865;&#25110;&#26159;&#19968;&#20010;&#39033;&#30446;&#38454;&#27573;&#12290;">&#39033;&#30446;&#32452;</span> &#25110;&#30452;&#25509;&#23646;&#20110;&#19968;&#20010;
			   <span class="proj_info_obj" title="&#36890;&#36807;&#35745;&#21010;&#65292;&#35774;&#35745;&#21644;&#31649;&#29702;&#19968;&#31995;&#21015;&#24037;&#20316;&#26469;&#36798;&#21040;&#19968;&#20010;&#29305;&#23450;&#30340;&#30446;&#30340;&#12290;">&#39033;&#30446;</span>&#65292;&#23427;&#30001;&#22810;&#20010;
			   <span class="proj_info_obj" title="&#19968;&#39033;&#21333;&#19968;&#30340;&#20855;&#20307;&#24037;&#20316;&#65292;&#29992;&#26469;&#23436;&#25104;&#19968;&#20010;&#20855;&#20307;&#20219;&#21153;&#12290;">&#24037;&#20316;&#39033;</span> &#32452;&#25104;&#12290;';
	$l_nwp_name = '&#31616;&#20171;';
	$l_nwp_owner = '&#25152;&#26377;&#32773;';
	$l_nwp_pc_blong = '&#25152;&#23646;&#39033;&#30446;&#32452;';
	$l_nwp_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_nwp_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_nwp_submit = '&#30830;&#23450;';

	$l_err_1 = '&#8212; &#24037;&#20316;&#21253;&#24050;&#32463;&#23384;&#22312;&#12290;';
	$l_err_2 = '&#8212; &#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290';
	$l_err_3 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_4 = '&#8212; &#35831;&#20808;&#36873;&#25321;&#39033;&#30446;&#25110;&#39033;&#30446;&#32452;&#65292;&#20877;&#26032;&#24314;&#24037;&#20316;&#21253;&#12290;';
	$l_err_5 = '&#8212; &#24744;&#27809;&#26377;&#36275;&#22815;&#26435;&#21033;&#26032;&#24314;&#24037;&#20316;&#21253;&#12290;';
	$l_err_6 = '&#8212; &#24037;&#20316;&#21253;<span class="error_message_italic">&#31616;&#20171;</span> &#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_err_7 = '&#8212; &#24037;&#20316;&#21253;<span class="error_message_italic">&#25152;&#26377;&#32773;</span> &#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_err_8 = '&#8212; &#24037;&#20316;&#21253;<span class="error_message_italic">&#25152;&#26377;&#29992;&#25143;</span> &#19981;&#23646;&#20110;&#26412;&#39033;&#30446;&#12290;';
	$l_err_9 = '&#8212; &#24037;&#20316;&#21253;<span class="error_message_italic">&#25130;&#27490;&#26085;&#26399;</span> &#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}

//=========================================================================================================

if (isset($_POST['status']) && isset($_SESSION['_project']))
{
	if ( DatabaseUtil::isProjectLeader($_SESSION['_userId'], $_SESSION['_project']->id) 
		 || (isset($_SESSION['_component']) && SecurityUtil::canUpdateComponentInfo()) )
	{
		if( isset($_POST['objective']) && !empty($_POST['objective']) &&
			isset($_POST['owner']) && is_numeric($_POST['owner']) &&
			isset($_POST['end_date']) && !empty($_POST['end_date']) )
		{
			$result = 0;
			$end = strtotime($_POST['end_date']);
			$today = strtotime(date("Y-m-d"));
	
			if (true)//$end > $today)
			{
				$ownerdb = $_POST['owner'];

				if (DatabaseUtil::isProjectMember($ownerdb, $_SESSION['_project']->id))
				{
					$proj = $_SESSION['_project'];

					$sId = CommonUtil::genRandomNumString(8);
					$comp_id = null;

					//check for the component belongs to the project for the purpose of hacking.
					if ( isset($_POST['component']) && !empty($_POST['component']) )
					{
						$comp_check = DatabaseUtil::getComp($_POST['component']);
						$comp_id = (isset($comp_check['p_id']) && $comp_check['p_id']==$proj->id) ? $_POST['component'] : -1;
					}

					if($comp_id != -1) {
						$result = DatabaseUtil::insertWorkPackage( $ownerdb,
																   $_SESSION['_userId'],
																   $_POST['objective'], 
																   $_POST['description'], 
																   $_POST['end_date'], 
																   $proj->id, 
																   $comp_id,
																   $sId );
						if ($result)
						{
							$newId = DatabaseUtil::getWorkPackageId($_POST['objective'], $sId);
							header( 'Location: work_package.php?wp_id='. $newId .'&sid='. $sId );
							exit;
						}
						else $result = 3;
					}
				}
				else $result = 8;
			}
			else $result = 2;
		}
		else if(!isset($_POST['objective']) || empty($_POST['objective'])) $result = 6;
		else if(!isset($_POST['owner']) || empty($_POST['owner'])) $result = 7;
		else $result = 9;
	}
	else $result = 5;
}
else if (!isset($_SESSION['_project']))$result = 4;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<!-- link calendar files  -->
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script language="JavaScript" src="../js/autocomplete.js"></script>
<script language="JavaScript" src="../js/common.js"></script>
<link rel="stylesheet" type='text/css' href="../css/AutoComplete.css" media="screen" /> 
<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel="stylesheet" type='text/css' href="css/project_layout.css" />
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<div id="left_nav"><?php include_once '../common/left_nav.inc.php';?></div>
	<div id="right_nav"><?php $_GET['right_nav_creat']=1; include_once '../common/right_nav.inc.php'; unset($_GET['right_nav_creat']);?></div>
	<div id="main_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
	<div id="project_info">
	<div id="page_title"><label><?php echo $l_create?>: <span id="page_title_const"><?php echo $l_create_wp?></span></label></div>
<?php
if (isset($result))
{
	switch ($result)
	{
	case 1:
		$err_message = $l_err_1;
		break;
	case 2:
		$err_message = $l_err_2;
		break;
	case 3:
		$err_message = $l_err_3;
		break;
	case 4:
		$err_message = $l_err_4;
		break;
	case 5:
		$err_message = $l_err_5;
		break;
	case 6:
		$err_message = $l_err_6;
		break;
	case 7:
		$err_message = $l_err_7;
		break;
	case 8:
		$err_message = $l_err_8;
		break;
	case 9:
		$err_message = $l_err_9;
		break;
	}

	echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
}
?>
	<div class="proj_info_div">
	<div class="proj_info_detail"><?php echo $l_info?></div>
	</div>
	<div class="proj_update_div">
	<form method="post" enctype="multipart/form-data" action="new_workpackage.php" name="create_workpackage" id="create_workpackage" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
	<label><span class="note_info"><?php echo $l_req_field?> " <span class="mandi_field">*</span>".</span></label>
	<div><label class="update_label"><?php echo $l_nwp_name?><span class="mandi_field"> *</span>: </label>
	<input class="work_objective" name="objective" maxlength="254" />
	</div>
	<div>
	<table>
	<tr><td><label class="update_label"><?php echo $l_nwp_owner?><span class="mandi_field">*</span> : </label></td>
	<td>
<?php
	echo '<select class="work_user_id" name="owner">';
	$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
	foreach($users as $uid => $user) echo '<option value="'.$uid.'">'.$user.'</option>';
	echo '</select>';
?></td></tr>
	<tr><td><label class="update_label"><?php echo $l_nwp_pc_blong?>:</label></td>
	<td>
<?php
	echo '<select class="work_user_id" name="component">';
	echo '<option value=""></option>';
	$comps = DatabaseUtil::getProjCompList($_SESSION['_project']->id);
	while($comp = mysql_fetch_array($comps, MYSQL_ASSOC))
		echo '<option value="'.$comp['id'].(isset($_SESSION['_component']) && $comp['id']==$_SESSION['_component']->id ? '" SELECTED': '"').'>'.$comp['title'].'</option>';
	echo '</select>';
?></td></tr></table>
	</div>
	<div><label class="update_label"><?php echo $l_nwp_deadline?> (yyyy-mm-dd)<span class="mandi_field"> *</span>:</label>
	<input type="text" name="end_date" class="deadline_input" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php echo (isset($_POST['end_date']) && !empty($_POST['end_date'])) ? $_POST['end_date'] : ''?>" />
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'create_workpackage',
		// input name
		'controlname': 'end_date'
	});
	</script>
	<label>(<span class="note_info">e.g. 2010-01-21</span>)</label>
	</div>
	<div><label class="update_label"><?php echo $l_nwp_descript?>:</label><br/>
	<textarea name="description" class="work_description"></textarea>
	</div>
	<input type="hidden" value="1" name="status" />
	<div><input type="submit" value="<?php echo $l_nwp_submit?>" id="submit_button"  class="update_submit_button" onmousedown="mousePress('submit_button')" onmouseout="mouseRelease('submit_button')" /></div>
	</form>
	</div>
	</div></div></div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>