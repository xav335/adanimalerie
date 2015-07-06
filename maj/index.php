<? include('../classes/config.php'); ?>
<?
	session_start();
	//print_r( $_SESSION["maj"] );
	
	// Cet utilisateur est déjà connecté -> Redirection vers la page des menus
	if ( $_SESSION["maj"]["connexion_etablie"] == "valide" ) header("Location: page_accueil.php");
	
	// Récupération des données passées en paramètres
	$erreur = $_POST["erreur"];
	
	// Suivant le type d'erreur...
	switch($erreur) {
		case "password envoyé" :
			$message = "Vous allez recevoir vos identifiants par mail.";	
			break;
			
		case "password non envoyé" :
			$message = "Problèmes techniques. Veuillez essayer ultérieurement.";	
			break;
			
		default:
			$message = "Une erreur est survenue lors de la connexion.";	
			break;
	}
?>

<html lang="fr">
<head>
	<title><?=TITRE_SITE?> - Administration -</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META name="Toolbar-imaging" http-equiv="imagetoolbar" CONTENT="no">
	
	<link rel="stylesheet" href="./css/style.css" type="text/css">
	
	<script language=Javascript>
	<!--
		<!-- Titre de la page et CSS -->
		<? include_once('./js/js.js');?>
		
	//-->
	</SCRIPT>
	
	<style type="text/css">
	/*GLOBAL CSS*/
		.green {font-family:Arial;font-size:8pt;color:#6DAC20}
		.erreur_login {font-family:Arial;font-size:8pt;color:#CC3300}
	</style>
</HEAD>

<body bgcolor="#688FD5">
	<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
	<tr>
		<td align="center" valign="middle">
			<table cellpadding=0 cellspacing=0 style="width:968px;height:551px;" border="0">
			<tr>
				<td style="height:64px;background:url(images/loginHeaderTop.gif);" align="center" valign="top"></td>
			</tr>
			<tr>
				<td width="968" style="height:471px;background:url(images/ref-struc-content.gif);" align="center" valign="middle">
					<form name="formulaire" action="./verif_access.php" method="POST">
						<table cellpadding="5" cellspacing="0" style="width:30%;" border="0">
						<?
						// Affichage d'un message d'erreur survenu lors de la connexion au site
						if ($erreur != "") {
						?>
							<tr>
								<td colspan="3" align="center"><b class=erreur_login><?=$message?></b></td>
							</tr>
						<? } ?>
						
						<tr>
							<td align="right"><b class=green>Login</b></td>
							<td width="10">&nbsp;</b></td>
							<td style="width:150px;">
								<input type="text" name="log" value="">
								<script type="text/javascript">
								<!--
									document.formulaire.log.focus();
								//-->
								</script>
							</td>
						</tr>
						<tr>
							<td align="right"><b class=green>Password</b></td>
							<td width="10">&nbsp;</b></td>
							<td><input type="password" name="mdp" value=""></td>
						</tr>
						<tr>
							<td align="right">&nbsp;</td>
							<td width="10">&nbsp;</b></td>
							<td><a href="./compte/mot_de_passe.php" class="lien">Mot de passe perdu?</a></td>
						</tr>
						<tr>
							<td colspan="3" align="right">
								<input type="image" src="images/btOkSimple.gif" id="Image1" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/btOkSimple_hover.gif',0)">
							</td>
						</tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td style="height:16px;background:url(images/bg_footer.gif);"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>