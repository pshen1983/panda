function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

function displayInvitation(div_id, inv_id, sid, pid, link_id)
{
	var div = document.getElementById(div_id);
	var link = document.getElementById(link_id);

	if(div.style.visibility == 'visible')
	{
		link.style.fontWeight = 'bold';
		div.style.visibility = 'hidden';
		div.style.display = "none";
	}
	else {
		if (div.innerHTML=='') {
			var http = GetXmlHttpObject();
			http.open("GET", "../message/invitation_body.inc.php?iid="+inv_id+"&sid="+sid+"&pid="+pid, true);
			http.onreadystatechange = function()
			{
				if(http.readyState == 4 && http.status == 200)
				{
					if( http.responseText == 1 )
					{
						window.location = '../default/login.php';
					}
					else {
						link.style.fontWeight='normal';
						div.innerHTML = http.responseText;
					}
				}
			}
			http.send(null);
		}

		link.style.fontWeight = 'normal';
		div.style.visibility = 'visible';
		div.style.display = "block";
	}
}

function displayMessage(div_id, mid, oid, label_id)
{
	var div = document.getElementById(div_id);
	var label = document.getElementById(label_id);

	if(div.style.visibility == 'visible')
	{
		div.style.visibility = 'hidden';
		div.style.display = "none";
	}
	else {
		if (div.innerHTML=='') {
			var http = GetXmlHttpObject();
			http.open("GET", "../message/message_body.inc.php?mid="+mid+"&oid="+oid, true);
			http.onreadystatechange = function()
			{
				if(http.readyState == 4 && http.status == 200) 
				{
					if( http.responseText == 1 )
					{
						window.location = '../default/login.php';
					}
					else {
						div.innerHTML = http.responseText;
						label.className = "invitation_body_label";
					}
				}
			}
			http.send(null);
		}

		div.style.visibility = 'visible';
		div.style.display = "block";
	}
}

function inviteFriend(label_id, email, suc_msg)
{
	var label = document.getElementById(label_id);

	var http = GetXmlHttpObject();
	http.open("GET", "../message/invite_friend_process.inc.php?e="+email, true);
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			var result = http.responseText;

			if(result == 1){
				window.location = '../default/login.php';
			}
			else if(result == 0){
				label.className = 'invitation_result_info';
				label.innerHTML = suc_msg;
			}
			else if(result == 2) {
				alert('wrong format');
			}
			else if(result == 3) {
				alert('already registered');
			}
			else if(result == 4) {
				alert('internal server error');
			}
		}
	}
	http.send(null);
}

function setNoteStatus(id)
{
	var http = GetXmlHttpObject();
	http.open("GET", "../message/set_note_done.inc.php?nid="+id, true);
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if (http.responseText == 1){
				window.location = '../default/login.php';
			}
			else if (http.responseText == 0) {
				location.reload(true);
			}
		}
	}
	http.send(null);
}

function showHideDoneNote(link_id)
{
	var link = document.getElementById(link_id);
	var elem = document.getElementById('done_note_list');

	if (elem.style.visibility == 'visible')
	{
		elem.style.display = 'none';
		elem.style.visibility = 'hidden';
		link.src = '../image/common/double_arrow_down.png';
	}
	else {
		if(elem.innerHTML == '') {
			link.src = '../image/snake.gif';
			var http = GetXmlHttpObject();
			http.open("GET", "../message/get_done_note.inc.php", true);
			http.onreadystatechange = function()
			{
				if(http.readyState == 4 && http.status == 200)
				{
					if (http.responseText == 1){
						window.location = '../default/login.php';
					}
					else {
						elem.innerHTML = http.responseText;
					}
				}
			}
			http.send(null);
		}

		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		link.src = '../image/common/double_arrow_up.png';
	}
}

function showMSNRequestBusy()
{
	document.getElementById('busy_img').style.display = "block";
}