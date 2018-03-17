<!DOCTYPE html>

<style type="text/css">
 body{

        min-height:100%;

        position:relative;

		font-family: microsoft yahei;

		text-align: center;
    }

	#head_bar{

		background: -webkit-linear-gradient(left top, rgba(254,73,66,0.6) , rgba(254,26,103,0.6)); 

        background: -o-linear-gradient(bottom right, rgba(254,73,66,0.6) , rgba(254,26,103,0.6)); 

        background: -moz-linear-gradient(bottom right, rgba(254,73,66,0.6) , rgba(254,26,103,0.6)); 

        background: linear-gradient(to bottom right, rgba(254,73,66,0.6) , rgba(254,26,103,0.6)); 

		padding-bottom: 0.6%;

		padding-top: 0.6%;

		padding-left: 3%;

	}

	#head_bar a{

		color: #ffffff !important;

		font-size: 1em !important;

		text-decoration: none;

	}

	#foot{

		background-color: rgb(59,48,52);

		color: #ffffff;

		position:absolute;

		bottom:0;

		width:100%;

	}

	#foot a{

		color:#ffffff !important;

	}

    .container{

        padding-bottom: 170px;

    }
    .firstfigure{

		padding-top:5%;

		padding-bottom: 0%;

		background-repeat:no-repeat !important;

		background-color: #efefef;

	}

    .ainankai{

		margin-bottom: 2%;

		margin-top: 2%;

	}
	.hfunction{

		background-color: #efefef;

		padding-top:2%;

		padding-bottom: 5%;


	}
	.moments{

		position: relative;

		padding-top: 3%; 

		padding-left: 2% !important;

		padding-right:2% !important;

		background-color: #efefef;

		background-repeat:no-repeat !important;
	}
	#box_bar{

		margin-top: 1%;

		margin-bottom: 1%;

	}
	.prograph
	{
		padding-top: 3%;
		padding-bottom: 3%;

		text-align: left;

	}
	.priority
	{
		text-align: center !important;
	}
	.psxels
	{

		font-size: 1em;
		color: rgb(255,255,255) !important;
	}
	.view_more a{

		font-size: 0.7em;

		color: rgb(255,255,255) !important;

	}
	.picture
	{
		font-size: 1em;

		color: rgb(255,255,255) !important;
	}
    #logo{



    }

	.headimg{
		width:100%;
	}
	.sideimg{width:45%;}
	

    @media (min-width: 768px) {
		.sideimg{width:55% !important;}
		.modal-dialog{width: 70% !important;}
		.headimg{width:80%;}
    }
    @media (min-width: 992px) {
		.sideimg{width:20% !important;}
		.modal-dialog{width: 50% !important;}
		.headimg{width:60%;}
    }
    @media (min-width: 1500px){
    	.modal-dialog{width: 30% !important;}
    }
    .icon3{
		margin-bottom: 10%;
	}

    .form-group {
    	margin-bottom: 20px !important;
	}
	.list-group-item{
	 	border:0px !important;
	 	background-color: transparent;
	 	color:#fff;
	}
	#wenan{
		background-image: url(./img/NKU.png);
	}
	.navbar-fixed-top > a:focus {
    	outline: 0px;
	}
</style>

<html lang="zh-Hans">

<head>

	<title>爱南开</title>

	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">

	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>

	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset="utf-8">

</head>

<body>

	<div class="container-fluid ">

		<div class=" navbar-fixed-top row" id="head_bar">
			<div class="col-sm-4 col-md-2 col-xs-6" href=""  style="text-align: left;">
				<img src="./img/logo.png" id="logo">
				<a>我的南开inankai</a></div>	
			<a class="col-sm-1 col-sm-offset-6 col-md-offset-8 col-md-1 col-xs-3" data-toggle="modal" data-target="#loginModal" style="text-align: right;" href="" id="login">登录</a>	
			<a class="col-sm-1 col-md-1  col-xs-3" data-toggle="modal" data-target="#registerModal" style="text-align: left;" href="">注册</a>
			
		</div>

	</div>

