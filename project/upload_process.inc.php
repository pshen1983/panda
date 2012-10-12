<?php
if(isset($_GET['progress_key'])) {
	$status = apc_fetch('upload_'.$_GET['progress_key']);
	echo $status['current']/$status['total']*100;
	die;
}
?>

<script src="../js/jquery.js" type="text/javascript"></script>
<link href="../css/style_progress.css" rel="stylesheet" type="text/css" />

<script>
$(document).ready(function()
{ 
	setInterval(
		function()
		{
			$.get("upload_process.inc.php?progress_key=<?php echo $_GET['up_id']; ?>&randval="+ Math.random(),
				function(data)	//return information back from jQuery's get request
				{
					if(data<100)
					{
						$('#progress_container').fadeIn(100);	//fade in progress bar
						$('#progress_bar').width(data +"%");	//set width of progress bar based on the $status value (set at the top of this page)
						$('#progress_message').html('Uploading file ' + parseInt(data) + "%");	//fade in progress bar
					}
					else
					{
						$('#progress_bar').width( "0px" );
						$('#progress_container').css("background-image", "url(../image/process_bar.gif)");
						$('#progress_message').html('Converting uploaded file ...');	//fade in progress bar
					}
				})
		} ,
		1000);	//Interval is set at 500 milliseconds (the progress bar will refresh every .5 seconds)
});
</script><body style="margin:0px"><div id="progress_container"><div id="progress_bar"></div><div id="progress_message"></div></div></body>