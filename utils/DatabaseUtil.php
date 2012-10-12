<?php
define("DBHOST", "localhost");
class DatabaseUtil
{
    public static $USER = array (
	    array( 'host' => DBHOST, 'username' => 'auser', 'password' => 'auserpass', 'database' => 'PANDA_USER'),
	    array( 'host' => DBHOST, 'username' => 'auser', 'password' => 'auserpass', 'database' => 'PANDA_USER')
    );
    public static $PROJ = array (
	    array( 'host' => DBHOST, 'username' => 'aproj', 'password' => 'aprojpass', 'database' => 'PANDA_PROJ'),
	    array( 'host' => DBHOST, 'username' => 'aproj', 'password' => 'aprojpass', 'database' => 'PANDA_PROJ')
    );
    public static $WOMA = array (
	    array( 'host' => DBHOST, 'username' => 'awoma', 'password' => 'awomapass', 'database' => 'PANDA_WOMA'),
	    array( 'host' => DBHOST, 'username' => 'awoma', 'password' => 'awomapass', 'database' => 'PANDA_WOMA')
    );
    public static $DOCS = array (
	    array( 'host' => DBHOST, 'username' => 'adocs', 'password' => 'adocspass', 'database' => 'PANDA_DOCS'),
	    array( 'host' => DBHOST, 'username' => 'adocs', 'password' => 'adocspass', 'database' => 'PANDA_DOCS')
    );
    public static $ENUM = array (
	    array( 'host' => DBHOST, 'username' => 'aenum', 'password' => 'aenumpass', 'database' => 'PANDA_ENUM'),
	    array( 'host' => DBHOST, 'username' => 'aenum', 'password' => 'aenumpass', 'database' => 'PANDA_ENUM')
    );
    public static $MESS = array (
	    array( 'host' => DBHOST, 'username' => 'amess', 'password' => 'amesspass', 'database' => 'PANDA_MESS'),
	    array( 'host' => DBHOST, 'username' => 'amess', 'password' => 'amesspass', 'database' => 'PANDA_MESS')
    );
    public static $PROF = array (
	    array( 'host' => DBHOST, 'username' => 'aprof', 'password' => 'aprofpass', 'database' => 'PANDA_PROF'),
	    array( 'host' => DBHOST, 'username' => 'aprof', 'password' => 'aprofpass', 'database' => 'PANDA_PROF')
    );
    public static $FBBS = array (
	    array( 'host' => DBHOST, 'username' => 'afbbs', 'password' => 'afbbspass', 'database' => 'PANDA_FBBS'),
	    array( 'host' => DBHOST, 'username' => 'afbbs', 'password' => 'afbbspass', 'database' => 'PANDA_FBBS')
    );
    
    public static $picPath = "../tmp/temp_profile_img.";

    public static function getConn($servers)
    {
    	$serverIdx = rand(0, count(sizeof($servers))-1);
    	$server = $servers[$serverIdx];
		$db_connection = mysql_pconnect($server['host'], $server['username'], $server['password']);
		mysql_query("SET character_set_results=utf8", $db_connection);
		mysql_query("SET character_set_client=utf8", $db_connection); 
		mysql_query("SET character_set_connection=utf8", $db_connection);

		if($db_connection)
		{
			mysql_select_db($server['database'], $db_connection);
		}

		return $db_connection;
    }

    public static function selectData($db_connection, $query)
    {
		if ( isset($db_connection) )
		{
			$select_result = mysql_query($query, $db_connection);
			$result = mysql_fetch_array($select_result, MYSQL_ASSOC);

			return $result;
		}

		return null;
    }

    public static function deleteData($db_connection, $query)
    {
    	$result = false;

		if ( isset($db_connection) )
			$result = mysql_query($query, $db_connection);

		return $result;
    }

	public static function selectDataList($db_connection, $query)
	{		
		if ( isset($db_connection) )
		{
			$select_result = mysql_query($query, $db_connection);
			return $select_result;
		}

		return null;
	}

    public static function insertData($db_connection, $query)
    {
    	$result = false;

		if ( isset($db_connection) )
			$result = mysql_query($query, $db_connection);

		return $result;
    }

    public static function updateData($db_connection, $query)
    {
    	$result = false;

		if ( isset($db_connection) )
			$result = mysql_query($query, $db_connection);

		return $result;
    }

    public static function checkNull($input)
    {
    	return (isset($input) ? "'". mysql_real_escape_string($input) . "'" : "NULL");
    }

//============================================ User Related ==============================================

