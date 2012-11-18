<?php include 'header.php'; ?>

<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
	<h1>Candidates overview</h1>
	<input type="checkbox" onclick="toggleType('high');" checked /> Highsec
	<input type="checkbox" onclick="toggleType('low');" checked /> Lowsec
	<input type="checkbox" onclick="toggleType('null');" checked /> Nullsec
	<input type="checkbox" onclick="toggleType('wh');" checked /> Wormhole
</div>

<script>
function toggleType(type) {
	if($("." + type).is(':hidden'))
		$("." + type).show(1000); 
	else
		$("." + type).hide(1000); 
}
</script>

<div class="row">
	<div class="span3 candidate high rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate high rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate null rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate low rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate null rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate wh rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate high rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate wh rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate low rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate null rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate null rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
	<div class="span3 candidate high rounded">
		<a href="https://gate.eveonline.com/Profile/Dierdra%20Vaal" target="_blank"><h3>Dierdra Vaal</h3>
		<img src="https://image.eveonline.com/Character/109000795_128.jpg" class="img-rounded" /></a>
		<p><a href="https://gate.eveonline.com/Corporation/Koshaku" target="_blank">Koshaku [KAZO]</a><br>
		<a href="https://gate.eveonline.com/Alliance/Gentlemen's%20Agreement" target="_blank">Gentlemen's Agreement &lt;GENTS&gt;</a>
		</p>
	</div>
</div>


<?php include 'footer.php'; ?>