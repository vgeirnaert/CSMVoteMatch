<?php
if(!isset($pagetitle))
	$pagetitle = "CSM Vote Match 2.0";
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $pagetitle; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.css">
		<link rel="icon" type="image/png" href="favicon32.png">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		<script src="js/vendor/jquery-1.8.2.min.js"></script>
        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/opentip.css">
    </head>
    <body id="body">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
		<noscript><div class="warning inverted">
			<img src="img/warning.png" />
			Javascript needs to be enabled in order for this website to function!
			<img src="img/warning.png" />
		</div></noscript>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="index.php" class="brand">Vote Match 2.0</a></li>
                            <li><a href="survey.php">Which candidate represents you?</a></li>
                            <li><a href="candidates.php">Candidates overview</a></li>
							<li><a href="compare.php">Candidate comparison</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Help & FAQ<b class="caret"></b></a>
                                <ul class="dropdown-menu">
									<li class="nav-header">FAQ</li>
                                    <li><a href="faq.php#about">What is this website about?</a></li>
									<li><a href="faq.php#care">Why should I care about the CSM?</a></li>
                                    <li><a href="faq.php#matching">How does matching work?</a></li>
                                    <li><a href="faq.php#trust">How do I know I can trust this website?</a></li>
									<li><a href="faq.php#who">Who runs this website?</a></li>
									<li><a href="faq.php#candidates">Are all candidates on this website?</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Help</li>
									<li><a href="faq.php#most">How to get the most out of Vote Match</a></li>
                                    <li><a href="faq.php#candidate">I am a candidate, how do I make my profile?</a></li>
									<li><a href="faq.php#voter">I am a voter, how do I decide who to vote for?</a></li>
									<li><a href="faq.php#contact">How do I contact the Vote Match admin?</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container contents rounded">