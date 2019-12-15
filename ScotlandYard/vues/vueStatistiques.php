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
		
		<?php $nbDepartements = mysqli_fetch_assoc($nbD)?>
		<p>Nombre de Departements: <?= $nbDepartements['nbD'] ?> </p>
		
		<table id="statistiqueTab">
			<?php while ($joueuses = mysqli_fetch_assoc($Joueuses)) { ?>
					<tr>
						<th>id</th>
						<th>Joueuse</th>
					</tr>
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
