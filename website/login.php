<?php include 'header.php'; ?>

<div class="row inverted rounded">
	<h1>Caniddate login</h1>
</div>
<br>
<div class="row rounded">
	<h1>Login</h1>
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
</div>
<script type="text/javascript">
function submitform() {
	document.loginform.password.value = Sha256.hash(document.loginform.password.value);
	document.loginform.submit();
}
</script>
<script type="text/javascript" src="js/sha256.js"></script>

<?php include 'footer.php'; ?>