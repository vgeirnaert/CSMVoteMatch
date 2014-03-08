<?php include 'header.php'; 
require_once '../../../configs/votematch/eve_vm.php';
?>

<div class="row inverted rounded">
	<h1>Caniddate login</h1>
</div>
<br>
<div class="row rounded">
	<h1>Login</h1>
	<?php
	if(Config::can_edit) {
	?>
	Are you a candidate in the CSM elections but do not have login information? Please contact <a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal">Dierdra Vaal</a> to request it!<br/><br/>
	<form method="post" action="processlogin.php" name="loginform">
	<div class="span12">
		<div class="span2">
			Character name
		</div>
		<div class="span4">
			<input type="text" name="username">
		</div>
	</div>
	<div class="span12">
		<div class="span2">
			Password
		</div>
		<div class="span4">
			<input type="password" name="password">
		</div>
	</div>
	<input type="Submit" class="btn" onclick="javascript: submitform(); return false;" value="Log in">
	</form>
	<?php
	} else {
	?>
	Elections are over and logging in is disabled!
	<?php
	}
	?>
</div>
<script type="text/javascript">
function submitform() {
	document.loginform.password.value = Sha256.hash(document.loginform.password.value);
	document.loginform.submit();
}
</script>
<script type="text/javascript" src="js/sha256.js"></script>

<?php include 'footer.php'; ?>