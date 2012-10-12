<?php
include_once ("../utils/DatabaseUtil.php");

class SearchDBUtil
{
//================================================= User =======================================================

	public static function searchUser($search_name, $start, $size)
	{
		if(empty($search_name)) return null;
		$names = array();
		$names = split(" ", $search_name);
		$index = count($names);
		$last = $index - 1;

		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$USER);
		$query = "SELECT id, login_email, firstname, lastname, fullname_cn FROM USER WHERE ". 
				 ($_SESSION['_language']=='zh' ?
				 "FULLNAME_CN like '".mysql_real_escape_string($search_name)."%' LIMIT $start, $size" : 
				 "FIRSTNAME like '".mysql_real_escape_string($names[0])."%'".(($index > 1) ? " and LASTNAME like '".mysql_real_escape_string($names[$last])."%'" : "")." LIMIT $start, $size");
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function searchUserCount($search_name)
	{
		if(empty($search_name)) return 0;
		$names = array();
		$names = split(" ", $search_name);
		$index = count($names);
		$last = $index - 1;

		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$USER);
		$query = "SELECT COUNT(*) as count FROM USER WHERE ".
				 ($_SESSION['_language']=='zh' ? 
				 "FULLNAME_CN like '".mysql_real_escape_string($search_name)."%'" : 
				 "FIRSTNAME like '".mysql_real_escape_string($names[0])."%'".(($index > 1) ? " and LASTNAME like '".mysql_real_escape_string($names[$last])."%'" : ""));
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function searchUserEmail($search_fname, $search_lname, $search_email, $start, $size)
	{
		$fname = (isset($search_fname)? " FIRSTNAME like '$search_fname%'" : "");
		$lname = (isset($search_lname)? " LASTNAME like '$search_lname%'" : "");
		$email = (isset($search_email)? " LOGIN_EMAIL like '$search_email%'" : "");

		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$USER);
		$query = "SELECT id, login_email, firstname, lastname, fullname_cn FROM USER WHERE".$fname.(($fname!="" && $lname!="" )?" and":"").$lname.((($fname!="" || $lname!="") && $email!="")?" and":"").$email." LIMIT $start, $size";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function searchUserEmailCount($search_fname, $search_lname, $search_email)
	{
		$fname = (isset($search_fname)? " FIRSTNAME like '$search_fname%'" : "");
		$lname = (isset($search_lname)? " LASTNAME like '$search_lname%'" : "");
		$email = (isset($search_email)? " LOGIN_EMAIL like '$search_email%'" : "");

		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$USER);
		$query = "SELECT COUNT(*) as count FROM USER WHERE".$fname.(($fname!="" && $lname!="")?" and":"").$lname.((($fname!="" || $lname!="") && $email!="")?" and":"").$email;
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}
	
	public static function getAllProjectMemebers($pid)
	{
		$users = DatabaseUtil::getUserListByProj($pid);
		$atResult = array();
		$ind = 0;
		while ($row = mysql_fetch_array($users, MYSQL_ASSOC))
		{
			$user = DatabaseUtil::getUser($row['u_id']);
			$atResult[$ind]['id'] = $row['u_id'];
			$atResult[$ind]['lastname'] = $user['lastname']; 
			$atResult[$ind]['firstname'] = $user['firstname'];
			$atResult[$ind]['login_email'] = $user['login_email'];
			$ind++;
		}

		return $atResult;
	}

//================================================= Project =======================================================

	public static function getProjListByTitle($title, $uid)
	{
		if(empty($title)) return null;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$PROJ);
		$query = "SELECT id, title, creator, owner, status, end_date, s_id FROM PROJECT WHERE TITLE like '$title%' AND ID IN 
				  (SELECT P_ID FROM RELATION WHERE U_ID=$uid) ORDER BY END_DATE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getProjListByTitleCount($title, $uid)
	{
		if(empty($title)) return 0;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$PROJ);
		$query = "SELECT COUNT(*) as count FROM PROJECT WHERE TITLE like '$title%' AND ID IN 
				  (SELECT P_ID FROM RELATION WHERE U_ID=$uid)";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function getAllUserProjects($uid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$PROJ);
		$query = "SELECT id, title, creator, owner, status, end_date, s_id FROM PROJECT WHERE ID IN 
				  (SELECT P_ID FROM RELATION WHERE U_ID=$uid)";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