	public static function getUser($id)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT login_email, pic, firstname, lastname, fullname_cn, proj_id FROM USER WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getUserName($id)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT firstname, lastname, fullname_cn FROM USER WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getUserEmail($id)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT login_email FROM USER WHERE ID=" . $id;
		$email = self::selectData($db_connection, $query);
		return $email['login_email'];
	}

	public static function getUserObj($id)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT login_email, pic, firstname, lastname, fullname_cn, proj_id FROM USER WHERE ID=$id";
		$user = self::selectData($db_connection, $query);

		$myUser = new User();
		$myUser->id = $id;
		$myUser->firstname = $user['firstname'];
		$myUser->lastname = $user['lastname'];
		$myUser->fullname_cn = $user['fullname_cn'];
		$myUser->login_email = $user['login_email'];
		$myUser->proj_id = isset($user['proj_id']) ? $user['proj_id'] : 0;

		if( isset($user['pic']) )
		{
			$profileImg = fopen(self::$picPath.$id, 'w') or $myUser->pic = '../image/default/default_pro_pic.png';
			fwrite($profileImg, $user['pic']);
			fclose($profileImg);
			$myUser->pic = self::$picPath.$id;
		}
		else {
			$myUser->pic = '../image/default_pro_pic.png';
		}

		return $myUser;
	}

	public static function getUserPassword($id)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT login_pass FROM USER WHERE ID=$id";
		$result = self::selectData($db_connection, $query);
		return $result['login_pass'];
	}

	public static function getUserByEmail($email)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT id, firstname, pic, lastname, fullname_cn, login_pass, proj_id FROM USER WHERE LOGIN_EMAIL='" . $email . "'";
		return self::selectData($db_connection, $query);
	}

	public static function emailExists($email)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT id FROM USER WHERE LOGIN_EMAIL='" . $email . "'";
		$result = self::selectData($db_connection, $query);
		return $result['id'];
	}

	public static function insertUser($firstname, $pic, $lastname, $fullname_cn, $email, $passwd)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "INSERT INTO USER (LOGIN_EMAIL, PIC, LOGIN_PASS, FIRSTNAME, LASTNAME, FULLNAME_CN, REGISTER_TIME)
				 VALUES ('". $email ."', '$pic', '". md5($passwd) ."', '". mysql_real_escape_string($firstname) ."', '". mysql_real_escape_string($lastname) ."', '". mysql_real_escape_string($fullname_cn) ."', NOW())";
		return self::insertData($db_connection, $query);
	}

	public static function updateUserDefaultProj($id, $proj_id)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "UPDATE USER SET PROJ_ID=".(isset($proj_id) ? $proj_id : "NULL")." WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function updateUserName($id, $firstname, $lastname, $fullname_cn)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "UPDATE USER SET ".
				 (isset($firstname) ? "FIRSTNAME='".mysql_real_escape_string($firstname)."', " : "").
				 (isset($lastname) ? "LASTNAME='".mysql_real_escape_string($lastname)."', " : "").
				 (isset($fullname_cn) ? "FULLNAME_CN='".mysql_real_escape_string($fullname_cn)."'" : "").
				 " WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function updatePassword($id, $passwd)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "UPDATE USER SET LOGIN_PASS='".md5($passwd)."' WHERE ID=$id";
		return self::updateData($db_connection, $query);
	}

	public static function updatePic($id, $pic)
	{
		if(!isset($pic)) return false;
		$db_connection = self::getConn(self::$USER);
		$query = "UPDATE USER SET PIC='$pic' WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function removeProjUserDefault($pid)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "UPDATE USER SET PROJ_ID=NULL WHERE PROJ_ID=$pid";
		return self::updateData($db_connection, $query);
	}

	public static function getUserPic($uid)
	{
		$atReturn = '../image/default_pro_pic.png';

		if( !file_exists(self::$picPath.$uid) )
		{
			$db_connection = self::getConn(self::$USER);
			$query = "SELECT pic FROM USER WHERE ID=$uid";
			$result = self::selectData($db_connection, $query);
			$pic = $result['pic'];

			if ( isset($pic) && !empty($pic)) 
			{
				$profileImg = fopen(self::$picPath.$uid, 'w');
				fwrite($profileImg, $pic);
				fclose($profileImg);
				$atReturn = self::$picPath.$uid;
			}
		}
		else {
			$atReturn = self::$picPath.$uid;
		}

		return $atReturn;
	}

	public static function insertProjInvitation($from, $to_email, $pid, $message, $sid)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "INSERT INTO INVI (FROM_ID, TO_EMAIL, P_ID, MESSAGE, CREATE_TIME, S_ID)
				  VALUES ($from, '$to_email', $pid, '$message', NOW(), '$sid')";
		return self::insertData($db_connection, $query);
	}

	public static function countUserInvitations($to_email)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT COUNT(*) as count FROM INVI WHERE TO_EMAIL='$to_email'";
		$result = self::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function invitationExist($from, $to_email, $pid)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT id FROM INVI WHERE FROM_ID=$from AND TO_EMAIL='$to_email' AND P_ID=$pid";
		$result = self::selectData($db_connection, $query);
		return $result['id'];
	}

	public static function getUserInvitations($to_email)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT id, from_id, p_id, create_time, s_id FROM INVI WHERE TO_EMAIL='$to_email' ORDER BY CREATE_TIME DESC";
		return self::selectDataList($db_connection, $query);
	}

	public static function getInvitation($iid, $sid)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT from_id, to_email, p_id, create_time FROM INVI WHERE ID=$iid AND S_ID='$sid'";
		return self::selectData($db_connection, $query);
	}

	public static function getInvitationBody($iid, $sid)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "SELECT message FROM INVI WHERE ID=$iid AND S_ID='$sid'";
		$result = self::selectData($db_connection, $query);
		return $result['message'];
	}

	public static function deleteInvitation($iid, $sid)
	{
		$db_connection = self::getConn(self::$USER);
		$query = "DELETE FROM INVI WHERE ID=$iid AND S_ID='$sid'";
		return self::deleteData($db_connection, $query);
	}

