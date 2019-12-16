<!DOCTYPE html>
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
	<div>
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		
		
		<?php $nbJoueuses = mysqli_fetch_assoc($nbJ)?>
		<p>Nombre total de Joueuses: <?= $nbJoueuses['nbJ'] ?> </p>
		
		<?php $nbQuartiers = mysqli_fetch_assoc($nbQ)?>
		<p>Nombre de Quartiers: <?= $nbQuartiers['nbQ'] ?> </p>
		
		
		<?php $nbCommunes = mysqli_fetch_assoc($nbC)?>
		<p>Nombre de Communes: <?= $nbCommunes['nbC'] ?> </p>
		
		<?php $nb = mysqli_fetch_assoc($nbP)?>
		<p>Nombre de Partie: <?= $nb['nbP'] ?> </p>
		
		<?php $nbDepartements = mysqli_fetch_assoc($nbD)?>
		<p>Nombre de Departements: <?= $nbDepartements['nbD'] ?> </p>
        

        	<table id="statistiqueTab" border=6 cellspacing=12 cellpadding=2>
				<th >liste des meilleurs scores</th>
			<?php while ($par= mysqli_fetch_assoc($maxGagnants)) { ?>
					
					<tr>
						<td><?= $par['nbr_doublon'] ?></td>
						<td><?= $par['nomJ'] ?></td>
					</tr>
			<?php } ?>
		</table>
        <br><br>
		<table id="statistiqueTab" border=6 cellspacing=12 cellpadding=2>
			<th>Voici la liste des gagnant</th>
			<?php while ($participes = mysqli_fetch_array($idG)) { ?>
					
					<tr>
				        <td><?= $participes['idPartie'] ?></td>
						<td><?= $participes['nomJ'] ?></td>
					</tr>
			<?php } ?>
		</table>
		<br><br>
		<table id="statistiqueTab" border=6 cellspacing=12 cellpadding=2>
				<th>Voici la liste des joueurs</th>
			<?php while ($joueuses = mysqli_fetch_assoc($Joueuses)) { ?>
					
					<tr>
						<td><?= $joueuses['idJ'] ?></td>
						<td><?= $joueuses['nomJ'] ?></td>
					</tr>
			<?php } ?>
		</table>



		
	</div>
	<?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" varchar(255)set="utf-8"></script>
<script src="js/messages.js" varchar(255)set="utf-8"></script>
</html>
