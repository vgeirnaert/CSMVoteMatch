<?php include 'header.php'; ?>

<!-- Main hero unit for a primary marketing message or call to action -->
<div class="row inverted">
	<h1>Candidates overview</h1>
	<a class="btn pull-right" href="#" onclick="toggleFilterButton();">Hide filters</a>
	<div class="span9 filters">
		<h2>Filters</h2>
		<div class="span2">
			<h4>Location</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="high" /> Highsec<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="low" /> Lowsec<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="null" /> Nullsec<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="wh" /> Wormhole
		</div>
		<div class="span2">
			<h4>CSM Experience</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="csm" /> Former CSM<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="nocsm" /> No CSM experience
		</div>
		<div class="span2">
			<h4>Time in Eve</h4>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="lt1" /> less than 1 year<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="1t2" /> 1-2 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="2t3" /> 2-3 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="3t4" /> 3-4 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="4t5" /> 4-5 years<br>
			<input type="checkbox" onclick="toggleCandidateVisibility();" checked value="mt5" /> more than 5 years
		</div>
	</div>
</div>
<script src="js/candidates.js"></script>
<br>
<div class="row">
	<div class="span4 candidate high nocsm lt1 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 1</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate high csm 1t2 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 2</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate null nocsm 2t3 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 3</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate low nocsm 3t4 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 4</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate null nocsm 4t5 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 5</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate wh nocsm mt5 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 6</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate high nocsm mt5 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 7</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate wh csm 4t5 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 8</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate low nocsm 3t4 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 9</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate null nocsm 2t3 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 10</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate null nocsm 1t2 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 11</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span4 candidate high nocsm lt1 rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal 12</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
</div>


<?php include 'footer.php'; ?>