//============================================ Profile Related ==============================================

	public static function insertProfile($uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "INSERT INTO PROFILE (U_ID) VALUES ($uid)";
		return self::insertData($db_connection, $query);
	}

	public static function getProfile($uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "SELECT id, u_id, message, location, b_year, b_month, b_day, interests FROM PROFILE WHERE U_ID=$uid";
		return self::selectData($db_connection, $query);
	}

	public static function doesProfileExist($uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "SELECT id FROM PROFILE WHERE U_ID=$uid";
		$result = self::selectData($db_connection, $query);
		return isset($result['id']);
	}

	public static function updatePersonalInfo($uid, $mess, $location, $year, $month, $day, $interest)
	{
		$year_in = (isset($year) && is_numeric($year) ? $year:'NULL');
		$month_in = (isset($month) && is_numeric($month) ? $month:'NULL');
		$day_in = (isset($day) && is_numeric($day) ? $day:'NULL');

		$db_connection = self::getConn(self::$PROF);
		$query = "UPDATE PROFILE SET MESSAGE=".self::checkNull($mess).", LOCATION=".self::checkNull($location).", B_YEAR=$year_in, B_MONTH=$month_in, B_DAY=$day_in, INTERESTS=".self::checkNull($interest)." WHERE U_ID=$uid";
		return self::updateData($db_connection, $query);
	}

	public static function insertEducation($uid, $type, $school, $department, $year_start, $year_end)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "INSERT INTO EDUCATION (U_ID, TYPE, SCHOOL, DEPARTMENT, YEAR_START, YEAR_END)
				  VALUES ($uid, '$type', '".mysql_real_escape_string($school)."', '".mysql_real_escape_string($department)."', $year_start, $year_end)";
		return self::insertData($db_connection, $query);
	}

	public static function getEducations($uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "SELECT id, type, school, department, year_start, year_end FROM EDUCATION WHERE U_ID=$uid ORDER BY YEAR_START DESC";
		return self::selectDataList($db_connection, $query);
	}

	public static function isUserEducation($uid, $eid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "SELECT u_id FROM EDUCATION WHERE ID=$eid";
		$result = self::selectData($db_connection, $query);
		return ($uid == $result['u_id']);
	}
	
	public static function updateEducation($id, $uid, $type, $school, $department, $year_start, $year_end)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "UPDATE EDUCATION SET TYPE='$type', SCHOOL='".mysql_real_escape_string($school)."', DEPARTMENT='".mysql_real_escape_string($department)."', YEAR_START=$year_start, YEAR_END=$year_end WHERE ID=$id AND U_ID=$uid";
		return self::updateData($db_connection, $query);
	}

	public static function deleteEducation($id, $uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "DELETE FROM EDUCATION WHERE ID=$id AND U_ID=$uid";
		return self::deleteData($db_connection, $query);
	}

	public static function insertEmployment($uid, $company, $title, $location, $year_start, $year_end)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "INSERT INTO EMPLOYMENT (U_ID, COMPANY, TITLE, LOCATION, YEAR_START, YEAR_END)
				  VALUES ($uid, '".mysql_real_escape_string($company)."', '".mysql_real_escape_string($title)."', '".mysql_real_escape_string($location)."', $year_start, $year_end)";
		return self::insertData($db_connection, $query);
	}

	public static function getEmployment($uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "SELECT id, company, title, location, year_start, year_end FROM EMPLOYMENT WHERE U_ID=$uid ORDER BY YEAR_START DESC";
		return self::selectDataList($db_connection, $query);
	}

	public static function isUserEmployment($uid, $eid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "SELECT u_id FROM EMPLOYMENT WHERE ID=$eid";
		$result = self::selectData($db_connection, $query);
		return ($uid == $result['u_id']);
	}

	public static function updateEmployment($id, $uid, $company, $title, $location, $year_start, $year_end)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "UPDATE EMPLOYMENT SET COMPANY='".mysql_real_escape_string($company)."', TITLE='".mysql_real_escape_string($title)."', LOCATION='".mysql_real_escape_string($location)."', YEAR_START=$year_start, YEAR_END=$year_end WHERE ID=$id AND U_ID=$uid";
		return self::updateData($db_connection, $query);
	}

	public static function deleteEmployment($id, $uid)
	{
		$db_connection = self::getConn(self::$PROF);
		$query = "DELETE FROM EMPLOYMENT WHERE ID=$id AND U_ID=$uid";
		return self::deleteData($db_connection, $query);
	}

//============================================ Project Related ==============================================

	public static $RELATION = 'RELATION';

	public static function getUserListByProj($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT u_id, role FROM RELATION WHERE P_ID=". $pid;
		return self::selectDataList($db_connection, $query);
	}

	public static function isProjectMember($uid, $pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT p_id FROM RELATION WHERE U_ID=$uid and P_ID=$pid";
		$result = self::selectData($db_connection, $query);
		return isset($result['p_id']);
	}

	public static function isProjectLeader($uid, $pid)
	{
		$member = "MEMB";
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT p_id FROM RELATION WHERE U_ID=$uid AND P_ID=$pid AND ROLE<>'$member'";
		$result = self::selectData($db_connection, $query);
		return isset($result['p_id']);
	}

	public static function getProj($id)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT title, creator, description, status, create_date, owner, end_date, s_id FROM PROJECT WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getProjectTitle($id)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT title, s_id FROM PROJECT WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getProjSid($id, $sid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT title, creator, description, status, create_date, owner, end_date FROM PROJECT WHERE ID=" . $id . " and S_ID=" . $sid;
		return self::selectData($db_connection, $query);
	}

	public static function getRole($uid, $pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT role from RELATION WHERE U_ID=". $uid ." and P_ID=". $pid;
		$result = self::selectData($db_connection, $query);
		return $result['role'];
	}

	public static function updateRole($uid, $pid, $role)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "UPDATE RELATION SET ROLE='$role' WHERE U_ID=$uid AND P_ID=$pid";
		return self::updateData($db_connection, $query);
	}

	public static function getUserProjIds($uid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT p_id, role from RELATION WHERE r.U_ID=". $uid;
		return self::selectDataList($db_connection, $query);
	}

	public static function getUserProjList($uid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT id, title, s_id from PROJECT where ID in (SELECT p_id FROM RELATION WHERE U_ID=$uid)";
		return self::selectDataList($db_connection, $query);
	}

	public static function getUserOpenProjList($uid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$complete = 'COMP';
		$query = "SELECT id, title, s_id from PROJECT WHERE STATUS<>'$complete' AND id IN
					(SELECT p_id FROM RELATION WHERE U_ID=$uid)";
		return self::selectDataList($db_connection, $query);
	}

	public static function hasCompeleteProject($uid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT COUNT(*) as count FROM PROJECT WHERE STATUS='COMP' AND ID IN 
					(SELECT p_id FROM RELATION WHERE U_ID=$uid)";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return ($result['count'] != 0);
	}

	public static function getUserCompleteProjList($uid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$complete = 'COMP';
		$query = "SELECT id, title, s_id from PROJECT WHERE STATUS='$complete' AND id IN
					(SELECT p_id FROM RELATION WHERE U_ID=$uid)";
		return self::selectDataList($db_connection, $query);
	}

	public static function updateProj($id, $title, $owner, $creator, $description, $status, $deadline)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "UPDATE PROJECT SET ".(isset($title)?"TITLE='$title', ":"").(isset($owner)?"OWNER=$owner, ":"").(isset($creator)?"CREATOR=$creator, ":"")."DESCRIPTION=". self::checkNull($description) .", STATUS='$status', END_DATE=". self::checkNull($deadline) ." WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function insertRelation($uid, $pid)
	{
		$role = 'MEMB';
		$db_connection = self::getConn(self::$PROJ);
		$query = "INSERT INTO RELATION(U_ID, P_ID, ROLE) VALUES($uid, $pid, '$role')";
		return self::insertData($db_connection, $query);
	}

	public static function deleteRelation($uid, $pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "DELETE FROM RELATION WHERE U_ID=$uid AND P_ID=$pid";
		return self::deleteData($db_connection, $query);
	}

