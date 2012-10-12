<?php
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/MessageUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

include_once ('language/l_upload_file.inc.php');

function getDimention($videoName)
{
	if (file_exists ($videoName))
	{  
		$output = shell_exec("ffmpeg -i $videoName -vstats 2>&1");  
		$result = ereg ( '[0-9]?[0-9][0-9][0-9]x[0-9][0-9][0-9][0-9]?', $output, $regs );  

		if (isset ( $regs [0] ))
		{  
			$vals = (explode ( 'x', $regs [0] ));  
			$width = $vals [0] ? $vals [0] : null;  
			$height = $vals [1] ? $vals [1] : null;  

			return array("w" => $width, "h" => $height);
		}
	}

	return null;
}

$up_id = uniqid();
$fileSize = $_FILES["file"]["size"];
if ($fileSize/1048576 <= 2 && $fileSize > 0)
{
	if( isset($_GET['p1']) && !empty($_GET['p1']) && 
		isset($_GET['p2']) && !empty($_GET['p2']) && 
		isset($_GET['s_id']) && !empty($_GET['s_id']) )
	{
	//	if(!isset($_SESSION)) session_start();
	//	SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);
	//
	//	if(!isset($_SESSION['_project']))
	//	{
	//    	header( 'Location: ../default/login.php' ) ;
	//    	exit;
	//	}

		if(DatabaseUtil::isProjectMember($_GET['p1'], $_GET['p2']))
		{
			$sId = sha1( uniqid() );
			$title = $_FILES["file"]["name"];
			$tmpName = $_FILES["file"]["tmp_name"];

			$fp = fopen($tmpName, 'r');
			$content = fread($fp, filesize($tmpName));
			fclose($fp);

			$version = DatabaseUtil::getDocVersion( isset($_POST['file_name']) ? $_POST['file_name'] : $title,
													$_GET['p2'], 
													(isset($_GET['p3']) && !empty($_GET['p3']) ? $_GET['p3'] : null), 
													(isset($_GET['p4']) && !empty($_GET['p4']) ? $_GET['p4'] : null), 
													(isset($_GET['p5']) && !empty($_GET['p5']) ? $_GET['p5'] : null) 
												   ) + 1;

			if( DatabaseUtil::insertProjDoc( isset($_POST['file_name']) ? $_POST['file_name'] : $title,
										     $_GET['p1'],
										     $content,
										     $fileSize,
										     $_GET['p2'], 
										     (isset($_GET['p3']) && !empty($_GET['p3']) ? $_GET['p3'] : null), 
										     (isset($_GET['p4']) && !empty($_GET['p4']) ? $_GET['p4'] : null), 
										     (isset($_GET['p5']) && !empty($_GET['p5']) ? $_GET['p5'] : null), 
										     $_POST['file_desc'],
										     $version,
										     $sId) )
			{
				if( isset($_GET['p5']) && !empty($_GET['p5']) )
					MessageUtil::sendWorkitemDocumentMessage($_GET['p5']);

	//			if($_GET['folder'] == DatabaseUtil::$DOC_VIDEO)
	//			{
	//				$video_in = $folder.$title;
	//				$video_out = $folder.$sId.".flv";
	//				$image_out = $folder.$sId.".jpg";
	//	
	//				$dim = getDimention($video_in);
	//				$ratio = 400/$dim['w'];
	//				$width = $dim['w']*$ratio;
	//				$height = $dim['h']*$ratio;
	//	
	//	//			echo '<script></script><img src="../image/process_bar.gif" />';
	//	
	//				$output = shell_exec("ffmpeg -i $video_in -y -ar 44100 -s ".$width."x$height $video_out");
	//				shell_exec("ffmpeg -i $video_out -an -ss 3 -t 00:00:01 -vcodec mjpeg -f mjpeg -r 1 -y -s ".$width."x$height $image_out");
	//	
	//				unlink( $folder.$title ); //delete
	//			}
		//		$result = DatabaseUtil::insertProjDoc( $title,
		//											   $_SESSION['_userId'],
		//											   $_SESSION['_project']->id, 
		//											   (isset($_SESSION['_component']) ? $_SESSION['_component']->id : null), 
		//											   (isset($_SESSION['_workpackage']) ? $_SESSION['_workpackage']->id : null), 
		//											   (isset($_SESSION['_workitem']) ? $_SESSION['_workitem']->id : null), 								 
		//											   $sId);

				$_SESSION['docMessage'] = '<div class="update_error_message"><label style="color:green;font-size:.8em;">'.$l_suc_mess.'</label></div>';
			}
			else $_SESSION['docMessage'] = '<div class="update_error_message"><label style="color:red;font-size:.8em;">'.$l_err_mess.'</label></div>';
		}
		else $_SESSION['docMessage'] = '<div class="update_error_message"><label style="color:red;font-size:.8em;">'.$l_err_mess.'</label></div>';
	}
	else $_SESSION['docMessage'] = '<div class="update_error_message"><label style="color:red;font-size:.8em;">'.$l_err_mess.'</label></div>';
}
else if($fileSize == 0) {
	$_SESSION['docMessage'] = '<div class="update_error_message"><label style="color:red;font-size:.8em;">'.$l_err_empty.'</label></div>';
}
else {
	$_SESSION['docMessage'] = '<div class="update_error_message"><label style="color:red;font-size:.8em;">'.$l_err_size.'</label></div>';
}

$location = '';
if(isset($_GET['p5']) && !empty($_GET['p5']))
	$location = '../project/work_item.php?wi_id='.$_GET['p5'].'&sid='.($_GET['s_id']+12373);
else if(isset($_GET['p4']) && !empty($_GET['p4']))
	$location = '../project/work_package.php?wp_id='.$_GET['p4'].'&sid='.($_GET['s_id']+12373);
else if(isset($_GET['p3']) && !empty($_GET['p3']))
	$location = '../project/project_component.php?c_id='.$_GET['p3'].'&sid='.($_GET['s_id']+12373);
else 
	$location = '../project/index.php?p_id='.$_GET['p2'].'&sid='.($_GET['s_id']+12373);

header( 'Location: ' . $location ) ;
?>

