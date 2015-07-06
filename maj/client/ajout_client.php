<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_client = $_POST["num_client"];
	
	$client = new client();
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	
	// On souhaite une modification du client
	if ($mon_action == "modification") {
		//echo "Modification...<br>";

		// Dans le cas d'un ajout, on vérifie que le mail n'existe pas déjà dans la base
		if ( !$client->load( $_POST["num_client"] ) ) {
			//echo "Ajout...<br>";
			
			if ( $client->isMailExist( $_POST["email"] ) ) {
				$message_erreur = "D&eacute;sol&eacute;, cette adresse mail existe d&eacute;j&agrave; dans la base.";
				$client->nom = trim( $_POST["nom"] );
				$client->prenom = trim( $_POST["prenom"] );
				$client->adresse = trim( $_POST["adresse"] );
				$client->cp = trim( $_POST["cp"] );
				$client->ville = trim( $_POST["ville"] );
				$client->telephone = trim( $_POST["tel"] );
				$client->mail = trim( $_POST["email"] );
				$client->mdp = $_POST["mdp"];
			}
			else
				$client->gererDonnees( $_POST );
		}
		else
			$client->gererDonnees( $_POST );
		
		// Redirection (s'il n'y a pas d'erreur)
		if ( $message_erreur == "" ) header("Location: ./liste_client.php");
	}
	
	if ( $client->load( $num_client ) ) {
		$titre_page = "Modification de " . chr(34) . stripslashes( utf8_encode( $client->nom ) ) . " " . stripslashes( utf8_encode( $client->prenom ) ) . chr(34);
		
		$checked_actif_oui = ($client->actif == 1) ? "checked" : "";
		$checked_actif_non = ($client->actif == 1) ? "" : "checked";
	}
	else {
		$titre_page = "Ajout d'un client";
		
		$checked_actif_oui = "";
		$checked_actif_non = "checked";
	}
	
	$menu = "client ajout";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function checkEmail(adr) {
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(adr)) {
				return (true);
			}
			return (false);
		}
		
		function initialiser() {
			find("nom").className = "";
			find("prenom").className = "";
			find("adresse").className = "";
			find("cp").className = "";
			find("ville").className = "";
			find("tel").className = "";
			find("email").className = "";
			find("mdp").className = "";
			find("mdp2").className = "";
		}

		function valider() {
			initialiser();
			
			var var_erreur = 0;
			find("div_affichage_erreur").style.display = "none";
			find("div_wait").style.display = "block";
			
			if (trim(document.formulaire.nom.value) == "") {
				find("nom").className = "erreur";
				var_erreur = 1;
			}
			
			if (trim(document.formulaire.prenom.value) == "") {
				find("prenom").className = "erreur";
				var_erreur = 1;
			}
			
			if (trim(document.formulaire.adresse.value) == "") {
				find("adresse").className = "erreur";
				var_erreur = 1;
			}
			
			if (trim(document.formulaire.cp.value) == "") {
				find("cp").className = "erreur";
				var_erreur = 1;
			}
			
			if (trim(document.formulaire.ville.value) == "") {
				find("ville").className = "erreur";
				var_erreur = 1;
			}
			
			if (trim(document.formulaire.tel.value) == "") {
				find("tel").className = "erreur";
				var_erreur = 1;
			}
			
			<?
			// Dans le cas d'une création de client, on ajoute ce test
			if ( $client->num_client == 0 ) {
				?>
				if (trim(document.formulaire.email.value) == "") {
					find("email").className = "erreur";
					var_erreur = 1;
				}
				else if ( !checkEmail( trim(document.formulaire.email.value) ) ) {
					find("email").className = "erreur";
					var_erreur = 1;
				}
				
				if ( trim(document.formulaire.mdp.value) == "" ) {
					find("mdp").className = "erreur";
					find("mdp2").className = "erreur";
					var_erreur = 1;
				}
				<?
			}
			?>
			
			if ( (trim(document.formulaire.mdp.value) != "") || (trim(document.formulaire.mdp2.value) != "") ) {
				if (trim(document.formulaire.mdp.value) != trim(document.formulaire.mdp2.value)) {
					find("mdp").className = "erreur";
					find("mdp2").className = "erreur";
					var_erreur = 1;
				}
			}
			
			if ( var_erreur == 0) {
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
			document.formulaire.action = "liste_client.php";
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
				
				<!-- Menu de gauche -->
				<? include_once("../includes/menu_gauche.php"); ?>
			
				<td width="*" style="vertical-align:top;padding:10px;">
					<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
					<tr>
						<td class="titrepage" colspan="2" height="30" valign="top"><?=$titre_page?></td>
					</tr>
					<tr>
						<td height="20" colspan="2">
							<?
							// Affichage de messages d'erreur éventuels
							if ( $message_erreur != "" ) {
								echo "<div style='background-color: #F5A10F; height: 25px; padding-top: 10px; padding-left: 10px; margin-top: 10px; margin-bottom: 10px; border: 1px solid #CC3300;'>";
								echo "<b><font color='#CC3300'>" . $message_erreur . "</font></b>";
								echo "</div>";
							}
							?>
						</td>
					</tr>
					<tr>
						<td width="100%" valign="top">
							<form name="formulaire" method="POST" action="ajout_client.php">
								<input type="hidden" name="num_client" value="<?=$client->num_client?>">
								<input type="hidden" name="mon_action" value="">
								
								<table cellpadding=0 cellspacing=0 width="100%" border="0">
								<tr>
									<td width="100" height="25" valign="middle">Nom * :</td>
									<td><input type="text" name="nom" id="nom" size="50" maxlenght="100" value="<?=stripslashes( utf8_encode( $client->nom ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Pr&eacute;nom * :</td>
									<td><input type="text" name="prenom" id="prenom" size="50" maxlenght="100" value="<?=stripslashes( utf8_encode( $client->prenom ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Adresse * :</td>
									<td><input type="text" name="adresse" id="adresse" size="50" maxlenght="250" value="<?=stripslashes( utf8_encode( $client->adresse ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Code postal * :</td>
									<td><input type="text" name="cp" id="cp" size="4" maxlenght="10" value="<?=stripslashes( utf8_encode( $client->cp ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">ville * :</td>
									<td><input type="text" name="ville" id="ville" size="50" maxlenght="10" value="<?=stripslashes( utf8_encode( $client->ville ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">T&eacute;l&eacutephone * :</td>
									<td><input type="text" name="tel" id="tel" size="15" maxlenght="20" value="<?=stripslashes( utf8_encode( $client->telephone ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Mail * :</td>
									<td>
										<?
										// Dans le cas d'une création de client, on ajoute le champ "mail"
										$readonly = ( $client->num_client == 0 ) ? "" : "readonly";
										?>
										<input type="text" name="email" id="email" size="50" maxlenght="100" <?=$readonly?> value="<?=stripslashes( utf8_encode( $client->mail ) )?>">
								</tr>
								<tr>
									<td height="25" valign="middle">Mot de passe :</td>
									<td><input type="password" name="mdp" id="mdp" size="50" maxlenght="100" value="<?=stripslashes( utf8_encode( $client->mdp ) )?>"></td>
								</tr>
								<tr>
									<td height="25" valign="middle">Confirmation :</td>
									<td><input type="password" name="mdp2" id="mdp2" size="50" maxlenght="100" value="<?=stripslashes( utf8_encode( $client->mdp ) )?>"></td>
								</tr>
								<tr>
									<td height="25">Client actif :</td>
									<td>
										<input type="radio" name="actif" value="1" <?=$checked_actif_oui?>>&nbsp;Oui&nbsp;
										<input type="radio" name="actif" value="0" <?=$checked_actif_non?>>&nbsp;Non
									</td>
								</tr>
								<tr>
									<td height="20" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" align="right" valign="top">
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
									</td>
								</tr>
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