//============================================ PROJECT COMPONENT Related ==============================================

	public static function getComp($id)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT creator, owner, title, description, status create_date, lastupdate_date, lastupdate_user, end_date, p_id, s_id, is_milestone FROM PROJCOMP WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getCompDate($id)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT lastupdate_date FROM PROJCOMP WHERE ID=" . $id;
		$result = self::selectData($db_connection, $query);
		return $result['lastupdate_date'];
	}

	public static function getCompSid($id, $sid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT creator, owner, title, description, status, create_date, lastupdate_date, lastupdate_user, end_date, p_id, is_milestone FROM PROJCOMP WHERE ID=" . $id . " and S_ID=" . $sid;
		return self::selectData($db_connection, $query);
	}

	public static function getCompId($title, $p_id)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT id FROM PROJCOMP WHERE TITLE='". mysql_real_escape_string($title) ."' and P_ID=". $p_id;
		$result = self::selectData($db_connection, $query);
		return $result['id'];
	}

	public static function getProjCompList($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT id, title, s_id FROM PROJCOMP WHERE P_ID=" . $pid;
		return self::selectDataList($db_connection, $query);
	}

	public static function insertComp($creator, $owner, $title, $discription, $end_date, $p_id, $s_id, $is_milestone)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "INSERT INTO PROJCOMP (CREATOR, OWNER, TITLE, DESCRIPTION, STATUS, CREATE_DATE, LASTUPDATE_DATE, LASTUPDATE_USER, END_DATE, P_ID, S_ID, IS_MILESTONE)
				 VALUES (". $creator .", ". $owner .", '". mysql_real_escape_string($title) ."', ". self::checkNull($discription) .", 'NEWA', NOW(), NOW(), ". $creator .", ". self::checkNull($end_date) .", ". $p_id .", ". $s_id .", ".($is_milestone ? "'Y'":"'N'").")";
		if( self::insertData($db_connection, $query) )
			$atReturn = mysql_insert_id();
		else $atReturn = -1;
		return $atReturn;
	}

	public static function updateComp($id, $title, $owner, $description, $status, $is_milestone, $end_date)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "UPDATE PROJCOMP SET ".(isset($title) ? "TITLE='$title', " : "").(isset($owner) ? "OWNER=". $owner .", " : "")."DESCRIPTION=". self::checkNull($description) .", STATUS='$status', IS_MILESTONE=".($is_milestone ? "'Y'":"'N'").", END_DATE=". self::checkNull($end_date) .", LASTUPDATE_USER=". $_SESSION['_userId'] .", LASTUPDATE_DATE=NOW() WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function getProjectMileStoneComponents($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT id, title, end_date, s_id FROM PROJCOMP WHERE P_ID=$pid AND IS_MILESTONE='Y'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getNoneCompleteComponent($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT id, title, s_id FROM PROJCOMP WHERE P_ID=$pid AND STATUS<>'COMP'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getCompleteComponent($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT id, title, s_id FROM PROJCOMP WHERE P_ID=$pid AND STATUS='COMP'";
		return self::selectDataList($db_connection, $query);
	}

	public static function hasComponent($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT COUNT(*) as count FROM PROJCOMP WHERE P_ID=$pid";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return ($result['count'] != 0);
	}

	public static function hasCompeleteComponent($pid)
	{
		$db_connection = self::getConn(self::$PROJ);
		$query = "SELECT COUNT(*) as count FROM PROJCOMP WHERE P_ID=$pid AND STATUS='COMP'";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return ($result['count'] != 0);
	}

