<?php
include_once ("../common/Objects.php");
include_once ("DatabaseUtil.php");

class SessionUtil
{
	public static function selectProject($uid, $pid, $sid)
	{
		$proj = DatabaseUtil::getProjSid($pid, $sid);

		if ($proj == null || !DatabaseUtil::isProjectMember($uid, $pid))
		{
			self::clearProjectSession();
			header( 'Location: ../home/index.php' ) ;
			exit;
		}
		else
		{
			$project = new Project();
			$project->id = $pid;
			$project->title = $proj['title'];
			$project->creator = $proj['creator'];
			$project->description = $proj['description'];
			$project->status = $proj['status'];
			$project->create_date = $proj['create_date'];
			$project->owner = $proj['owner'];
			$project->end_date = $proj['end_date'];
			$project->s_id = $sid;
			$_SESSION['_project'] = $project;

			$creator = DatabaseUtil::getUser($project->creator);
			$creatorU = new User();
			$creatorU->id = $project->creator;
			$creatorU->lastname = $creator['lastname'];
			$creatorU->firstname = $creator['firstname'];
			$creatorU->fullname_cn = $creator['fullname_cn'];
			$creatorU->login_email = $creator['login_email'];
			$_SESSION['_projectCreator'] = $creatorU;

			$manager = DatabaseUtil::getUser($project->owner);
			$managerU = new User();
			$managerU->id = $project->owner;
			$managerU->lastname = $manager['lastname'];
			$managerU->firstname = $manager['firstname'];
			$managerU->fullname_cn = $manager['fullname_cn'];
			$managerU->login_email = $manager['login_email'];
			$_SESSION['_projectManager'] = $managerU;

			$role = DatabaseUtil::getRole($uid, $pid);
			$_SESSION['_role'] = $role;
			$_SESSION['_roleD'] = DatabaseUtil::getEnumDescription(DatabaseUtil::$RELATION, $role);
		}
	}

	public static function selectComponent($uid, $cid, $sid)
	{
		$comp = DatabaseUtil::getCompSid($cid, $sid);
	
		if ($comp == null) {
			header( 'Location: ../home/index.php' ) ;
			self::clearComponentSession();
			exit;
		}
		else
		{
			if( !isset($_SESSION['_project']) || $comp['p_id'] != $_SESSION['_project']->id )
			{
				$proj = DatabaseUtil::getProj($comp['p_id']);
				self::selectProject($uid, $comp['p_id'], $proj['s_id']);
			}

			$component = new Component();
			$component->id = $cid;
			$component->creator = $comp['creator'];
			$component->owner = $comp['owner'];
			$component->title = $comp['title'];
			$component->description = $comp['description'];
			$component->status = $comp['status'];
			$component->create_date = $comp['create_date'];
			$component->lastupdate_date = $comp['lastupdate_date'];
			$component->lastupdate_user = $comp['lastupdate_user'];
			$component->end_date = $comp['end_date'];
			$component->p_id = $comp['p_id'];
			$component->s_id = $sid;
			$component->is_milestone = $comp['is_milestone']=='Y';
			$_SESSION['_component'] = $component;

			$creator = DatabaseUtil::getUser($component->creator);
			$creatorU = new User();
			$creatorU->id = $component->creator;
			$creatorU->lastname = $creator['lastname'];
			$creatorU->firstname = $creator['firstname'];
			$creatorU->fullname_cn = $creator['fullname_cn'];
			$creatorU->login_email = $creator['login_email'];
			$_SESSION['_componentCreator'] = $creatorU;

			$creator = DatabaseUtil::getUser($component->owner);
			$creatorO = new User();
			$creatorO->id = $component->owner;
			$creatorO->lastname = $creator['lastname'];
			$creatorO->firstname = $creator['firstname'];
			$creatorO->fullname_cn = $creator['fullname_cn'];
			$creatorO->login_email = $creator['login_email'];
			$_SESSION['_componentOwner'] = $creatorO;

			$laup = DatabaseUtil::getUser($component->lastupdate_user);
			$laupU = new User();
			$laupU->id = $component->lastupdate_user;
			$laupU->lastname = $laup['lastname'];
			$laupU->firstname = $laup['firstname'];
			$laupU->fullname_cn = $laup['fullname_cn'];
			$laupU->login_email = $laup['login_email'];
			$_SESSION['_componentLaup'] = $laupU;
		}
	}

