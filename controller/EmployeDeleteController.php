<<<<<<< HEAD
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
    //classes loading end
    session_start();
    //post input processing   
	$idEmploye = htmlentities($_POST['idEmploye']);
    $employeManager = new EmployeManager($pdo);
	$employeManager->delete($idEmploye);
	$_SESSION['employe-delete-success'] = "<strong>Opération valide : </strong>L'employé est supprimé avec succès.";
	header('Location:../employes.php');
    
=======
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
    //classes loading end
    session_start();
    //post input processing   
	$idEmploye = htmlentities($_POST['idEmploye']);
    $employeManager = new EmployeManager($pdo);
	$employeManager->delete($idEmploye);
	$_SESSION['employe-delete-success'] = "<strong>Opération valide : </strong>L'employé est supprimé avec succès.";
	header('Location:../employes.php');
    
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
    