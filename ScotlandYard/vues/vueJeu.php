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
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		
		<p>Ton quartier de depart: <?= $quartierDetectsDepart[1][0] ?> <br/>
		    
		   Les autres detectives sont dans les quartiers: <br/>
														  <?php
		                                                    for($i=1; $i < $numDetects; $i++)
															{
																echo $quartierDetectsDepart[1][$i] . "<br>";
															}
														   ?>
		</p>
		<form action="/action_page.php">
			<p>Choisisez votre destination:</p>
			
			<?php foreach ($arriveesJoueuse[1] as &$arrivee) {?>
			
				<input type="radio" name="arrivee" value=<?=$arrivee?>> <?=$arrivee?><br>
			  
			<?php } ?>
			<input type="submit" value="Soumettre">
		</form>
		<main>
			<!--<form id="config" method="post" action="index.php?page=jouer"> -->
			<form id="config" method="post" action="#">
				<input type="submit" id="submit" name="boutonValider" value="OK" />
			</form>
			
		</main>
	</div>
	<?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






