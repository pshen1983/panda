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

function adjustHeight()
{
	document.getElementById('doc_bro_tree').style.height = "100%";

	var height1 = document.getElementById('doc_bro_tree').offsetHeight;
	var height2 = document.getElementById('doc_bro_value').offsetHeight;

	if (height2 >= height1)
		document.getElementById('doc_bro_tree').style.height = height2+"px";
}

function showHideDocBro(img_id, sec_id)
{
	if(document.getElementById(sec_id).style.visibility == 'visible')
	{
		document.getElementById(sec_id).style.visibility = 'hidden';
		document.getElementById(sec_id).style.display = "none";
		document.getElementById(img_id).src="../image/collapse.png";
	}
	else {
		document.getElementById(sec_id).style.visibility = 'visible';
		document.getElementById(sec_id).style.display = "block";
		document.getElementById(img_id).src="../image/expand.png";
	}
	
	adjustHeight();
}

function hideShowDocBro(img_id, sec_id)
{
	if(document.getElementById(sec_id).style.visibility == 'hidden')
	{
		document.getElementById(sec_id).style.visibility = 'visible';
		document.getElementById(sec_id).style.display = "block";
		document.getElementById(img_id).src="../image/expand.png";
	}
	else {
		document.getElementById(sec_id).style.visibility = 'hidden';
		document.getElementById(sec_id).style.display = "none";
		document.getElementById(img_id).src="../image/collapse.png";
	}
	
	adjustHeight();
}

function getProjs(p_id, sec_id)
{
	ul = document.getElementById(sec_id);
	if(ul.innerHTML == '') {
		var http = GetXmlHttpObject();
		http.open("GET", "../docs/document_browser_proj.inc.php?p_id="+p_id, true);

		http.onreadystatechange = function()
		{
			if(http.readyState == 4 && http.status == 200) 
			{
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					ul.innerHTML = http.responseText;
				}
			}
		}
		http.send(null);
	}
}

function getComps(c_id, sec_id)
{
	ul = document.getElementById(sec_id);
	if(ul.innerHTML == '') {
		var http = GetXmlHttpObject();
		http.open("GET", "../docs/document_browser_comp.inc.php?c_id="+c_id, true);

		http.onreadystatechange = function()
		{
			if(http.readyState == 4 && http.status == 200) 
			{
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					ul.innerHTML = http.responseText;
				}
			}
		}
		http.send(null);
	}
}

function getWps(wp_id, sec_id)
{
	ul = document.getElementById(sec_id);
	if(ul.innerHTML == '') {
		var http = GetXmlHttpObject();
		http.open("GET", "../docs/document_browser_wp.inc.php?wp_id="+wp_id, true);

		http.onreadystatechange = function()
		{
			if(http.readyState == 4 && http.status == 200) 
			{
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					ul.innerHTML = http.responseText;
				}
			}
		}
		http.send(null);
	}
}

function getDocs(p_id, c_id, wp_id, wi_id, s_id, sec_id, link_id)
{
	link = document.getElementById(link_id);
	hidden = document.getElementById('hidden_id');
	pre = document.getElementById(hidden.value);

	ul = document.getElementById(sec_id);
	var http = GetXmlHttpObject();
	http.open("GET", "../docs/document_browser_docs.inc.php?p_id="+p_id+"&c_id="+c_id+"&wp_id="+wp_id+"&wi_id="+wi_id+"&s_id="+s_id, true);

	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200) 
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else {
				pre.style.fontWeight='normal';
				hidden.value=link_id;
				link.style.fontWeight='bold';
				ul.innerHTML = http.responseText;
				adjustHeight();
			}
		}
	}
	http.send(null);

}