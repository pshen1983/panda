<?php
class User
{
	public $id;
	public $lastname;
	public $firstname;
	public $fullname_cn;
	public $login_email;
	public $pic;
	public $proj_id;
}

class Project
{
	public $id;
	public $title;
	public $creator;
	public $description;
	public $status;
	public $create_date;
	public $owner;
	public $end_date;
	public $s_id;
}

class Component
{
	public $id;
	public $creator;
	public $owner;
	public $title;
	public $description;
	public $status;
	public $is_milestone;
	public $create_date;
	public $lastupdate_date;
	public $lastupdate_user;
	public $end_date;
	public $p_id;
	public $s_id;
}

class Workpackage
{
	public $id;
	public $owner_id;
	public $creator_id;
	public $objective;
	public $status;
	public $creation_time;
	public $lastupdated_time;
	public $lastupdated_user;
	public $deadline;
	public $proj_id;
	public $comp_id;
	public $s_id;
}

class WorkItem
{
	public $id;
	public $pw_id;
	public $owner_id;
	public $creator_id;
	public $proj_id;
	public $comp_id;
	public $workpackage_id;
	public $linkedworkpackage_id;
	public $title;
	public $description;
	public $type;
	public $status;
	public $priority;
	public $creation_time;
	public $lastupdated_time;
	public $lastupdated_user;
	public $deadline;
	public $s_id;
}
?>