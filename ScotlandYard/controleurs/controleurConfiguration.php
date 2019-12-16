<?php 
include('static/outilsJeu.php');
$connexion = getConnexionBD(); // connexion à la BD
$message = "";
if(isset($_POST['boutonValider'])) { // formulaire soumis
	
	// recuperation des valeurs saisies
	$prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
	$nbDetectives = mysqli_real_escape_string($connexion, $_POST['nbDetects']);
	if(isset($_POST['strategie']))
	{
		$strategie = $_POST['strategie'];
	}
	else 
	{
		// choix aléatoirement de stratégie si la joueuse n'a pas fait un choix 
		$strategies = array("basique", "econome", "pistage"); 
		$strategie = $strategies[array_rand($strategies)];
	}
	
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
	if($lastConfigId)
	{
		$id = mysqli_fetch_assoc($lastConfigId)['max'] + 1;
	}
	else 
	{
		$id = 0;
	}
	$timeStamp = date("Y-m-d H:i:s");
	$timeStamp = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$timeStamp))) ;
	$configNom = $strategie . strval($id) . $prenom;
	$requete = "INSERT INTO Configuration (nomConfiguration, dateConfiguration, strategieConfiguration) 
				VALUES ('". $configNom . "', '". $timeStamp . "', '". $strategie . "')";
	$insertion = mysqli_query($connexion, $requete);
	if($insertion == TRUE) {
		$message = "La configuration a bien été ajoutée dans la nouveau partie !";
	}
	else {
		$message = "Erreur lors de l'insertion de la configuration.";
	}
	
	// ajouter une nouvelle partie 
	$requete = "INSERT INTO Partie (dateDemarage, nbDetectives, idConfiguration) 
				VALUES ('". $timeStamp . "', '". $nbDetectives . "', '" . $id . "')";
	$insertion = mysqli_query($connexion, $requete);
	if($insertion == TRUE) {
		$message = "De partie a bien été ajoutée dans la nouveau partie !";
	}
	else {
		$message = "Erreur lors de l'insertion de la partie.";
	}
	
	// peupler table participe
	$partieId = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT max(idPartie) AS max FROM Partie"))['max'];
	$requete = "INSERT INTO Participe (nomJ, idPartie) 
				VALUES ('". $prenom . "', '". $partieId . "')";
	$insertion = mysqli_query($connexion, $requete);
	if($insertion == FALSE) {
		$message = "Erreur lors de l'insertion des valeurs dans table participe.";
	}
	
	// peupler table inclus
	$resultat = mysqli_query($connexion, "SELECT nomI FROM Image"); 
	$configId = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT max(idConfiguration) AS max FROM Configuration"))['max'];
	$images = array(); 
	if($resultat)
	{
			while($row = mysqli_fetch_assoc($resultat))
			{
				$images[] = $row['nomI'];
			}
	}
	foreach($images as &$image)
	{
		$requete = "INSERT INTO Inclus VALUES('". $configId . "', '". $image . "')"; 
	}
	
	
	if(!isset($_SESSION)) session_start();
	$_SESSION['DETECTS_GAGNE'] = false; 
	$_SESSION['COUNT_TOURS_MISTERX'] = 0; 
    $_SESSION['NUM_DETECTS'] = $nbDetectives;
	$_SESSION['STRATEGIE'] = $strategie; 
	$_SESSION['QUARTIERS_DEPART'] = initDeparts(); // 3D array: [[idQuartiers][nomsQuartiers][typesTransport]]
	if($_SESSION['STRATEGIE'] == "econome")
	{
		$_SESSION['TICKETS'] = array(); 
		for($i=0; $i < $nbDetectives; $i++)
		{
			$_SESSION['TICKETS'][] = array('Taxi' => 10, 'Bus' => 8, 'Metro/tramway' => 4); 
		}
	}
	// aller sur la page de jeu 
	if(isset($_SESSION['QUARTIERS_DEPART']) && !empty($_SESSION['QUARTIERS_DEPART']) &&
	   isset($_SESSION['STRATEGIE']) && !empty($_SESSION['STRATEGIE']) &&
	   isset($_SESSION['NUM_DETECTS']) && !empty($_SESSION['NUM_DETECTS']))
	{
		if($_SESSION['STRATEGIE'] == "econome")
		{
			if(isset($_SESSION['TICKETS']) && !empty($_SESSION['TICKETS']))
			{
				header("Location: index.php?page=jouer");
			}
		}
		else 
		{
			header("Location: index.php?page=jouer");
		}
	}
}
?>