	public static function selectWorkpackage($uid, $wpid, $sid)
	{
		$wp = DatabaseUtil::getWorkPackageSid($wpid, $sid);

		if ($wp == null) {
			header( 'Location: ../home/index.php' );
			self::clearWorkpackageSession();
			exit;
		}
		else
		{
			if( !isset($_SESSION['_project'])|| 
				$wp['proj_id'] != $_SESSION['_project']->id )
			{
				$proj = DatabaseUtil::getProj($wp['proj_id']);
				self::selectProject($uid, $wp['proj_id'], $proj['s_id']);
			}

			if( isset($wp['comp_id']) && 
				(!isset($_SESSION['_component']) || $wp['comp_id'] != $_SESSION['_component']->id) )
			{
				$comp = DatabaseUtil::getComp($wp['comp_id']);
				self::selectComponent($uid, $wp['comp_id'], $comp['s_id']);
			}
			else if( isset($_SESSION['_component']) && !isset($wp['comp_id']) )
			{
				self::clearComponentSession();
			}

			$workpackage = new Workpackage();
			$workpackage->id = $wpid;
			$workpackage->owner_id = $wp['owner_id'];
			$workpackage->creator_id = $wp['creator_id'];
			$workpackage->objective = $wp['objective'];
			$workpackage->description = $wp['description'];
			$workpackage->status = $wp['status'];
			$workpackage->creation_time = $wp['creation_time'];
			$workpackage->lastupdated_time = $wp['lastupdated_time'];
			$workpackage->lastupdated_user = $wp['lastupdated_user'];
			$workpackage->deadline = $wp['deadline'];
			$workpackage->proj_id = $wp['proj_id'];
			$workpackage->comp_id = $wp['comp_id'];
			$workpackage->s_id = $sid;
			$_SESSION['_workpackage'] = $workpackage;

			$creator = DatabaseUtil::getUser($workpackage->creator_id);
			$creatorU = new User();
			$creatorU->id = $workpackage->creator_id;
			$creatorU->lastname = $creator['lastname'];
			$creatorU->firstname = $creator['firstname'];
			$creatorU->fullname_cn = $creator['fullname_cn'];
			$creatorU->login_email = $creator['login_email'];
			$_SESSION['_workpackageCreator'] = $creatorU;

			$creator = DatabaseUtil::getUser($workpackage->owner_id);
			$creatorO = new User();
			$creatorO->id = $workpackage->owner_id;
			$creatorO->lastname = $creator['lastname'];
			$creatorO->firstname = $creator['firstname'];
			$creatorO->fullname_cn = $creator['fullname_cn'];
			$creatorO->login_email = $creator['login_email'];
			$_SESSION['_workpackageOwner'] = $creatorO;

			$laup = DatabaseUtil::getUser($workpackage->lastupdated_user);
			$laupU = new User();
			$laupU->id = $workpackage->lastupdated_user;
			$laupU->lastname = $laup['lastname'];
			$laupU->firstname = $laup['firstname'];
			$laupU->fullname_cn = $laup['fullname_cn'];
			$laupU->login_email = $laup['login_email'];
			$_SESSION['_workpackageLaup'] = $laupU;
		}
	}

	public static function selectWorkItem($uid, $wiid, $sid)
	{
		$wi = DatabaseUtil::getWorkItemSid($wiid, $sid);

		if ($wi == null)
		{
			header( 'Location: ../home/index.php' ) ;
			self::clearWorkitemSession();
			exit;
		}
		else
		{
			if( !isset($_SESSION['_project']) || 
				$wi['proj_id'] != $_SESSION['_project']->id )
			{
				$proj = DatabaseUtil::getProj($wi['proj_id']);
				self::selectProject($uid, $wi['proj_id'], $proj['s_id']);
			}

			if( isset($wi['comp_id']) && 
				(!isset($_SESSION['_component']) || $wi['comp_id'] != $_SESSION['_component']->id) )
			{
				$comp = DatabaseUtil::getComp($wi['comp_id']);
				self::selectComponent($uid, $wi['comp_id'], $comp['s_id']);
			}
			else if( isset($_SESSION['_component']) && !isset($wi['comp_id']) )
			{
				self::clearComponentSession();
			}

			if( isset($wi['workpackage_id']) && 
				(!isset($_SESSION['_workpackage']) || $wi['workpackage_id'] != $_SESSION['_workpackage']->id) )
			{
				$wp = DatabaseUtil::getWorkPackage($wi['workpackage_id']);
				self::selectWorkpackage($uid, $wi['workpackage_id'], $wp['s_id']);
			}
			else if( isset($_SESSION['_workpackage']) && !isset($wi['workpackage_id']) )
			{
				self::clearWorkpackageSession();
			}

			$workitem = new WorkItem();
			$workitem->id = $wiid;
			$workitem->pw_id = $wi['pw_id'];
			$workitem->owner_id = $wi['owner_id'];
			$workitem->creator_id = $wi['creator_id'];
			$workitem->proj_id = $wi['proj_id'];
			$workitem->comp_id = $wi['comp_id'];
			$workitem->workpackage_id = $wi['workpackage_id'];
			$workitem->linkworkpackage_id = $wi['linkworkpackage_id'];
			$workitem->title = $wi['title'];
			$workitem->description = $wi['description'];
			$workitem->type = $wi['type'];
			$workitem->status = $wi['status'];
			$workitem->priority = $wi['priority'];
			$workitem->creation_time = $wi['creation_time'];
			$workitem->lastupdated_time = $wi['lastupdated_time'];
			$workitem->lastupdated_user = $wi['lastupdated_user'];
			$workitem->deadline = $wi['deadline'];
			$workitem->s_id = $sid;
			$_SESSION['_workitem'] = $workitem;

			$creator = DatabaseUtil::getUser($workitem->creator_id);
			$creatorU = new User();
			$creatorU->id = $workitem->creator_id;
			$creatorU->lastname = $creator['lastname'];
			$creatorU->firstname = $creator['firstname'];
			$creatorU->fullname_cn = $creator['fullname_cn'];
			$creatorU->login_email = $creator['login_email'];
			$_SESSION['_workitemCreator'] = $creatorU;

			$creator = DatabaseUtil::getUser($workitem->owner_id);
			$creatorO = new User();
			$creatorO->id = $workitem->owner_id;
			$creatorO->lastname = $creator['lastname'];
			$creatorO->firstname = $creator['firstname'];
			$creatorO->fullname_cn = $creator['fullname_cn'];
			$creatorO->login_email = $creator['login_email'];
			$_SESSION['_workitemOwner'] = $creatorO;

			$laup = DatabaseUtil::getUser($workitem->lastupdated_user);
			$laupU = new User();
			$laupU->id = $workitem->lastupdated_user;
			$laupU->lastname = $laup['lastname'];
			$laupU->firstname = $laup['firstname'];
			$laupU->fullname_cn = $laup['fullname_cn'];
			$laupU->login_email = $laup['login_email'];
			$_SESSION['_workitemLaup'] = $laupU;
		}
	}