//============================================ WORK PACKAGE Related ==============================================

	public static function getWorkPackage($id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT owner_id, creator_id, objective, description, status, creation_time, lastupdated_time, lastupdated_user, deadline, proj_id, comp_id, s_id FROM WORKPACKAGE WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getWorkPackageDate($id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT lastupdated_time FROM WORKPACKAGE WHERE ID=" . $id;
		$result = self::selectData($db_connection, $query);
		return $result['lastupdated_time'];
	}

	public static function getWorkPackageSid($id, $sid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT owner_id, creator_id, objective, description, status, creation_time, lastupdated_time, lastupdated_user, deadline, proj_id, comp_id FROM WORKPACKAGE WHERE ID=" . $id . " and S_ID=" . $sid;
		return self::selectData($db_connection, $query);
	}

	public static function getWorkPackageId($objective, $sid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id FROM WORKPACKAGE WHERE OBJECTIVE='". mysql_real_escape_string($objective) ."' and S_ID=". $sid;
		$result = self::selectData($db_connection, $query);
		return $result['id'];
	}

	public static function getCompWorkPackageList($cid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, objective, s_id FROM WORKPACKAGE WHERE COMP_ID=" . $cid;
		return self::selectDataList($db_connection, $query);
	}

	public static function getProjWorkPackageList($pid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, objective, s_id FROM WORKPACKAGE WHERE COMP_ID IS NULL and PROJ_ID=" . $pid;
		return self::selectDataList($db_connection, $query);
	}

	public static function getUserWorkPackageList($uid, $isOwner, $proj, $comp, $status)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, objective, s_id FROM WORKPACKAGE WHERE " . 
				 (($isOwner) ? "OWNER_ID=" : "CREATOR_ID=") . $uid . 
				 (isset($proj) ? " and PROJ_ID=" . $proj : "") .
				 (isset($comp) ? " and COMP_ID=" . $comp : "") .
				 (isset($status) ? " and STATUS=" . $status : "");
		return self::selectDataList($db_connection, $query);
	}

	public static function getMonthWorkPackageDueList($year, $month, $woner)
	{
		$db_connection = self::getConn(self::$WOMA);
		$date_start = mktime(0,0,0,$month,1,$year);
		$month_e = ($month !=12) ? $month+1 : 1;
		$year_e = ($month !=12) ? $year : $year+1;
		$date_end = mktime(0,0,0,$month_e,1,$year_e);
		$closed = 'CLOS';

		$query = "SELECT id, objective, deadline, s_id FROM WORKPACKAGE WHERE STATUS<>'$closed' and OWNER_ID=$woner and DEADLINE>='". date("Y-m-d", $date_start) ."' and DEADLINE<'". date("Y-m-d", $date_end) ."'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getMonthProjectWorkPackageDueList($year, $month, $woner, $proj)
	{
		$db_connection = self::getConn(self::$WOMA);
		$date_start = mktime(0,0,0,$month,1,$year);
		$month_e = ($month !=12) ? $month+1 : 1;
		$year_e = ($month !=12) ? $year : $year+1;
		$date_end = mktime(0,0,0,$month_e,1,$year_e);
		$closed = 'CLOS';

		$query = "SELECT id, objective, deadline, s_id FROM WORKPACKAGE WHERE STATUS<>'$closed' and OWNER_ID=$woner and PROJ_ID=$proj and DEADLINE>='". date("Y-m-d", $date_start) ."' and DEADLINE<'". date("Y-m-d", $date_end) ."'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getMonthComponentWorkPackageDueList($year, $month, $woner, $comp)
	{
		$db_connection = self::getConn(self::$WOMA);
		$date_start = mktime(0,0,0,$month,1,$year);
		$month_e = ($month !=12) ? $month+1 : 1;
		$year_e = ($month !=12) ? $year : $year+1;
		$date_end = mktime(0,0,0,$month_e,1,$year_e);
		$closed = 'CLOS';

		$query = "SELECT id, objective, deadline, s_id FROM WORKPACKAGE WHERE STATUS<>'$closed' and OWNER_ID=$woner and COMP_ID=$comp and DEADLINE>='". date("Y-m-d", $date_start) ."' and DEADLINE<'". date("Y-m-d", $date_end) ."'";
		return self::selectDataList($db_connection, $query);
	}

	public static function insertWorkPackage($owner, $creator, $objective, $description, $end_date, $p_id, $c_id, $s_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "INSERT INTO WORKPACKAGE (OWNER_ID, CREATOR_ID, OBJECTIVE, DESCRIPTION, STATUS, CREATION_TIME, LASTUPDATED_TIME, LASTUPDATED_USER, DEADLINE, PROJ_ID, COMP_ID, S_ID)
				 VALUES (". $owner .", ". $creator .", '". mysql_real_escape_string($objective) ."', ". self::checkNull($description) .", 'OPEN', NOW(), NOW(), ". $creator .", '". $end_date ."', ". $p_id .", ".  self::checkNull($c_id) .", ". $s_id .")";
		return self::insertData($db_connection, $query);
	}

	public static function updateWorkPackage($id, $owner, $objective, $description, $status, $deadline)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "UPDATE WORKPACKAGE SET ". (isset($owner) ? "OWNER_ID=". $owner .", " : "") ."OBJECTIVE=". self::checkNull($objective) .", DESCRIPTION=". self::checkNull($description) .", STATUS='$status', DEADLINE='". $deadline ."', LASTUPDATED_USER=". $_SESSION['_userId'] .", LASTUPDATED_TIME=NOW() WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function insertWorkPackageComment($owner, $wp_id, $content)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "INSERT INTO COMMENT_WP (WORKPACKAGE_ID, CREATOR_ID, CONTENT, MODIFIED)
				 VALUES ($wp_id, $owner, '".mysql_real_escape_string($content)."', NOW())";
		return self::insertData($db_connection, $query);
	}

	public static function getWorkPackageComments($wp_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, creator_id, content, modified FROM COMMENT_WP WHERE WORKPACKAGE_ID=$wp_id";
		return self::selectDataList($db_connection, $query);
	}

	public static function getWorkPackageCommentCount($wp_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT COUNT(*) as count FROM COMMENT_WP WHERE WORKPACKAGE_ID=$wp_id";
		$result = self::selectData($db_connection, $query);
		return $result['count'];
	}

//============================================ WORK ITEM Related ==============================================

	public static function getWorkItem($id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT pw_id, owner_id, creator_id, proj_id, comp_id, workpackage_id, linkworkpackage_id, title, description, type, status, priority, creation_time, lastupdated_time, lastupdated_user, deadline, s_id FROM WORKITEM WHERE ID=" . $id;
		return self::selectData($db_connection, $query);
	}

	public static function getWorkItemDate($id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT lastupdated_time FROM WORKITEM WHERE ID=" . $id;
		$result = self::selectData($db_connection, $query);
		return $result['lastupdated_time'];
	}

	public static function getWorkItemSid($id, $sid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT pw_id, owner_id, creator_id, proj_id, comp_id, workpackage_id, linkworkpackage_id, title, description, type, status, priority, creation_time, lastupdated_time, lastupdated_user, deadline FROM WORKITEM WHERE ID=" . $id . " and S_ID=" . $sid;
		return self::selectData($db_connection, $query);
	}

	public static function getWorkPackageWorkItemList($wpid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, pw_id, title, s_id, owner_id, type, status, priority, deadline, lastupdated_time FROM WORKITEM WHERE WORKPACKAGE_ID=" . $wpid;
		return self::selectDataList($db_connection, $query);
	}

	public static function getComponentWorkItemList($cid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, pw_id, title, type, s_id FROM WORKITEM WHERE WORKPACKAGE_ID IS NULL AND COMP_ID=" . $cid;
		return self::selectDataList($db_connection, $query);
	}

	public static function getProjectWorkItemList($pid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, pw_id, title, type, s_id FROM WORKITEM WHERE WORKPACKAGE_ID IS NULL AND COMP_ID IS NULL AND PROJ_ID=" . $pid;
		return self::selectDataList($db_connection, $query);
	}

	public static function getMonthWorkItemDueList($year, $month, $woner)
	{
		$db_connection = self::getConn(self::$WOMA);
		$date_start = mktime(0,0,0,$month,1,$year);
		$month_e = ($month !=12) ? $month+1 : 1;
		$year_e = ($month !=12) ? $year : $year+1;
		$date_end = mktime(0,0,0,$month_e,1,$year_e);
		$closed = 'CLOS';
		$duplicated = 'DUPL';
		$not_valid = 'NOTV';
		$done = 'DONE';

		$query = "SELECT id, pw_id, title, type, deadline, s_id FROM WORKITEM WHERE STATUS<>'$closed' and STATUS<>'$duplicated' and STATUS<>'$done' and STATUS<>'$not_valid' and OWNER_ID=$woner and DEADLINE>='". date("Y-m-d", $date_start) ."' and DEADLINE<'". date("Y-m-d", $date_end) ."'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getMonthProjectWorkItemDueList($year, $month, $woner, $proj)
	{
		$db_connection = self::getConn(self::$WOMA);
		$date_start = mktime(0,0,0,$month,1,$year);
		$month_e = ($month !=12) ? $month+1 : 1;
		$year_e = ($month !=12) ? $year : $year+1;
		$date_end = mktime(0,0,0,$month_e,1,$year_e);
		$closed = 'CLOS';
		$duplicated = 'DUPL';
		$not_valid = 'NOTV';
		$done = 'DONE';

		$query = "SELECT id, pw_id, title, deadline, type, s_id FROM WORKITEM WHERE STATUS<>'$closed' and STATUS<>'$duplicated' and STATUS<>'$done' and STATUS<>'$not_valid' and OWNER_ID=$woner and PROJ_ID=$proj and DEADLINE>='". date("Y-m-d", $date_start) ."' and DEADLINE<'". date("Y-m-d", $date_end) ."'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getMonthComponentWorkItemDueList($year, $month, $woner, $comp)
	{
		$db_connection = self::getConn(self::$WOMA);
		$date_start = mktime(0,0,0,$month,1,$year);
		$month_e = ($month !=12) ? $month+1 : 1;
		$year_e = ($month !=12) ? $year : $year+1;
		$date_end = mktime(0,0,0,$month_e,1,$year_e);
		$closed = 'CLOS';
		$duplicated = 'DUPL';
		$not_valid = 'NOTV';
		$done = 'DONE';

		$query = "SELECT id, pw_id, title, type, deadline, s_id FROM WORKITEM WHERE STATUS<>'$closed' and STATUS<>'$duplicated' and STATUS<>'$done' and STATUS<>'$not_valid' and OWNER_ID=$woner and COMP_ID=$comp and DEADLINE>='". date("Y-m-d", $date_start) ."' and DEADLINE<'". date("Y-m-d", $date_end) ."'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getWorkItemId($owner_id, $creator_id, $proj_id, $sid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id FROM WORKITEM WHERE OWNER_ID=$owner_id AND CREATOR_ID=$creator_id AND PROJ_ID=$proj_id AND S_ID=$sid";
		$result = self::selectData($db_connection, $query);
		return $result['id'];
	}

	public static function insertWorkItem($owner, $creator, $p_id, $c_id, $workpackage_id, $title, $description, $type, $priority, $end_date, $s_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$max_q = "SELECT MAX(PW_ID) as max FROM WORKITEM WHERE PROJ_ID=$p_id";
		$result = self::selectData($db_connection, $max_q);
		$next = $result['max'] + 1;
		$query = "INSERT INTO WORKITEM (OWNER_ID, PW_ID, CREATOR_ID, PROJ_ID, COMP_ID, WORKPACKAGE_ID, LINKWORKPACKAGE_ID, TITLE, DESCRIPTION, TYPE, STATUS, PRIORITY, CREATION_TIME, LASTUPDATED_TIME, LASTUPDATED_USER, DEADLINE, S_ID)
				 VALUES ($owner, $next, ". $creator .", ". $p_id .", ". self::checkNull($c_id) .", ". self::checkNull($workpackage_id) .", NULL, '". mysql_real_escape_string($title) ."', ". self::checkNull($description) .", '$type', 'OPEN', '$priority', NOW(), NOW(), ". $creator .", '". $end_date ."', ". $s_id .")";
		return self::insertData($db_connection, $query);
	}

	public static function updateWorkItem($id, $owner, $com_id, $wp_id, $title, $description, $status, $priority, $deadline)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "UPDATE WORKITEM SET ".(isset($owner) ? "OWNER_ID=". $owner .", " : "")."COMP_ID=".(isset($com_id) ? $com_id .", " : "NULL, ")."WORKPACKAGE_ID=".(isset($wp_id) ? $wp_id .", " : "NULL, ")."TITLE=". self::checkNull($title) .", DESCRIPTION=". self::checkNull($description) .", STATUS='$status', PRIORITY='$priority', DEADLINE='". $deadline ."', LASTUPDATED_USER=". $_SESSION['_userId'] .", LASTUPDATED_TIME=NOW() WHERE ID=". $id;
		return self::updateData($db_connection, $query);
	}

	public static function updateWorkItemStatus($id, $status)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "UPDATE WORKITEM SET STATUS='$status' WHERE ID=$id";
		return self::updateData($db_connection, $query);
	}

	public static function insertWorkItemComment($owner, $wi_id, $content)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "INSERT INTO COMMENT_WI (WORKITEM_ID, CREATOR_ID, CONTENT, MODIFIED)
				 VALUES ($wi_id, $owner, '".mysql_real_escape_string($content)."', NOW())";
		return self::insertData($db_connection, $query);
	}

	public static function getWorkItemComments($wi_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, creator_id, content, modified FROM COMMENT_WI WHERE WORKITEM_ID=$wi_id";
		return self::selectDataList($db_connection, $query);
	}

	public static function getWorkItemCommentCount($wi_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT COUNT(*) as count FROM COMMENT_WI WHERE WORKITEM_ID=$wi_id";
		$result = self::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function doesWorkitemExistInProject($wi_id, $p_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT proj_id FROM WORKITEM WHERE ID=$wi_id";
		$result = self::selectData($db_connection, $query);
		return (isset($result['proj_id']) ? ($result['proj_id']==$p_id) : false);
	}

	public static function transferUserWorkitems($pid, $fid, $tid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "UPDATE WORKITEM SET OWNER_ID=$tid WHERE PROJ_ID=$pid AND OWNER_ID=$fid";
		return self::updateData($db_connection, $query);
	}

	public static function insertSubscription($p_id, $wi_id, $u_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "INSERT INTO SUBSCRIPTION (PROJ_ID, WORKITEM_ID, USER_ID) VALUES ($p_id, $wi_id, $u_id)";
		return self::insertData($db_connection, $query);
	}

	public static function getSubscribers($wi_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, user_id FROM SUBSCRIPTION WHERE WORKITEM_ID=$wi_id";
		return self::selectDataList($db_connection, $query);
	}

	public static function getUserSubscribedWorkitems($u_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id, workitem_id FROM SUBSCRIPTION WHERE USER_ID=$u_id";
		return self::selectDataList($db_connection, $query);
	}

	public static function removeSubscription($wi_id, $u_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "DELETE FROM SUBSCRIPTION WHERE USER_ID=$u_id AND WORKITEM_ID=$wi_id";
		return self::deleteData($db_connection, $query);
	}

	public static function isUserSubscribedToWorkitem($wi_id, $u_id)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT id FROM SUBSCRIPTION WHERE USER_ID=$u_id AND WORKITEM_ID=$wi_id";
		$result = self::selectData($db_connection, $query);
		return isset($result['id']);
	}

	public static function transferUserSubscriptions($pid, $fid,  $tid)
	{
		$db_connection = self::getConn(self::$WOMA);
		$query = "SELECT workitem_id FROM SUBSCRIPTION WHERE PROJ_ID=$pid AND USER_ID=$fid";
		$ids = self::selectDataList($db_connection, $query);
		$range = '(0';
		while ($id = mysql_fetch_array($ids, MYSQL_ASSOC))
			$range.=','.$id['workitem_id'];
		$range.= ')';
		$query = "DELETE FROM SUBSCRIPTION WHERE WORKITEM_ID IN $range AND USER_ID=$tid";
		if( self::deleteData($db_connection, $query) ) {
			$query = "UPDATE SUBSCRIPTION SET USER_ID=$tid WHERE PROJ_ID=$pid AND USER_ID=$fid";
			$result = self::updateData($db_connection, $query);
		}
		else $result = false;
		return $result;
	}

