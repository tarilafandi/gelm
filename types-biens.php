<?php
include('config.php');
if(isset($_POST['typeBien'])){
	$typeBien = htmlentities($_POST['typeBien']);
	$idProjet = htmlentities($_POST['idProjet']);
	if($typeBien=="appartement"){
		$requete = " SELECT * FROM t_appartement WHERE idProjet=".$idProjet." AND status = 'Disponible' ";	
	}
	else if($typeBien=="localCommercial"){
		$requete = " SELECT * FROM t_locaux WHERE idProjet=".$idProjet." AND status = 'Disponible' ";
	}
	else if($typeBien=="terrain"){
		$requete = " SELECT * FROM t_terrain WHERE idProjet=".$idProjet." AND status = 'Disponible' ";
	}
	else if($typeBien=="maison"){
		$requete = " SELECT * FROM t_maison WHERE idProjet=".$idProjet." AND status = 'Disponible' ";
	}
	
	// connexion à la base de données
    try{
        $bdd = $pdo;
    } 
	catch(Exception $e){
        exit('Impossible de se connecter à la base de données.');
    }
    // exécution de la requête
    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
     
    // résultats
    while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
		$res = '<option value="'.$donnees['id'].'">'.$donnees['nom'].' - Prix : '.number_format($donnees['prix'], 2, ',', ' ').'</option>';
		echo $res;
	}
}