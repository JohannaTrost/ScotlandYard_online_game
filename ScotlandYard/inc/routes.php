<?php

/*
** Il est possible d'automatiser le routing, notamment en cherchant directement le fichier controleur et le fichier vue.
** ex, pour page=afficher : verification de l'existence des fichiers controleurs/controleurAfficher.php et vues/vueAfficher.php
** Cela impose un nommage strict des fichiers.
*/

$Routes = array(
	'accueil' => array('controleur' => 'controleurAccueil', 'vue' => 'vueAccueil'),
	'jouer' => array('controleur' => 'controleurJeu', 'vue' => 'vueJeu'), 
	'jouer-maintenant' => array('controleur' => 'controleurConfiguration', 'vue' => 'vueConfiguration'),
	'statistiques' => array('controleur' => 'controleurStatistiques', 'vue' => 'vueStatistiques')
);

?>
