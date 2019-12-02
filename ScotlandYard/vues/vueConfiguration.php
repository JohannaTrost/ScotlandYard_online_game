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
		<main>
			<!--<form id="config" method="post" action="index.php?page=jouer"> -->
			<form id="config" method="post" action="#">
				<label for="prenom">Prenom: </label>
				<input type="text" name="prenom" id="prenom" placeholder="saisir votre nom" required />
				<br/><br/>
				<label for="nbDetects">Nombre de détectives: </label>
				<input type="number" name="nbDetects" id="nbDetects" placeholder="entre 3 et 5" required>
				<br/><br/>
				<input type="submit" id="submit" name="boutonValider" value="OK" disabled />
				<a href="https://bdw1.univ-lyon1.fr/p1925142/ScotlandYard/index.php?page=jouer" target="_blank"><i class="fa fa-play-circle fa-2x"></i></a>
			</form>
			
		</main>
	</div>
	<?php include('static/footer.php'); ?>
</body>
<script>
	const configForm = document.getElementById('config');
	const nbDetectsField = document.getElementById('nbDetects');
	const submit = document.getElementById('submit');  
	nbDetectsField.addEventListener('keyup', function (event) 
	{  
	  if ( nbDetectsField.value >= 3 && nbDetectsField.value <= 5 ) 
	  {
		submit.disabled = false;
	  } 
	  else 
	  {
		submit.disabled = true;
	  }
	});
	  
	submit.addEventListener('click', function (event) {
	  configForm.submit();
	});
</script>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>






