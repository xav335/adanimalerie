<? require_once('../../classes/config.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$mail_utilisateur = $_POST["mail_utilisateur"];
	
	$utilisateur = new utilisateur();
	
	// On souhaite une modification de l'utilisateur
	if ($mon_action == "modification") {
		
		// Chargement de l'utilisateur ...
		if ( $utilisateur->loadByMail($mail_utilisateur) ) {
		
			// Préparation du message à envoyer
			$_to = $utilisateur->mail_utilisateur;
			$sujet = "Identifiants perdus";
			//echo "Envoi du message à " . $_to . "<br>";
			
			$entete = "From:www.alphatravel.fr <NePasRepondre@alphatravel.fr>\n";
			$entete .= "MIME-version: 1.0\n";
			$entete .= "Content-type: text/html; charset= iso-8859-1\n";
			
			$corps = "";
			$corps .= "Bonjour,<br>Voici vos identifiants : <br>";
			$corps .= "login : " . $utilisateur->login . "<br>";
			$corps .= "mot de passe : " . $utilisateur->mdp . "<br><br>";
			$corps .= "A très bientôt sur notre site.<br>";
			//echo $corps . "<br>";
			
			// Envoi des identifiants par mail
			if(mail($_to, $sujet, stripslashes($corps), $entete))
				$message = "<font color='green'><b>Message envoy&eacute;.<br>Vous allez recevoir vos identifiants d'ici quelques instants.</b></font>";
			else
				$message = "<font color='#CC3300'><b>Erreur lors de la proc&eacute;dure d'envoi. Veuillez essayer ult&eacute;rieurement.</b></font>";
		}
		else
			$message = "<font color='#CC3300'><b>Erreur lors de la proc&eacute;dure d'envoi. Cette adresse est introuvable.</b></font>";
	}
	
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
		
		function valider() {
			if (document.formulaire.mail_utilisateur.value != "") {
				document.formulaire.mon_action.value = "modification";
				document.formulaire.submit();
			}
		}
		
		function annuler() {
			document.formulaire.action = "../index.php";
			document.formulaire.submit();
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
<div id="erreurdiv"></div>
<div id="DIV_TRIPTIC" style="position:absolute;top:0;left:0;display:none;"></div>
<div id="div_travail" style="position:absolute;top:0;left:0;visibility:hidden;"></div>
	<table cellpadding=0 cellspacing=0 style="width:968px;height:100%;" align="center" border="0" id="CONTENT">
	<tr>
		<td width="100%" style="height:64px;background:url(../images/ref-struc-top.gif);">
	</tr>
	<tr style="background:#FFF;">
		<td>
			<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" align="center" border="0">
			<tr>
				<td style="width:4px;background:#A9BFE7;">
				<td width="150" style="vertical-align:top;padding:0 1px 10px 1px;border-right:solid 1px #A9BFE7;background:#D2E3F3;">&nbsp;</td>
				<td width="*" style="vertical-align:top;padding:10px;">
					<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
					<tr>
						<td class="titrepage" colspan="2" height="30" valign="top">Mot de passe perdu?</td>
					</tr>
					<tr>
						<td height="20" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td width="100%" valign="top">
							<form name="formulaire" method="POST" action="mot_de_passe.php">
								<input type="hidden" name="mon_action" value="">
								
								<table width="100%" cellpadding=0 cellspacing=0 border="0">
								<? if ($message != "") { ?>
									<tr>
										<td width="100%" align="center"><?=$message?></td>
									</tr>
									<tr>
										<td height="20" colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" align="right" valign="top">
											<a href="javascript:annuler();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/buttons/backHover.png',0)"><img src="../images/buttons/back.png" name="Image2" border="0"></a>
										</td>
									</tr>
									<? 
								}
								else {
									?>
									<tr>
										<td width="70" height="25" valign="middle">Votre mail * :</td>
										<td><input type="text" name="mail_utilisateur" id="mail_utilisateur" size="50" maxlenght="50" value=""></td>
									</tr>
									<tr>
										<td height="20" colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" align="right" valign="top">
											<a href="javascript:valider();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/buttons/submitHover.png',0)"><img src="../images/buttons/submit.png" name="Image2" border="0"></a>
										</td>
									</tr>
								<? } ?>
								</table>
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