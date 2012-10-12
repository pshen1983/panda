<?php
include_once ("../utils/DatabaseUtil.php");

class MessageUtil
{
	private static $HEAD = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: ProjNote<projnote@yahoo.com>\r\nReturn-path: ProjNote<projnote@yahoo.com>\r\n";

	private static function msg($msg)
	{
		return nl2br('<html><body><p>'.$msg.'</p><br />_______________________________________<br /><br />ProjNote - http://www.projnote.com/<br /><br />您永远的项目计划，任务和缺陷管理的职能助理 / A free assistant for your project plan, task and defect management<br /><br /><p><img src="http://www.projnote.com/image/logo.png" /></p></body></html>');
	}

	public static function sendPassword($to, $passwd)
	{
if($_SESSION['_language'] == 'en') {
	$subject = 'ProjNote - Registration Successful';
	$message = 'Hi '.$_SESSION['_loginUser']->firstname.',<br /><br />Thank you for using ProjNote ( http://www.projnote.com/ ) to assist your project work. Your registration password:'.$passwd.'';
}
else if($_SESSION['_language'] == 'zh') {
	$subject = 'ProjNote — 注册成功';
	$message = '您好，<br /><br />感谢您选测 ProjNote ( http://www.projnote.com/ ) 作为您的项目、任务助理。您的注册密码是：'.$passwd.'，请妥善保管。<br /><br />ProjNote 是一个免费的以项目为基础的个人任务管理平台，提供项目细化，团队协作，文档共享和项目统计等功能。<br /><br />ProjNote 帮助您细化项目，将项目划分成有机的组成部分或时间阶段。项目成员可以相互指派、分享、关注工作（任务、设计、提醒、缺陷等）可以相互分享文档。项目的创建者还可以通过项目管理功能查看单位时间内项目工作项的统计，以及分析。 ProjNote 还支持单用户多项目管理功能。<br /><br />无论您有什么想法，意见和建议，请告诉我们，帮助我们完善产品，优化服务，让我们共同进步。<br /><br />我们相信品质与科技相结合的服务能够简化我们的工作，方便我们的生活。';
}
		date_default_timezone_set('Asia/Shanghai');
		$mail_sent = mail( $to, $subject, self::msg($message), self::$HEAD );
	}


	public static function retrievePassword($to, $passwd)
	{
if($_SESSION['_language'] == 'en') {
	$subject = 'ProjNote - Retrieve password';
	$message = "Thank you for using ProjNote ( http://www.projnote.com/ ) to assist your project work<br /><br />
				Here is your temporary password:" . $passwd;
}
else if($_SESSION['_language'] == 'zh') {
	$subject = 'ProjNote — 找回密码 ';
	$message = "感谢您选测 ProjNote（ http://www.projnote.com/ ）协助您的项目，您的临时密码是：".$passwd;
}
		date_default_timezone_set('Asia/Shanghai');
		$headers = "From: ProjNote <projnote@yahoo.com>\r\nReply-To: projnote@yahoo.com";

		$mail_sent = mail( $to, $subject, $message, $headers );
	}


	public static function sendInvitation($from, $to)
	{
if($_SESSION['_language'] == 'en') {
	$subject = 'ProjNote - Your friend invites you to join';
	$message = "Dear Mr./Ms.,<br /><br />Your friend invites you to ProjNote ( http://www.projnote.com/default/register.php ).<br />ProjNote is a free projects collabration site. Find a easy way for project team communication.";
}
else if($_SESSION['_language'] == 'zh') {
	$subject = 'ProjNote - 您的朋友邀请您注册 ';
	$message = '您好，<br /><br />您的朋友 '.$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname.' 邀请您加入 <a href="http://www.projnote.com/">ProjNote</a>，<a href="http://www.projnote.com/default/register.php">马上加入</a>。<br /><br />ProjNote 是一个免费的以项目为基础的个人任务管理平台，提供项目细化，团队协作，文档共享和项目统计等功能。<br /><br />ProjNote 帮助您细化项目，将项目划分成有机的组成部分或时间阶段。项目成员可以相互指派、分享、关注工作（任务、设计、提醒、缺陷等）可以相互分享文档。项目的创建者还可以通过项目管理功能查看单位时间内项目工作项的统计，以及分析。 ProjNote 还支持单用户多项目管理功能。<br /><br /><span style="color:#CF4040;">我们相信品质与科技相结合的服务能够简化我们的工作，方便我们的生活。</span>';
}
		date_default_timezone_set('Asia/Shanghai');
		$mail_sent = mail( $to, $subject, self::msg($message), self::$HEAD );
	}


