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
	$image = new animal_image();
	$produit_associe = new produit_associe();
	$produit_produit_associe = new produit_produit_associe();
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	
	// On souhaite une modification de categorie
	if ( $mon_action == "modification" ) {
		
		// Mise à jour de la base
		$num_animal = $animal->gererDonnee( $_POST, $_FILES );
		
		$maj_ok = ($num_animal == 0) ? "" : "[--- Mise &agrave; jour r&eacute;alis&eacute;e avec succ&egrave;s ---]";
		$erreur = ($num_animal == 0) ? "Erreur lors de la modification de la base" : "";
	}
	
	// Upload d'une image
	else if ( $mon_action == "uploader" ) {
		//echo "Upload...<br>";
		$image->gererDonnees( $_POST, $_FILES );
	}
	
	// Suppression d'une image
	else if ( $mon_action == "supprimer image" ) {
		if ( $image->load( $_POST["num_animal_image"] ) ) $image->supprimer();
	}
	
	// On valide le contenu de la liste des produits associés
	else if (($mon_action == "valider liste") && ($num_animal != "")) {
		//echo "ICI!!! : " . count($_POST["toBox"]) . "<br>";
		
		// Tentative de chargement ...
		if ( $animal->load( $num_animal ) ) {
		
			// Supprime les produits associés précédemment sélectionnés
			$produit_produit_associe->supprimer( 0, 0, $num_animal );
			
			// Rajout des produits associés
			$produit_produit_associe->gererDonnee( $_POST );
		}
	}
	
	if ( $animal->load( $num_animal ) ) {
		$titre_page = "Modification d'un animal";
		
		$num_animal_categorie = $animal->num_animal_categorie;
		$nom = stripcslashes( utf8_encode( $animal->nom ) );
		$resume = stripcslashes( utf8_encode( $animal->resume ) );
		$texte = stripcslashes( utf8_encode( $animal->texte ) );
	}
	else {
		$titre_page = "Ajout d'un animal";
		$num_animal_categorie = 0;
		$nom = "";
		$resume = "";
		$texte = "";
	}
	
	// Liste des categories disponibles
	$liste_categorie = $categorie->getListeReccursive( 0 );
	
	// Liste des images déjà associées à cet animal
	$liste_image = $image->getListe( $num_animal );
	
	// -- Liste des produits associés DEJA associés à cet animal -- //
	$liste = $produit_produit_associe->getListe( 0, 0, $num_animal );
	
	$liste_texte = "0";
	if ( !empty( $liste ) ) {
		foreach( $liste as $_prod ) {
			$liste_texte .= "," . $_prod->num_produit_associe;
		}
	}
	
	$liste_produit_deja_associe = $produit_associe->getListe( $liste_texte );
	// ------------------------------------------------------------ //
	
	// Liste des produits associés
	$liste_produit_associe = $produit_associe->getListe( '', $liste_texte );
	
	$display = ( $animal->num_animal == "" ) ? "none" : "block";
	$menu = "animal ajout";
?>

