<? include('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_produit_associe = $_POST["num_produit_associe"];
	$nom = trim($_POST["nom"]);
	
	$produit_associe = new produit_associe();
	$produit_produit_associe = new produit_produit_associe();
	
	// Ajout ou modification d'une categorie
	if ($mon_action == "modification") {
		$num_produit_associe = $produit_associe->gererDonnee( $_POST );
		$maj_ok = ($num_produit_associe == 0) ? "" : "[--- Mise &agrave; jour r&eacute;alis&eacute;e avec succ&egrave;s ---]";
		$erreur = ($num_produit_associe == 0) ? "Erreur lors de la modification de la base" : "";
		$num_produit_associe = "";
	}
	
	// Suppression de la catégorie ainsi que des photos incluses dedans
	if ($mon_action == "suppression") {
		if ($produit_associe->load( intval($num_produit_associe) )) {
			
			// Suppression des associations déjà existantes
			$produit_produit_associe->supprimer( 0, $num_produit_associe );
			
			$produit_associe->supprimer($num_produit_associe);
		}
		
		$maj_ok = "[--- Cat&eacute;gorie supprim&eacute;e ---]";
		$erreur = "";
		$num_produit_associe = "";
	}
	
	// Aucune catégorie n'est sélectionnée
	if (intval($num_produit_associe) == 0) {
		$titre_zone_ajout = "Ajout d'un produit associ&eacute;";
		$nom = "";
	}
	else {
		$titre_zone_ajout = "Modification d'un produit associ&eacute;";
		$produit_associe->load( intval($num_produit_associe) );
		$nom = stripcslashes( utf8_encode( $produit_associe->nom ) );
	}
	
	// Liste des catégories
	$liste_categorie = $produit_associe->getListe();
	
	$menu = "produit associe";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<style type="text/css">
	<!--
		/*DIV AFFICHAGE ERREUR SAISIE*/
		#erreurdiv {
			background:#FF8100;color:white;border:solid 1px #666;padding:0 2px;position:absolute;top:0;left:0;display:none;
		}
		
		.erreur {
			border: 2px solid #CC3300;
		}
	-->
	</style>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function annuler() {
			document.formulaire.num_produit_associe.value = "";
			document.formulaire.submit();
		}
		
		function afficher(num) {
			//alert(num);
			document.formulaire.num_produit_associe.value = num;
			document.formulaire.submit();
		}
		
		function initialiser() {
			find("nom").className = "";
		}
		
		function ajouter() {
			initialiser();
			
			find("div_affichage_erreur").style.display = "none";
			find("div_wait").style.display = "block";
			
			if ( trim( find("nom").value ) == "") {
				//erreur("nom", "Le nom de la cat&eacute;gorie est obligatoire");
				find("nom").className = "erreur";
				find("div_wait").style.display = "none";
				find("div_affichage_erreur").style.display = "block";
			}
			else {
				document.formulaire.mon_action.value = "modification";
				document.formulaire.submit();
			}
		}
		
		function supprimer(num) {
			if (confirm("Voulez vous vraiment supprimer cet enregistrement?")) {
				document.formulaire.mon_action.value = "suppression";
				document.formulaire.num_produit_associe.value = num;
				document.formulaire.submit();
			}
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
	<div id="erreurdiv"></div>
	<form name="formulaire" method="POST" action="liste.php">
		<input type="hidden" name="mon_action" value="">
		<input type="hidden" name="num_produit_associe" value="<?=$num_produit_associe?>">
	
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
							<td class="titrepage" colspan="2" height="30" valign="top">Gestion des produits associ&eacute;s</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" height="50">
								<fieldset style="display:block;margin:0;">
									<legend><font color="#688FD5"><b><?=$titre_zone_ajout?></b></font></legend>
									<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
									<?
									// Affichage de l'erreur
									if ($erreur != "") {
										?>
										<div style="padding-left:10px; margin-bottom:10px; background-color: #EDC436; border: 2px solid #CC3300;">
											<p><font color="#CC3300"><b>[--- <?=$erreur?> ---]</b></font></p>
										</div>
										<? 
									}
									
									// Tout s'est bien passé
									else if ($maj_ok != "") {
										?>
										<div style="padding-left:10px; margin-bottom:10px; background-color: #E4FDC3; border: 1px solid green;">
											<p><font color="green"><b><?=$maj_ok?></b></font></p>
										</div>
										<?
									}
									?>
									<tr>
										<td width="50" height="25" align="left" valign="middle">Nom du produit associ&eacute; * :</td>
										<td width="*" align="left" valign="middle">
											<input type="text" name="nom" id="nom" value="<?=$nom?>" size="40" maxlength="100">
										</td>
									</tr>
									<tr>
										<td height="25">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" width="100%" height="25" align="right" valign="middle">
											<div style="float:right;margin-left:10px;">
												<a href="javascript:annuler();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../images/buttons/resetHover.png',0)"><img src="../images/buttons/reset.png" name="Image1" border="0"></a>
												<a href="javascript:ajouter();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/buttons/submitHover.png',0)"><img src="../images/buttons/submit.png" name="Image2" border="0"></a>
											</div>
											<div id="div_wait" style="float:right;margin-top:3px;display:none;"><img src="../images/activity.gif"></div>
											<div id="div_affichage_erreur" style="display: none;">
												<table width="320" cellpadding=0 cellspacing=0 border="0">
												<tr>
													<td width="40" align="center"><img src="../images/alerte-petit.gif" alt="Loading...">&nbsp;</td>
													<td width=*"><font color="#B30307"><b>Attention, certains champs sont obligatoires...</b></font></td>
												</tr>
												</table>
											</div>
										</td>
									</tr>
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<? if ( !empty( $liste_categorie ) ) { ?>
									<fieldset style="display:block;margin:0;">
										<legend><font color="#688FD5"><b>Liste des produits associ&eacute;s</b></font></legend>
										<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
										<tr>
											<td align="left" valign="top">
												<div style="height:495;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td>
															<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
															<tr>
																<td width="*"><b>Titre</b></td>
																<td width="40">&nbsp;</td>
															</tr>
															</table>
														</td>
													</tr>
													<?
													$index = 1;
													
													// On liste tous les sites
													foreach( $liste_categorie as $_categorie ) {
														$index = $index + 1;
														
														if ($index % 2) {
															$choix_couleur = "#F5FFE5";
															$fonce = "_fonce";
														}
														else {
															$choix_couleur = "#E4FDC3";
															$fonce = "";
														}
														?>
				<tr>
					<td>
						<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
						<tr>
							<td>
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
								<tr>
									<td width="*" height="20">
										<a href="javascript:afficher(<?=$_categorie->num_produit_associe?>);"><?=stripcslashes( utf8_encode( $_categorie->nom ) )?></a>
									</td>
									<td width="40" align="right" valign="middle">
										<a href="javascript:afficher(<?=$_categorie->num_produit_associe?>);"><img src="../images/icones/edit.gif" border="0" title="Modifier la cat&eacute;gorie"></a>
										<a href="javascript:supprimer(<?=$_categorie->num_produit_associe?>);"><img src="../images/icones/delete.gif" border="0" title="Supprimer la cat&eacute;gorie"></a>
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
									</fieldset>
								<? 
								}
								else {
									?>
									<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
									<tr>
										<td align="left" valign="top">
											<div style="height:300;overflow :auto;">
												<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
												<tr>
													<td align="center"><font color="#CC3300"><b>Aucun produit associ&eacute; dans la base.</b></font></td>
												</tr>
												</table>
											</div>
										</td>
									</tr>
									</table>
									<?
								}
								?>
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