	public static function sendSubscriptionMessage($wiid, $isNew)
	{
		$subs = DatabaseUtil::getSubscribers($wiid);
		$wi = DatabaseUtil::getWorkItem($wiid);
		$wili = '<a href="../project/work_item.php?wi_id='.$wiid.'&sid='.$wi['s_id'].'">'.$wi['title'].'</a>';

if($_SESSION['_language'] == 'en') {
	$subject = 'Workitem Subscription';
	$post_text = $isNew ? ' has been created and you are subscribed to it.' : ' has been updated. <br />To not get such messags, please "Unfollow this Workitem" on the Workitem page.';
	$message = 'Workitem - '.$wili.$post_text;
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '工作项关注信息';
	$post_text = $isNew ? ' 刚刚新建，您被为选为关注者。' : ' 刚刚更新。<br />点击此工作项页右侧 “不再关注此工作项” 链接 不再收到此类信息。';
	$message = '工作项  — '.$wili.$post_text;
}
		while($sub = mysql_fetch_array($subs, MYSQL_ASSOC))
		{
			if( $sub['user_id'] != $_SESSION['_userId'] )
				DatabaseUtil::insertMessage($subject, $sub['user_id'], $_SESSION['_userId'], $message);
		}
	}


	public static function sendNewWorkitemMessage($wiid)
	{
include ("../utils/configuration.inc.php");
		$wi = DatabaseUtil::getWorkItem($wiid);
		$wili = '<a href="'.$HTTP_BASE.'/project/work_item.php?wi_id='.$wiid.'&sid='.$wi['s_id'].'">'.$wi['title'].'</a>';

if($_SESSION['_language'] == 'en') {
	$subject = 'You have a new Workitem';
	$message = "Workitem - ".$wili." has been created for you.";
	$email_s = "ProjNote - You have a new Workitem";
	$email_m = 'Hi,<br /><br />A new ProjNote workitem ( '.$wili.' ) has just been created for you.';
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '您有一个新的工作项';
	$message = '您有一个新的工作项：'.$wili;
	$email_s = 'ProjNote — 您有一个新的工作项';
	$email_m = '您好，<br /><br />您有一个新的 ProjNote 工作项（ '.$wili.' ）刚刚新建。';
}
		DatabaseUtil::insertMessage($subject, $wi['owner_id'], $_SESSION['_userId'], $message);

		date_default_timezone_set('Asia/Shanghai');;

		$to = DatabaseUtil::getUserEmail($wi['owner_id']);
		$mail_sent = mail( $to, $email_s, self::msg($email_m), self::$HEAD );
	}


	public static function sendWorkitemStatusChangeMessage($wiid, $statOld)
	{
		$wi = DatabaseUtil::getWorkItem($wiid);
		$wili = '<a href="../project/work_item.php?wi_id='.$wiid.'&sid='.$wi['s_id'].'">'.$wi['title'].'</a>';
		$f = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_STATUS, $statOld);
		$t = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_STATUS, $wi['status']);

