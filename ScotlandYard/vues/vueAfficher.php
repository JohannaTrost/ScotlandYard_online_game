<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<!-- le titre du document, qui apparait dans l'onglet du navigateur -->
    <title><?= $nomSite ?></title>
    <!-- lie le style CSS externe  -->
    <link href="css/style.css" rel="stylesheet" media="all" type="text/css">
    <!-- ajoute une image favicon (dans l'onglet du navigateur) -->
    <link rel="shortcut icon" type="image/x-icon" href="img/sheep.png" />
</head>
<body>
    <?php include('static/header.php'); ?>
    <div id="divCentral">
		<?php include('static/menu.php'); ?>
		<main>

			
			<h2>Tableau Quartier :</h2>
			<table >
			<thead>

				<th>ID Quartier</th>
				<th>Nom Quartier</th>
				<th>Nom Ville</th>
				</thead>>
				
			<?php for($i=0;$i<40;$i++) { ?>
				<tbody >

				  <?php  for($j=0;$j<5;$j++){ ?>
				        <?php $quartier = mysqli_fetch_array($quartiers) ?>
			            <th id="tabor">				 		
				 	 	<?= $quartier['idQ']?>
				 	 	</th>
				 	 	 <th id="tabor">				 		
				 	 	<?= $quartier['nomQ']?>
				 	 	</th>
				 	 	 <th id="tabor">				 		
				 	 	<?= $quartier['nomCommune']?>
				 	 	</th>
				 	 	

  <?php } 	?>				</tbody>;
<?php } 	?>	
				
  ?>	 
</table>
	</div>
    <?php include('static/footer.php'); ?>
</main>
</div>
</body>
<script src="js/correction.js" charset="utf-8"></script>
<script src="js/messages.js" charset="utf-8"></script>
</html>

