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

function select_innerHTML(objeto,innerHTML)
{
	objeto.innerHTML = "";
	var selTemp = document.createElement("micoxselect");
	var opt;
	selTemp.id="micoxselect1";
	document.body.appendChild(selTemp);
	selTemp = document.getElementById("micoxselect1");
	selTemp.style.display="none";
	if(innerHTML.toLowerCase().indexOf("<option")<0){
		innerHTML = "<option>" + innerHTML + "</option>";
	}
	innerHTML = innerHTML.replace(/<option/g,"<span").replace(/<\/option/g,"</span");
	selTemp.innerHTML = innerHTML;
	  
	
	for(var i=0;i<selTemp.childNodes.length;i++)
	{
		var spantemp = selTemp.childNodes[i];
		if(spantemp.tagName){     
			opt = document.createElement("OPTION");
		    
			if(document.all){
				objeto.add(opt);
			}
			else{
				objeto.appendChild(opt);
			}    
			opt.value = spantemp.getAttribute("value");
			opt.text = spantemp.innerHTML;
			opt.selected = spantemp.getAttribute('selected');
			opt.className = spantemp.className;
		} 
	}    
	document.body.removeChild(selTemp);
	selTemp = null;
}

function userSearchPage(num, div)
{
	var div = document.getElementById(div);

	var http = GetXmlHttpObject();

	http.open("GET", "../search/user.inc.php?page="+num, true);
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
			}
		}
	}
	http.send(null);
}