//============================================== CALENDAR Related =================================================

	public static $WORKITEM=0;
	public static $WORKPACKAGE=1;

	public static function selectTableWork($owner, $start, $end, $proj, $comp)
	{
		$wi_closed = 'CLOS';
		$wi_duplicate = 'DUPL';
		$wi_notvalid = 'NOTV';
		$wi_done = 'DONE';
//		$wp_closed = 'CLOS';

		$db_connection = self::getConn(self::$WOMA);
		$wi_where = "WHERE STATUS<>'$wi_closed' and STATUS<>'$wi_done' and STATUS<>'$wi_duplicate' and STATUS<>'$wi_notvalid'".( isset($start)&&!empty($start) ? " and DEADLINE>='$start'": "").( isset($end)&&!empty($end) ? " and DEADLINE<='$end'": "")." and OWNER_ID=". $owner.(isset($proj) ? " and PROJ_ID=". $proj : "").(isset($comp) ? " and COMP_ID=". $comp : "");
//		$wp_where = "WHERE STATUS<>'$wp_closed' and DEADLINE>='". $start ."' and DEADLINE<='". $end ."' and OWNER_ID=". $owner.(isset($proj) ? " and PROJ_ID=". $proj : "").(isset($comp) ? " and COMP_ID=". $comp : "");

		$query = "SELECT id, pw_id, proj_id, comp_id, workpackage_id, title as title, type as type, status, priority as priority, deadline, ". self::$WORKITEM ." as itype, s_id FROM WORKITEM $wi_where ORDER BY DEADLINE";
//				." UNION "."SELECT id, '', proj_id, comp_id, id as workpackage_id, objective as title, '' as type, status, '' as priority, deadline, ". self::$WORKPACKAGE ." as itype, s_id FROM WORKPACKAGE". $wp_where ." ORDER BY DEADLINE";

		return self::selectDataList($db_connection, $query);
	}

