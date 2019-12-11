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
    <div id="divCentral">
		<?php include('static/menu.php'); ?>
		<?php if(!isset($_SESSION)) session_start(); ?>
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		
		<p>Ton quartier de depart: <?= $_SESSION['QUARTIERS_DEPART']['noms'][0] ?> <br/>
		    
		   Les autres detectives sont dans les quartiers: <br/>
														  <?php
		                                                    for($i=1; $i < $_SESSION['NUM_DETECTS']; $i++)
															{
																echo $_SESSION['QUARTIERS_DEPART']['noms'][$i] . "<br>";
															}
														   ?>
		</p>
		<main>
			<form method="post" action="">
				<p>Choisisez votre destination:</p>
				
				<!-- foreach ($arriveesJoueuse[1] as &$arrivee) { -->
				<?php for ($i=0; $i < sizeof($arriveesJoueuse['noms'])-1; $i++) {?>
				
					<input type="radio" name="arrivee" value=<?=$arriveesJoueuse['ids'][$i], str_replace(' ', '&nbsp;', $arriveesJoueuse['noms'][$i])?>> <?=str($arriveesJoueuse['noms'][$i])?> en <?=str($arriveesJoueuse['transports'][$i])?><br>
				  
				<?php } ?>
				<input type="submit" id="submit" name="boutonValider" value="Soumettre">
			</form>	
			<p>
			<?php 
				  echo $_SESSION['COUNT_TOURS_MISTERX'] . "eme tour de mister X"; 
				  if($_SESSION['DETECTS_GAGNE'] == true) {
					echo "Vous avez gagné la partie";
			      	session_destroy(); 
			      }
				  else if($_SESSION['COUNT_TOURS_MISTERX'] == 20) {
					echo "Mister X a gagné la partie";
			      	session_destroy(); 
				  }
			?>
			</p>
		</main>
	</div>
	<?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






