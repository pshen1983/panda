<?php
include_once ("../common/Objects.php");
session_start();

include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_wp_due = 'Workpackage due';
	$l_wi_due = 'Workitem due';

	$l_today = 'Today';
	$l_w_0 = 'Sun';
	$l_w_1 = 'Mon';
	$l_w_2 = 'Tue';
	$l_w_3 = 'Wed';
	$l_w_4 = 'Thu';
	$l_w_5 = 'Fri';
	$l_w_6 = 'Sat';

	$l_m = array();
	$l_m[1] = 'January';
	$l_m[2] = 'February';
	$l_m[3] = 'March';
	$l_m[4] = 'April';
	$l_m[5] = 'May';
	$l_m[6] = 'June';
	$l_m[7] = 'July';
	$l_m[8] = 'August';
	$l_m[9] = 'September';
	$l_m[10] = 'October';
	$l_m[11] = 'November';
	$l_m[12] = 'December';
	
	$l_year = '';
}
else if($_SESSION['_language'] == 'zh') {
	$l_wp_due = '&#25130;&#27490;&#24037;&#20316;&#21253;';
	$l_wi_due = '&#25130;&#27490;&#24037;&#20316;&#39033;';

	$l_today = '&#20170;&#22825;';
	$l_w_0 = '&#21608;&#26085;';
	$l_w_1 = '&#21608;&#19968;';
	$l_w_2 = '&#21608;&#20108;';
	$l_w_3 = '&#21608;&#19977;';
	$l_w_4 = '&#21608;&#22235;';
	$l_w_5 = '&#21608;&#20116;';
	$l_w_6 = '&#21608;&#20845;';

	$l_m = array();
	$l_m[1] = '1&#26376;';
	$l_m[2] = '2&#26376;';
	$l_m[3] = '3&#26376;';
	$l_m[4] = '4&#26376;';
	$l_m[5] = '5&#26376;';
	$l_m[6] = '6&#26376;';
	$l_m[7] = '7&#26376;';
	$l_m[8] = '8&#26376;';
	$l_m[9] = '9&#26376;';
	$l_m[10] = '10&#26376;';
	$l_m[11] = '11&#26376;';
	$l_m[12] = '12&#26376;';

	$l_year = '&#24180;';
}

//=========================================================================================================

$output = '';
$month = $_GET['month'];
$year = $_GET['year'];

if($month == '' && $year == '') { 
	$time = time();
	$month = date('n',$time);
    $year = date('Y',$time);
}
$prev_year = $year - 1;
$next_year = $year + 1;

$date = getdate(mktime(0,0,0,$month,1,$year));
$today = getdate();
$hours = $today['hours'];
$mins = $today['minutes'];
$secs = $today['seconds'];

if(strlen($hours)<2) $hours="0".$hours;
if(strlen($mins)<2) $mins="0".$mins;
if(strlen($secs)<2) $secs="0".$secs;

$days=date("t",mktime(0,0,0,$month,1,$year));
$start = $date['wday']+1;
$name = $l_m[$month];
$year2 = $date['year'].$l_year;
$offset = $days + $start - 1;

if($month==12) { 
	$next=1; 
	$nexty=$year + 1; 
} else { 
	$next=$month + 1; 
	$nexty=$year; 
}

if($month==1) { 
	$prev=12; 
	$prevy=$year - 1; 
} else { 
	$prev=$month - 1; 
	$prevy=$year; 
}

if($offset <= 28) $weeks=28; 
elseif($offset > 35) $weeks = 42; 
else $weeks = 35; 

$output .= "
<div id='cal_intro'>
<!-- img class='cal_link' src='../image/work_icon/Package.png' /'><label>: ".$l_wp_due."</label> | 
<img class='cal_link' src='../image/work_icon/Item.png' /'><label> : ".$l_wi_due."</label -->
</div>
<table class='cal' cellspacing='1' id='".$year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-'>
<tr>
	<td colspan='7'>
		<table class='calhead'>
		<tr>
			<td>
				<a style='padding-left:2px;' href='javascript:navigate($month,$prev_year)'><img class='year_half' src='../image/ajax_calendar/calLeft.gif'><img class='year_half' src='../image/ajax_calendar/calLeft.gif'></a>
				<a href='javascript:navigate($prev,$prevy)'><img src='../image/ajax_calendar/calLeft.gif'></a>
				<a class='today' href='javascript:navigate(\"\",\"\")'>".$l_today."</a>
				<a href='javascript:navigate($next,$nexty)'><img src='../image/ajax_calendar/calRight.gif'></a>
				<a href='javascript:navigate($month,$next_year)'><img class='year_half' src='../image/ajax_calendar/calRight.gif'><img class='year_half' src='../image/ajax_calendar/calRight.gif'></a>
			</td>
			<td align='right'>
				<div>".($_SESSION['_language']=='zh' ? $year2.' '.$name : $name.' '.$year2)." </div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr class='dayhead'>
	<td>".$l_w_0."</td>
	<td>".$l_w_1."</td>
	<td>".$l_w_2."</td>
	<td>".$l_w_3."</td>
	<td>".$l_w_4."</td>
	<td>".$l_w_5."</td>
	<td>".$l_w_6."</td>
