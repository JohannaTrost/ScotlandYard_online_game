<?php 
$connexion = getConnexionBD(); // connexion à la BD

if(isset($_POST['boutonValider'])) { // formulaire soumis
	
	// recuperation des valeurs saisies
	$prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
	$nbDetectives = mysqli_real_escape_string($connexion, $_POST['nbDetects']);
	
	// gérér la joueuse
	$requete = "SELECT * FROM Joueuses WHERE nomJ = ('". $prenom . "')";
	$verification = mysqli_query($connexion, $requete);

	if($verification == FALSE || mysqli_num_rows($verification) == 0) { // pas de joueuse avec ce nom, insertion
		$requete = "INSERT INTO Joueuses (nomJ) VALUES ('". $prenom . "')";
		$insertion = mysqli_query($connexion, $requete);
		if($insertion == TRUE) {
			$message = "La joueuse $prenom a bien été ajoutée !";
		}
		else {
			$message = "Erreur lors de l'insertion de la joueuse $prenom.";
		}
	}
	$requete = "INSERT INTO Partie (nbDetectives) VALUES ('". $nbDetectives . "')";
	$insertion = mysqli_query($connexion, $requete);
	if($insertion == TRUE) {
		$message = "La nombre des detectives $nbDetectives a bien été ajoutée dans la nouveau partie !";
	}
	else {
		$message = "Erreur lors de l'insertion de la nombre des detectives $nbDetectives.";
	}

}
?>
