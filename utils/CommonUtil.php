<?php
class CommonUtil
{
	private static $LANGUAGES = array('zh', 'en');

	public static function genRandomString($length)
	{
	    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $string = "";

	   	$size = strlen($characters) - 1;
	    for ($p = 0; $p < $length; $p++)
	    {
	        $string = $string . $characters[mt_rand(0, $size)];
	    }

	    return $string;
	}

	public static function genRandomNumString($length)
	{
	    $characters = "0123456789";
	    $string = "";

	   	$size = strlen($characters) - 1;
	    for ($p = 0; $p < $length; $p++)
	    {
	        $string = $string . $characters[mt_rand(0, $size)];
	    }

	    return $string;
	}

	public static function genRandomCharString($length)
	{
	    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $string = "";

	   	$size = strlen($characters) - 1;
	    for ($p = 0; $p < $length; $p++)
	    {
	        $string = $string . $characters[mt_rand(0, $size)];
	    }

	    return $string;
	}

	public static function validateEmailFormat($emailAddr)
	{
		$atReturn = preg_match ("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.([a-z]{2,3}))$/", $emailAddr, $matches);

		if ($atReturn) return $atReturn==1;
		else return false;
	}

	public static function validateDateFormat($date)
	{
		$atReturn = preg_match ("/^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/", $date);

		if ($atReturn) return $atReturn==1;
		else return false;
	}

	public static function truncate($input, $size)
	{
		$act = strlen($input);
		if(strlen($input)>$size)
		{
			$proj_text = substr($input, 0, $size - 1);
			$proj_text .= " ...";
		}
		else
		{
			$proj_text = $input;
		}
	
		return $proj_text;
	}

	public static function getTable( $elems, 
									 $sortCol, 
									 $tableListTitle, 
									 $preTableSec, 
									 $table_showhide_link_id, 
									 $table_showhide_div_id,
									 $empty_display,
									 $table_id,
									 $table_class,
									 $dateColumn=null
									)
	{
		$firstLine = true;

		$atReturn = "<link rel='stylesheet' href='../css/table.css' type='text/css' media='print, projection, screen' />
			<link rel='stylesheet' href='../css/calendar.css' />
			<script type='text/javascript' src='../js/jquery.js'></script>
			<script type='text/javascript' src='../js/common.js'></script>
			<script type='text/javascript' src='../js/jquery-ext.js'></script>
			<script type='text/javascript' src='../js/tablefilter.js'></script>
			<script type='text/javascript' src='../js/calendar_us.js'></script>
		";

		$atReturn .= "<div class=\"list_title_label\">";
		$atReturn .= $tableListTitle;
		if(isset($table_showhide_link_id))
			$atReturn .= "<a class=\"show_hide_table_link\" href=\"javascript:showHideDiv('$table_showhide_link_id', '$table_showhide_div_id')\"><img id='$table_showhide_link_id' class='double_arrow' src='../image/common/double_arrow_up.png'></img></a>";
		$atReturn .= "</div><div id='$table_showhide_div_id' class='".$table_class."'>";

		$atReturn .= (isset($preTableSec) ? $preTableSec : "");

		$size = count($elems);

		if ($size == 1)
			$atReturn .= '<label class="empty_result">'.$empty_display.'</label>';
		 
		$atReturn .= "<table id='".$table_id."' cellspacing='1' class='tablesorter'>";
	
		foreach($elems as $elem)
		{
			if($firstLine)
			{
				$firstLine = false;
	
				$line = "<tr>";
				foreach($elem as $value)
				{
					$line .= '<th>' . $value . '</th>';
				}
				$line .= "</tr>";
	
				$atReturn .= "<thead>" . $line . "</thead>";
				$atReturn .= "<tbody>";
			}
			else {
				$atReturn .= "<tr>";
				foreach($elem as $ii=>$value)
				{
					$atReturn .= '<td'.($dateColumn!=null ? ' style="width:'.$dateColumn[$ii].'%;"':'').'>' . $value . '</td>';
				}
				$atReturn .= "</tr>";
			}
		}
		$atReturn .="</tbody></table></div>".$sortCol;

		return $atReturn;
	}

	public static function getProjUserList()
	{
		$atReturn = array();

		if(isset($_SESSION['_project']))
		{
			$users = DatabaseUtil::getUserListByProj($_SESSION['_project']->id);
			$name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['lastname'] ." ". $user['firstname'];
			$ind = 0;
			while ($row = mysql_fetch_array($users, MYSQL_ASSOC))
			{
				$user = DatabaseUtil::getUser($row['u_id']);
				$atReturn[$ind] = ",'".$name." (". $user['login_email'] .")'";
				$ind++;
			}
		}

		return $atReturn;
	}

	public static function getProjUsers($pid)
	{
		$atReturn = array();

		$users = DatabaseUtil::getUserListByProj($pid);

		while ($row = mysql_fetch_array($users, MYSQL_ASSOC))
		{
			$user = DatabaseUtil::getUser($row['u_id']);
			$name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['lastname'] ." ". $user['firstname'];
			$atReturn[$row['u_id']] = $name." (". $user['login_email'] .")";
		}

		return $atReturn;
	}

