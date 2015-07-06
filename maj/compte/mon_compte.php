<? require_once('../../classes/start_session_admin.php'); ?>
<? require_once('../../classes/config.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	
	$utilisateur = new utilisateur();
	$utilisateur->load($_SESSION["maj"]["num_utilisateur"]);
	
	// On souhaite une modification de l'utilisateur
	if ($mon_action == "modification") {
		$utilisateur->civilite = $_POST["civilite"];
		$utilisateur->nom_utilisateur = $_POST["nom_utilisateur"];
		$utilisateur->prenom_utilisateur = $_POST["prenom_utilisateur"];
		$utilisateur->mail_utilisateur = $_POST["mail_utilisateur"];
		$utilisateur->login = $_POST["login"];
		
		if (($post["nouveau_mdp"] != "") && ($post["confirmation"] != ""))
			$utilisateur->mdp = $_POST["nouveau_mdp"];
		
		$utilisateur->modifierUtilisateur();
		
		// Message de confirmation
		$message = "[-- Informations personnelles modifi&eacute;es. --]";
	}
	
	$titre_page = "Mon compte";
	$menu_compte = "mon compte";
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
	-->
	</style>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function checkEmail(adr) {
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(adr)) {
					return (true);
			}
			erreur('mail_utilisateur','L\'adresse mail est incorrecte');
			return (false);
		}
		
		function valider() {
			var val_erreur = 0;
			
			if (document.formulaire.civilite.value == "") {
				erreur('civilite','La civilit&eacute; du utilisateur est obligatoire');
				val_erreur = 1;
			}
			
			else if (trim(document.formulaire.nom_utilisateur.value) == "") {
				erreur('nom_utilisateur','Le nom du utilisateur est obligatoire');
				val_erreur = 1;
			}
			
			else if (trim(document.formulaire.prenom_utilisateur.value) == "") {
				erreur('prenom_utilisateur','Le pr&eacute;nom du utilisateur est obligatoire');
				val_erreur = 1;
			}
			
			else if (trim(document.formulaire.login.value) == "") {
				erreur('login','Le login est obligatoire');
				val_erreur = 1;
			}
			
			else if (trim(document.formulaire.mail_utilisateur.value) == "") {
				erreur('mail_utilisateur','Le mail est obligatoire');
				val_erreur = 1;
			}
			
			if (trim(document.formulaire.nouveau_mdp.value) != "") {
				
				// Les 2 champs sont remplis --> Ils doivent être identiques
				if ((trim(document.formulaire.nouveau_mdp.value) != "") && (trim(document.formulaire.confirmation.value) != "")) {
					
					if (trim(document.formulaire.nouveau_mdp.value) != trim(document.formulaire.confirmation.value) != "") {
						erreur('nouveau_mdp','Le nouveau mot de passe et la confirmation doivent être identiques');
						val_erreur = 1;
					}
				}
				
				else  {
					erreur('confirmation','Veuillez confirmer votre nouveau mot de passe');
					val_erreur = 1;
				}
			}
			else {
				document.formulaire.nouveau_mdp.value = "";
				document.formulaire.confirmation.value = "";
			}
			
			if (val_erreur == 0) {
				
				// On regarde si l'adresse mail est bien formée
				if (checkEmail(document.formulaire.mail_utilisateur.value)) {
					document.formulaire.mon_action.value = "modification";
					document.formulaire.submit();
				}
			}
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
						<td class="titrepage" colspan="2" height="30" valign="top"><?=$titre_page?></td>
					</tr>
					<tr>
						<td height="20" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td width="100%" valign="top">
							<form name="formulaire" method="POST" action="mon_compte.php">
								<input type="hidden" name="mon_action" value="">
								
								<table width="100%" cellpadding=0 cellspacing=0 border="0">
								<? if ($message != "") { ?>
									<tr>
										<td width="130" height="25">&nbsp;</td>
										<td><font color="green"><b><?=$message?></b></font></td>
									</tr>
								<? } ?>
								<tr>
									<td width="130" height="25" valign="middle">Civilit&eacute; * :</td>
									<td>
										<select name="civilite" id="civilite">
											<option value="">-- Choisir --</option>
											<option value="Mme" <? if ($utilisateur->civilite == "Mme") { ?> selected <? } ?>>Mme</option>
											<option value="Melle" <? if ($utilisateur->civilite == "Melle") { ?> selected <? } ?>>Melle</option>
											<option value="M." <? if ($utilisateur->civilite == "M.") { ?> selected <? } ?>>M.</option>
										</select>
									</td>
								</tr>
								<tr>
									<td height="25" valign="middle">Nom * :</td>
									<td><input type="text" name="nom_utilisateur" id="nom_utilisateur" size="50" maxlenght="100" value="<?=str_replace("\\", "", $utilisateur->nom_utilisateur)?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Pr&eacute;nom * :</td>
									<td><input type="text" name="prenom_utilisateur" id="prenom_utilisateur" size="50" maxlenght="100" value="<?=str_replace("\\", "", $utilisateur->prenom_utilisateur)?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Mail * :</td>
									<td><input type="text" name="mail_utilisateur" id="mail_utilisateur" size="50" maxlenght="50" value="<?=str_replace("\\", "", $utilisateur->mail_utilisateur)?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Login * :</td>
									<td><input type="text" name="login" id="login" size="50" maxlenght="100" value="<?=str_replace("\\", "", $utilisateur->login)?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Mot de passe * :</td>
									<td><input type="password" name="mdp" id="mdp" size="25" maxlenght="25" value="<?=str_replace("\\", "", $utilisateur->mdp)?>" readonly></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Nouveau mot de passe :</td>
									<td><input type="password" name="nouveau_mdp" id="nouveau_mdp" size="25" maxlenght="25" value=""></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Confirmation :</td>
									<td><input type="password" name="confirmation" id="confirmation" size="25" maxlenght="25" value=""></td>
								</tr>
								</table>
							</form>
						</td>
					</tr>
					<tr>
						<td height="20" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top">
							<a href="javascript:valider();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/buttons/submitHover.png',0)"><img src="../images/buttons/submit.png" name="Image2" border="0"></a>
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