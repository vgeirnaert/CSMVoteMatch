<?php 
ini_set('session.gc_maxlifetime', 20800);
session_start();

if(isset($_SESSION["cdata"])) {
	$cdetails = $_SESSION["cdata"];
	
	$pagetitle = "Edit " . $cdetails["charname"];

	include 'header.php'; 
?>
<div class="row inverted rounded">
	<h1>Edit candidate answers for: <?php echo $cdetails["charname"]; ?></h1>
</div>
<br>
<div class="row rounded">
	<form name="candidatedetails" method="post" action="processcandidate.php">
	<div class="span11 coverview rounded">
		<a href="editanswers.php" class="btn btn-large btn-primary">&laquo; Click here to set or change your answers to the questionnaire</a>
		<a href="processlogin.php" class="btn btn-large btn-danger pull-right">Log out</a>
		<br><b>Notice:</b> We recommend <i>saving your progress every 30 minutes or so</i> to avoid session timeout. You'll be able to continue where you left off afterwards. We apologise for the inconvenience.
	</div>
	<div class="span5 coverview rounded pull-right">
		<img src="https://image.eveonline.com/Character/<?php echo $cdetails["charid"]; ?>_512.jpg" />
	</div>
	
	<div class="span6 coverview rounded">
		<h2>In Eve Online</h2>
		<div class="span6">
			<div class="span2">
				Character name
			</div>
			<div class="span4 bold">
				<a href="https://gate.eveonline.com/Profile/<?php echo $cdetails["charname"]; ?>" target="_blank"><?php echo $cdetails["charname"]; ?></a>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Corporation
			</div>
			<div class="span4 bold">
				<a href="https://gate.eveonline.com/Corporation/<?php echo $cdetails["corpname"]; ?>" target="_blank"><?php echo $cdetails["corpname"]; ?></a>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Alliance
			</div>
			<div class="span4 bold">
				<a href="https://gate.eveonline.com/Alliance/<?php echo $cdetails["alliancename"]; ?>" target="_blank"><?php echo $cdetails["alliancename"]; ?></a>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				CSM experience
			</div>
			<div class="span4">
				<?php 
					$csm = $cdetails["csm"];
					if(count($csm) > 0) {
						for($i = 0; $i < count($csm); $i++) {
							echo "CSM" . $csm[$i] . ", ";
						}
					} else {
						echo "None";
					}					
				?>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Playing since
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["played"]; ?>" name="playsince" placeholder="YYYY-MM-DD">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				You fly most in
			</div>
			<div class="span4 bold">
				<select name="playspace" class="span3">
					<option value="1" <?php if($cdetails["flies"] == "high") echo "selected";?>>High sec</option>
					<option value="2" <?php if($cdetails["flies"] == "low") echo "selected";?>>Low sec</option>
					<option value="3" <?php if($cdetails["flies"] == "null") echo "selected";?>>0.0</option>
					<option value="4" <?php if($cdetails["flies"] == "wh") echo "selected";?>>W-space</option>
				</select>
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Your <i>main</i> playstyle is
			</div>
			<div class="span4 bold">
				<select name="playstyle" class="span3">
					<option value="1" <?php if($cdetails["playstyle"] == "pvp") echo "selected";?>>PvP (solo combat, fleet ops, etc)</option>
					<option value="2" <?php if($cdetails["playstyle"] == "pve") echo "selected";?>>PvE (missions, exploration, ratting, etc)</option>
					<option value="3" <?php if($cdetails["playstyle"] == "ind") echo "selected";?>>Industry (mining, manufacturing, trading, etc)</option>
					<option value="4" <?php if($cdetails["playstyle"] == "ldr") echo "selected";?>>Leadership (corp/alliance managment, etc)</option>
					<option value="5" <?php if($cdetails["playstyle"] == "meta") echo "selected";?>>Metagaming (scamming, espionage, etc)</option>
					<option value="6" <?php if($cdetails["playstyle"] == "oth") echo "selected";?>>Other</option>
				</select>
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>In real life</h2>
		<div class="span6">
			<div class="span2">
				Name
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realname"]; ?>" name="rlname">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Location
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realloc"]; ?>" name="rllocation">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Occupation
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realocc"]; ?>" name="rljob">
			</div>
		</div>
		<div class="span6">
			<div class="span2">
				Age
			</div>
			<div class="span4 bold">
				<input type="text" value="<?php echo $cdetails["realage"]; ?>" name="rlage">
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>Campaign statement</h2>
		<textarea style="width: 95%" rows="10" name="campaign"><?php echo $cdetails["statement"]; ?></textarea>
	</div>
	<div class="span5 coverview rounded pull-right">
		<h2>Contact information</h2>
		<i>Note: URLs must start with http:// or https://</i></br>
		<div class="span5">
			<div class="span2">
				Website URL
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["website"]; ?>" placeholder="http://" name="url">
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Twitter name
			</div>
			<div class="span3">
				@<input type="text" value="<?php echo $cdetails["twitter"]; ?>" name="twitter">				
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Campaign thread URL
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["thread"]; ?>" name="thread" placeholder="http://">
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Can users evemail you
			</div>
			<div class="span3 bold">
				<label for="evemail" class="checkbox"><input type="checkbox" id="evemail" <?php if($cdetails["bevemail"]) echo 'checked'; ?> name="canevemail">Yes</label>
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Can users convo you
			</div>
			<div class="span3 bold">
				<label for="convo" class="checkbox"><input type="checkbox" id="convo" <?php if($cdetails["bconvo"]) echo 'checked'; ?> name="canconvo">Yes</label>
			</div>
		</div>
		<div class="span5">
			<div class="span2">
				Public email address
			</div>
			<div class="span3">
				<input type="text" value="<?php echo $cdetails["email"]; ?>" name="email">				
			</div>
		</div>
	</div>
	<div class="span6 coverview rounded">
		<h2>Experience in Eve</h2>
		<textarea style="width: 95%" rows="10" name="eveexp"><?php echo $cdetails["eveexp"]; ?></textarea>
	</div>
	<div class="span5 coverview rounded pull-right">
		<h2>Real life experience</h2>
		<textarea style="width: 95%" rows="10" name="rlexp"><?php echo $cdetails["realexp"]; ?></textarea>
	</div>

	<div class="span11 coverview rounded">
		<h2>Questions</h2>
		<?php
			$questions = $cdetails["questions"];
			
			for($i = 0; $i < count($questions); $i++) {
				$qtuple = $questions[$i];
				
				echo '<h3>' . $qtuple["question"] . '</h3>';
				echo '<textarea style="width: 95%" rows="5" name="question_' . $qtuple["qid"] . '">';
				echo $qtuple["answer"];
				echo '</textarea>';
			}
		?> 
		
	</div>
	<div class="span11 coverview rounded">
		<a href="#" style="font-size:30px; line-height: 60px;" class="btn btn-warning pull-right" onclick="javascript: submitform(); return false;">Submit changes</a>
	</div>
	</form>
</div>
<script type="text/javascript">
function submitform() {
	var errorString = "";
	
	if(invalidDate(document.candidatedetails.playsince.value))
		errorString += "'Playing since' input (" + document.candidatedetails.playsince.value + ") is incorrect (required date format is YYYY-MM-DD)\n\n";
		
	if(invalidAge(document.candidatedetails.rlage.value))
		errorString += "'Age' input (" + document.candidatedetails.rlage.value + ") is incorrect. Please input whole numbers only\n\n";
		
	if(errorString.length == 0)
		document.candidatedetails.submit();
	else
		alert(errorString + "Please provide correct input and submit again.");
}

function invalidDate(date) {
	var datepattern = new RegExp("^20\\d\\d-\\d\\d-\\d\\d$", "gi");
	return !datepattern.test(date)
}

function invalidAge(age) {
	var datepattern = new RegExp("^\\d+$", "gi");
	return !datepattern.test(age)
}
</script>
<?php	
	include 'footer.php'; 
}
?>