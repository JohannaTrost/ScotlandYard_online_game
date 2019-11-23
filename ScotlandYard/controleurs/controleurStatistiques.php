<?php 
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

// recupération nb des joueuses 
$requete = "SELECT COUNT(DISTINCT idJ) AS nbJ FROM Joueuses";
$nbJ = mysqli_query($connexion, $requete);
if($nbJ == FALSE) {
	$message .= "Aucune joueuse n'a été trouvée dans la base de données!";
}

// recupération nb des quartiers
$requete = "SELECT COUNT(DISTINCT idQ) AS nbQ FROM Quartiers";
$nbQ = mysqli_query($connexion, $requete);
if($nbQ == FALSE) {
	$message .= "Aucune quartier n'a été trouvée dans la base de données!";
}

// recupération nb des departements 
$requete = "SELECT COUNT(DISTINCT departement) AS nbD FROM Communes";
$nbD = mysqli_query($connexion, $requete);
if($nbD == FALSE) {
	$message .= "Aucune departement n'a été trouvée dans la base de données!";
}

// recupération nb des communes 
$requete = "SELECT COUNT(DISTINCT cpCommune) AS nbC FROM Communes";
$nbC = mysqli_query($connexion, $requete);
if($nbC == FALSE) {
	$message .= "Aucune commune n'a été trouvée dans la base de données!";
}

// data tables pour comparer les joueuses 
// idJ et nomJ
// TODO nombre des perdes, victoires et parties totales par joueuse et ranking 
$requete = "SELECT DISTINCT idJ, DISTINCT nomJ FROM Joueuses";
$joueuses = mysqli_query($connexion, $requete);
if($joueuses == FALSE) {
	$message .= "Aucune joueuse n'a été trouvée dans la base de données!";
}
?>
