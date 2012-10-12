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

function adminUpdateUser(p1, p2)
{
	var select = document.getElementById(p2);
	window.location='../admin/update_user.inc.php?u='+p1+'&r='+select.value;
}

function adminDeleteUser(p1)
{
	window.location='../admin/delete_user.inc.php?u='+p1;
}

function updatecoPic()
{
	var pic = document.getElementById('c_o_wi');
	var start = document.getElementById('c_o_start_date');
	var end = document.getElementById('c_o_end_date');

	$("#c_o_wi").hide();
	start.disabled = false;
	end.disabled = false;

	s_day = start.value;
	e_day = end.value;

	pic.src="../admin/g_open_close_wi.inc.php?s="+s_day+"&e="+e_day;

	setTimeout(function(){
		$("#c_o_wi").show();
		start.disabled = true;
		end.disabled = true;
		}, 1);
}

function updateNoPic()
{
	var pic = document.getElementById('n_o_wi');
	var start = document.getElementById('n_o_start_date');
	var end = document.getElementById('n_o_end_date');

	$("#n_o_wi").hide();
	start.disabled = false;
	end.disabled = false;

	s_day = start.value;
	e_day = end.value;

	pic.src="../admin/g_num_open_wi.inc.php?s="+s_day+"&e="+e_day;

	setTimeout(function(){
		$("#n_o_wi").show();
		start.disabled = true;
		end.disabled = true;
		}, 1);
}

function updateClosePic()
{
	var pic = document.getElementById('clos_wi');
	var dur = document.getElementById('clos_dur');
	var end = document.getElementById('clos_end_date');

	$("#clos_wi").hide();
	end.disabled = false;
	e_day = end.value;

	pic.src="../admin/g_close_wi_ot.inc.php?e="+e_day+"&d="+dur.options[dur.selectedIndex].value;

	setTimeout(function(){
		$("#clos_wi").show();
		end.disabled = true;
		}, 1);

}

function updateCreatePic()
{
	var pic = document.getElementById('crea_wi');
	var dur = document.getElementById('crea_dur');
	var end = document.getElementById('crea_end_date');

	$("#crea_wi").hide();
	end.disabled = false;
	e_day = end.value;

	pic.src="../admin/g_open_wi_ot.inc.php?e="+e_day+"&d="+dur.options[dur.selectedIndex].value;

	setTimeout(function(){
		$("#crea_wi").show();
		end.disabled = true;
		}, 1);
}