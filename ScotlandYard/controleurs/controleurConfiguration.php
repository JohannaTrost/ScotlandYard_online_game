<?php 
include('static/outilsJeu.php');
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
	// ajouter une Configuration
	$requete = "SELECT max(idConfiguration) AS max FROM Configuration";
	$lastConfigId = mysqli_query($connexion, $requete);
	if($lastConfigId==TRUE)
	{
		$id = mysqli_fetch_assoc($lastConfigId)['max'] + 1;
	}
	else 
	{
		$id = 0;
	}
	$configNom = "basique" . strval($id) . $prenom;
	$timeStamp = date("Y-m-d H:i:s");
	$timeStamp = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$timeStamp))) ;
	$strategie = "basique";
	$requete = "INSERT INTO Configuration (nomConfiguration, dateConfiguration, strategieConfiguration) 
				VALUES ('". $configNom . "', '". $timeStamp . "', '". $strategie . "')";
	
	$insertion = mysqli_query($connexion, $requete);
	if($insertion == TRUE) {
		$message = "La configuration a bien été ajoutée dans la nouveau partie !";
	}
	else {
		$message = "Erreur lors de l'insertion de la configuration.";
	}

	$requete = "INSERT INTO Partie (dateDemarage, nbDetectives, idConfiguration) 
				VALUES ('". $timeStamp . "', '". $nbDetectives . "', '" . $id . "')";
	$insertion = mysqli_query($connexion, $requete);
	if($insertion == TRUE) {
		$message = "De partie a bien été ajoutée dans la nouveau partie !";
	}
	else {
		$message = "Erreur lors de l'insertion de la partie.";
	}
}
if(isset($_POST['boutonPlay'])) {
	if(isset($_SESSION['COUNT_TOURS_MISTERX']) && !empty($_SESSION['COUNT_TOURS_MISTERX']))
	{
		// si une partie est déjà en cours demarre une nouvelle 
		session_destroy();
	} 
	if(!isset($_SESSION)) session_start();
	$_SESSION['DETECTS_GAGNE'] = false; 
	$_SESSION['COUNT_TOURS_MISTERX'] = 0; 
    $_SESSION['NUM_DETECTS'] = getNbDetectsDeLaPartie();
    $_SESSION['TOUS_QUARTIERS_DEPART'] = getTousQuartiersDeparts();
	$_SESSION['QUARTIERS_DEPART'] = initDeparts(); // 2D array dans [[idQuartiers][nomsQuartiers]]
}
?>