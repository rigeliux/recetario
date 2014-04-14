<!doctype html>
<html>
<head>
<meta charset="utf-8">
<base href="<?php echo base_url() ?>" class="sitebase">
<title><?=$titulo.$siteName?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<link rel="stylesheet" href="assets/css/jquery-ui/jquery-ui-1.10.0.custom.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/loading.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<?php echo registred_css($css); ?>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/helpers.css">
</head>

<body role="document">
<div id="hs-source"><div class="load-async-cont"></div></div>
<div class="loading first-loading" style="width:100%; height:100%;"></div>

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Bootstrap theme</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>

<div class="container">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="jumbotron">
		<h1>Ahoy Mate!</h1>
		<p>Bienvenido a a este tu recetario pirrrrata, abajo podrás ver una lista de las diferentes recetas.</p>
	</div>
</div>

<div class="container theme-showcase" role="main">