</tr>";

$col=1;
$cur=1;
$next=0;

if(isset($_SESSION['_component']))
{
//	$wpList = DatabaseUtil::getMonthComponentWorkPackageDueList($year, $month, $_SESSION['_userId'], $_SESSION['_component']->id);
	$wiList = DatabaseUtil::getMonthComponentWorkItemDueList($year, $month, $_SESSION['_userId'], $_SESSION['_component']->id);
}
else if(isset($_SESSION['_project']))
{
//	$wpList = DatabaseUtil::getMonthProjectWorkPackageDueList($year, $month, $_SESSION['_userId'], $_SESSION['_project']->id);
	$wiList = DatabaseUtil::getMonthProjectWorkItemDueList($year, $month, $_SESSION['_userId'], $_SESSION['_project']->id);
}
else
{
//	$wpList = DatabaseUtil::getMonthWorkPackageDueList($year, $month, $_SESSION['_userId']);
	$wiList = DatabaseUtil::getMonthWorkItemDueList($year, $month, $_SESSION['_userId']);
}

$work_array = array();

//while($row = mysql_fetch_array($wpList, MYSQL_ASSOC))
//{
//	$day = getdate(strtotime($row['deadline']));
//	$link = '<a onmouseover="javascript:highlighton(\'wp'.$row['id'].'\')" onmouseout="javascript:highlightoff(\'wp'.$row['id'].'\')" title="'.str_replace('"', '&quot;', $row['objective']).'" href="../project/work_package.php?wp_id=' . $row['id'] . '&sid='. $row['s_id'] .'">' . '<img class="cal_link" src="../image/work_icon/Package.png" />' . '</a>';
//
//	if (array_key_exists($day['mday'], $work_array))
//	{
//		$work_array[$day['mday']]['wp'. $row['id']] = $link;
//	}
//	else
//	{
//		$sub = array();
//		$sub['wp'. $row['id']] = $link;
//		$work_array[$day['mday']] = $sub;
//	}
//}

while($row = mysql_fetch_array($wiList, MYSQL_ASSOC))
{
	$day = getdate(strtotime($row['deadline']));
	$link = '<a onmouseover="javascript:highlighton(\'wi_'.$row['id'].'_'.$row['s_id'].'\')" onmouseout="javascript:highlightoff(\'wi_'.$row['id'].'_'.$row['s_id'].'\')" title="'.str_pad($row['pw_id'], 4, "0", STR_PAD_LEFT).' - '.str_replace('"', '&quot;', $row['title']).'" href="../project/work_item.php?wi_id=' . $row['id'] . '&sid='. $row['s_id'] .'">' . '<img id="img_'.$row['id'].'_'.$row['s_id'].'" class="enum_img cmlink" src="../image/type/'.$row['type'].'.gif" />' . '</a>';

	if (array_key_exists($day['mday'], $work_array))
	{
		$work_array[$day['mday']]['wi'. $row['id']] = $link;
	}
	else
	{
		$sub = array();
		$sub['wi'. $row['id']] = $link;
		$work_array[$day['mday']] = $sub;
	}
}

for($i=1;$i<=$weeks;$i++) { 
	if($next==3) $next=0;
	if($col==1) $output.="<tr class='dayrow'>"; 

	$output.="<td valign='top'";

	if($i <= ($days+($start-1)) && $i >= $start) {
		$output.=' class="en_day" id="'.str_pad($cur, 2, "0", STR_PAD_LEFT).'"><b';

		if(($cur==$today['mday']) && ($month==$today['mon'])) $output.=" style='color:red'";

		$output.=">$cur</b>";

		if(array_key_exists($cur, $work_array))
		{
			$output.="<div>";

			foreach($work_array[$cur] as $work)
			{
				$output.=$work;
			}

			$output.="</div>";
		}

		$output.="</td>";

		$cur++; 
		$col++; 
		
	} else { 
		$output.="></td>"; 
		$col++; 
	}  
	    
    if($col==8) { 
	    $output.="</tr>"; 
	    $col=1; 
    }
}

$output.="</table>";

unset($work_array);
echo $output;

?>
