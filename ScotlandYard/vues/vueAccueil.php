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
    <!-- ajoute une Image favicon (dans l'onglet du navigateur) -->
    <link rel="shortcut icon" type="Image/x-icon" href="img/sheep.png" />
	
</head>
<body>
    <?php include('static/header.php'); ?>
	<?php include('static/menu.php'); ?>
    <div id="divCentral">
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		<main>
			<?php include('dataMigration.php')?>

			<p> <img src="img/mapLyon3.jpg">
				Attrapez le gangster Mister X ! </br> Un gangster est en liberté à Lyon. 
				Vous pouvez être l'inspecteur qui l'attrape. Avec 2 à 4 autres détectives, vous pouvez partir à la recherche et suivre Mister X à Lyon. 
				Vous serez répartis dans différentes parties de la ville et pourrez vous déplacer en bus, en taxi ou en métro. 
				Heureusement, vos collègues ont pu découvrir quels moyens de transport Mister X utilise, mais malheureusement il n'y a pas encore 
				d'autres indices, n'est-ce pas ? </br> Mais faites attention pendant la poursuite au nombre de billets qu'il vous reste.  
				Commencez la chasse immédiatement et testez différentes stratégies de jeu pour encore plus de plaisir !
			</p>
			<form method="post" action="index.php?page=jouer-maintenant">
				<input type=submit id="playnow" name="buttonConfig" value="PLAY">
			</form>
		</main>
	</div>
    <?php include('static/footer.php'); ?>
</body>

<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






