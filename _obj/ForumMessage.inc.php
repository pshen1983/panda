<?php
include_once ("../utils/DatabaseUtil.php");

class ForumMessage
{
	private $id;

	public $sid;
	public $tid;
	public $reply;
	public $body;

	private $creator;
	private $ctime;

	public static function addMessage($sid, $tid, $reply, $body)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "INSERT INTO FORUM_MESSAGE (SID, TID, REPLY, BODY, CREATOR, CTIME)
				 VALUES ($sid, $tid, ".DatabaseUtil::checkNull($reply).", ".DatabaseUtil::checkNull($body).", ".$_SESSION['_userId'].", NOW())";
		return DatabaseUtil::insertData($db_connection, $query);
	}

	public static function getThreadMessages($tid, $start, $size)
	{
		$atReturn = array();
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT id, sid, reply, body, creator, ctime FROM FORUM_MESSAGE WHERE TID=$tid ORDER BY CTIME LIMIT $start, $size";
		$messages = DatabaseUtil::selectDataList($db_connection, $query);

		if(isset($messages) && $messages)
		{
			while($message = mysql_fetch_array($messages, MYSQL_ASSOC))
			{
				$m = new ForumMessage();
				$m->id = $message['id'];
				$m->sid = $message['sid'];
				$m->tid = $tid;
				$m->reply = $message['reply'];
				$m->body = $message['body'];
				$m->creator = $message['creator'];
				$m->ctime = $message['ctime'];
				$atReturn[$message['id']] = $m;
			}
		}

		return $atReturn;
	}

	public static function getSectionMessageCount($sid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT COUNT(*) as count FROM FORUM_MESSAGE WHERE SID=$sid";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

	public static function getThreadMessageCount($tid)
	{
		$db_connection = DatabaseUtil::getConn(DatabaseUtil::$FBBS);
		$query = "SELECT COUNT(*) as count FROM FORUM_MESSAGE WHERE TID=$tid";
		$result = DatabaseUtil::selectData($db_connection, $query);
		return $result['count'];
	}

//========================================================== Static / Non-Static ========================================================

	public function getId()
	{
		return $this->id;
	}

	public function getCreator()
	{
		return $this->creator;
	}

	public function getCtime()
	{
		return $this->ctime;
	}
}