if($_SESSION['_language'] == 'en') {
	$subject = 'Status change of a Workitem.';
	$message = "Workitem - ".$wili." created by you has status change from  <b>$f</b> to  <b>$t</b>.";
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '工作项状态变更';
	$message = "您建立的工作项：".$wili." 状态从 <b>$f</b> 更新到 <b>$t</b>。";
}
		DatabaseUtil::insertMessage($subject, $wi['creator_id'], $_SESSION['_userId'], $message);
	}


	public static function sendWorkitemCommentMessage($wiid)
	{
include ("../utils/configuration.inc.php");
		$wi = DatabaseUtil::getWorkItem($wiid);
		$wili = '<a href="'.$HTTP_BASE.'/project/work_item.php?wi_id='.$wiid.'&sid='.$wi['s_id'].'">'.$wi['title'].'</a>';

		if( $wi['owner_id']!=$_SESSION['_userId'] )
		{
if($_SESSION['_language'] == 'en') {
	$subject = 'A new comment has been added to your workitem';
	$message = "Workitem - ".$wili." has a new comment from ".$_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname;
	$email_s = "ProjNote - A new comment has been added to your workitem";
	$email_m = 'Hi,<br /><br />'.$_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname.' has left a new comment to your ProjNote workitem: '.$wili;
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '您的工作项有新留言';
	$message = "您的工作项：".$wili."有一条新留言来自 ".$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname."。";
	$email_s = "ProjNote — 您的工作项有新留言";
	$email_m = '您好，<br /><br />您在 ProjNote 的工作项：'.$wili.' 有一个新 留言 来自用户 - '.$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname.'。';
}
			DatabaseUtil::insertMessage($subject, $wi['owner_id'], $_SESSION['_userId'], $message);

			date_default_timezone_set('Asia/Shanghai');
			$to = DatabaseUtil::getUserEmail($wi['owner_id']);

			$mail_sent = mail( $to, $email_s, self::msg($email_m), self::$HEAD );
		}

		$subs = DatabaseUtil::getSubscribers($wiid);

if($_SESSION['_language'] == 'en') {
	$s_subject = 'A comment has been added to your SUBSCRIPBED workitem';
	$s_message = "Your subscribed Workitem - ".$wili." has a new comment from ".$_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname;
}
else if($_SESSION['_language'] == 'zh') {
	$s_subject = '您 关注 的工作项有新留言';
	$s_message = "您 关注 的工作项：".$wili." 有一条新 留言 来自 - ".$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname."。<br />点击此工作项页右侧 “不再关注此工作项” 链接 不再收到此类信息。";
}
		while($sub = mysql_fetch_array($subs, MYSQL_ASSOC)) {
			if( $sub['user_id'] != $_SESSION['_userId'] )
				DatabaseUtil::insertMessage($s_subject, $sub['user_id'], $_SESSION['_userId'], $s_message);
		}
	}


	public static function sendWorkitemDocumentMessage($wiid)
	{
include ("../utils/configuration.inc.php");
		$wi = DatabaseUtil::getWorkItem($wiid);
		$wili = '<a href="'.$HTTP_BASE.'/project/work_item.php?wi_id='.$wiid.'&sid='.$wi['s_id'].'">'.$wi['title'].'</a>';

		if( $wi['owner_id']!=$_SESSION['_userId'] )
		{
if($_SESSION['_language'] == 'en') {
	$subject = 'A document has been added to your workitem';
	$message = "Your Workitem - ".$wili." has a newly added document from ".$_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname;
	$email_s = "ProjNote - A document has been added to your workitem";
	$email_m = 'Hi,<br /><br />'.$_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname.' has left a comment to your ProjNote workitem: '.$wili;
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '您的工作项有新附加文件';
	$message = '您的工作项：'.$wili.' 有一个新 附加文档 来自用户 - '.$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname.'。';
	$email_s = "ProjNote — 您的工作项有新附加文件";
	$email_m = '您好，<br /><br />您在 ProjNote 的工作项：'.$wili.' 有一个新 附加文档 来自用户 - '.$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname.'。';
}
			DatabaseUtil::insertMessage($subject, $wi['owner_id'], $_SESSION['_userId'], $message);

			date_default_timezone_set('Asia/Shanghai');
			$to = DatabaseUtil::getUserEmail($wi['owner_id']);

			$mail_sent = mail( $to, $email_s, self::msg($email_m), self::$HEAD );
		}

		$subs = DatabaseUtil::getSubscribers($wiid);

if($_SESSION['_language'] == 'en') {
	$s_subject = 'A document has been added to your SUBSCRIBED workitem';
	$s_message = "Your subscribed Workitem - ".$wili." has a newly added document from ".$_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname;
}
else if($_SESSION['_language'] == 'zh') {
	$s_subject = '您 关注 的工作项有新附加文件';
	$s_message = "您 关注 的工作项：".$wili." 有一个新附加文件来自 - ".$_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname."。<br />点击此工作项页右侧 “不再关注此工作项” 链接 不再收到此类信息。";
}
		while($sub = mysql_fetch_array($subs, MYSQL_ASSOC)) {
			if( $sub['user_id'] != $_SESSION['_userId'] )
				DatabaseUtil::insertMessage($s_subject, $sub['user_id'], $_SESSION['_userId'], $s_message);
		}
	}


	public static function sendNewProjectMessage($pid)
	{
		$proj = DatabaseUtil::getProjectTitle($pid);
		$plink = '<a href="../project/index.php?p_id='.$pid.'&sid='.$proj['s_id'].'">'.$proj['title'].'</a>';

if($_SESSION['_language'] == 'en') {
	$subject = 'Invite friends to your new Project';
	$message = 'You have created Project - '.$plink.'. Do you want to <a href="../message/invite_project.php">invite your friend</a> now? <br>You can also invite your frient through the left navigation link <a href="../message/invitation.php">Project Invitation</a> on the Home Page.';
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '邀请朋友加入您的新项目';
	$message = '您刚刚创建了新项目 — '.$plink.'。马上 <a href="../message/invite_project.php">邀请朋友</a> 加入。<br>您也可以稍后通过主页左侧链接 <a href="../message/invitation.php">项目邀请</a> 邀请朋友加入。';
}
		DatabaseUtil::insertMessage($subject, $_SESSION['_userId'], 1, $message);
	}


	public static function sendQuitProjectMessage($pid, $uid)
	{
		$proj = DatabaseUtil::getProjectTitle($pid);
		$plink = '<a href="../project/index.php?p_id='.$pid.'&sid='.$proj['s_id'].'">'.$proj['title'].'</a>';

if($_SESSION['_language'] == 'en') {
	$subject = 'A project member has quit your project';
	$message = $_SESSION['_loginUser']->firstname.' '.$_SESSION['_loginUser']->lastname.' has just quit your Project - '.$plink.'. All his/her owned and followed workitem are transferred to you.';
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '您的项目有成员退出';
	$message = $_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname.'刚刚离开了您的项目 — '.$plink.'。他负责和关注的工作项都已转给了您。';
}
		DatabaseUtil::insertMessage($subject, $uid, $_SESSION['_userId'], $message);
	}


	public static function sendRemoveProjectMessage($pid, $uid)
	{
		$proj = DatabaseUtil::getProjectTitle($pid);
		$plink = $proj['title'];

if($_SESSION['_language'] == 'en') {
	$subject = 'You are removed from a project';
	$message = $_SESSION['_loginUser']->firstname.' '.$_SESSION['_loginUser']->lastname.' has removed you from Project - '.$plink.'.';
}
else if($_SESSION['_language'] == 'zh') {
	$subject = '您被从一个项目中退出';
	$message = $_SESSION['_loginUser']->lastname.$_SESSION['_loginUser']->firstname.'将您从项目 — '.$plink.' 中退出。';
}
		DatabaseUtil::insertMessage($subject, $uid, $_SESSION['_userId'], $message);
	}
}
?>