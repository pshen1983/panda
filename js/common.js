function findPosX(obj)
{
	var curleft = 0;
	if(obj.offsetParent) {
		while(1) {
			curleft += obj.offsetLeft;
			if(!obj.offsetParent) break;
			obj = obj.offsetParent;
		}
	}
	else if(obj.x)
	curleft += obj.x;
	return parseInt(curleft);
}

function findPosY(obj)
{
	var curtop = 0;
	if(obj.offsetParent) {
		while(1) {
			curtop += obj.offsetTop;
			if(!obj.offsetParent) break;
			obj = obj.offsetParent;
		}
	}
	else if(obj.y)
	curtop += obj.y;
	return parseInt(curtop);
}

function css_browser_selector(u)
{
	var ua=u.toLowerCase(),
		is=function(t){return ua.indexOf(t)>-1},
		g='gecko',
		w='webkit',
		s='safari',
		o='opera',
		m='mobile',
		h=document.documentElement,
		b=[(!(/opera|webtv/i.test(ua))&&/msie\s(\d)/.test(ua))?('ie ie'+RegExp.$1):is('firefox/2')?g+' ff2':is('firefox/3.5')?g+' ff3 ff3_5':is('firefox/3.6')?g+' ff3 ff3_6':is('firefox/3')?g+' ff3':is('gecko/')?g:is('opera')?o+(/version\/(\d+)/.test(ua)?' '+o+RegExp.$1:(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')):is('konqueror')?'konqueror':is('blackberry')?m+' blackberry':is('android')?m+' android':is('chrome')?w+' chrome':is('iron')?w+' iron':is('applewebkit/')?w+' '+s+(/version\/(\d+)/.test(ua)?' '+s+RegExp.$1:''):is('mozilla/')?g:'',is('j2me')?m+' j2me':is('iphone')?m+' iphone':is('ipod')?m+' ipod':is('ipad')?m+' ipad':is('mac')?'mac':is('darwin')?'mac':is('webtv')?'webtv':is('win')?'win'+(is('windows nt 6.0')?' vista':''):is('freebsd')?'freebsd':(is('x11')||is('linux'))?'linux':'','js'];

	c = b.join(' ');
	h.className += ' '+c;
	return c;
}; 
css_browser_selector(navigator.userAgent);

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

function changeCodeImage(id, r)
{
	var end = new Date();
	document.getElementById(id).src="../utils/getCode.php?r="+r+"&time="+end.getTime();
}

function showHideNavCoEx(id, tId, cId)
{
	if(document.getElementById(tId).style.visibility == 'visible')
	{
		document.getElementById(tId).style.visibility = 'hidden';
		document.getElementById(tId).style.display = "none";
		document.getElementById(cId).style.backgroundColor  = 'transparent';
		document.getElementById(id).src="../image/collapse.png";

		document.getElementById(cId).onmouseover = function(){this.style.backgroundColor = "#54D5F5";}
		document.getElementById(cId).onmouseout = function(){this.style.backgroundColor = "transparent";}
	}
	else {
		document.getElementById(tId).style.visibility = 'visible';
		document.getElementById(tId).style.display = "block";
		document.getElementById(cId).style.backgroundColor  = '#CCC';
		document.getElementById(id).src="../image/expand.png";

		document.getElementById(cId).onmouseover = "none";
		document.getElementById(cId).onmouseout = "none";
	}

	document.getElementById(tId).style.width = "100%";
	document.getElementById(cId).style.display  = 'block';
	document.getElementById(cId).style.textDecoration  = 'none';
}

function hideShowNavCoEx(id, tId, cId)
{
	if($("#"+tId).is(":hidden"))
	{
		$("#"+tId).show('300');
		document.getElementById(cId).style.backgroundColor  = '#CCC';
		document.getElementById(id).src="../image/expand.png";
	}
	else {
		$("#"+tId).hide('300');
		document.getElementById(cId).style.backgroundColor  = 'transparent';
		document.getElementById(id).src="../image/collapse.png";
	}
}

function showHideDiv(img_id, div_id)
{
	if($("#"+div_id).is(":hidden")) {
		$("#"+div_id).show('300', function(){
			$("#"+img_id).attr("src","../image/common/double_arrow_up.png");
			adjustHeight();
		});
	}
	else {
		$("#"+div_id).hide('300', function(){
			$("#"+img_id).attr("src","../image/common/double_arrow_down.png");
			adjustHeight();
		});
	}
}

function checkUserExistance()
{
	document.getElementById('emailerror').style.visibility = 'hidden';
	document.getElementById('emailerrormessage').innerText = "";
	document.getElementById('indicator').src="../image/snake.gif";
	document.getElementById('indicator').style.visibility = 'visible';

	var email = document.getElementById('email').value;

	if (email)
	{
		var http = GetXmlHttpObject();
		var url = "../utils/checkEmail.php";
		var params = "e="+email;
		http.open("GET", url+"?"+params, true);
		http.onreadystatechange = function() 
		{
			if(http.readyState == 4 && http.status == 200) 
			{
				var result = http.responseText;

				if (result == '0')
				{
					document.getElementById('indicator').src="../image/checkmark.png";
				}
				else
				{
					document.getElementById('indicator').style.visibility = 'hidden';
					document.getElementById('emailerror').style.visibility = 'visible';
					if (!document.getElementById('emailerrormessage').hasChildNodes())
						document.getElementById('emailerrormessage').appendChild(document.createTextNode(result));
					document.getElementById('emailerrormessage').firstChild.nodeValue = result;
				}
			}
		}
		http.send(null);
	}
	else
	{
		document.getElementById('indicator').style.visibility = 'hidden';
	}
}

function highlighton(id)
{
	$('a#'+id).css("background-color","#bbb");
	$('a#'+id).css("text-shadow","0 1px 1px #fff");
}

function highlightoff(id)
{
	$('a#'+id).css("background-color","transparent");
	$('a#'+id).css("text-shadow","none");
}

function showHideComplete(link_id, div_id, url)
{
	var link = document.getElementById(link_id);
	var elem = document.getElementById(div_id);

	if($("#"+div_id).is(":hidden")) {
		if(elem.innerHTML == '') {
			link.src = '../image/snake.gif';
			var http = GetXmlHttpObject();
			http.open("GET", url, true);
			http.onreadystatechange = function()
			{
				if(http.readyState == 4 && http.status == 200)
				{
					if( http.responseText == 1 )
					{
						window.location = '../default/login.php';
					}
					else {
						elem.innerHTML = http.responseText;
						$("#"+div_id).show('300', 
							function(){
								adjustHeight();
								link.src = '../image/common/double_arrow_up.png';
							});
						
					}
				}
			}
			http.send(null);
		}
		else {
			$("#"+div_id).show('300',
				function() {
					adjustHeight();
					link.src = '../image/common/double_arrow_up.png';
				});
		}
	}
	else {
		$("#"+div_id).hide('300',
			function() {
				adjustHeight();
				link.src = '../image/common/double_arrow_down.png';
			});
	}
}

function showComments(link_id, div_id, work_type, work_id, s_id)
{
	var link = document.getElementById(link_id);
	var elem = document.getElementById(div_id);

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
			http.open("GET", "../project/comments.inc.php?type="+work_type+"&work_id="+work_id+"&sid="+s_id, true);

			http.onreadystatechange = function()
			{
				if(http.readyState == 4 && http.status == 200) 
				{
					if( http.responseText == 1 )
					{
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

function enableElement(src_id, tar_id)
{
	var src = document.getElementById(src_id);
	var tar = document.getElementById(tar_id);

	if(src.value == '') {
		tar.disabled = true;
	}
	else {
		tar.disabled = false;
	}
}

function limitTextLength(src_id, limit, monitor_label_id)
{
	var src = document.getElementById(src_id);
	var mon = document.getElementById(monitor_label_id);

	if (src.value.length > limit) {
		src.value = src.value.substring(0, limit);
	}
	else {
		mon.innerHTML = limit-src.value.length;
	}
}

function addMoreUserInvitation(pre_div, order, count_id, text, label)
{
	var botton = document.getElementById('more_user_div');
	var tbody = document.getElementById('invitation_sec');
	var hidden = document.getElementById(count_id);
	var next = order + 1;

	var trTag = document.createElement("tr");
	trTag.id = pre_div + "_" + order;
	trTag.className ="";

	var tdTag1 = document.createElement("td");
	tdTag1.innerHTML = '<label class="invite_disp_label">'+label+'</label>';
	trTag.appendChild(tdTag1);

	var tdTag2 = document.createElement("td");
	tdTag2.className = "invite_table_input_td";
	tdTag2.innerHTML = '<input type="text" class="invite_email_input textfield" id="user_email_' + order + '" name="user_email_'+ order + '" />';
	trTag.appendChild(tdTag2);
	
	tbody.appendChild(trTag);

	botton.innerHTML = '<input id="more_user_botton" type="button" onmousedown="mousePress(\'more_user_botton\')" onmouseup="mouseRelease(\'more_user_botton\')" onmouseout="mouseRelease(\'more_user_botton\')" onClick="javascript:addMoreUserInvitation(\'invitation\', '+next+', \''+count_id+'\', \''+text+'\', \''+ label +'\')" value="'+text+'" />';
	hidden.value = next;
}

function addMoreWIFollower(pre_div, order, count_id, text, label)
{
	var botton = document.getElementById('more_follow_botton');
	var tbody = document.getElementById('follow_sec');
	var select = document.getElementById('follow_email_0');
	var hidden = document.getElementById(count_id);
	var next = order + 1;

	var trTag = document.createElement("tr");
	trTag.id = pre_div + "_" + order;
	trTag.className ="";

	var tdTag1 = document.createElement("td");
	tdTag1.innerHTML = '<label class="update_label">'+label+'</label>';
	trTag.appendChild(tdTag1);

	var tdTag2 = document.createElement("td");
	tdTag2.className = "invite_table_input_td";
	tdTag2.innerHTML = '<select class="work_user_id" name="'+pre_div+'_email_'+order+'" id="'+pre_div+'_email_'+order+'">' + select.innerHTML + '</select>';
	trTag.appendChild(tdTag2);

	tbody.appendChild(trTag);

	botton.innerHTML = '<input id="more_follow_button" type="button" onmousedown="mousePress(\'more_follow_button\')" onmouseup="mouseRelease(\'more_follow_button\')" onmouseout="mouseRelease(\'more_follow_button\')" onClick="javascript:addMoreWIFollower(\'fellow\', '+next+', \''+count_id+'\', \''+text+'\', \''+ label +'\')" value="'+text+'" />';
	hidden.value = next;
}

function addDefaultProject(link_id)
{
	var link = document.getElementById(link_id);
	link.innerHTML = '<img class="l_b_s" src="../image/loading_bar_s.gif"></img>';
	link.href= "#";
	var http = GetXmlHttpObject();
	http.open("GET", "../project/add_the_project.inc.php", true);
	
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else if( http.responseText != 0 )
			{
					link.href= "javascript:removeDefaultProject('"+link_id+"')";
					link.innerHTML = http.responseText;
			}
		}
	}
	http.send(null);
}

function removeDefaultProject(link_id)
{
	var link = document.getElementById(link_id);
	link.innerHTML = '<img class="l_b_s" src="../image/loading_bar_s.gif"></img>';
	link.href= "#";
	var http = GetXmlHttpObject();
	http.open("GET", "../project/remove_the_project.inc.php", true);

	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else if( http.responseText != 0 )
			{
				link.href= "javascript:addDefaultProject('"+link_id+"')";
				link.innerHTML = http.responseText;
			}
		}
	}
	http.send(null);
}

function mousePress(id)
{
	document.getElementById(id).style.backgroundImage = "url(../image/button/button_background_over.png)";
}

function mouseRelease(id)
{
	document.getElementById(id).style.backgroundImage = "url(../image/button/button_background.png)";
}

function mousePressHeaderSearch(id)
{
	document.getElementById(id).style.backgroundImage = "url(../image/button/search_background_over.png)";
}

function mouseReleaseHeaderSearch(id)
{
	document.getElementById(id).style.backgroundImage = "url(../image/button/search_background.png)";
}

function adjustHeight()
{
	$('div#main_body').height('');
	$('div#right_nav').height('');
	h1 = parseInt($('div#main_body').height());
	h2 = parseInt($('div#right_nav').height());
	if(h2>h1) $('div#main_body').height(h2);
}

function addUserSub(link_id, work)
{
	var link = document.getElementById(link_id);
	link.innerHTML = '<img src="../image/loading_bar_s.gif"></img>';
	link.href= "#";
	var http = GetXmlHttpObject();
	http.open("GET", "../project/add_user_sub.inc.php?w="+work, true);
	
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else if( http.responseText != 0 )
			{
				link.href= "javascript:removeUserSub('"+link_id+"', '"+work+"')";
				link.innerHTML = http.responseText;
			}
		}
	}
	http.send(null);
}

function removeUserSub(link_id, work)
{
	var link = document.getElementById(link_id);
	link.innerHTML = '<img src="../image/loading_bar_s.gif"></img>';
	link.href= "#";
	var http = GetXmlHttpObject();
	http.open("GET", "../project/remove_user_sub.inc.php?w="+work, true);
	
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else if( http.responseText != 0 ) {
				link.href= "javascript:addUserSub('"+link_id+"', '"+work+"')";
				link.innerHTML = http.responseText;
			}
		}
	}
	http.send(null);
}

