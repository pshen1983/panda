<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/CommonUtil.php");
	include_once ("../utils/SearchDBUtil.php");
	include_once ("../utils/SecurityUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_empty = '(empty)';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_empty = '&#65288;&#31354;&#65289;';
	}
	
	//=========================================================================================================
	
	if( ((isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input'])) ||
		((isset($_SESSION['u_first']) && !empty($_SESSION['u_first'])) ||
		 (isset($_SESSION['u_last']) && !empty($_SESSION['u_last'])) ||
		 (isset($_SESSION['search_email']) && !empty($_SESSION['search_email']))))&& 
		isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']>=0 )
	{
		$number_per_page = 20;
		$manyRecordLimit = 11;
		$name = '';
		if(isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']))
		{
			$users = SearchDBUtil::searchUser( $_SESSION['seach_input'], ($_GET['page']*$number_per_page), $number_per_page );
		}
		else {
			$users = SearchDBUtil::searchUserEmail( (isset($_SESSION['u_first']) && !empty($_SESSION['u_first'])) ? $_SESSION['u_first'] : null, 
													(isset($_SESSION['u_last']) && !empty($_SESSION['u_last'])) ? $_SESSION['u_last'] : null, 
													(isset($_SESSION['search_email']) && !empty($_SESSION['search_email'])) ? $_SESSION['search_email'] : null,
													($_GET['page']*$number_per_page),
													$number_per_page );
		}
	
		if(isset($users)) {
			$output = '<div style="width:600px;margin-top:20px;"><div>';
			if(isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']))	
				$count = SearchDBUtil::searchUserCount($_SESSION['seach_input']);
			else
				$count = SearchDBUtil::searchUserEmailCount( (isset($_SESSION['u_first']) && !empty($_SESSION['u_first'])) ? $_SESSION['u_first'] : null, 
															 (isset($_SESSION['u_last']) && !empty($_SESSION['u_last'])) ? $_SESSION['u_last'] : null, 
															 (isset($_SESSION['search_email']) && !empty($_SESSION['search_email'])) ? $_SESSION['search_email'] : null
															);
	
	//===============================================================================================================
	
			$hasRecord = false;
			$manyRecord = false;
			$pages = ceil($count/$number_per_page);
	
			if ($pages > 1)
			{
				$pages2 = $pages;
				if($pages > $manyRecordLimit) {
					$pages = $manyRecordLimit;
					$manyRecord = true;
				}
		
				$output.= '<a title="First page" style="font-size:.9em;text-decoration:none;" href="javascript:userSearchPage(\'0\',\'search_result\')">&laquo;</a> 
						   <a title="Previous page" style="font-size:.9em;text-decoration:none;" href="javascript:userSearchPage(\''.($_GET['page']>0?$_GET['page']-1: '0').'\',\'search_result\')">&lt;</a> ';
				
				$start = 0;
				$size = $pages;
				if($manyRecord && $_GET['page']>$manyRecordLimit/2) {
					$output.= "... ";
					$start = ceil($_GET['page']-$manyRecordLimit/2);
					$size = $pages+$start;
					if($_GET['page']>$pages2-ceil($manyRecordLimit/2)) {
						$start = $pages2-$manyRecordLimit;
						$size = $pages2;
					}
				}
		
				for($ind=$start; $ind<$size; $ind++)
					$output.= '<a style="font-size:.9em;'.($ind==$_GET['page']? 'text-decoration:none;' : '').'" href="javascript:userSearchPage(\''.$ind.'\',\'search_result\')">'.($ind+1).'</a> ';
		
				if($manyRecord && $_GET['page']<$pages2-ceil($manyRecordLimit/2)) $output.= "... ";
				$output.= '<a title="Next page" style="font-size:.9em;text-decoration:none;" href="javascript:userSearchPage(\''.($_GET['page']<$pages2-1?$_GET['page']+1: $_GET['page']).'\',\'search_result\')">&gt;</a> 
						   <a title="Last page" style="font-size:.9em;text-decoration:none;" href="javascript:userSearchPage(\''.($pages2-1).'\',\'search_result\')">&raquo;</a> ';
			}
	//===============================================================================================================
				
			$output.= '</div><table>';
		
			$count = 0;
			while($user = mysql_fetch_array($users, MYSQL_ASSOC))
			{
				if(!$hasRecord) $hasRecord = true;
				$pic = DatabaseUtil::getUserPic($user['id']);
				$name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['firstname']." ".$user['lastname'];
				$output.= "<tr>
						   <div class='search_result_row'".(($count%2) ? " style='background-color:#F3F3F3;'" : "").">
						   <img align='middle' style='width:80px;height:80px;border:1px solid #DDD' src='".$pic."'/>
						   <label style='margin-left:10px;'><a class='user_link' href='../search/user_details.php?p1=".session_id()."&p2=".($user['id']*3-1)."'>".$name."</a> (".$user['login_email'].")</label>
						   </div>
						   </tr>"; 
				$count++;
			}
			$output.= "</table></div>";
	
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