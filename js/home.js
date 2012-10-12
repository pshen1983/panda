var dragok=false;
var resize_x=false;
var resize_y=false;
var dy,dx;

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

function move(e){
	if (!e) e = window.event;

	if (resize_x && resize_y)
	{
		var div = document.getElementById("pic_select");
		var scroll_T = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
		var bottom = findPosY(div)-scroll_T;
		var scroll_L = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;
		var left = findPosX(div)-scroll_L;

		document.getElementById("pic_select").style.height = e.clientY - bottom + "px";
		document.getElementById("pic_select").style.width = e.clientX - left + "px";
	}
	else if(resize_x) {
		var div = document.getElementById("pic_select");
		scroll_L = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;
		var left = findPosX(div)-scroll_L;

		document.getElementById("pic_select").style.width = e.clientX - left + "px";
	}
	else if(resize_y) {
		var div = document.getElementById("pic_select");
		scroll_T = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
		var bottom = findPosY(div)-scroll_T;

		document.getElementById("pic_select").style.height = e.clientY - bottom + "px";
	}
	else if (dragok){
		var div = document.getElementById("pic_select");
		var par = document.getElementById("pic_holder");

		if( parseInt(par.style.left+0)<=parseInt(div.style.left+0) && 
			parseInt(div.style.left+0)+parseInt(div.style.width)<=parseInt(par.style.width) )
			div.style.left = dx + e.clientX + "px";
		if (parseInt(par.style.left+0)>parseInt(div.style.left+0))
			div.style.left = par.style.left;
		if (parseInt(div.style.left+0)+parseInt(div.style.width)>parseInt(par.style.width))
			div.style.left = parseInt(par.style.width) - parseInt(div.style.width) - 2 + "px";

		if( parseInt(par.style.top+0)<=parseInt(div.style.top+0) && 
			parseInt(div.style.top+0)+parseInt(div.style.height)<=parseInt(par.style.height) )
			div.style.top = dy + e.clientY + "px";
		if (parseInt(par.style.top+0)>parseInt(div.style.top+0))
			div.style.top = par.style.top;
		if (parseInt(div.style.top+0)+parseInt(div.style.height)>parseInt(par.style.height))
			div.style.top = parseInt(par.style.height) - parseInt(div.style.height) - 2 + "px";
	}
}

function over(e){
	if (!e) e = window.event;

	var div = document.getElementById("pic_select");
	
	var widt = parseInt(div.style.width);
	var height = parseInt(div.style.height);

	var scroll_T = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
	var scroll_L = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;
	
	var left = (widt+findPosX(div)-scroll_L);
	var bottom = (height+findPosY(div)-scroll_T);

	resize_x = (e.clientX <= left+2) && (e.clientX > (left-4));
	resize_y = (e.clientY <= bottom+2) && (e.clientY > (bottom-4));

	if( resize_x && resize_y )
	{
		div.style.cursor = 'se-resize';
	}
	else if ( resize_x )
	{
		div.style.cursor = 'e-resize';
	}
	else if ( resize_y )
	{
		div.style.cursor = 's-resize';
	}
	else {
		div.style.cursor = 'move';
	}
}

function down(e){
	if (!e) e = window.event;
	var div = document.getElementById("pic_select");
	var div2 = document.getElementById("pic_holder");

	if(!resize_x && !resize_y) {
		if(!dragok) dragok = true;
	}
	dx = parseInt(div.style.left+0) - e.clientX;
	dy = parseInt(div.style.top+0) - e.clientY;

	div2.onmousemove = move;
	div.onmousemove = move;

	div.onmousedown = null;

	return false;
}

function up(){
	var div = document.getElementById("pic_select");
	var div2 = document.getElementById("pic_holder");
	dragok = false;
	resize_x = false;
	resize_y = false;
	div2.onmousemove = null;
	div.onmousemove = over;

	div.onmousedown = down;

	pickSelectedImage();
}

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

function pickSelectedImage()
{
	var div = document.getElementById("pic_select");
	var s_x = parseInt(div.style.left+0);
	var s_y = parseInt(div.style.top+0);
	var s_w = parseInt(div.style.width);
	var s_h = parseInt(div.style.height);

	document.getElementById("sel_result").src='../image/blank_pro_pic.gif';
	
	var http = GetXmlHttpObject();
	http.open("GET", "../home/saveImage.inc.php?p1="+s_x+"&p2="+s_y+"&p3="+s_w+"&p4="+s_h, true);
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
			if( http.responseText == 1 )
			{
				window.location = '../default/login.php';
			}
			else {
				document.getElementById("sel_result").src=document.getElementById("sel_result_input").value+'?'+Math.random();
			}
		}
	}
	http.send(null);
}

function setBackground(element, color)
{
	element.style.backgroundColor = color;
}

function addMoreEduc(num_id)
{
	var input = document.getElementById(num_id);
	var next = parseInt(input.value);

	window.location='../home/education_history.php?n='+next;
}

function addMoreEmpl(num_id)
{
	var input = document.getElementById(num_id);
	var next = parseInt(input.value);

	window.location='../home/employment_history.php?n='+next;
}

function deleteEduc(id)
{
	window.location='../home/delete_education.inc.php?n='+id;
}

function deleteEmpl(id)
{
	window.location='../home/delete_employment.inc.php?n='+id;
}

function enableEducUpdate(num_id)
{
	var input0 = document.getElementById('educ_up_'+num_id);
	var input1 = document.getElementById('school_'+num_id);
	var input2 = document.getElementById('depart_'+num_id);
	var input3 = document.getElementById('type_'+num_id);
	var input4 = document.getElementById('start_'+num_id);
	var input5 = document.getElementById('end_'+num_id);

	input0.value = 'true';
	input1.disabled = false;
	input2.disabled = false;
	input3.disabled = false;
	input4.disabled = false;
	input5.disabled = false;
}

function enableEmplUpdate(num_id)
{
	var input0 = document.getElementById('empl_up_'+num_id);
	var input1 = document.getElementById('company_'+num_id);
	var input2 = document.getElementById('local_'+num_id);
	var input3 = document.getElementById('title_'+num_id);
	var input4 = document.getElementById('start_'+num_id);
	var input5 = document.getElementById('end_'+num_id);

	input0.value = 'true';
	input1.disabled = false;
	input2.disabled = false;
	input3.disabled = false;
	input4.disabled = false;
	input5.disabled = false;
}