<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>银行管理系统</title>
<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="token" content="{{csrf_token()}}">
<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<style>

body{display: block;background-color: #000000;margin: 0px;overflow: scroll;}
a{color:#0078ff;}
/* 登陆界面 */
.login-form{
	width: 70%;
	max-width: 400px;
	padding: 35px 50px 15px;
	display: block; 
	margin: 18% auto;
	color: white;
	border: 1px solid #eaeaea;
	box-shadow: 0 0 25px #cac6c6;
	background-color: #151515;
	border-radius: 5px;
	opacity: 0.9;
}
.login-form-title{
	text-align: center;
	font-size: 1.8em;
	overflow-x: hidden;
}
.login-form>div{
	color: white;
	position: relative;
}
.login-form-input, .login-form-submit{
	padding: 3px 10px;
	/* margin: 10px 0; */
	height: 36px;
	color: white;
	font-size: inherit;
	background-color: #252323;
	border: 1px solid #bfcbd9;
	border-radius: 4px;
}
.login-userId, .login-pwd{
	width: 85%;
}
/* 验证码 */
.login-form-codediv>input, .login-form-codediv>img{
    float: left;
}
.login-verification{
    color: green;
    width: 60%;
    display: block;
}
.login-verification-img{
    display: block;
    width: 100px;
    height: 36px;
	padding: 3px 10px;
	/* margin: 10px 0; */
}
.login-form-codediv:after{
	content: '';
	display: block;
	clear: both;
}
.login-form-submit{
	width: 90%;
	background-color: black;
}
/* 登陆输入框 */
.login-prompt{
	height: 22px;
	font-size: 12px;
	opacity: 0;
}
.login-userId-error, .login-pwd-error, .login-verification-error{
	border: 1px solid red;
}
.prompt-userId-error, .prompt-pwd-error, .prompt-verification-error{
	opacity: 1;
	color: red;
}

#tip {
	height: 20px;
	line-height: 15px;
	text-align: center;
	color: #F76260;
	font-size: 14px;
}

</style>

</head>
<body>
<div id="login">
	<form class="login-form">
		<h3 class="login-form-title">银行登陆系统</h3>
		<div>
			<input class="login-form-input login-userId"
			 onBlur="watchInput('login-userId','login-userId-error','prompt-userId','prompt-userId-error','请输入账号')"
			 onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')"
			 type="text" value="" placeholder="账号"
			 id="name">
		</div>
		<span class="login-prompt prompt-userId">请输入账号</span>
		<div>
			<input class="login-form-input login-pwd" 
			 onBlur="watchInput('login-pwd','login-pwd-error','prompt-pwd','prompt-pwd-error','请输入密码')"
			 onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')"
			type="password" value="" placeholder="密码"
			id="pwd">
		</div>
		<span class="prompt-pwd login-prompt">请输入密码</span>
		{{--  <div class="login-form-codediv">
			<input class="login-form-input login-verification"
			 onBlur="watchInput('login-verification','login-verification-error','prompt-verification','prompt-verification-error','请输入验证码')"
			 onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')"
			 type="text" value="" placeholder="验证码">
			<img class="login-verification-img" src="/img/Verification.png" alt="登陆验证码">
		</div>
		<span class="prompt-verification login-prompt">请输入验证码</span>  --}}
		<div id="tip"></div>
		<div>
			<input id="login_btn" onclick="submit_form()"
			 class="login-form-submit" type="button" value="提&nbsp;&nbsp;&nbsp;交">
		</div>
	</form>
</div>
<script>
// 监听input文本框值的变化
function watchInput(ErrorInput,ErrorInputName,ErrorSpan,ErrorSpanName,ErrorInfo) {
	if($("."+ErrorInput)[0].value == ""){
		addErrorClass("."+ErrorInput,ErrorInputName,"."+ErrorSpan,ErrorSpanName,ErrorInfo);
	}else{
		removeErrorClass("."+ErrorInput,ErrorInputName,"."+ErrorSpan,ErrorSpanName,"check.");
	}
}
function addErrorClass(ErrorInput,ErrorInputName,ErrorSpan,ErrorSpanName,ErrorInfo){
	$(ErrorInput).addClass(ErrorInputName);
	$(ErrorSpan).addClass(ErrorSpanName);
	$(ErrorSpan)[0].innerText = ErrorInfo;
	setTimeout(function(){
		removeErrorClass(ErrorInput,ErrorInputName,ErrorSpan,ErrorSpanName,"check.");
	},2000);
}
function removeErrorClass(ErrorInput,ErrorInputName,ErrorSpan,ErrorSpanName,ErrorInfo){
	$(ErrorInput).removeClass(ErrorInputName);
	$(ErrorSpan).removeClass(ErrorSpanName);
	$(ErrorSpan)[0].innerText = ErrorInfo;
}
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
});


$('input').on('input', function () {
        $(this).val($(this).val().replace(/(^\s+)|(\s+$)/g, ""));
})


