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
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<?php include('static/header.php'); ?>
	<?php include('static/menu.php'); ?>
    <div id="divCentral">
		<?php if(!isset($_SESSION)) session_start(); ?>
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		<main>
			<p>Ton quartier de depart: <?= $_SESSION['QUARTIERS_DEPART']['noms'][0] ?> <br/>
				
			   Les autres detectives sont dans les quartiers: <br/>
															  <?php
																for($i=1; $i < $_SESSION['NUM_DETECTS']; $i++)
																{
																	echo $_SESSION['QUARTIERS_DEPART']['noms'][$i] . "<br>";
																}
															   ?>
			</p>
			<p>
				<?php 
				// affiche position de mister X si on est dans la tour 3, 8, 13 ou 18 
				if($_SESSION['STRATEGIE'] == "pistage")
				{ 
					if(in_array($_SESSION['COUNT_TOURS_MISTERX'], array(3, 8, 13, 18, 20)) || $_SESSION['DETECTS_GAGNE'] == true)
					{?>
						Mister X se trouve dans le quartier	<?= $_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']] ?> <br/>
			  <?php } ?>
					Le meilleur chemin pour trouver Mister x est ... <br/>
			        <?=$plusCourtChemin[1]['nom'] ?> <br/> 
		  <?php } 
				if($_SESSION['COUNT_TOURS_MISTERX'] > 0)
				{?>
					Mister X a utilisé le <?=$routeMisterX?> </br>
				<?php } ?>
			</p>
			<form method="post" action="">
				<p>Choisisez votre destination:</p>
				
				<!-- foreach ($arriveesJoueuse[1] as &$arrivee) { -->
				<?php for ($i=0; $i < sizeof($arriveesJoueuse['noms']); $i++) {?>
				
					<input type="radio" name="arrivee" value=<?=$arriveesJoueuse['ids'][$i], str_replace(' ', '&nbsp;', $arriveesJoueuse['noms'][$i])?>> <?=str($arriveesJoueuse['noms'][$i])?> en <?=str($arriveesJoueuse['transports'][$i])?><br>
				  
				<?php } ?>
				<input type="submit" id="submit" name="boutonValider" value="Soumettre">
			</form>	
		</main>
	</div>
	<?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






