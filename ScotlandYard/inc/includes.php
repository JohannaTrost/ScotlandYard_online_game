<?php
// scp -r ScotlandYard p1925142@bdw1.univ-lyon1.fr:~
// http://bdw1.univ-lyon1.fr/p1925142/ScotlandYard/
$nomSite = "ScotlandYard";
$baseline = "Jouer Scotland Yard, trouver mister X";

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	$connexion = mysqli_connect(SERVEUR, UTILISATRICE, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	return $connexion;
}

// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}

?>
