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
    <div id="divCentral">
		<?php include('static/menu.php'); ?>
		<main>
			<div class="to-delete" style="background-color: yellow;">Pour un peu d'aide et des encouragements, vous devriez ouvrir la console web de votre navigateur.</div>
			
			<div class="to-delete">Une page quasi vide et non MVC. Il y a du boulot pour donner envie de visiter le site !</div>
			<p> 
				Description du jeu
			</p>
			
		</main>
	</div>
    <?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






