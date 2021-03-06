<?php
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
	include('lib/pagination.php');
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
    	//classManagers
    	$projetManager = new ProjetManager($pdo);
		$fournisseurManager = new FournisseurManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$livraisonDetailManager = new LivraisonDetailManager($pdo);
		$reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
		//classes and vars
		$livraisonDetailNumber = 0;
		$totalReglement = 0;
		$totalLivraison = 0;
		$titreLivraison ="Détail de la livraison";
		$livraison = "Vide";
		$fournisseur = "Vide";
		$projet = "Vide";
		if( isset($_GET['codeLivraison']) ){
			$livraison = $livraisonManager->getLivraisonByCode($_GET['codeLivraison']);
			$fournisseur = $fournisseurManager->getFournisseurById($livraison->idFournisseur());
			$projet = $projetManager->getProjetById($livraison->idProjet());
			$livraisonDetail = $livraisonDetailManager->getLivraisonsDetailByIdLivraison($livraison->id());
		}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>GELM - Management Application</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/metro.css" rel="stylesheet" />
	<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<?php include("include/top-menu.php"); ?>	
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php include("include/sidebar.php"); ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->			
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Gestion des livraisons
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des livraisons</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Détails de Livraison</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN ALERT MESSAGES -->	
						<?php if(isset($_SESSION['livraison-detail-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-detail-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-detail-delete-success']);
						 ?>		
						 <?php if(isset($_SESSION['livraison-detail-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-detail-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-detail-add-success']);
						 ?>
						 <?php if(isset($_SESSION['livraison-detail-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-detail-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-detail-add-error']);
						 ?>		
						<?php if(isset($_SESSION['livraison-detail-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-detail-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-detail-update-success']);
						 ?>
						 <?php if(isset($_SESSION['livraison-detail-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-detail-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-detail-update-error']);
						 ?>
						 <?php if(isset($_SESSION['livraison-detail-fill'])){ ?>
							<div class="alert alert-info">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-detail-fill'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-detail-fill']);
						 ?>
						 <!-- END  ALERT MESSAGES -->
						<div class="portlet">
							<div class="portlet-title">
								<h4><?= $titreLivraison ?></h4>&nbsp;
								<a target="_blank" href="controller/LivraisonDetailPrintController.php?idLivraison=<?= $livraison->id() ?>" class="btn blue">
									<i class="icon-print"></i>&nbsp;Détails Livraison
								</a>
								<?php
							 	$btnColor = "";
								if($livraison->status()==utf8_decode("Pay&eacute;")){
									$btnColor = "btn mini green";	
								}
								else if($livraison->status()==utf8_decode("Pay&eacute;+TVA")){
									$btnColor = "btn mini blue";	
								}
								else if($livraison->status()=="Non Pay&eacute;"){
									$btnColor = "btn mini red";	
								} 
								?>
								<br>
								<a class="<?= $btnColor ?>"><?= $livraison->status() ?></a>
								<br><br>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<!-- BEGIN PORTLET BODY -->
							<div class="portlet-body">
								<!-- BEGIN Livraison Form -->
								<div class="row-fluid">
									<div class="span3">
									  <div class="control-group">
										 <label class="control-label" for="projet"><strong>Projet</strong></label>
										 <div class="controls">
											<input class="m-wrap" value="<?= $projet->nom() ?>" disabled="disabled" />   
										 </div>
									  </div>
								   </div>
								   <div class="span3">
									  <div class="control-group">
										 <label class="control-label" for="fournisseur"><strong>Fournisseur</strong></label>
										 <div class="controls">
											<input class="m-wrap" value="<?= $fournisseur->nom() ?>" disabled="disabled" />   
										 </div>
									  </div>
								   </div>
								   <div class="span3">
									  <div class="control-group">
										 <label class="control-label" for="libelle"><strong>Libelle</strong></label>
										 <div class="controls">
											<input class="m-wrap" value="<?= $livraison->libelle() ?>" disabled="disabled" />   
										 </div>
									  </div>
								   </div>
								   <div class="span3">
									  <div class="control-group">
										 <label class="control-label" for="dateLivraison"><strong>Date de livraison</strong></label>
										 <div class="controls">
											<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
												<input class="m-wrap m-ctrl-small date-picker" value="<?= $livraison->dateLivraison() ?>" disabled="disabled" />
											 </div>
										 </div>
									  </div>
								   </div>
								</div>
							<!-- END Livraison Form -->
							<!-- BEGIN Ajouter Article Link -->
							<a class="btn green" href="#addArticle" data-toggle="modal" data-id="">
								Ajouter un article <i class="icon-plus "></i>
							</a>
							<!-- END Ajouter Article Link -->
							<!-- BEGIN addArticle Box -->
							<div id="addArticle" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h3>Ajouter un artcile </h3>
								</div>
								<div class="modal-body">
									<form class="form-horizontal" action="controller/LivraisonDetailAddController.php" method="post">
										<div class="control-group">
											<label class="control-label">Désignation</label>
											<div class="controls">
												<input type="text" name="designation" value="" />
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">Prix Unitaire</label>
											<div class="controls">
												<input type="text" name="prixUnitaire" value="" />
											</div>	
										</div>
										<div class="control-group">
											<label class="control-label">Quantité</label>
											<div class="controls">
												<input type="text" name="quantite" value="" />
											</div>	
										</div>
										<div class="control-group">
											<div class="controls">	
												<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>">
												<input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>">
												<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
												<button type="submit" class="btn red" aria-hidden="true">Oui</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- END addArticle BOX -->
							<br><br>
							<!-- BEGIN LivraisonDetail TABLE -->
							<?php
							if( 1 ){
							?>
							<table class="table table-striped table-bordered table-hover">
							<tr>
								<th>Désignation</th>
								<th>Quantité</th>
								<th>Prix.Uni</th>
								<th>Total</th>
								<th>Modifier</th>
								<th>Supprimer</th>
							</tr>
							<?php
							foreach($livraisonDetail as $detail){
							?>
							<tr>
								<td>
									<?= $detail->designation() ?>
								</td>
								<td>
									<?= $detail->quantite() ?>
								</td>
								<td>
									<?= number_format($detail->prixUnitaire(), '2', ',', ' ') ?>&nbsp;DH
								</td>
								<td>
									<?= number_format($detail->prixUnitaire() * $detail->quantite(), '2', ',', ' ') ?>&nbsp;DH
								</td>
								<td class="hidden-phone">
									<a class="btn mini green" href="#updateLivraisonDetail<?= $detail->id();?>" data-toggle="modal" data-id="<? $detail->id(); ?>">
										<i class="icon-refresh "></i>
									</a>
								</td>
								<td class="hidden-phone">
									<a class="btn mini red" href="#deleteLivraisonDetail<?= $detail->id();?>" data-toggle="modal" data-id="<? $detail->id(); ?>">
										<i class="icon-remove "></i>
									</a>
								</td>
							</tr>
							<!-- BEGIN  updateLivraisonDetail BOX -->
							<div id="updateLivraisonDetail<?= $detail->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h3>Modifier les détails de livraison </h3>
								</div>
								<div class="modal-body">
									<form class="form-horizontal" action="controller/LivraisonDetailUpdateController.php" method="post">
										<p>Êtes-vous sûr de vouloir modifier les détails de cette livraison ?</p>
										<div class="control-group">
											<label class="control-label" for="designation">Désignation</label>
											<div class="controls">
												<input name="designation" class="m-wrap" type="text" value="<?= $detail->designation() ?>" />
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="quantite">Quantité</label>
											<div class="controls">
												<input name="quantite" class="m-wrap" type="text" value="<?= $detail->quantite() ?>" />
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="prixUnitaire">Prix Unitaire</label>
											<div class="controls">
												<input name="prixUnitaire" class="m-wrap" type="text" value="<?= $detail->prixUnitaire() ?>" />
											</div>
										</div>
										<div class="control-group">
											<input type="hidden" name="idLivraisonDetail" value="<?= $detail->id() ?>" />
											<input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>" />
											<div class="controls">	
												<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
												<button type="submit" class="btn red" aria-hidden="true">Oui</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- END  update LivraisonDetail   BOX -->
							<!-- BEGIN  delete LivraisonDetail BOX -->
							<div id="deleteLivraisonDetail<?= $detail->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h3>Supprimer List des produits</h3>
								</div>
								<div class="modal-body">
									<form class="form-horizontal loginFrm" action="controller/LivraisonDetailDeleteController.php" method="post">
										<p>Êtes-vous sûr de vouloir supprimer cette article ?</p>
										<div class="control-group">
											<label class="right-label"></label>
											<input type="hidden" name="idLivraisonDetail" value="<?= $detail->id() ?>" />
											<input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>" />
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</form>
								</div>
							</div>
							<!-- END delete LivraisonDetail BOX -->
							<?php
							}//end foreach
							$totalLivraisonDetail = 
							$livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
							$nombreArticle = 
							$livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id())
							?>
							</table>
							<table class="table table-striped table-bordered table-advance table-hover">
								<thead>
									<tr>
										<th><strong>Nombre d'article de la livraison</strong></th>
										<td><strong><a><?= $nombreArticle ?></a></strong></td>
									</tr>
								<thead>
									<tr>
										<th><strong>Total de la livraison</strong></th>
										<td><strong><a><?= number_format($totalLivraisonDetail, 2, ',', ' ') ?></a>&nbsp;DH</strong></td>
									</tr>	
								</thead>
							</table>
							<?php
							}//end if
							?>
							<!-- END LivraisonDetail TABLE -->
							</div>
							<!-- END  PORTLET BODY  -->
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2015 &copy; GELM. Management Application.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="script.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>