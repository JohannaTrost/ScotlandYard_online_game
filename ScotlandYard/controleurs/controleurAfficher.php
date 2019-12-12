<?php 
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

// recupération des séries

/*
** À vous de jouer : lister les critiques en vous inspirant du code ci-dessus.
** Vous pourrez plus tard améliorer le code en affichant chaque série avec les
** critiques qui la concernent !
*/


// recupération des Quartiers
$requete = "SELECT idQ, nomQ, nomCommune, typeQ FROM Quartiers";
$quartiers = mysqli_query($connexion, $requete);
if($quartiers == FALSE) {
	$message .= "Aucune actrice n'a été trouvée dans la base de données !";
}




?>
			

		</main>
	</div>
    <?php include('static/footer.php'); ?>
</body>
<script src="js/correction.js" charset="utf-8"></script>
<script src="js/messages.js" charset="utf-8"></script>
</html>