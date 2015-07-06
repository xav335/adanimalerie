<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_promotion = $_POST["num_promotion"];
	
	$promotion = new promotion();
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	
	// On souhaite une modification
	if ($mon_action == "modification") {
		
		// Mise à jour de la base
		$promotion->gererDonnee( $_POST );
		header("Location: ./liste.php");
	}
	
	if ( $promotion->load( $num_promotion ) ) {
		$titre_page = "Modification d'une promotion";
		
		$titre = stripcslashes( utf8_encode( $promotion->titre ) );
		$sous_titre = stripcslashes( utf8_encode( $promotion->sous_titre ) );
		$reduction = stripcslashes( utf8_encode( $promotion->reduction ) );
		$texte = str_replace("\\", "", $promotion->texte);
		$checked_oui = ( $promotion->online == '1') ? "checked" : "";
		$checked_non = ( $promotion->online == '1') ? "" : "checked";
	}
	else {
		$titre_page = "Ajout d'une promotion";
		$titre = "";
		$sous_titre = "";
		$reduction = "";
		$texte = "";
		$date_creation = date("d/m/Y");
		$checked_oui = "";
		$checked_non = "checked";
	}
	
	// Liste des promotions disponibles
	$liste_promotion = $promotion->getListe();
	
	$menu = "promotion ajout";
?>

<html>
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function initialiser() {
			find("titre").className = "";
			find("sous_titre").className = "";
			find("reduction").className = "";
			find("texte").className = "";
		}
		
		function valider() {
			initialiser();
			
			var val_erreur = 0;
			find("div_affichage_erreur").style.display = "none";
			find("div_wait").style.display = "block";
			
			if (trim( find("titre").value ) == "") {
				find("titre").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("sous_titre").value ) == "") {
				find("sous_titre").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("reduction").value ) == "") {
				find("reduction").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("texte").value ) == "") {
				find("texte").className = "erreur";
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
						<td height="20">&nbsp;</td>
					</tr>
					<tr>
						<td width="100%" valign="top">
							<form name="formulaire" method="POST" action="ajout.php">
								<input type="hidden" name="num_promotion" value="<?=$promotion->num_promotion?>">
								<input type="hidden" name="mon_action" value="">
								
								<div id="conteneur">
									<div class="titre_champ">Titre * :</div>
									<div class="champ"><input type="text" name="titre" id="titre" size="40" maxlenght="100" value="<?=$titre?>"></div>
									<div style="clear:both;"></div>
									
									<div class="titre_champ">Sous titre * :</div>
									<div class="champ"><input type="text" name="sous_titre" id="sous_titre" size="100" maxlenght="250" value="<?=$sous_titre?>"></div>
									<div style="clear:both;"></div>
									
									<div class="titre_champ">R&eacute;duction * :</div>
									<div class="champ"><input type="text" name="reduction" id="reduction" size="100" maxlenght="250" value="<?=$reduction?>"></div>
									<div style="clear:both;"></div>
									
									<div id="div_texte_titre" class="titre_champ">Texte * :</div>
									<div id="div_texte" class="champ"><input type="text" name="texte" id="texte" size="100" maxlenght="250" value="<?=$texte?>"></div>
									<div style="clear:both;"></div>
									
									<div class="titre_champ">En ligne :</div>
									<div class="champ_simple">
										<input type="radio" name="online" value="0" <?=$checked_non?>>&nbsp;Non&nbsp;&nbsp;
										<input type="radio" name="online" value="1" <?=$checked_oui?>>&nbsp;Oui
									</div>
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
</body>
</html>
<? include('../../include_connexion/connexion_site_off.php'); ?>