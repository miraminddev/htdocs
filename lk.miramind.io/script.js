//ТИКЕТЫ

function post_wal() {
	var url = 'wform';
	var name = 'post_wal';
  	var val = $("#val").val();
	str = '&val=' + val;
	
	
	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			if (obj.go) go(obj.go);
			else alert(obj.message);
			location.reload();
		}
	});
}



function post_ticket() {
	var url = 'wform';
	var name = 'new_ticket';
	var zagolovok = $("#zagolovok").val();
	var mes = $("#message").val();
	str = '&zagolovok=' + zagolovok + '&message=' + mes
	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			if (obj.go) go(obj.go);
			else alert(obj.message);
			location.reload();
		}
	});
}
function post_ticket_answer() {
	var url = 'wform';
	var name = 'post_ticket_answer';
	var idt = $("#idt").val();
	var mes = $("#message").val();
	str = '&idt=' + idt + '&message=' + mes
	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			if (obj.go) go(obj.go);
			else alert(obj.message);
			location.reload();
		}
	});
}
function post_close_ticket_admin() {
	var url = 'wform';
	var name = 'post_close_ticket_admin';
	var idt = $("#idt").val();
	str = '&idt=' + idt
	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			if (obj.go) go(obj.go);
			else alert(obj.message);
			location.reload();
		}
	});
}
function post_close_ticket() {
	var url = 'wform';
	var name = 'post_close_ticket';
	var idt = $("#idt").val();
	str = '&idt=' + idt
	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			if (obj.go) go(obj.go);
			else alert(obj.message);
			location.reload();
		}
	});
}
//ТИКЕТЫ




//ПРОФИЛЬ
function changepass() {
	var url = 'wform';
	var name = 'changepass';
	var password = $("#password").val();
	var newpass = $("#newpass").val();
	var newpass2 = $("#newpass2").val();
	var str = '&password=' + password + '&newpass=' + newpass + '&newpass2=' + newpass2
	
	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			if (obj.go) go(obj.go);
			else alert(obj.message);
		}
	});
}

function changeprofile() {
	var url = 'wform';
	var name = 'changeprofile';
	var firstname = $("#firstname").val();
	var wallet = $("#wallet").val();
	
	var str = '&firstname=' + firstname + '&wallet=' + wallet


	$.ajax({
		url: '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function(result) {
			obj = jQuery.parseJSON(result);
			alert(obj.message);
			location.reload();
		}
	});
}


//НОВОСТИ

//НОВОСТИ	
	
	
	
	
	
	


function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
function go(url) {
	window.location.href = '/' + url;
}

