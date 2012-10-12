function displayImage(source)
{
	document.getElementById("image_frame").src = source;
}

function playVideo(source)
{
	document.getElementById("player_container").innerHTML = '';
	document.getElementById("player_container").innerHTML = '<embed src="../common/flvplayer.swf" id="flvplayer" allowFullScreen=""false"" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="' + source + '"  allowscriptaccess="always" />';
}