<!-- 注册框（Modal） -->

	<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">

					&times;

				</button>

				<h4 class="modal-title" id="myModalLabel">

					注册

				</h4>

			</div>



			<div class="modal-body ">

				<a class="user_type" title="个人" href=""><img src="http://cdn.duitang.com/uploads/blog/201411/18/20141118153107_QuHGU.thumb.700_0.jpeg" width="40%"></a>

				<a class="user_type" title="社团" href=""><img src="http://cdn.duitang.com/uploads/blog/201411/18/20141118153107_QuHGU.thumb.700_0.jpeg" width="40%"></a>

			</div>

		

		</div>

	</div>

	</div>


	<!-- 登录框（Modal） -->

	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content"  >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h3 class="modal-title" id="myModalLabel">
					登录
				</h3>
			</div>
			<div class="modal-body" style="width:72.6%; margin:auto">
				<form class="form" role="form" action="">
					<div class="form-group">
						<input class="form-control input-lg" type="text" placeholder="用户名" id="username"></input>
					</div>
					<div class="form-group">
						<input class="form-control input-lg" type="password" placeholder="密码" id="password"></input>
					</div>
					<div class="form-group pull-left">
						<div class="checkbox">
							<label><input type="checkbox" id="remeberme">请记住我</label>
						</div>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-lg btn-block" data-dismiss="modal" value="登录" id="submit" style="text-align: center !important; background-color: #6d323b; border:0px">
						<div style="padding: 2%;">
							<span class="pull-left"><a href="">找回密码</a></span>
							<a id="regist_jump" class="pull-right" href="">注册</a>
						</div>
					</div>
					
				</form>
			</div>
			
		</div>
	</div>
	</div>

	<div class="container-fluid firstfigure">
		<div class="row " style="text-align: center">

			<img src="./img/inankai.png" class="headimg">

		</div>
	</div>

<div class="container-fluid hfunction">

		<ul class="media-list col-md-8 col-md-offset-2 col-xs-12 col-sm-10 col-sm-offset-1" style="padding:0px;">
			
			<li class="media moments ">
				<div class="row" >
					<div class="prograph row col-md-6 col-md-offset-3 col-sm-12" style="position: absolute; z-index: 2;">
						<div class="row col-md-2 col-sm-4">
							<span class="picture"><strong>图 库</strong></span>
						</div>
						<div class="row col-md-10 col-sm-8">
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
						</div>
					</div>
					<div class="prograph row col-md-6 col-md-offset-7 col-sm-12" style="position: absolute; z-index: 2;">
						<div class="row col-md-2 col-sm-4">
							<span class="picture"><strong>图 库</strong></span>
						</div>
						<div class="row col-md-10 col-sm-8">
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
						</div>
					</div>

					<img class="priority" src="./img/NKU.png" width="100%" >

				</div>

			</li>

			<li class="media moments ">
				<div class="row" >
					<div class="prograph row col-md-6 col-md-offset-1 col-sm-12" style="position: absolute; z-index: 2;">
						<div class="row col-md-2">
							<span class="picture"><strong>图 库</strong></span>
						</div>
						<div class="row col-md-10">
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>pro
						</div>
					</div>
					<div class="prograph row col-md-6 col-md-offset-5" style="position: absolute; z-index: 2;">
						<div class="row col-md-2">
							<span class="picture"><strong>图 库</strong></span>
						</div>
						<div class="row col-md-10">
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
						</div>
					</div>

					<img class="priority" src="./img/program.png" width="100%" >

				</div>

			</li>

			<li class="media moments ">
				<div class="row" >
					<div class="prograph row col-md-6 col-md-offset-3" style="position: absolute; z-index: 2;">
						<div class="row col-md-2">
							<span class="picture"><strong>图 库</strong></span>
						</div>
						<div class="row col-md-10">
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
						</div>
					</div>
					<div class="prograph row col-md-6 col-md-offset-7" style="position: absolute; z-index: 2;">
						<div class="row col-md-2">
							<span class="picture"><strong>图 库</strong></span>
						</div>
						<div class="row col-md-10">
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
							<span class="psxels"><strong>Psxels</strong></span></br>
							<span class="view_more" ><a href="">提供高清照片且品质优良的免费照片网站</a></span><br/>
						</div>
					</div>

					
					<img class="priority" src="./img/design.png" width="100%" >

				</div>

			</li>

		</ul>
	<div class="col-md-2 col-xs-2 col-sm-1">
		<div class="row icon3">
			<a href=""><img src="./img/动态圈圆.png" title="动态圈" class="sideimg"></a>
		</div>
		<div class="row icon3">
			<a href=""><img src="./img/nk.png" title="爱南开" class="sideimg"></a>
		</div>
		<div class="row icon3">
			<a href=""><img src="./img/person.png" title="个人页" class="sideimg"></a>
		</div>
	</div>
		
	
	

	</div>


	<div class="container">


	</div>



	<footer class="container-fluid" id="foot">

		<div class="row" style="padding:2%;">

			<div class="col-md-2 col-md-offset-7 col-xs-6" id="foot_words">

				<p><a href="">关于我们</a></p>

				<p><a href="">联系我们</a></p>

				<p><a href="">开发团队</a></p>

				<p><a href="">其他作品</a></p>

			</div>

			<div  class="col-md-2 col-xs-6">

				<img id="qr_code" src="./img/qr_code.jpg" > 

			<div>

		</div>

	</footer>

</body>



<script type="text/javascript">

	$(document).ready(function(){  

    var img = $("#qr_code");  

	var h = $("#foot_words").outerHeight(); 	

	var w = 70;

    img.css({height:h},{width:w});  

    $("#logo").css("width",$("#login").outerHeight());

    });

</script>