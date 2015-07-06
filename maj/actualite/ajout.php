<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_actualite = $_POST["num_actualite"];
	
	$actualite = new actualite();
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	
	// On souhaite une modification
	if ($mon_action == "modification") {
		
		// Mise à jour de la base
		$actualite->gererDonnee( $_POST );
		header("Location: ./liste.php");
	}
	
	if ( $actualite->load( $num_actualite ) ) {
		$titre_page = "Modification d'une actualit&eacute;";
		
		$titre = stripcslashes( utf8_encode( $actualite->titre ) );
		$resume = stripcslashes( utf8_encode( $actualite->resume ) );
		$texte = str_replace("\\", "", $actualite->texte);
		$date_creation = traitement_date_affiche( $actualite->date_creation );
	}
	else {
		$titre_page = "Ajout d'une actualit&eacute;";
		$titre = "";
		$resume = "";
		$texte = "";
		$date_creation = date("d/m/Y");
	}
	
	// Liste des actualites disponibles
	$liste_actualite = $actualite->getListe();
	
	$menu = "actu ajout";
?>

<html>
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	<? include_once('../tinymce.php'); ?>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function initialiser() {
			find("titre").className = "";
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
			
			if (trim( find("titre").value ) == "") {
				//erreur('titre', 'Le titre est obligatoire');
				find("titre").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("resume").value ) == "") {
				//erreur('resume', 'Le r&eacute;sume est obligatoire');
				find("resume").className = "erreur";
				val_erreur = 1;
			}
			
			if (trim( find("texte").value ) == "") {
				//erreur('texte', 'Le texte est obligatoire');
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
								<input type="hidden" name="num_actualite" value="<?=$actualite->num_actualite?>">
								<input type="hidden" name="mon_action" value="">
								<input type="hidden" name="texte" id="texte" value="">
								
								<div id="conteneur">
									<div class="titre_champ">Titre * :</div>
									<div class="champ"><input type="text" name="titre" id="titre" size="40" maxlenght="100" value="<?=$titre?>"></div>
									<div style="clear:both;"></div>
									
									<div class="titre_champ">R&eacute;sum&eacute; * :</div>
									<div class="champ"><input type="text" name="resume" id="resume" size="100" maxlenght="250" value="<?=$resume?>"></div>
									<div style="clear:both;"></div>
									
									<div id="div_texte_titre" class="titre_champ">Texte * :</div>
									<div id="div_texte" class="champ"><textarea name="corps_texte" id="corps_texte" cols="100" rows="35"><?=$texte?></textarea></div>
									<div style="clear:both;"></div>
									
									<div class="titre_champ">Date de cr&eacute;ation * :</div>
									<div class="champ_simple">
										<table width="100%" cellpadding=0 cellspacing=0 border="0">
										<tr>
											<td width="90"><input type="text" class="champ_formulaire" name="date_creation" id="date_creation" size="10" maxlength="10" value="<?=$date_creation?>" readonly ></td>
											<td><a href="#" onclick="displayCalendar(document.formulaire.date_creation,'dd/mm/yyyy',this)"><img src="../images/icones/calendrier.jpg" border="0"></a></td>
										</tr>
										</table>	
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