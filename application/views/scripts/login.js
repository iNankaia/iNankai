var username = '';
var password = '';
var get_json = {};
var flag = -1;
var login_state = -6;
//var info = {};
$('form').submit(function(){
	username = $('#username').val();
	password = $('#password').val();
	$.post(
		"<?php echo site_url('user/signin') ?>",
		{
			'account': username,
			'password': password
		}
		function(data){
			get_json = JSON.parse(data);
			flag = get_json['flag'];
			if(flag == 100){ //登陆成功
				window.location.href="<?php echo site_url('') ?>";
			}
			else{
				alert(get_json['content']);
			}
		},
		'json'
		); 
});