function submit_form() {
	if (check()) {
		var data = {name: $('#name').val(), pwd: $('#pwd').val()};
		$.ajax({
			type: 'post',
			data: data,
			success: function (data) {
				if (data.status == 0) {
					location.replace('/' + location.hash);
				} else {
					flashTip(data.msg);
				}
			},
			error: function () {
				flashTip('网络错误，请稍后再试!');
			}
		})
	}

}

	function check() {
		var nameObj = $('#name');
		if (nameObj.val().length == 0) {
			nameObj.focus();
			flashBorder(nameObj.parent('.login-input'));
			return false;
		}
		var pwdObj = $('#pwd');
		if (pwdObj.val().length == 0) {
			pwdObj.focus();
			flashBorder(pwdObj.parent('.login-input'));
			return false;
		}

		return true;
	}
	
	function flashBorder(obj) {
        obj.css('border', '1px solid #ff7575');
        setTimeout(function () {
            obj.css('border', '1px solid #cdcdcd')
        }, 1000);
    }
	function keyLogin(event) {
        if (event.keyCode == 13) {
            submit_form();
        }
    }
	//消息提示
	function flashTip(msg) {
        $('#tip').html(msg);
        setTimeout(function () {
            $('#tip').html('');
        }, 3500);
    }

</script>


<script type="text/javascript" src="/library/js/three.min.js"></script>
<script type="text/javascript">
	var SEPARATION = 100, AMOUNTX = 50, AMOUNTY = 50;

	var container;
	var camera, scene, renderer;

	var particles, particle, count = 0;

	var mouseX = 0, mouseY = 0;

	var windowHalfX = window.innerWidth / 2;
	var windowHalfY = window.innerHeight / 2;

	init();
	animate();

	function init() {

		container = document.createElement( 'div' );
		container.style.cssText = "position: absolute;top: 0;z-index: -1;background-color:#000";
		document.body.appendChild( container );

		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 10000 );
		camera.position.z = 1000;

		scene = new THREE.Scene();

		particles = new Array();

		var PI2 = Math.PI * 2;
		var material = new THREE.ParticleCanvasMaterial( {
			color: 0xffffff,
			program: function ( context ) {

				context.beginPath();
				context.arc( 0, 0, 1, 0, PI2, true );
				context.fill();

			}

		} );

		var i = 0;

		for ( var ix = 0; ix < AMOUNTX; ix ++ ) {

			for ( var iy = 0; iy < AMOUNTY; iy ++ ) {

				particle = particles[ i ++ ] = new THREE.Particle( material );
				particle.position.x = ix * SEPARATION - ( ( AMOUNTX * SEPARATION ) / 2 );
				particle.position.z = iy * SEPARATION - ( ( AMOUNTY * SEPARATION ) / 2 );
				scene.add( particle );

			}

		}

		renderer = new THREE.CanvasRenderer();
		renderer.setSize( window.innerWidth, window.innerHeight );
		container.appendChild( renderer.domElement );

		document.addEventListener( 'mousemove', onDocumentMouseMove, false );
		document.addEventListener( 'touchstart', onDocumentTouchStart, false );
		document.addEventListener( 'touchmove', onDocumentTouchMove, false );

		//

		window.addEventListener( 'resize', onWindowResize, false );

	}

	function onWindowResize() {

		windowHalfX = window.innerWidth / 2;
		windowHalfY = window.innerHeight / 2;

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	//

	function onDocumentMouseMove( event ) {

		mouseX = event.clientX - windowHalfX;
		mouseY = event.clientY - windowHalfY;

	}

	function onDocumentTouchStart( event ) {

		if ( event.touches.length === 1 ) {

			event.preventDefault();

			mouseX = event.touches[ 0 ].pageX - windowHalfX;
			mouseY = event.touches[ 0 ].pageY - windowHalfY;

		}

	}

	function onDocumentTouchMove( event ) {

		if ( event.touches.length === 1 ) {

			event.preventDefault();

			mouseX = event.touches[ 0 ].pageX - windowHalfX;
			mouseY = event.touches[ 0 ].pageY - windowHalfY;

		}

	}

	//

	function animate() {

		requestAnimationFrame( animate );

		render();


	}

	function render() {

		camera.position.x += ( mouseX - camera.position.x ) * .05;
		camera.position.y += ( - mouseY - camera.position.y ) * .05;
		camera.lookAt( scene.position );

		var i = 0;

		for ( var ix = 0; ix < AMOUNTX; ix ++ ) {

			for ( var iy = 0; iy < AMOUNTY; iy ++ ) {

				particle = particles[ i++ ];
				particle.position.y = ( Math.sin( ( ix + count ) * 0.3 ) * 50 ) + ( Math.sin( ( iy + count ) * 0.5 ) * 50 );
				particle.scale.x = particle.scale.y = ( Math.sin( ( ix + count ) * 0.3 ) + 1 ) * 2 + ( Math.sin( ( iy + count ) * 0.5 ) + 1 ) * 2;

			}

		}

		renderer.render( scene, camera );

		count += 0.1;

	}
</script>

<div style="text-align:center;margin:1px 0; font:normal 14px/24px 'MicroSoft YaHei';color:#ffffff;opacity: 0.9;">
<p>软件工程——银行管理系统 &nbsp;&nbsp;&nbsp;&nbsp; 开发团队：zcl、ls、yyb、ly</p>
</div>
</body>
</html>