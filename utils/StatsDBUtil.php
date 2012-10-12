<?php
include_once ("../utils/DatabaseUtil.php");

class StatsDBUtil
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
		$query = "SELECT id, login_email, firstname, lastname FROM USER WHERE FIRSTNAME like '$names[0]%'".(($index > 1) ? " and LASTNAME like '$names[$last]%'" : "")." LIMIT $start, $size";
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
		$query = "SELECT COUNT(*) as count FROM USER WHERE FIRSTNAME like '$names[0]%'".(($index > 1) ? " and LASTNAME like '$names[$last]%'" : "");
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function searchUserEmail($search_fname, $search_lname, $search_email, $start, $size)
	{
		$fname = (isset($search_fname)? " FIRSTNAME like '$search_fname%'" : "");
		$lname = (isset($search_lname)? " LASTNAME like '$search_lname%'" : "");
		$email = (isset($search_email)? " LOGIN_EMAIL like '$search_email%'" : "");

		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$USER);
		$query = "SELECT id, login_email, firstname, lastname FROM USER WHERE".$fname.(($fname!="" && $lname!="" )?" and":"").$lname.((($fname!="" || $lname!="") && $email!="")?" and":"").$email." LIMIT $start, $size";
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
		$query = "SELECT id, title, creator, status, end_date, s_id FROM PROJECT WHERE TITLE like '$title%' AND ID IN 
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
		$query = "SELECT id, title, creator, status, end_date, s_id FROM PROJECT WHERE ID IN 
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
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND LASTUPDATED_USER=$uid ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageClosedByMe($uid, $pid)
	{
		$closed = "CLOS";
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND LASTUPDATED_USER=$uid AND STATUS=$closed ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageOwnedByMe($uid, $pid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT id, objective, owner_id, status, creation_time, comp_id, s_id, deadline FROM WORKPACKAGE WHERE PROJ_ID=$pid AND OWNER_ID=$uid ORDER BY DEADLINE DESC";
		return DatabaseUtil::selectDataList($db_connection, $query);
	}

//================================================= Work Item =======================================================

	public static function countWorkitemCreatedInTime($pid, $start, $end)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKITEM WHERE PROJ_ID=$pid AND CREATION_TIME<='$end' AND CREATION_TIME>='$start'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function countWorkitemClosedInTime($pid, $start, $end)
	{
		$closed = 'DONE';
		$invalid = 'NOTV';
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKITEM WHERE PROJ_ID=$pid AND (STATUS='$closed' OR STATUS='$invalid') AND LASTUPDATED_TIME<='$end' AND LASTUPDATED_TIME>='$start'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function countCloseWorkitemAtTime($pid, $time)
	{
		$closed = 'DONE';
		$invalid = 'NOTV';
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKITEM WHERE PROJ_ID=$pid AND (STATUS='$closed' OR STATUS='$invalid') AND LASTUPDATED_TIME<='$time'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function countWorkitemAtTime($pid, $time)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$WOMA);
		$query = "SELECT COUNT(*) as count FROM WORKITEM WHERE PROJ_ID=$pid AND CREATION_TIME<='$time'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

//================================================= Documentation =======================================================

	public static function getProjDocList($title, $u_id, $p_id, $c_id, $wp_id, $wi_id)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$DOCS);
		$query = "SELECT id, title, updater, last_update, p_id, comp_id, work_pid, work_iid, s_id FROM FILE WHERE ".
				 "P_ID=$p_id ".
				 (isset($title)&&!empty($title) ? " AND TITLE like '$title%'" : "").
				 (isset($u_id)&&is_numeric($u_id) ? " AND UPDATER=$u_id" : "").
				 (isset($c_id)&&is_numeric($c_id) ? " AND COMP_ID=$c_id" : "").
				 (isset($wp_id)&&is_numeric($wp_id) ? " AND WORK_PID=$wp_id" : "").
				 (isset($wi_id)&&is_numeric($wi_id) ? " AND WORK_IID=$wi_id" : "");

		return DatabaseUtil::selectDataList($db_connection, $query);
	}
}