function getCompWp(c_id, wp_id, p_id)
{
	var link = document.getElementById(c_id);
	var wp = document.getElementById(wp_id);
	var comp_id = link.options[link.selectedIndex].value;
	var http = GetXmlHttpObject();

	if(comp_id == '')
		http.open("GET", "../project/get_proj_wp.inc.php?p="+p_id, true);
	else
		http.open("GET", "../project/get_comp_wp.inc.php?c="+comp_id, true);

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200)
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else {
				select_innerHTML(wp, '<option value=""></option>'+http.responseText);
			}
		}
	}
	http.send(null);
}

function getHighest(div_1, div_2)
{
	document.getElementById(div_1).style.height = "100%";
	var height1 = document.getElementById(div_1).offsetHeight;
	var height2 = document.getElementById(div_2).offsetHeight;

	if (height2 >= height1)
		document.getElementById(div_1).style.height = height2+"px";
}

function timeOutCallsAtLoad()
{
	alert("Halo");
	t=setTimeout('timeOutCallsAtLoad()',3000);
}

function changeLang(lang)
{
	var http = GetXmlHttpObject();

	http.open("GET", "../common/change_lang.inc.php?l="+lang, true);
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if (http.responseText == 0) {
				location.reload(true);
			}
		}
	}
	http.send(null);
}

