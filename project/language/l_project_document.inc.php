<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_doc_name = 'Document Name';
	$l_doc_version = 'Version';
	$l_doc_size = 'Doc Size';
	$l_upload_by = 'Uploaded by';
	$l_upload_on = 'Uploaded on';
	$l_upload_btn = 'Upload';
	
	$l_proj = 'Project - ';
	$l_comp = 'Component - ';
	$l_wp = 'Workpackage - ';
	$l_wi = 'Workitem #';
	$l_pre = 'Shared documents in ';
	$l_doc_desc = 'Document Description:';

	$l_0_doc = 'There is 0 attached document.';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_doc_name = '&#25991;&#20214;&#21517;';
	$l_doc_version = '版本';
	$l_doc_size = '&#25991;&#26723;&#22823;&#23567;';
	$l_upload_by = '&#19978;&#20256;&#29992;&#25143;';
	$l_upload_on = '&#19978;&#20256;&#26102;&#38388;';
	$l_upload_btn = '&#19978;&#20256;';
	
	$l_proj = '&#39033;&#30446; - ';
	$l_comp = '&#39033;&#30446;&#32452; - ';
	$l_wp = '&#24037;&#20316;&#21253; - ';
	$l_wi = '&#24037;&#20316;&#39033; ';
	$l_pre = '共享文档列表：';
	$l_doc_desc = '文档注解：';

	$l_0_doc = '&#30446;&#21069;&#27809;&#26377;&#38468;&#21152;&#25991;&#20214;&#12290;';
}
?>