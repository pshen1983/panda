<?php
include_once ("../common/Objects.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['_project']))
{
	header( 'Location: index.php' );
	exit;
}

include_once ("language/l_project_document.inc.php");

$pr_id = $_SESSION['_project']->id;
$co_id = (isset($_SESSION['_component']) ? $_SESSION['_component']->id : '');
$wp_id = (isset($_SESSION['_workpackage']) ? $_SESSION['_workpackage']->id : '');
$wi_id = (isset($_SESSION['_workitem']) ? $_SESSION['_workitem']->id : '');

$s_id = '';
if(isset($_SESSION['_workitem']) && !empty($_SESSION['_workitem']))
	$s_id = $_SESSION['_workitem']->s_id;
else if(isset($_SESSION['_workpackage']) && !empty($_SESSION['_workpackage']))
	$s_id = $_SESSION['_workpackage']->s_id;
else if(isset($_SESSION['_component']) && !empty($_SESSION['_component']))
	$s_id = $_SESSION['_component']->s_id;
else
	$s_id = $_SESSION['_project']->s_id;

$title = '';

if(!empty($wi_id))
	$title = $l_wi.str_pad($_SESSION['_workitem']->pw_id, 4, "0", STR_PAD_LEFT)." - <span class='table_work_level_name'>".CommonUtil::truncate($_SESSION['_workitem']->title, 49)."</span>";
else if(!empty($wp_id))
	$title = $l_wp." <span class='table_work_level_name'>".CommonUtil::truncate($_SESSION['_workpackage']->objective, 49)."</span>";
else if(!empty($co_id))
	$title = $l_comp." <span class='table_work_level_name'>".CommonUtil::truncate($_SESSION['_component']->title, 49)."</span>";
else
	$title = $l_proj." <span class='table_work_level_name'>".CommonUtil::truncate($_SESSION['_project']->title, 49)."</span>";

$docs = DatabaseUtil::getProjDocList($pr_id, (empty($co_id)?null:$co_id), (empty($wp_id)?null:$wp_id), (empty($wi_id)?null:$wi_id));
$count = count($docs);

$outpre = "<div id='mid_link_saperator'></div>";

$outmid = "";//<label style='font-weight:normal;font-size:.8em;color:red;'>".$l_0_doc."</label>";

$table = array();
$index = 0;
$table[$index] = array($l_doc_name, $l_doc_version, $l_doc_size, $l_upload_by, $l_upload_on);

while($doc = mysql_fetch_array($docs, MYSQL_ASSOC))
{
	$index = $index + 1;
	$size = ($doc['size']/1024);
	$user = DatabaseUtil::getUser($doc['updater']);
	$table[$index] = array( '<a style="text-decoration:none;" title="'.$doc["description"].'" href="../utils/download.inc.php?f='. str_replace(" ", "%20", $doc["s_id"]) .'&s_id='. 3*($_SESSION["_project"]->id+7) .'&id='.$doc["id"].'">'.CommonUtil::truncate($doc["title"], 19).'</a>',
							$doc['version'],
							($size>512 ? round($size/1024,2).' MB' : round($size,2).' KB'),
							(($_SESSION['_language'] == 'zh') ? $user["lastname"].$user["firstname"] : CommonUtil::truncate($user["firstname"].' '.$user["lastname"], 31) ),
							$doc["last_update"]
						);
}

$sortColumn =
	"<script id='filter_bar_js' type='text/javascript'>
	$(function() {
		$('table#doc_table')
			.tablesorter({widthFixed: true, widgets: ['zebra']})
	});
	var table_Props = 	{
							col_0: \"select\",
							col_1: \"select\",
							col_2: \"none\",
							col_3: \"select\",
							col_4: \"none\",
							display_all_text: \"\",
							sort_select: false 
						};
	setFilterGrid( \"doc_table\",table_Props );
	</script>";

$outpost = CommonUtil::getTable( $table, 
								 $sortColumn, 
								 $l_pre.$title, 
								 null,//$datePickForm, 
								 "doc_list_table_show_hide_link", 
								 "doc_list_table", 
								 null, //$empty_display, 
								 'doc_table',
								 'sort_table',
								 array(34, 12, 13, 19, 22)
							  );
if(isset($_SESSION['docMessage']))
{
	$outpost.= $_SESSION['docMessage'];
	unset($_SESSION['docMessage']);
}
$outpost.= '<form id="up_doc_form" action="../project/upload_file.inc.php?p1='.$_SESSION['_userId'].'&p2='.$pr_id.'&p3='.$co_id.'&p4='.$wp_id.'&p5='.$wi_id.'&s_id='.($s_id-12373).'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
			<input type="file" name="file" id="file" onchange="document.getElementById(\'file_name\').value=(this.value.replace(/\\\\/g,\'/\').replace( /.*\//, \'\' ));" />
			<label class="info">(< 2Mb )</label><br><label class="info">'.$l_doc_desc.'</label><br />
			<textarea name="file_desc" id="file_desc"></textarea>
			<input id="file_name" name="file_name" type="hidden" value="" />
			<input id="upload_doc_button" class="upload_doc_button_input" onmousedown="mousePress(\'upload_doc_button\');" onmouseup="mouseRelease(\'upload_doc_button\');" onmouseout="mouseRelease(\'upload_doc_button\');" type="submit" value="'.$l_upload_btn.'" />
			</form></div>';

echo $outpre.$outmid.$outpost;
?>