	public static function clearProjectSession()
	{
		self::clearComponentSession();

		unset($_SESSION['_project']);
		unset($_SESSION['_projectCreator']);
		unset($_SESSION['_projectLaup']);

		unset($_SESSION['_users']);

		unset($_SESSION['_role']);
	} 

	public static function clearComponentSession()
	{
		self::clearWorkpackageSession();

		unset($_SESSION['_component']);
		unset($_SESSION['_componentCreator']);
		unset($_SESSION['_componentOwner']);
		unset($_SESSION['_componentLaup']);
	} 

	public static function clearWorkpackageSession()
	{
		self::clearWorkitemSession();

		unset($_SESSION['_workpackage']);
		unset($_SESSION['_workpackageCreator']);
		unset($_SESSION['_workpackageOwner']);
		unset($_SESSION['_workpackageLaup']);
	}  

	public static function clearWorkitemSession()
	{
		unset($_SESSION['_workitem']);
		unset($_SESSION['_workitemCreator']);
		unset($_SESSION['_workitemOwner']);
		unset($_SESSION['_workitemLaup']);
	}  

	public static function initSession()
	{
		self::updateSessionList(DatabaseUtil::$RELATION);
		self::updateSessionList(DatabaseUtil::$PROJ_STATUS);
		self::updateSessionList(DatabaseUtil::$WP_STATUS);
		self::updateSessionList(DatabaseUtil::$WI_STATUS);
		self::updateSessionList(DatabaseUtil::$WI_TYPE);
		self::updateSessionList(DatabaseUtil::$PRIORITY);
		self::updateSessionList(DatabaseUtil::$EDUCATION);
	}

	public static function updateSessionList($table)
	{
		$relation = DatabaseUtil::getEnumList($table);

		$_SESSION[$table] = array();
		$ind = 0;
		while ($row = mysql_fetch_array($relation, MYSQL_ASSOC))
		{
			$_SESSION[$table][$ind] = $row;
			$ind++;
		}
	}

	public static function getUserOpenProjList()
	{
		$_SESSION['_oProjList'] = array();
		$projects = DatabaseUtil::getUserOpenProjList($_SESSION['_userId']);

		$counter = 0;
		while($proj = mysql_fetch_array($projects, MYSQL_ASSOC))
		{
			$_SESSION['_oProjList'][$proj['id']] = array();
			$_SESSION['_oProjList'][$proj['id']]['p_id'] = $proj['id']; 
			$_SESSION['_oProjList'][$proj['id']]['title'] = $proj['title']; 
			$_SESSION['_oProjList'][$proj['id']]['s_id'] = $proj['s_id']; 
			$_SESSION['_oProjList'][$proj['id']]['role'] = DatabaseUtil::getRole($_SESSION['_userId'], $proj['id']);
			$counter++;
		}
	}
}
?>