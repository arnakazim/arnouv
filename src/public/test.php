<!DOCTYPE html>
<html lang="en">
  <head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Arnaud Ouvrier</title>
	<link rel="icon" href="img/favicon.ico" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body data-spy="scroll" data-target="#navbar" data-offset="54">
	<nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar-light bg-light hidden">
		<div class="container-fluid">
			<a class="navbar-brand" href="#home">
				<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
				Arnaud Ouvrier
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="#about">About</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#resume">Resume</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#contact">Contact me</a>
					</li>
				</ul>
				<span class="navbar-text">
					<a href="#"><i class="fa fa-linkedin"></i></a>&ensp;
					<a href="#"><i class="fa fa-github"></i></a>&ensp;
					<a href="#"><i class="fa fa-twitter"></i></a>
				</span>
			</div>
		</div>
	</nav>
	

<?php
$page = json_decode(file_get_contents('json/index.json'));
$lang = $page->conf->languages->default;


foreach($page->sections as $name => $section) {

	

	echo '<section id="' . $name . '">';

	if($section->type == "parallax") {
		?>
		
		<div class="home-parallax">
		<div class="home-parallax-content container">
			<div class="row">
				<div class="home-parallax-header col-12 text-center">
					<h1 class="home-parallax-title"><?= $section->content->header->title->{$lang} ?></h1>
					<p class="home-parallax-subtitle"><?= $section->content->header->subtitle->{$lang} ?></p>
				</div>
			</div>
		</div>
		<div class="home-parallax-bg" style="background-image: url('<?= $section->backgroundImage ?>');"></div>
	</div>
		
		
		<?php
	}

	else {
		?>
		
		<div class="container">
		<div class="row justify-content-center section-header">
			<div class="col-md-8 text-center">
				<h2 class="section-title"><?= $section->content->header->title->{$lang} ?></h2>
				<p class="lead"><?= $section->content->header->subtitle->{$lang} ?></p>
			<?php 
				if(!empty($section->content->header->button)): 
				$btn = $section->content->header->button;
			?>
				<p class="section-button"><a href="<?= $btn->link->{$lang} ?>" class="btn btn-<?= $btn->type ?>" download><i class="<?= $btn->icon ?>"></i>&ensp;<?= $btn->text->{$lang} ?></a></p>
			<?php endif; ?>
			</div>
				</div></div>

			<?php

					if($section->type == "tiles") {


						echo '<div class="container-fluid tile-container"><div class="row">';

						foreach($section->content->body as $body) {
							if($body->type == "tile") {

								?>
								
								
								<div class="col-md-<?= $body->cols ?> tile" style="background-color:<?= $page->conf->colors->{$body->color} ?>">
									<h3 class="tile-title"><?= $body->title->{$lang} ?></h3>
									<?php foreach ($body->content as $tileContent): 
									if ($tileContent->type == "imgFluid"): ?>
									<img class="img-fluid tile-picture" src="<?= $tileContent->image ?>" alt="<?= $tileContent->alt->{$lang} ?>" style="border-color:<?= $page->conf->colors->{$tileContent->borderColor} ?>">
									

									<?php elseif ($tileContent->type == "text"): ?>
									<p class="tile-text"><?= $tileContent->text->{$lang} ?></p>
									<?php endif; ?>
									
									
									<?php endforeach; ?>
								</div>
								
								
								<?php

							}

						}


						echo '</div></div>';

					}


				

			?>
			
		</div>
	</div>
		
		
		<?php
	}

	echo '</section>';

}






?>






	<footer class="footer bg-light text-center">
		<span class="text-muted">
			&copy; 2017 &ndash; Arnaud Ouvrier<br>
			<span class="small">
				Made with 
				<span class="text-danger"><i class="fa fa-heart"></i></span> 
				by myself &#128521;
			</span>
		</span>
	</footer>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="js/animate.js"></script>
  </body>
</html>
