<?php
include_once ("../common/Objects.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/StatsDBUtil.php");

if(!isset($_SESSION)) session_start();

$image_width = 650;
$image_height = 300;
$border = 30;
$bar_num = 8;
$content_width = $image_width - 2*$border;
$content_height = $image_height - 2*$border;
$bar_width = $content_width/$bar_num - $border;

$image = imagecreate($image_width, $image_height);
$background = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 220, 220, 220);
$total = 0;

if( SecurityUtil::canUpdateProjectInfo() &&
	isset($_GET['e']) && CommonUtil::validateDateFormat($_GET['e']) && 
	isset($_GET['d']) && is_numeric($_GET['d']) && $_GET['d']>0 )
{
	$last_create_y = null;
	$last_close_y = null;
	$last_x = null;
	$total_create = null;
	$total_close = null;
	$total = null;

	$end_time = strtotime($_GET['e']);
	$end_date = getdate($end_time);

	$wi_num = array();

	for($ii=0; $ii<$bar_num; $ii++)
	{
		$delta = $ii*$_GET['d'];
	    $end = mktime( 12, 0, 0, $end_date['mon'], $end_date['mday']-$delta, $end_date['year'] );
	    $start = mktime( 12, 0, 0, $end_date['mon'], $end_date['mday']-$delta-$_GET['d']+1, $end_date['year'] );

	    $new_end = date("Y-m-d", $end);
	    $new_start = date("Y-m-d", $start);
	    if($ii == $bar_num-1) $start_date = $new_start;

	    $wi_num[$ii] = StatsDBUtil::countWorkitemClosedInTime($_SESSION['_project']->id, $new_start, $new_end);
	    if( $total<$wi_num[$ii] ) $total = $wi_num[$ii];
	}

	foreach( $wi_num as $key=>$value )
	{
		$height = ($total!=0 ? ceil($content_height*$value/$total) : 0);
		if($height == 0) $height = 1;

		$img = imagecreate($bar_width, $height);
		
		$background = imagecolorallocate($img, 200, 200, 200);

		$x = $content_width + 3*$border/2 - ($key+1)*($bar_width+$border);
		$y = $border + $content_height - $height;
		imagecopyresampled($image, $img, $x, $y, 0,0, $bar_width, $height, $bar_width, $height);
		imagestring( $image, 3, $x+$bar_width/2-3, $y-12, $value, $black);
	}

	imageline ( $image, $border, $border+$content_height, $border+$content_width, $border+$content_height , $black );
	imageline ( $image, $border, $border, $border, $border+$content_height , $black );
	
	imageline ( $image, $border, $border, $border-4, $border+8, $black );
	imageline ( $image, $border, $border, $border+4, $border+8, $black );
	imageline ( $image, $border+$content_width, $border+$content_height, $border+$content_width-8, $border+$content_height+4, $black );
	imageline ( $image, $border+$content_width, $border+$content_height, $border+$content_width-8, $border+$content_height-4, $black );

	imagestring ( $image, 5, $border-3, $border/2-5, "n", $black);
	imagestring ( $image, 5, $image_width-$border+8, $image_height-$border-8, "t", $black);

	imagestring ( $image, 2, 6, $image_height-$border-10, "0", $black);
	imagestring ( $image, 2, 6, $border, $total, $black);
	imagestring ( $image, 2, 0, $image_height-$border/2-5, $start_date, $black);
	imagestring ( $image, 2, $image_width-2*$border, $image_height-$border/2-5, $_GET['e'], $black);
}

header('Content-type: image/png') ;
imagepng($image);
imagedestroy($image);
?>