//============================================ DOCUMENTATION Related ==============================================

	public static function moveWorkitemDocToComponent($wiid, $cid)
	{
		$value = ($cid!=0 ? $cid : 'NULL');
		$db_connection = self::getConn(self::$DOCS);
		$query = "UPDATE FILE SET COMP_ID=$value WHERE WORK_IID=$wiid";
		return self::updateData($db_connection, $query);
	}

	public static function getProjDocList($pid, $cid, $wpid, $wiid)
	{
		$db_connection = self::getConn(self::$DOCS);
		$query = "SELECT id, title, size, updater, last_update, version, description, s_id FROM FILE WHERE P_ID=" . $pid . " and COMP_ID" . (isset($cid) ? "=" : " is ") . self::checkNull($cid) . " and WORK_PID". (isset($wpid) ? "=" : " is ") . self::checkNull($wpid) . " and WORK_IID". (isset($wiid) ? "=" : " is ") . self::checkNull($wiid);
		return self::selectDataList($db_connection, $query);
	}

	public static function getDocProjId($doc_id)
	{
		$db_connection = self::getConn(self::$DOCS);
		$query = "SELECT p_id FROM FILE WHERE ID=$doc_id";
		$result = self::selectData($db_connection, $query);
		return $result['p_id'];
	}

	public static function getDoc($id, $s_id)
	{
		$db_connection = self::getConn(self::$DOCS);
		$query = "SELECT title, updater, last_update, content, size, version, p_id, comp_id, work_pid, work_iid FROM FILE WHERE ID=$id AND S_ID='".$s_id."'";
		return self::selectData($db_connection, $query);
	}

	public static function getDocVersion($title, $pid, $cid, $wpid, $wiid)
	{
		$db_connection = self::getConn(self::$DOCS);
		$query = "SELECT MAX(VERSION) as max FROM FILE WHERE TRUE 
				  AND TITLE='$title' 
				  AND P_ID=$pid ".
				  (isset($cid) && is_numeric($cid) ? "AND COMP_ID=$cid " : "").
				  (isset($wpid) && is_numeric($wpid) ? "AND WORK_PID=$wpid " : "").
				  (isset($wiid) && is_numeric($wiid) ? "AND WORK_IID=$wiid" : "");
		$result = self::selectData($db_connection, $query);
		return $result['max'];
	}

	public static function insertProjDoc($title, $updater, $content, $size, $pid, $cid, $wpid, $wiid, $desc, $ver, $sid)
	{
		$db_connection = self::getConn(self::$DOCS);
		$query = "INSERT INTO FILE (TITLE, UPDATER, LAST_UPDATE, CONTENT, SIZE, P_ID, COMP_ID, WORK_PID, WORK_IID, DESCRIPTION, VERSION, S_ID)
				 VALUES ('".mysql_real_escape_string($title)."', $updater, NOW(), ".self::checkNull($content).", $size, $pid, ". self::checkNull($cid) .", ". self::checkNull($wpid) .", ". self::checkNull($wiid) .", ".self::checkNull($desc).", $ver, '$sid')";
		return self::insertData($db_connection, $query);
	}