function getLangList()
{
	var cont = document.getElementById('lang_list');
	var arrow = document.getElementById('lang_arrow');

	if (cont.style.visibility == 'visible') {
		cont.style.visibility = 'hidden';
		arrow.innerHTML = "&#9660;";
	}
	else {
		var link = document.getElementById('lang_link');
		var top = findPosY(link) + link.offsetHeight + 1;
		var left = findPosX(link);

		cont.style.left = left + "px";
		cont.style.top = top + "px";
		arrow.innerHTML = "&#9650;";
		cont.style.visibility = 'visible';
	}
}

function showMessageBox()
{
	var box = document.getElementById('send_box');
	box.style.visibility = 'visible';
	box.style.display = 'block';
}

function hideMessageBox()
{
	var box = document.getElementById('send_box');
	box.style.visibility = 'hidden';
	box.style.display = 'none';
}

function setMessageBoxPosition()
{
	var form = document.getElementById('send_mess_div');

	if(window.innerWidth!=undefined)
	{
		var length = parseInt((window.innerWidth-700)/2);
		var height = parseInt((window.innerHeight-350)/2);
	}
	else {
		var length = parseInt((document.documentElement.clientWidth-700)/2);
		var height = parseInt((document.documentElement.clientHeight-435)/2);
	}

	form.style.pixelTop = height;
	form.style.pixelLeft = length;
	
	form.style.top = height+'px';
	form.style.left = length+'px';
}

function longpollLeftNav()
{
	$.ajax({
		url: "../message/getCount.inc.php",
		success: function(data){
			var count = jQuery.parseJSON(data);
			if(count.mess>0)
				$("#mess_count").html(' <span id="mcount" class="right_nav_count round_border_4">'+count.mess+'</span>');
			else $("#mess_count").html('');
			if(count.invi>0)
				$("#invi_count").html(' <span id="icount" class="right_nav_count round_border_4">'+count.invi+'</span>');
			else $("#invi_count").html('');
		}
	});
}

function addProjectRightMenu(msg)
{
	$("a.projlink").contextMenu({ menu: 'pMenu' }, function(action, el, pos) {
		var substr = $(el).attr('id').split('_');
		if( action=='pgoto' ) {
			window.location = '../project/index.php?p_id='+substr[1]+'&sid='+substr[2];
		}
		else if( action=='pquit' && confirm(msg) ) {
			$.ajax({
				url: "../project/quit_project.inc.php",
				type: "POST",
				data: "pid="+substr[1]+'&sid='+substr[2],
				success: function(data) {
					if( data==0 ) location.reload();
					else if ( data==1 ) window.location='../default/login.php';
					else alert(data);
				}
			});
		}
	});
}