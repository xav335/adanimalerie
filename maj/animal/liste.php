<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_animal = $_POST["num_animal"];
	
	$categorie = new animal_categorie();
	$animal = new animal();
	$produit_produit_associe = new produit_produit_associe();
	
	// Suppression d'un cours
	if ($mon_action == "suppression") {
		//echo "Suppression...<br>";
		
		if ( $animal->load( $num_animal ) ) {
			
			// Suppression des associations déjà existantes
			$produit_produit_associe->supprimer( 0, 0, $num_animal );
			
			$animal->supprimer();
		}
	}
	
	// Liste des categories disponibles
	$liste_animal = $animal->getListe();
	
	$menu = "animal";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function supprimer(num) {
			if (confirm("Voulez vous vraiment supprimer cet enregistrement?")) {
				document.formulaire.action = "liste.php";
				document.formulaire.mon_action.value = "suppression";
				document.formulaire.num_animal.value = num;
				document.formulaire.submit();
			}
		}
		
		function afficher(num) {
			//alert(num);
			document.formulaire.action = "./ajout.php";
			document.formulaire.mon_action.value = "";
			document.formulaire.num_animal.value = num;
			document.formulaire.submit();
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
	<form name="formulaire" method="POST" enctype="multipart/form-data" action="liste.php">
		<input type="hidden" name="mon_action" value="">
		<input type="hidden" name="num_animal" value="">
		
		<table cellpadding=0 cellspacing=0 style="width:968px;height:100%;" align="center" border="0">
		<tr>
			<td width="100%" style="height:64px;background:url(../images/ref-struc-top.gif);">
		</tr>
		<tr style="background:#FFF;">
			<td>
				<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" align="center" border="0">
				<tr>
					<td style="width:4px;background:#A9BFE7;">
					
					<!-- Menu de gauche -->
					<? include_once("../includes/menu_gauche.php");?>
				
					<td width="*" style="vertical-align:top;padding:10px;">
						<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
						<tr>
							<td class="titrepage" height="30" valign="top">Liste des animaux</td>
						</tr>
						<tr>
							<td>
								<fieldset style="display:block;margin:0;">
									<legend><font color="#688FD5"><b>Liste</b></font></legend>
									<? 
									if ( !empty( $liste_animal ) ) {
										?>
										<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
										<tr>
											<td align="left" valign="top">
												<div style="height:700;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td>
															<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
															<tr>
																<td width="*" align="left"><b>Titre</b></td>
																<td width="150" align="left"><b>Cat&eacute;gorie</b></td>
																<td width="40">&nbsp;</td>
															</tr>
															</table>
														</td>
													</tr>
													<?
													$index = 1;
													$categorie_temp = new animal_categorie();
													
													// On liste tous les sites
													foreach( $liste_animal as $_animal ) {
														$index = $index + 1;
														
														if ($index % 2) {
															$choix_couleur = "#F5FFE5";
															$fonce = "_fonce";
														}
														else {
															$choix_couleur = "#E4FDC3";
															$fonce = "";
														}
														
														// Récupération du nom de la catégorie
														$nom_categorie = ( $categorie_temp->load( $_animal->num_animal_categorie ) ) ? stripcslashes( utf8_encode( $categorie_temp->nom ) ) : "-";
														?>
				<tr>
					<td>
						<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
						<tr>
							<td>
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
								<tr>
									<td width="*" height="20">
										<a href="javascript:afficher(<?=$_animal->num_animal?>);" style="margin-left: <?=$decalage?>px;"><?=stripcslashes( utf8_encode( $_animal->nom ) )?></a>
									</td>
									<td width="150"><?=$nom_categorie?></td>
									<td width="40" align="right" valign="middle">
										<a href="javascript:afficher(<?=$_animal->num_animal?>);"><img src="../images/icones/edit.gif" border="0" title="Modifier"></a>
										<a href="javascript:supprimer(<?=$_animal->num_animal?>);"><img src="../images/icones/delete.gif" border="0" title="Supprimer"></a>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
														<?
													}
													?>
													</table>
												</div>
											</td>
										</tr>
										</table>
									<? 
									}
									else {
										?>
										<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
										<tr>
											<td align="left" valign="top">
												<div style="height:700;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td align="center"><font color="#CC3300"><b>Aucun animal dans la base.</b></font></td>
													</tr>
													</table>
												</div>
											</td>
										</tr>
										</table>
										<?
									}
									?>
								</fieldset>
							</td>
						</tr>
						</table>
					</td>
					<td style="width:6px;background:url(../images/ref-struc-border-right.gif) repeat-y;">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="height:16px;background:url(../images/ref-struc-bottom.gif);"></td>
		</tr>
		</table>
	</form>
</body>
</html>
<? include('../../include_connexion/connexion_site_off.php'); ?>