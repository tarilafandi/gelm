<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');
	include('../lib/image-processing.php');  
    //classes loading end
    session_start();
    
    //post input processing
    $idProjet = htmlentities($_POST['idProjet']);
	if( !empty($_POST['idProjet']) ){
		$id = htmlentities($_POST['id']);
		if(htmlentities($_POST['typeImmobiliere'])=="appartement"){
			$appartementManager = new AppartementManager($pdo);
			$appartementManager->delete($id);
		}
		else if(htmlentities($_POST['typeImmobiliere'])=="local"){
			$locauxManager = new LocauxManager($pdo);
			$locauxManager->delete($id);
		}
		else if(htmlentities($_POST['typeImmobiliere'])=="maison"){
			$maisonManager = new MaisonManager($pdo);
			$maisonManager->delete($id);
		}
		else if(htmlentities($_POST['typeImmobiliere'])=="terrain"){
			$terrainManager = new TerrainManager($pdo);
			$terrainManager->delete($id);
		}
        
        $_SESSION['bien-delete-success']='<strong>Opération valide</strong> : Le Bien Immobilière est supprimé avec succès !';
        $redirectLink = 'Location:../projet-biens.php?idProjet='.$idProjet;
        header($redirectLink);
	}
	else{
		header('Location:../projet-biens.php?idProjet='.$idProjet);
	}
    
    