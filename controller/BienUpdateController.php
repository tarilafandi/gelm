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
		if( !empty($_POST['numeroTitre']) ){
			$id = htmlentities($_POST['id']);
	        $numeroTitre = htmlentities($_POST['numeroTitre']);
			$nom = htmlentities($_POST['nom']);
			$superficie = htmlentities($_POST['superficie']);
			$prix = htmlentities($_POST['prix']);
			if(isset($_POST['niveau'])){
				$niveau = htmlentities($_POST['niveau']);	
			}
			if(isset($_POST['facade'])){
				$facade = htmlentities($_POST['facade']);		
			}
			if(isset($_POST['mezzanine'])){
				$mezzanine = htmlentities($_POST['mezzanine']);			
			}
			if(isset($_POST['nombrePiece'])){
				$nombrePiece = htmlentities($_POST['nombrePiece']);			
			}
			if(isset($_POST['nombreEtage'])){
				$nombreEtage = htmlentities($_POST['nombreEtage']);			
			}
			if(isset($_POST['emplacement'])){
				$emplacement = htmlentities($_POST['emplacement']);			
			}
			if(isset($_POST['cave'])){
				$cave = htmlentities($_POST['cave']);			
			}
	        
			if(htmlentities($_POST['typeImmobiliere'])=="appartement"){
				$appartement = new Appartement(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'niveau' => $niveau, 'facade' => $facade, 'nombrePiece' => $nombrePiece,
				'status' => $status, 'superficie' => $superficie, 'cave' => $cave, 
				'id' => $id));
				$appartementManager = new AppartementManager($pdo);
				$appartementManager->update($appartement);
			}
			else if(htmlentities($_POST['typeImmobiliere'])=="local"){
				$local = new Locaux(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'mezzanine' => $mezzanine, 'facade' => $facade, 
				'status' => $status, 'superficie' => $superficie,  
				'id' => $id));
				$locauxManager = new LocauxManager($pdo);
				$locauxManager->update($local);
			}
			else if(htmlentities($_POST['typeImmobiliere'])=="maison"){
				$maison = new Maison(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'nombreEtage' => $nombreEtage, 'emplacement' => $emplacement, 
				'status' => $status, 'superficie' => $superficie,  
				'id' => $id));
				$maisonManager = new MaisonManager($pdo);
				$maisonManager->update($maison);
			}
			else if(htmlentities($_POST['typeImmobiliere'])=="terrain"){
				$terrain = new Terrain(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'emplacement' => $emplacement, 
				'status' => $status, 'superficie' => $superficie,  
				'id' => $id));
				$terrainManager = new TerrainManager($pdo);
				$terrainManager->update($terrain);
			}
	        
	        $_SESSION['bien-update-success']='<strong>Opération valide</strong> : Le Bien Immobilière est modifié avec succès !';
	        $redirectLink = 'Location:../projet-biens.php?idProjet='.$idProjet;
	        header($redirectLink);
    	}
	    else{
	    	$_SESSION['bien-update-error'] = "<strong>Erreur Modification Bien Immobilière</strong> : Vous devez remplir au moins le champ 'Numéro Titre'.";
	        $redirectLink = 'Location:../projet-biens.php?idProjet='.$idProjet;
	        header($redirectLink);
			exit;
    	}	
	}
	else{
		header('Location:../projet-biens.php?idProjet='.$idProjet);
	}
    
    