	public static function getProjLeads($pid)
	{
		$atReturn = array();

		$users = DatabaseUtil::getUserListByProj($pid);

		while ($row = mysql_fetch_array($users, MYSQL_ASSOC))
		{
			$user = DatabaseUtil::getUser($row['u_id']);
			$name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['lastname'] ." ". $user['firstname'];
			if($row['role']!="MEMB") $atReturn[$row['u_id']] = $name." (". $user['login_email'] .")";
		}

		return $atReturn;
	}

	public static function html_entity_decode_utf8($string)
	{
	    static $trans_tbl;
	
	    // replace numeric entities
	    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'code2utf(hexdec("\\1"))', $string);
	    $string = preg_replace('~&#([0-9]+);~e', 'self::code2utf(\\1)', $string);
	
	    // replace literal entities
	    if (!isset($trans_tbl))
	    {
	        $trans_tbl = array();
	
	        foreach (get_html_translation_table(HTML_ENTITIES) as $val=>$key)
	            $trans_tbl[$key] = utf8_encode($val);
	    }
	
	    return strtr($string, $trans_tbl);
	}

	public static function code2utf($num)
	{
	    if ($num < 128) return chr($num);
	    if ($num < 2048) return chr(($num >> 6) + 192) . chr(($num & 63) + 128);
	    if ($num < 65536) return chr(($num >> 12) + 224) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
	    if ($num < 2097152) return chr(($num >> 18) + 240) . chr((($num >> 12) & 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
	    return '';
	}

	public static function ncr_decode($string, $target_encoding='UTF-8') {
	    return iconv('UTF-8', $target_encoding, self::html_entity_decode_utf8($string));
	}
	
	public static function count_days( $day1, $day2 ) 
	{
	    $time1 = mktime( 12, 0, 0, $day1['mon'], $day1['mday'], $day1['year'] ); 
	    $time2 = mktime( 12, 0, 0, $day2['mon'], $day2['mday'], $day2['year'] ); 
	    return round( abs( $time1 - $time2 ) / 86400 ); 
	}

	public static function isManagement($role)
	{
		return (strcmp($role, "OWNE") == 0 || strcmp($role, "MANA") == 0);
	}

	public static function isSupportLanguage($lang)
	{
		foreach(self::$LANGUAGES as $language)
		{
			if($lang==$language) return true;
		}

		return false;
	}

	public static function setLanguageCookie($lang)
	{
		if( self::isSupportLanguage($lang) ) {
			setcookie ("param3", $lang,  28 * 86400 + time(), "/");
		}
	}

	public static function setSessionLanguage()
	{
		if( !isset($_SESSION) ) session_start();

		if( !isset($_SESSION['_language']) )
		{
			if( isset($_COOKIE['param3']) && self::isSupportLanguage($_COOKIE['param3']) )
			{
				$_SESSION['_language'] = $_COOKIE['param3'];
			}
			else {
				$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	
				foreach(self::$LANGUAGES as $language)
				{
					if(strrpos($lang, $language)) {
						$_SESSION['_language'] = $language;
						return;
					}
				}
	
				$_SESSION['_language'] = 'en';
			}
		}
	}

	public static function getPageLink($total, $div, $link, $current)
	{
		$arReturn = '';
		$pages = ($total-$total%$div)/$div;
		if( $total%$div > 0 ) $pages++;

		if($pages < 10)
		{
			for( $ii=1; $ii<=$pages; $ii++ ) {
				$arReturn .= '<a class="pagelink'.(($ii!=$current) ? '" href="'.$link.$ii.'"' : ' pagelinksel"').'>'.$ii.'</a>';
			}
		}
		else {
			if( $current < 6 ) {
				for( $ii=1; $ii<=6; $ii++ ) {
					$arReturn .= '<a class="pagelink'.(($ii!=$current) ? '" href="'.$link.$ii.'"' : ' pagelinksel"').'>'.$ii.'</a>';
				}
				$arReturn .= '<a class="pagelink" href="'.$link.$pages.'">... '.$pages.'</a><a class="pagelink" href="'.$link.($current+1).'">></a>';
			}
			else if( $current >= 6 && $current <= $pages-5 ) {
				$arReturn .= '<a class="pagelink" href="'.$link.($current-1).'"><</a><a class="pagelink" href="'.$link.'1">1 ...</a>';

				for( $ii=$current-2; $ii<=$current+2; $ii++ ) {
					$arReturn .= '<a class="pagelink'.(($ii!=$current) ? '" href="'.$link.$ii.'"' : ' pagelinksel"').'>'.$ii.'</a>';
				}

				$arReturn .= '<a class="pagelink" href="'.$link.$pages.'">... '.$pages.'</a><a class="pagelink" href="'.$link.($current+1).'">></a>';
			}
			else {
				$arReturn .= '<a class="pagelink" href="'.$link.($current-1).'"><</a><a class="pagelink" href="'.$link.'1">1 ...</a>';
				for( $ii=$pages-5; $ii<=$pages; $ii++ ) {
					$arReturn .= '<a class="pagelink'.(($ii!=$current) ? '" href="'.$link.$ii.'"' : ' pagelinksel"').'>'.$ii.'</a>';
				}
			}
		}

		return $arReturn;
	}
}
?>