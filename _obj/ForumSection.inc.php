<?php
include_once ("../utils/DatabaseUtil.php");

class ForumSection
{
	private $id;
	private $sid;

	public $title;
	public $language;
	public $description;

	public static function getSectionBySid($id)
	{
		$atReturn = null;
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT sid, title, description FROM FORUM_SECTION WHERE SID=$id AND LANGUAGE='".$_SESSION['_language']."'";
		$section = DatabaseUtil::selectData($db_connection, $query);

		if(isset($section) && $section)
		{
			$atReturn = new ForumSection();
			$atReturn->id = $id;
			$atReturn->sid = $section['sid'];
			$atReturn->language = $_SESSION['_language'];
			$atReturn->title = $section['title'];
			$atReturn->description = $section['description'];
		}

		return $atReturn;
	}

	public static function getSections()
	{
		$atReturn = array();
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT id, sid, title, description FROM FORUM_SECTION WHERE LANGUAGE='".$_SESSION['_language']."'";
		$sections = DatabaseUtil::selectDataList($db_connection, $query);

		if(isset($sections) && $sections)
		{
			while($section = mysql_fetch_array($sections, MYSQL_ASSOC))
			{
				$s = new ForumSection();
				$s->id = $section['id'];
				$s->sid = $section['sid'];
				$s->language = $_SESSION['_language'];
				$s->title = $section['title'];
				$s->description = $section['description'];
				$atReturn[$section['id']] = $s;
			}
		}

		return $atReturn;
	}

	public static function getSectionName($sid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT title FROM FORUM_SECTION WHERE LANGUAGE='".$_SESSION['_language']."' AND SID=$sid";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['title'];
	}

//========================================================== Static / Non-Static ========================================================

	public function getId()
	{
		return $this->id;
	}

	public function getSid()
	{
		return $this->sid;
	}
}