function getProjComp(comp_id, p_id)
{
	var link = document.getElementById(p_id);
	var comp = document.getElementById(comp_id);
	var proj_id = link.options[link.selectedIndex].value;

	if (proj_id!='')
	{
		var comp_span = document.getElementById(comp_id+"_span");
		comp_span.innerHTML = '<img src="../../image/snake.gif" />';

		var http = GetXmlHttpObject();

		http.open("GET", "../project/get_proj_comp.inc.php?p="+proj_id, true);

		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200)
			{
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(comp, '<option value=""> </option>'+http.responseText);
					comp_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function getProjWp(wp_id, p_id)
{
	var link = document.getElementById(p_id);
	var wp = document.getElementById(wp_id);
	var proj_id = link.options[link.selectedIndex].value;

	if (proj_id!='')
	{
		var wp_span = document.getElementById(wp_id+"_span");
		wp_span.innerHTML = '<img src="../../image/snake.gif" />';
	
		var http = GetXmlHttpObject();
	
		http.open("GET", "../project/get_proj_wp.inc.php?p="+proj_id, true);
	
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(wp, '<option value=""> </option>'+http.responseText);
					wp_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function getProjWi(wi_id, p_id)
{
	var link = document.getElementById(p_id);
	var wi = document.getElementById(wi_id);
	var proj_id = link.options[link.selectedIndex].value;

	if (proj_id!='')
	{
		var wi_span = document.getElementById(wi_id+"_span");
		wi_span.innerHTML = '<img src="../../image/snake.gif" />';
	
		var http = GetXmlHttpObject();
	
		http.open("GET", "../project/get_proj_wi.inc.php?p="+proj_id, true);
	
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(wi, '<option value=""> </option>'+http.responseText);
					wi_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function getCompWi(p_id, c_id, wi_id)
{
	var link = document.getElementById(c_id);
	var wi = document.getElementById(wi_id);
	var comp_id = link.options[link.selectedIndex].value;

	if(comp_id=='')
	{
		getProjWi(wi_id, p_id);
	}
	else {
		var wi_span = document.getElementById(wi_id+"_span");
		wi_span.innerHTML = '<img src="../../image/snake.gif" />';

		var http = GetXmlHttpObject();

		http.open("GET", "../project/get_comp_wi.inc.php?c="+comp_id, true);

		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(wi, '<option value=""> </option>'+http.responseText);
					wi_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function getWpWi(p_id, c_id, wp_id, wi_id)
{
	var link = document.getElementById(wp_id);
	var wi = document.getElementById(wi_id);
	var wp_id = link.options[link.selectedIndex].value;

	if(wp_id=='')
	{
		getCompWi(p_id, c_id, wi_id);
	}
	else {
		var wi_span = document.getElementById(wi_id+"_span");
		wi_span.innerHTML = '<img src="../../image/snake.gif" />';
		
		var http = GetXmlHttpObject();

		http.open("GET", "../project/get_wp_wi.inc.php?w="+wp_id, true);

		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(wi, '<option value=""> </option>'+http.responseText);
					wi_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function getProjUser(user_id, p_id)
{
	var link = document.getElementById(p_id);
	var user = document.getElementById(user_id);
	var proj_id = link.options[link.selectedIndex].value;
	
	if (proj_id!='')
	{
		var user_span = document.getElementById(user_id+"_span");
		user_span.innerHTML = '<img src="../../image/snake.gif" />';
	
		var http = GetXmlHttpObject();
	
		http.open("GET", "../project/get_proj_user.inc.php?p="+proj_id, true);
	
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(user, '<option value=""> </option>'+http.responseText);
					user_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function getCompWpSearch(p_id, c_id, wp_id)
{
	var link = document.getElementById(c_id);
	var wp = document.getElementById(wp_id);
	var comp_id = link.options[link.selectedIndex].value;

	if(comp_id=='')
	{
		getProjWp(wp_id, p_id);
	}
	else {
		var wp_span = document.getElementById(wp_id+"_span");
		wp_span.innerHTML = '<img src="../../image/snake.gif" />';
		
		var http = GetXmlHttpObject();

		http.open("GET", "../project/get_comp_wp.inc.php?c="+comp_id, true);

		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				if( http.responseText == 1 )
				{
					window.location = '../default/login.php';
				}
				else {
					select_innerHTML(wp, '<option value=""> </option>'+http.responseText);
					wp_span.innerHTML = '';
				}
			}
		}
		http.send(null);
	}
}

function wiSearchEnDi()
{
	var link = document.getElementById('project');
	var proj_id = link.options[link.selectedIndex].value;

	var num = document.getElementById('id_input');
	var obj = document.getElementById('objective_input');
	var own = document.getElementById('owner');
	var cre = document.getElementById('creator');
	var com = document.getElementById('component');
//	var wor = document.getElementById('workpackage');
	var typ = document.getElementById('type');
	var sta = document.getElementById('status');
	var pri = document.getElementById('priority');
	var sea = document.getElementById('search_submit_button');
	var c_s = document.getElementById('work_create_date_start');
	var c_e = document.getElementById('work_create_date_end');
	var l_s = document.getElementById('work_last_update_start');
	var l_e = document.getElementById('work_last_update_end');
	var d_s = document.getElementById('work_deadline_start');
	var d_e = document.getElementById('work_deadline_end');

	if(proj_id != "")
	{
		num.disabled = false;
		obj.disabled = false;
		own.disabled = false;
		cre.disabled = false;
		com.disabled = false;
//		wor.disabled = false;
		typ.disabled = false;
		sta.disabled = false;
		pri.disabled = false;
		sea.disabled = false;
		c_s.style.backgroundColor = 'white';
		c_e.style.backgroundColor = 'white';
		l_s.style.backgroundColor = 'white';
		l_e.style.backgroundColor = 'white';
		d_s.style.backgroundColor = 'white';
		d_e.style.backgroundColor = 'white';
	}
	else {
		num.disabled = true;
		obj.disabled = true;
		own.disabled = true;
		cre.disabled = true;
		com.disabled = true;
//		wor.disabled = true;
		typ.disabled = true;
		sta.disabled = true;
		pri.disabled = true;
		sea.disabled = true;
		c_s.style.backgroundColor = '';
		c_e.style.backgroundColor = '';
		l_s.style.backgroundColor = '';
		l_e.style.backgroundColor = '';
		d_s.style.backgroundColor = '';
		d_e.style.backgroundColor = '';
	}
}

function docSearchEnDi()
{
	var link = document.getElementById('project');
	var proj_id = link.options[link.selectedIndex].value;

	var na = document.getElementById('doc_name');
	var co = document.getElementById('component');
	var wp = document.getElementById('workpackage');
	var wi = document.getElementById('workitem');
	var ow = document.getElementById('owner');
	var su = document.getElementById('search_submit_button');
	var us = document.getElementById('doc_upload_start');
	var ue = document.getElementById('doc_upload_end');

	if(proj_id != "")
	{
		na.disabled = false;
		co.disabled = false;
//		wp.disabled = false;
		wi.disabled = false;
		ow.disabled = false;
		su.disabled = false;
		us.style.backgroundColor = 'white';
		ue.style.backgroundColor = 'white';
	}
	else {
		na.disabled = true;
		co.disabled = true;
//		wp.disabled = true;
		wi.disabled = true;
		ow.disabled = true;
		su.disabled = true;
		us.style.backgroundColor = '';
		ue.style.backgroundColor = '';
	}
}

function searchWIFormOnSubmit()
{
	var c_s = document.getElementById('work_create_date_start');
	var c_e = document.getElementById('work_create_date_end');
	var l_s = document.getElementById('work_last_update_start');
	var l_e = document.getElementById('work_last_update_end');
	var d_s = document.getElementById('work_deadline_start');
	var d_e = document.getElementById('work_deadline_end');

	c_s.disabled = false;
	c_e.disabled = false;
	l_s.disabled = false;
	l_e.disabled = false;
	d_s.disabled = false;
	d_e.disabled = false;
}

function searchDocFormOnSubmit()
{
	var u_s = document.getElementById('doc_upload_start');
	var u_e = document.getElementById('doc_upload_end');

	u_s.disabled = false;
	u_e.disabled = false;
}