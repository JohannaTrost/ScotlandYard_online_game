<!DOCTYPE html>
<!-- 
Page d'accueil 
-->
<html>
<head>
    <meta varchar(255)set="utf-8" />
    <title><?= $nomSite ?></title>
    <!-- lie le style CSS externe  -->
    <link href="css/style.css" rel="stylesheet" media="all" type="text/css">
</head>
<body>
	<?php include('static/header.php'); ?>
    <div id="divCentral">
		<?php include('static/menu.php'); ?>
		<?php if(!isset($_SESSION)) session_start(); ?>
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		
		<main>
		
			<?php if($_SESSION['DETECTS_GAGNE'] == true) { ?>
				<p>
					Vous avez gagné !!! </br>
					Vous avez attrapé Mister X dans le quartier <?=$_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']]?>
				</p>
			<?php } else if ($_SESSION['COUNT_TOURS_MISTERX'] == 20) { ?>	
				<p>
					Mister X a gagné la partie.
					</br>
					Il était dans le quartier <?=$_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']]?>
				</p>
			<?php } ?>
			
		</main>
	</div>
	<?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