<html>
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	<? include_once('../tinymce.php'); ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="../../js/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="../../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="../../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
	<style type="text/css">
		.multipleSelectBoxControl span{	/* Labels above select boxes*/
			font-family:arial;
			font-size:11px;
			font-weight:bold;
		}
		.multipleSelectBoxControl div select{	/* Select box layout */
			font-family:arial;
			height:100px;
		}
		.multipleSelectBoxControl input{	/* Small butons */
			width:25px;	
		}
		
		.multipleSelectBoxControl div{
			float:left;
		}
			
		.multipleSelectBoxDiv
	</style>
	
	<script type="text/javascript">
		/************************************************************************************************************
		(C) www.dhtmlgoodies.com, October 2005
		
		This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
		
		Terms of use:
		You are free to use this script as long as the copyright message is kept intact. However, you may not
		redistribute, sell or repost it without our permission.
		
		Thank you!
		
		www.dhtmlgoodies.com
		Alf Magne Kalleland
		
		************************************************************************************************************/
		
		var fromBoxArray = new Array();
		var toBoxArray = new Array();
		var selectBoxIndex = 0;
		var arrayOfItemsToSelect = new Array();
		
		<? include('../js/fonction_selectbox.js'); ?>
	</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$(".simple").fancybox();
			
			$("a[rel=groupe_image]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
		});
	</script>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function initialiser() {
			find("num_animal_categorie").className = "";
			find("nom").className = "";
			find("resume").className = "";
			find("corps_texte").className = "";
		}
		
		function valider() {
			initialiser();
			tinyMCE.triggerSave();
			document.formulaire.texte.value = document.formulaire.corps_texte.value;
			
			var val_erreur = 0;
			find("div_affichage_erreur").style.display = "none";
			find("div_wait").style.display = "block";
			
			if (trim( find("num_animal_categorie").value ) == "") {
				find("num_animal_categorie").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("nom").value ) == "") {
				find("nom").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("resume").value ) == "") {
				find("resume").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("texte").value ) == "") {
				find("corps_texte").className = "erreur";
				val_erreur = 1;
			}
			
			if ( val_erreur == 0 ) {
				//alert("On poste");
				document.formulaire.mon_action.value = "modification";
				document.formulaire.submit();
			}
			else {
				find("div_wait").style.display = "none";
				find("div_affichage_erreur").style.display = "block";
			}
		}
		
		function uploader() {
			find("div_wait_upload").style.display = "block";
			document.formulaire.mon_action.value = "uploader";
			document.formulaire.submit();
		}
		
		function supprimer_image( num ) {
			document.formulaire.num_animal_image.value = num;
			document.formulaire.mon_action.value = "supprimer image";
			document.formulaire.submit();
		}
		
		function valider_produit_associe() {
			find("div_wait_animal").style.display = "block";
			multipleSelectOnSubmit();
			
			document.formulaire.mon_action.value = "valider liste";
			document.formulaire.submit();
		}
		
		function annuler() {
			window.location.href = "liste.php";
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
<div id="erreurdiv"></div>
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
				<? include_once("../includes/menu_gauche.php"); ?>
			
				<td width="*" style="vertical-align:top;padding:10px;">
					<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
					<tr>
						<td class="titrepage" height="30" valign="top"><?=$titre_page?></td>
					</tr>
					<tr>
						<td width="100%" valign="top">
							<form name="formulaire" method="POST" enctype="multipart/form-data" action="ajout.php">
								<input type="hidden" name="num_animal" value="<?=$num_animal?>">
								<input type="hidden" name="mon_action" value="">
								<input type="hidden" name="texte" id="texte" value="">
								<input type="hidden" name="num_animal_image" value="">
								
								<div id="conteneur">
									<fieldset>
										<legend><font color="#688FD5"><b>Informations sur l'animal</b></font></legend>
										
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
									
										<div class="titre_champ">Cat&eacute;gorie d'animal * :</div>
										<div class="champ">
											<select name="num_animal_categorie" id="num_animal_categorie">
												<option value="" selected>-- Choisir --</option>
												<?
												foreach( $liste_categorie as $_categorie ) {
													$decalage = "";
													for ($i=0; $i<($_categorie->niveau * 5); $i++) {
														$decalage .= "&nbsp;";
													}
													?>
													<option value="<?=$_categorie->num_animal_categorie?>" <? if ( $num_animal_categorie == $_categorie->num_animal_categorie ) { ?> selected <? } ?>>
														<?=$decalage?><?=stripcslashes( utf8_encode( $_categorie->nom ) )?>
													</option>
													<?
												}
												?>
											</select>
										</div>
										<div style="clear:both;"></div>
										
										<div class="titre_champ">Nom de l'animal * :</div>
										<div class="champ"><input type="text" name="nom" id="nom" size="40" maxlenght="100" value="<?=$nom?>"></div>
										<div style="clear:both;"></div>
										
										<div class="titre_champ">R&eacute;sum&eacute; * :</div>
										<div class="champ"><input type="text" name="resume" id="resume" size="100" maxlenght="100" value="<?=$resume?>"></div>
										<div style="clear:both;"></div>
										
										<div id="div_texte_titre" class="titre_champ">Texte :</div>
										<div id="div_texte" class="champ"><textarea name="corps_texte" id="corps_texte"><?=$texte?></textarea></div>
										<div style="clear:both;"></div>
										
										<div class="bouton">
											<div style="float:right;">
									        	<a href="javascript:annuler();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../images/buttons/resetHover.png',0)"><img src="../images/buttons/reset.png" name="Image1" border="0"></a>
												<a href="javascript:valider();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/buttons/submitHover.png',0)"><img src="../images/buttons/submit.png" name="Image2" border="0"></a>
											</div>
											<div id="div_wait" style="margin-right: 160px;margin-top: 5px; display: none;"><img src="../images/activity.gif" alt="Loading..."></div>
											<div id="div_affichage_erreur" style="display: none;">
												<table width="320" cellpadding=0 cellspacing=0 border="0">
												<tr>
													<td width="40" align="center"><img src="../images/alerte-petit.gif" alt="Loading...">&nbsp;</td>
													<td width=*"><font color="#B30307"><b>Attention, certains champs sont obligatoires...</b></font></td>
												</tr>
												</table>
											</div>
										</div>
										<div style="clear:both;"></div>
									</fieldset>
									
									<fieldset style="display:<?=$display?>;">
										<legend><font color="#688FD5"><b>Images de l'animal</b></font></legend>
										
										<div style="height:100px;">
											<div class="titre_champ">Ajouter une image :</div>
											<div class="champ">
												<input type="file" name="fic_image" size="100" onchange="uploader();">
											</div>
											<div id="div_wait_upload" style="display: none;"><img src="../images/activity.gif" alt="Loading..."></div>
											<div style="clear:both;"></div>
											
											<div style="height:75px; overflow :auto; border: 0px solid blue;">
												<? 
												if ( !empty( $liste_image ) ) {
													?>
													<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
													<tr>
														<td align="left" valign="top">
															<div style="height:100%;overflow :auto;">
																<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
																<tr>
																	<td>
																		<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
																		<tr>
																			<td width="*" align="left"><b>Image</b></td>
																			<td width="20">&nbsp;</td>
																		</tr>
																		</table>
																	</td>
																</tr>
																<?
																$index = 1;
																
																// On liste tous les sites
																foreach( $liste_image as $_image ) {
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
													<a href="../../images/animal/<?=$_image->fic_image?>" rel="groupe_image" title="<?=stripcslashes( utf8_encode( $_image->fic_image ) )?>"><?=stripcslashes( utf8_encode( $_image->fic_image ) )?></a>
												</td>
												<td width="20" align="right" valign="middle">
													<a href="javascript:supprimer_image(<?=$_image->num_animal_image?>);"><img src="../images/icones/delete.gif" border="0" title="Supprimer"></a>
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
															<div style="height:100%;">
																<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
																<tr>
																	<td align="center"><font color="#CC3300"><b>Aucune image associ&eacute;e &agrave; cet animal.</b></font></td>
																</tr>
																</table>
															</div>
														</td>
													</tr>
													</table>
													<?
												}
												?>
											</div>
										</div>
									</fieldset>
									
									<fieldset style="display:<?=$display?>;">
										<legend><font color="#688FD5"><b>Produit associ&eacute; &agrave;...</b></font></legend>
										
										<div class="champ_simple">
											<table width="750" cellpadding=0 cellspacing=0 border="0">
											<tr>
												<td width="100%" align="center">
													<select multiple name="fromBox[]" id="fromBox">
														<? 
														// On liste tous les produits associés
														foreach( $liste_produit_associe as $_produit_associe ) {
															?>
															<option value="<?=$_produit_associe->num_produit_associe?>"><?=stripcslashes( utf8_encode( $_produit_associe->nom ) )?></option>
															<?
														}
														?>
													</select>
													<select multiple name="toBox[]" id="toBox">
														<? 
														// On liste tous les produits associés
														foreach( $liste_produit_deja_associe as $_produit_associe ) {
															?>
															<option value="<?=$_produit_associe->num_produit_associe?>"><?=stripcslashes( utf8_encode( $_produit_associe->nom ) )?></option>
															<?
														}
														?>
													</select>
												</td>
											</tr>
											</table>
										</div>
										<div style="clear:both;"></div>
										
										<div class="bouton">
											<div style="float:right;">
												<a href="javascript:valider_produit_associe();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image21','','../images/buttons/submitHover.png',0)"><img src="../images/buttons/submit.png" name="Image21" border="0"></a>
											</div>
											<div id="div_wait_animal" style="margin-right: 80px;margin-top: 5px; display: none;"><img src="../images/activity.gif" alt="Loading..."></div>
										</div>
										<div style="clear:both;"></div>
									</fieldset>
								</div>
							</form>
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
	
	<script type="text/javascript">
		createMovableOptions("fromBox", "toBox", 750, 125, 'Articles associ&eacute;s disponibles', 'Articles associ&eacute;s s&eacute;lectionn&eacute;s');
	</script>
</body>
</html>
<? include('../../include_connexion/connexion_site_off.php'); ?>