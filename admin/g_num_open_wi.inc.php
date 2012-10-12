<?php
include_once ("../common/Objects.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/StatsDBUtil.php");

if(!isset($_SESSION)) session_start();

$image_width = 480;
$image_height = 300;
$border = 30;
$content_width = $image_width - 2*$border;
$content_height = $image_height - 2*$border;

$image = imagecreate($image_width, $image_height);
$background = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 0, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 220, 220, 220);
$grey = imagecolorallocate($image, 160, 160, 160);
$white = imagecolorallocate($image, 255, 255, 255);
$style = array($gray, $gray, $gray, $gray, $gray, $gray, $gray, $white, $white, $white, $white, $white, $white, $white);

if( SecurityUtil::canUpdateProjectInfo() &&
	isset($_GET['s']) && CommonUtil::validateDateFormat($_GET['s']) && 
	isset($_GET['e']) && CommonUtil::validateDateFormat($_GET['e']) )
{
	$last_close_y = null;
	$last_x = null;
	$total = null;

	$start_time = strtotime($_GET['s']);
	$start_date = getdate($start_time);

	$end_time = strtotime($_GET['e']);
	$end_date = getdate($end_time);

	$days = CommonUtil::count_days($start_date, $end_date);

	imageline( $image, $border, $border+($content_height/2), $border+$content_width, $border+($content_height/2) , $gray );
	imageline( $image, $border, $border+($content_height/4), $border+$content_width, $border+($content_height/4) , $gray );
	imageline( $image, $border, $border+(3*$content_height/4), $border+$content_width, $border+(3*$content_height/4) , $gray );
	imageline( $image, $border, $border, $border+$content_width, $border , $gray );

	for($ii=$days; $ii>=0; $ii--)
	{
	    $end = mktime( 12, 0, 0, $start_date['mon'], $start_date['mday']+($ii==0 ? 1 : $ii), $start_date['year'] );
	    $new_end = date("Y-m-d", $end);

	    $wi_num = StatsDBUtil::countWorkitemAtTime($_SESSION['_project']->id, $new_end);
	    $close = StatsDBUtil::countcloseWorkitemAtTime($_SESSION['_project']->id, $new_end);

	    if($ii==$days) {
	    	$total = $wi_num;
	    	if($total!=0) {
				imagesetstyle($image, $style);
				$final_y = $border+$content_height*$close/$total;
				imageline( $image, $border, $final_y, $border+$content_width, $final_y, IMG_COLOR_STYLED );
				imagestring( $image, 2, 23-((int)log10($wi_num-$close))*6, $final_y-6, $wi_num-$close, $grey);
	    	}
	    }
		else if($ii==0)
		{
	    	if($wi_num-$close>0) {
				imagesetstyle($image, $style);
				$final_y = $border+$content_height*($total-$wi_num+$close)/$total;
				imagestring( $image, 2, 23-((int)log10($wi_num-$close))*6, $final_y-6, $wi_num-$close, $grey);
	    	}
		}

//================================================================================================================
		$x = $border + (($days!=0) ? $ii*$content_width/$days : $content_width);
		$close_y = $border + ($total!=0 ? (($wi_num-$close)*$content_height)/($total) : 1);
		$close_y = $image_height - $close_y;
//================================================================================================================

	    if($ii==$days) {
	    	$last_close_y = $close_y;
	    	$last_x = $x;
	    }

//================================================================================================================
	    imageline ( $image, $x, $close_y, $last_x, $last_close_y , $blue );
//================================================================================================================

	    if($ii!=$days) {
	    	$last_close_y = $close_y;
	    	$last_x = $x;
	    }
	}

	imageline ( $image, $border, $border+$content_height, $border+$content_width, $border+$content_height , $black );
	imageline ( $image, $border, $border, $border, $border+$content_height , $black );
	
	imageline ( $image, $border, $border, $border-4, $border+8, $black );
	imageline ( $image, $border, $border, $border+4, $border+8, $black );
	imageline ( $image, $border+$content_width, $border+$content_height, $border+$content_width-8, $border+$content_height+4, $black );
	imageline ( $image, $border+$content_width, $border+$content_height, $border+$content_width-8, $border+$content_height-4, $black );

	imagestring ( $image, 5, $border-3, $border/2, "n", $black);
	imagestring ( $image, 5, $image_width-$border+3, $image_height-$border-8, "t", $black);

	imagestring ( $image, 2, 6, $image_height-$border-10, "0", $black);
	imagestring ( $image, 2, 6, $border, $total, $black);
	imagestring ( $image, 2, 0, $image_height-$border/2-5, $_GET['s'], $black);
	imagestring ( $image, 2, $image_width-2*$border, $image_height-$border/2-5, $_GET['e'], $black);
}

header('Content-type: image/png') ;
imagepng($image);
imagedestroy($image);
?>