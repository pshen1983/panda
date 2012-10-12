<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SearchDBUtil.php");
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/CommonUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_empty = '(empty)';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_empty = '&#65288;&#31354;&#65289;';
	}
	
	//=========================================================================================================
	
	if(isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']) && 
	  (isset($_SESSION['_project']) && !empty($_SESSION['_project'])) )
	{
		$hasRecord = false;
		
		$wps = SearchDBUtil::getWorkPackageListByTitle($_SESSION['seach_input'], $_SESSION['_project']->id);
		if(isset($wps)) {
			$output = "<table><tr>
					   <table class='search_result_header' style='width:960px;' border='1' cellpadding='3' cellspacing='0'>
					   <tr>
					   <td style='width:32%;'>Workpackage Objective</td>
					   <td style='width:16%;'>Owner</td>
					   <td style='width:10%;'>Status</td>
					   <td style='width:16%;'>Component</td>
					   <td style='width:16%;'>Project</td>
					   <td style='width:10%;'>Deadline</td>
					   </tr>
					   </table></tr>";
		
			$count = 0;	
	
			while($wp = mysql_fetch_array($wps, MYSQL_ASSOC))
			{
				$userO = DatabaseUtil::getUser($wp['owner_id']);
				$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WP_STATUS, $wp['status']);
				if(isset($wp['comp_id'])) {
					$comp = DatabaseUtil::getComp($wp["comp_id"]);
					$comp_content = '<a href="../project/project_component.php?c_id='.$wp["comp_id"].'&sid='.$comp["s_id"].'" title="'.str_replace('"', '&quot;', $comp["title"]).'">'.CommonUtil::truncate($comp["title"], 20).'</a>';
				}
	
				if(!$hasRecord) $hasRecord = true;
	
				$output.= '<tr>
						   <table class="search_result_row" border="0" style="width:960px;';
				if($count%2) $output.="background-color:#EEEEEE;";
	
				$ownerName = ($_SESSION['_language'] == 'zh') ? $userO["lastname"].$userO["firstname"] : CommonUtil::truncate($userO["firstname"].' '.$userO["lastname"], 20);
				$output.= '"><tr>
						   <td style="width:32%;"><a href="../project/work_package.php?wp_id='.$wp["id"].'&sid='.$wp["s_id"].'" title="'.str_replace('"', '&quot;', $wp["objective"]).'">'.CommonUtil::truncate($wp["objective"], 40).'</a></td>
						   <td style="width:16%;">'.$ownerName.'</td>
						   <td style="width:10%;">'.$status.'</td>
						   <td style="width:16%;">'.(isset($wp["comp_id"]) ? $comp_content : '').'</td>
						   <td style="width:16%;"><a href="../project/index.php?p_id='.$_SESSION["_project"]->id.'&sid='.$_SESSION["_project"]->s_id.'" title="'.str_replace('"', '&quot;', $_SESSION["_project"]->title).'">'.CommonUtil::truncate($_SESSION["_project"]->title, 20).'</a></td>
						   <td style="width:10%;">'.$wp["deadline"].'</td>
						   </tr></table>
						   </tr>'; 
				$count++;
			}
			$output.= "</table>";
	
			if(!$hasRecord)
				$output = $l_empty;
	
			echo $output;
		}
	}
}
else {
	echo 1;
}
?>