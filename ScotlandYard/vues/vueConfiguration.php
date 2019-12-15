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
	<link href="css/configForm.css" rel="stylesheet" media="all" type="text/css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<?php include('static/header.php'); ?>
	<?php include('static/menu.php'); ?>
    <!--<div id="divCentral">-->
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		<main>
			<!--<form id="config" method="post" action="index.php?page=jouer"> -->
			<?php if(!isset($_SESSION)) session_start();?>
			<!--<form id="config" method="post" action="" >
				<label for="prenom">Prenom: </label>
				<input type="text" name="prenom" id="prenom" placeholder="saisir votre nom" required />
				<br/><br/>
				<label for="nbDetects">Nombre de détectives: </label>
				<input type="number" name="nbDetects" id="nbDetects" placeholder="entre 3 et 5" required>
				<br/><br/>
				<label for="strategie">STRATEGIE Basique: </label>
				<input type="radio" name="strategie" value="basique">
				<br/><br/>
			    <label for="strategie">STRATEGIE Econome: </label>
			    <input type="radio" name="strategie" value="econome">
			    <br/><br/>
			    <label for="stragie">STRATEGIE Pistage: </label>
			    <input type="radio" name="strategie" value="pistage">
			    <br/><br/>
				<button type="submit" id="submit" name="boutonValider" disabled><i class="fa fa-play-circle fa-4x"></i></button>
			</form>-->
			<div class="configFormPic" style="background-image: url('img/mapLyon3.jpg');">
				<div class="wrap-configForm">
					<span class="config-form-title">
						Nouvelle Partie
					</span>
					<form class="config-form" id="config" method="post" action="" >

						<div class="wrap-configForm">
							<input class="input" type="text" name="prenom" id="prenom" placeholder="saisir votre nom" required >
							<input class="input" type="email" name="email" id="email" placeholder="saisir addresse mail" required>
							<input class="input" type="number" name="nbDetects" id="nbDetects" placeholder="entrez nombre de détectives (3-5)" required>
							<label for="strategie">Strategie Basique 
								<input class="input" type="radio" name="strategie" value="basique">
							</label>
							<label for="strategie">Strategie Econome 
								<input class="input" type="radio" name="strategie" value="econome">
							</label>
							<label for="stragie">Strategie Pistage
								<input class="input" type="radio" name="strategie" value="pistage">
							</label>
						</div>
						<div class="container-config-form-btn">
							<button type="submit" id="submit" name="boutonValider" disabled>
								<i class="fa fa-play-circle fa-4x"></i>
							</button>
						</div>

					</form>
				</div>
			</div>
		</main>
	<!--</div>-->
	<?php include('static/footer.php'); ?>
</body>
<script>
	const configForm = document.getElementById('config');
	const nbDetectsField = document.getElementById('nbDetects');
	const submit = document.getElementById('submit');  
	const prenomField = document.getElementById('prenom');
	
	nbDetectsField.addEventListener('input', function (event) 
	{  
	  if ( nbDetectsField.value >= 3 && nbDetectsField.value <= 5 && prenomField.value.length > 0) 
	  {
		submit.disabled = false;
	  } 
	  else 
	  {
		submit.disabled = true;
	  }
	});
	
	prenomField.addEventListener('input', function (event) 
	{  
	  if ( nbDetectsField.value >= 3 && nbDetectsField.value <= 5 && prenomField.value.length > 0) 
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






