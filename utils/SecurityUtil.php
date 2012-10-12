<?php
include_once ("../common/Objects.php");
include_once ("DatabaseUtil.php");
include_once ("CommonUtil.php");
include_once ("SessionUtil.php");

class SecurityUtil
{
    static $cypher = 'blowfish';
    static $mode   = 'ecb';
    static $key    = '1a2s3d4f5g6h';

	public static function isProjectMember($uid, $pid)
	{
		return DatabaseUtil::isProjectMember($uid, $pid);
	}

    public static function encrypt($plaintext)
    {
        $td = mcrypt_module_open(self::$cypher, '', self::$mode, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, self::$key, $iv);
        $crypttext = mcrypt_generic($td, $plaintext);
        mcrypt_generic_deinit($td);
        return $iv.$crypttext;
    }
 
    public static function decrypt($crypttext)
    {
        $plaintext = "";
        $td        = mcrypt_module_open(self::$cypher, '', self::$mode, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
        $iv        = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        if ($iv)
        {
            mcrypt_generic_init($td, self::$key, $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);
    }

    public static function checkLogin($page)
    {
    	if(!isset($_SESSION['_userId']) && !self::cookieLogin())
    	{
    		header( 'Location: ../default/login.php?page=' . str_replace("&", "%%", $page) ) ;
    		exit;
    	}
    	else
    	{
    		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']."_sp3091"))
    		{
    			unset($_SESSION);
				session_destroy();
    			header( 'Location: ../default/login.php?page=' . str_replace("&", "%%", $page) ) ;
    			exit;
    		}
    	}

		if(!isset($_SESSION['_language'])) 
		{
			CommonUtil::setSessionLanguage();
			SessionUtil::initSession();
		}
    }

	public static function doLogin($email, $passwd)
	{
		$atReturn = 0;
		$user = DatabaseUtil::getUserByEmail($email);

		if(isset($user))
		{
			if($user)
			{
				if(strcmp(md5($passwd), $user['login_pass']) == 0)
				{
					$_SESSION['_userId'] = $user['id'];
					$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']."_sp3091");

					$myUser = new User();
					$myUser->id = $user['id'];
					$myUser->firstname = $user['firstname'];
					$myUser->lastname = $user['lastname'];
					$myUser->fullname_cn = $user['fullname_cn'];
					$myUser->login_email = $email;
					$myUser->proj_id = isset($user['proj_id']) ? $user['proj_id'] : 0;

					if( isset($user['pic']) )
					{
						$profileImg = fopen(DatabaseUtil::$picPath.$user['id'], 'w') or $myUser->pic = '../image/default/default_pro_pic.png';
						fwrite($profileImg, $user['pic']);
						fclose($profileImg);
						$myUser->pic = DatabaseUtil::$picPath.$user['id'];
					}
					else {
						$myUser->pic = '../image/default_pro_pic.png';
					}
					$_SESSION['_loginUser'] = $myUser;

					SessionUtil::initSession();

					$atReturn = 0;
				}
				else $atReturn = 3;
			}
			else $atReturn = 2;
		}
		else $atReturn = 1;

		return $atReturn;
	}

	public static function setCookie($email, $passwd)
	{
		setcookie ("param1", self::encrypt($email), 28 * 86400 + time(), "/");
		setcookie ("param2", self::encrypt($passwd), 28 * 86400 + time(), "/");
	}

	public static function unsetCookie()
	{
		setcookie ("param1", null, 0, "/");
		setcookie ("param2", null, 0, "/");
	}

	public static function cookieLogin()
	{
		if(isset($_COOKIE['param1']) && isset($_COOKIE['param2']))
		{
			$email = self::decrypt($_COOKIE['param1']);
			$passwd = self::decrypt($_COOKIE['param2']);

			return (self::doLogin($email, $passwd) == 0);
		}

		return false;
	}

    public static function canUpdateProjectOwner()
    {
    	if(!isset($_SESSION['_project'])) return false;
    	$role = $_SESSION['_role'];
    	return (strcmp($role, "OWNE") == 0);
    }

    public static function canUpdateProjectInfo()
    {
    	if(!isset($_SESSION['_project'])) return false;
    	$role = $_SESSION['_role'];
    	return (strcmp($role, "OWNE") == 0 || strcmp($role, "MANA") == 0);
    }

    public static function canUpdateComponentOwner()
    {
    	if(!isset($_SESSION['_component'])) return false;
   		return self::canUpdateProjectInfo();
    }

    public static function canUpdateComponentInfo()
    {
    	if(!isset($_SESSION['_component'])) return false;
    	else if($_SESSION['_component']->owner == $_SESSION['_userId'])
    		return true;
    	else
    		return self::canUpdateComponentOwner();
    }

    public static function canUpdateWorkpackageOwner()
    {
    	if(!isset($_SESSION['_workpackage'])) return false;
   		else if(isset($_SESSION['_component']))
    		return self::canUpdateComponentInfo();
    	else
    		return self::canUpdateProjectInfo();
    }

    public static function canUpdateWorkpackageInfo()
    {
    	if(!isset($_SESSION['_workpackage'])) return false;
    	else if($_SESSION['_workpackage']->owner_id == $_SESSION['_userId'])
    		return true;
    	else
    		return self::canUpdateWorkpackageOwner();
    }

    public static function canUpdateWorkitem()
    {
    	if(!isset($_SESSION['_workitem'])) return false;
    	else if($_SESSION['_workitem']->owner_id == $_SESSION['_userId'] || 
    			$_SESSION['_workitem']->creator_id == $_SESSION['_userId'] )
    		return true;
    	else if(isset($_SESSION['_workpackage']))
    		return self::canUpdateWorkpackageInfo();
    	else if(isset($_SESSION['_component']))
    		return self::canUpdateComponentInfo();
    	else
    		return self::canUpdateProjectInfo();
    }
}
?>