//============================================ ENUM Related ==============================================

    public static $PROJ_STATUS = 'PROJ_STATUS';
    public static $WP_STATUS = 'WP_STATUS';
    public static $WI_STATUS = 'WI_STATUS';
    public static $WI_TYPE = 'WI_TYPE';
    public static $PRIORITY = 'PRIORITY';
    public static $EDUCATION = 'EDUCATION';

	public static function getEnumList($table)
	{
		$lang = isset($_SESSION['_language']) ? $_SESSION['_language'] : '';
		$db_connection = self::getConn(self::$ENUM);
		$query = "SELECT code, description FROM $table WHERE LANGUAGE='$lang'";
		return self::selectDataList($db_connection, $query);
	}

	public static function getEnumDescription($table, $code)
	{
		$lang = isset($_SESSION['_language']) ? $_SESSION['_language'] : '';
		$db_connection = self::getConn(self::$ENUM);
		$query = "SELECT description FROM $table WHERE CODE='$code' AND LANGUAGE='$lang'";
		$result = self::selectData($db_connection, $query);
		return $result['description'];
	}

	public static function isEmunValue($table, $code)
	{
		$desc = self::getEnumDescription($table, $code);
		return (isset($desc) && !empty($desc));
	}

//============================================ MESS Related ==============================================

	public static function getMessages($user)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT id, title, from_id, create_time, is_read FROM MESSAGE WHERE OWNER_ID=$user ORDER BY CREATE_TIME DESC";
		return self::selectDataList($db_connection, $query);
	}

	public static function getMessageBody($mid, $oid)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT body FROM MESSAGE WHERE ID=$mid AND OWNER_ID=$oid";
		$result = self::selectData($db_connection, $query);
		return $result['body'];
	}

	public static function insertMessage($title, $owner_id, $from_id, $body)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "INSERT INTO MESSAGE (TITLE, OWNER_ID, FROM_ID, BODY, CREATE_TIME, IS_READ)
				  VALUES ('$title', $owner_id, $from_id, ". self::checkNull($body) .", NOW(), 'N')";
		return self::insertData($db_connection, $query);
	}

	public static function countUnreadMessages($user)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT COUNT(*) as count FROM MESSAGE WHERE IS_READ='N' AND OWNER_ID=$user";
		$result = self::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function setMessageRead($mid, $u_id)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "UPDATE MESSAGE SET IS_READ='Y' WHERE ID=$mid AND OWNER_ID=$u_id";
		return self::updateData($db_connection, $query);
	}

	public static function deleteMessage($mid)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "DELETE FROM MESSAGE WHERE ID=$mid AND OWNER_ID=".$_SESSION['_userId'];
		return self::deleteData($db_connection, $query);
	}

	public static function getUserActiveNotes($user)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT id, title, description, done, create_time FROM NOTE WHERE USER_ID=$user AND DONE='N' ORDER BY CREATE_TIME DESC";
		return self::selectDataList($db_connection, $query);
	}

	public static function getUserDoneNotes($user)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT id, title, description, done, done_time FROM NOTE WHERE USER_ID=$user AND DONE='Y' ORDER BY DONE_TIME DESC";
		return self::selectDataList($db_connection, $query);
	}

	public static function insertNotes($u_id, $title, $description)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "INSERT INTO NOTE (USER_ID, TITLE, DESCRIPTION, CREATE_TIME, DONE, DONE_TIME)
				  VALUES ($u_id, '".mysql_real_escape_string($title)."', ".self::checkNull($description).", NOW(), 'N', NULL)";
		return self::insertData($db_connection, $query);
	}

	public static function countActiveNotes($user)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT COUNT(*) as count FROM NOTE WHERE USER_ID=$user AND DONE='N'";
		$result = self::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function getNoteDoneStatus($nid, $u_id)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT done FROM NOTE WHERE ID=$nid AND USER_ID=$u_id";
		$result = self::selectData($db_connection, $query);
		return $result['done'];
	}

	public static function setNoteDoneStatus($nid, $u_id, $status)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "UPDATE NOTE SET DONE='$status',".($status='Y' ? " DONE_TIME=NOW()" : "")." WHERE ID=$nid AND USER_ID=$u_id";
		return self::updateData($db_connection, $query);
	}

	public static function insertFeedback($email, $content)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "INSERT INTO FEEDBACK (FROM_EMAIL, BODY, CREATE_TIME)
				  VALUES ('".mysql_real_escape_string($email)."', '".mysql_real_escape_string($content)."', NOW())";
		return self::insertData($db_connection, $query);
	}

	public static function getFeedback($id)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT from_email, body, create_time FROM FEEDBACK WHERE ID=$id";
		return self::selectData($db_connection, $query);
	}

	public static function getFeedbackList()
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "SELECT from_email, body, create_time FROM FEEDBACK";
		return self::selectDataList($db_connection, $query);
	}

	public static function deleteFeedback($id)
	{
		$db_connection = self::getConn(self::$MESS);
		$query = "DELETE FROM FEEDBACK WHERE ID=$id";
		return self::deleteData($db_connection, $query);
	}
}