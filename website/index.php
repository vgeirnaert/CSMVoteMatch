<?php include 'header.php'; ?>

<div class="hero-unit">
	<h1>Your vote matters!</h1>
	<p class="rounded hero">Vote Match cuts through the campaign clutter and presents an unbiased overview of the candidates in this CSM election and their positions. Want to know how to get the most out of Vote Match? <a href="faq.php#most">Click here!</a></p>

</div>

<div class="row rounded">
	<div class="span4 frontblurb">
		<h2><a href="survey.php">Get started!</a></h2>
		<p>Unsure which candidate to vote for? Take our survey of statements about Eve Online and see how your vision for Eve matches up with the vision of the candidates in the coming CSM election. </p>
		<p><a class="btn" href="survey.php">Get started &raquo;</a></p>
	</div>
	<div class="span4 frontblurb">
		<h2><a href="candidates.php">Candidates overview</a></h2>
		<p>Vote Match allows all candidates to set up a profile with their contact details, their campaign message and any experience they have that is relevant to their candidacy, explaining why they should get your vote. Go here to browse the profiles of the CSM candidates.</p>
		<p><a class="btn" href="candidates.php">View candidates &raquo;</a></p>
   </div>
	<div class="span4 frontblurb">
		<h2><a href="compare.php">Candidate comparison</a></h2>
		<p>Vote Match allows you to compare candidates with eachother for when you just want to see the differences between them. You can filter out on questions and/or candidates just as you can with the survey results to help you focus on the things that are the most important to you.</p>
		<p><a class="btn" href="compare.php">Compare candidates &raquo;</a></p>
	</div>
</div>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Eve Votematch is not yet open</h4>
      </div>
      <div class="modal-body">
        <p>Eve Votematch currently contains example data instead of the actual CSM9 election data because the election period has not yet started and CCP has not officially released a list of candidates for this election. Please keep an eye on our twitter account <a href="https://twitter.com/evevotematch" target="_blank">@EveVotematch</a> or the <a href="https://forums.eveonline.com/default.aspx?g=topics&f=268" target="_blank">official Eve Online forums</a> to be notified when Eve Votematch goes live for the CSM9 elections.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">I understand</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
setTimeout(function() {
	$('#myModal').modal({backdrop: true, show: true});
	}, 1000);
</script>

<?php include 'footer.php'; ?>