//================================================= Project Component =======================================================

	public static function getCompListByTitle($title, $pid)
	{
		if(empty($title)) return null;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$PROJ);
		$query = "SELECT id, title, creator, owner, status, end_date, s_id FROM PROJCOMP WHERE P_ID=$pid AND TITLE like '$title%'";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getCompListByTitleCount($title, $pid)
	{
		if(empty($title)) return 0;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$PROJ);
		$query = "SELECT COUNT(*) as count FROM PROJCOMP WHERE P_ID=$pid AND TITLE like '$title%'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

//================================================= Work Package =======================================================

	public static function getWorkPackageListByTitle($title, $pid)
	{
		if(empty($title)) return null;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, comp_id, deadline, s_id FROM WORKPACKAGE WHERE PROJ_ID=$pid AND OBJECTIVE like '$title%' ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageListByTitleCount($title, $pid)
	{
		if(empty($title)) return 0;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKPACKAGE WHERE PROJ_ID=$pid AND OBJECTIVE like '$title%'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}
	
	public static function getWorkPackageCreatedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND CREATOR_ID=$uid ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageLastModifiedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, lastupdated_time, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND LASTUPDATED_USER=$uid ORDER BY LASTUPDATED_TIME DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageClosedByMe($uid, $pid)
	{
		$closed = "CLOS";
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND LASTUPDATED_USER=$uid AND STATUS='$closed' ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageOwnedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND OWNER_ID=$uid ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

//================================================= Work Item =======================================================

	public static function getWorkItemListByTitle($title, $pid)
	{
		if(empty($title)) return null;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, owner_id, status, type, priority, comp_id, workpackage_id, deadline, s_id FROM WORKITEM WHERE PROJ_ID=$pid AND TITLE like '$title%' ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkItemListById($pw_id, $pid)
	{
		if(empty($pw_id)) return null;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, owner_id, status, type, priority, comp_id, workpackage_id, deadline, s_id FROM WORKITEM WHERE PROJ_ID=$pid AND PW_ID=$pw_id ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkItemListByTitleCount($title, $pid)
	{
		if(empty($title)) return 0;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKITEM WHERE PROJ_ID=$pid AND TITLE like '$title%'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		if($result['count'] == 0)
			$atReturn = self::getWorkItemListByIdCount($title, $pid);
		else
			$atReturn = $result['count'];
			
		return $atReturn;		
	}

	public static function getWorkItemListByIdCount($pw_id, $pid)
	{
		if(empty($pw_id) || !is_numeric($pw_id)) return 0;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKITEM WHERE PROJ_ID=$pid AND PW_ID=$pw_id";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function getWorkItemCreatedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creation_time, workpackage_id, comp_id, s_id, deadline FROM WORKITEM WHERE PROJ_ID=$pid AND CREATOR_ID=$uid ORDER BY CREATION_TIME DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkItemLastModifiedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creation_time, workpackage_id, comp_id, s_id, lastupdated_time, deadline FROM WORKITEM WHERE PROJ_ID=$pid AND LASTUPDATED_USER=$uid ORDER BY LASTUPDATED_TIME DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkItemClosedByMe($uid, $pid)
	{
		$closed = "DONE";
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creation_time, workpackage_id, comp_id, s_id, deadline FROM WORKITEM WHERE PROJ_ID=$pid AND LASTUPDATED_USER=$uid AND STATUS='$closed' ORDER BY LASTUPDATED_TIME DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkItemOwnedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creation_time, workpackage_id, comp_id, s_id, deadline FROM WORKITEM WHERE PROJ_ID=$pid AND OWNER_ID=$uid ORDER BY DEADLINE";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getMyOpenWorkItem($uid, $pid)
	{
		$open = "OPEN";
		$in_pro = "INPR";
		$re_op = "REOP";
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creation_time, workpackage_id, comp_id, s_id, deadline FROM WORKITEM WHERE PROJ_ID=$pid AND OWNER_ID=$uid AND (STATUS='$open' OR STATUS='$in_pro' OR STATUS='$re_op') ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getMySubscribedWorkItem($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creation_time, workpackage_id, comp_id, s_id, deadline FROM WORKITEM WHERE ID in (
				  SELECT workitem_id FROM SUBSCRIPTION WHERE USER_ID=$uid AND PROJ_ID=$pid) ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkItems($id, $p_id, $c_id, $wp_id, $owner, $creator, $title, $status, $type, $priority, $c_s, $c_e, $l_s, $l_e, $d_s, $d_e)
	{
		if (empty($p_id)) return "";
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, pw_id, title, type, priority, status, owner_id, creator_id, creation_time, workpackage_id, comp_id, s_id, deadline FROM WORKITEM WHERE ".
				 "PROJ_ID=$p_id ".
				 (isset($id)&&is_numeric($id) ? " AND PW_ID=$id" : "").
				 (isset($c_id)&&is_numeric($c_id) ? " AND COMP_ID=$c_id" : "").
				 (isset($wp_id)&&is_numeric($wp_id) ? " AND WORKPACKAGE_ID=$wp_id" : "").
				 (isset($owner)&&is_numeric($owner) ? " AND OWNER_ID=$owner" : "").
				 (isset($creator)&&is_numeric($creator) ? " AND CREATOR_ID=$creator" : "").
				 (isset($title)&&!empty($title) ? " AND TITLE like '$title%'" : "").
				 (isset($status)&&!empty($status) ? " AND STATUS='$status'" : "").
				 (isset($type)&&!empty($type) ? " AND TYPE='$type'" : "").
				 (isset($priority)&&!empty($priority) ? " AND PRIORITY='$priority'" : "").
				 (isset($c_s)&&!empty($c_s) ? " AND CREATION_TIME>='$c_s'" : "").
				 (isset($c_e)&&!empty($c_e) ? " AND CREATION_TIME<='$c_e'" : "").
				 (isset($l_s)&&!empty($l_s) ? " AND LASTUPDATED_TIME>='$l_s'" : "").
				 (isset($l_e)&&!empty($l_e) ? " AND LASTUPDATED_TIME<='$l_e)'" : "").
				 (isset($d_s)&&!empty($d_s) ? " AND DEADLINE>='$d_s'" : "").
				 (isset($d_e)&&!empty($d_e) ? " AND DEADLINE<='$d_e)'" : "");
		return DatabaseUtil::selectDataList($db_connection, $query);
	}
	
//================================================= Documentation =======================================================

	public static function getProjDocList($title, $u_id, $p_id, $c_id, $wp_id, $wi_id, $ul_s, $ul_e)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$DOCS);
		$query = "SELECT id, title, updater, last_update, p_id, comp_id, work_pid, work_iid, description, s_id FROM FILE WHERE ".
				 "P_ID=$p_id ".
				 (isset($title)&&!empty($title) ? " AND TITLE like '$title%'" : "").
				 (isset($u_id)&&is_numeric($u_id) ? " AND UPDATER=$u_id" : "").
				 (isset($c_id)&&is_numeric($c_id) ? " AND COMP_ID=$c_id" : "").
				 (isset($wp_id)&&is_numeric($wp_id) ? " AND WORK_PID=$wp_id" : "").
				 (isset($wi_id)&&is_numeric($wi_id) ? " AND WORK_IID=$wi_id" : "").
				 (isset($ul_s)&&!empty($ul_s) ? " AND LAST_UPDATE>='$ul_s'" : "").
				 (isset($ul_e)&&!empty($ul_e) ? " AND LAST_UPDATE<='$ul_e)'" : "");
		return DatabaseUtil::selectDataList($db_connection, $query);
	}
}