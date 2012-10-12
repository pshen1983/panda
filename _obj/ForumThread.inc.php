<?php
include_once ("../utils/DatabaseUtil.php");

class ForumThread
{
	private $id;

	public $sid;
	public $title;
	public $creator;
	public $vcount;
	public $ctime;
	public $top;
	public $lrep;
	public $ltime;

	public static function addThread($sid, $title)
	{
		$top = ($_SESSION['_userId']==1) ? "Y" : "N";
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "INSERT INTO FORUM_THREAD (SID, TITLE, CREATOR, VCOUNT, CTIME, TOP, LREP, LTIME)
				 VALUES ($sid, '$title', ".$_SESSION['_userId'].", 0, NOW(), '$top', ".$_SESSION['_userId'].", NOW())";
		return DatabaseUtil::insertData($db_connection, $query) ? mysql_insert_id($db_connection) : -1;
	}

	public static function getThread($tid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT sid, title, creator, ctime, top, vcount, lrep, ltime FROM FORUM_THREAD WHERE ID=$tid";
		$thread = DatabaseUtil::selectData($db_connection, $query);

		$t = null;
		if(isset($thread) && $thread)
		{
			$t = new ForumThread();
			$t->id = $tid;
			$t->sid = $thread['sid'];
			$t->title = $thread['title'];
			$t->creator = $thread['creator'];
			$t->ctime = $thread['ctime'];
			$t->top = $thread['top'];
			$t->vcount = $thread['vcount'];
			$t->lrep = $thread['lrep'];
			$t->ltime = $thread['ltime'];
		}

		return $t;
	}

	public static function getSectionThreads($sid, $start, $size)
	{
		$atReturn = array();
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT id, title, creator, ctime, top, vcount, lrep, ltime FROM FORUM_THREAD WHERE SID=$sid ORDER BY TOP DESC, LTIME DESC LIMIT $start, $size";
		$threads = DatabaseUtil::selectDataList($db_connection, $query);

		if(isset($threads) && $threads)
		{
			while($thread = mysql_fetch_array($threads, MYSQL_ASSOC))
			{
				$t = new ForumThread();
				$t->id = $thread['id'];
				$t->sid = $sid;
				$t->title = $thread['title'];
				$t->creator = $thread['creator'];
				$t->ctime = $thread['ctime'];
				$t->top = $thread['top'];
				$t->vcount = $thread['vcount'];
				$t->lrep = $thread['lrep'];
				$t->ltime = $thread['ltime'];
				$atReturn[$thread['id']] = $t;
			}
		}

		return $atReturn;
	}

	public static function getSectionThreadCount($sid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT COUNT(*) as count FROM FORUM_THREAD WHERE SID=$sid";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function getSectionLastThread($sid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT id, title, creator, ctime, top, vcount, lrep, ltime FROM FORUM_THREAD WHERE SID=$sid ORDER BY CTIME DESC LIMIT 1";
		$thread = DatabaseUtil::selectData($db_connection, $query);

		$t = null;
		if( isset($thread) && $thread )
		{
			$t = new ForumThread();
			$t->id = $thread['id'];
			$t->sid = $sid;
			$t->title = $thread['title'];
			$t->creator = $thread['creator'];
			$t->ctime = $thread['ctime'];
			$t->top = $thread['top'];
			$t->vcount = $thread['vcount'];
			$t->lrep = $thread['lrep'];
			$t->ltime = $thread['ltime'];
		}

		return $t;
	}

	public static function viewThread($tid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "UPDATE FORUM_THREAD SET VCOUNT=VCOUNT+1 WHERE ID=$tid;";
		return DatabaseUtil::updateData($db_connection, $query);
	}

	public static function deleteThread($tid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "DELETE FROM FORUM_THREAD WHERE ID=$tid";
		$result = DatabaseUtil::deleteData($db_connection, $query);
	}

	public static function threadExist($tid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT id FROM FORUM_THREAD WHERE ID=$tid";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['id'];
	}

//========================================================== Static / Non-Static ========================================================

	public function updateLastReply()
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "UPDATE FORUM_THREAD SET LREP='".$this->lrep."', LTIME=NOW() WHERE ID=".$this->id;
		return DatabaseUtil::updateData($db_connection, $query);
	}

	public function getId()
	{
		return $this->id;
	}
}