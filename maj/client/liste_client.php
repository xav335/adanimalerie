<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_client = $_POST["num_client"];
	
	$etat_compte = ( $_POST["etat_compte"] == "" ) ? "" : $_POST["etat_compte"];
	$type_tri = ( $_POST["type_tri"] == "" ) ? "nom" : $_POST["type_tri"];
	$ordre = ( $_POST["ordre"] == "" ) ? "asc" : $_POST["ordre"];
	
	$client = new client();
	
	// Suppression de l'accès
	if ($mon_action == "suppression") {
		if ( $client->load($num_client) ) $client->supprimer();
	}
	
	// Liste des clients disponibles
	$liste_client = $client->getListeClient($etat_compte, '0', $type_tri, $ordre);
	
	$menu = "client";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function afficher(num) {
			//alert(num);
			document.formulaire.target = "";
			document.formulaire.action = "ajout_client.php";
			document.formulaire.num_client.value = num;
			document.formulaire.submit();
		}
		
		function supprimer(num) {
			if (confirm("Voulez vous vraiment supprimer ce client ainsi que ces réservations?")) {
				document.formulaire.action = "liste_client.php";
				document.formulaire.mon_action.value = "suppression";
				document.formulaire.num_client.value = num;
				document.formulaire.submit();
			}
		}
		
		function rechercher() {
			document.formulaire.target = "";
			document.formulaire.action = "liste_client.php";
			document.formulaire.mon_action.value = "";
			document.formulaire.submit();
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
	<form name="formulaire" method="POST" action="ajout_client.php">
		<input type="hidden" name="mon_action" value="">
		<input type="hidden" name="num_client" value="">
	
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
							<td class="titrepage" height="30" valign="top">Liste des clients</td>
						</tr>
						<tr>
							<td>
								<fieldset style="display:block;margin:0;">
									<legend><font color="#688FD5"><b>Trier les r&eacute;sultats</b></font></legend>
									
									<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
									<tr>
										<td height="25" width="150" valign="middle">Crit&egrave;re(s) de recherche :</td>
										<td width="100" align="left" valign="middle">
											<select name="type_tri">
												<option value="" selected>-- Choisir --</option>
												<option value="nom" <? if ($type_tri == "nom") { ?> selected <? } ?>>Par nom de client</option>
												<option value="actif" <? if ($type_tri == "actif") { ?> selected <? } ?>>Par &eacute;tat du compte</option>
											</select>	
										</td>
										<td width="100" align="right" valign="middle">
											<select name="ordre">
												<option value="" selected>-- Choisir --</option>
												<option value="asc" <? if ($ordre == "asc") { ?> selected <? } ?>>A --> z</option>
												<option value="desc" <? if ($ordre == "desc") { ?> selected <? } ?>>Z --> a</option>
											</select>	
										</td>
										<td width="10">&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td height="25" width="150" valign="middle">Etat du compte :</td>
										<td align="left" valign="middle">
											<select name="etat_compte">
												<option value="" selected>-- Tous --</option>
												<option value="0" <? if ($etat_compte == "0") { ?> selected <? } ?>>Client inactif</option>
												<option value="1" <? if ($etat_compte == "1") { ?> selected <? } ?>>Client actif</option>
											</select>	
										</td>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="4">&nbsp;</td>
										<td align="right">
											<input type="button" value="Trier les r&eacute;sultats" onclick="rechercher();">
										</td>
									</tr>
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td height="20">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<fieldset style="display:block;margin:0;">
									<legend><font color="#688FD5"><b>Liste des clients</b></font></legend>
									
									<? 
									if ( !empty( $liste_client ) ) {
										?>
										<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
										<tr>
											<td align="left" valign="top">
												<div style="height:550;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td>
															<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
															<tr>
																<td width="*"><b>Nom</b></td>
																<td width="30" align="center"><b>Actif</b></td>
																<td width="40">&nbsp;</td>
															</tr>
															</table>
														</td>
													</tr>
													<?
													$index = 1;
													
													// On liste tous les clients
													foreach($liste_client as $_client) {
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
										<a href="javascript:afficher(<?=$_client->num_client?>);"><?=stripslashes( utf8_encode( $_client->nom ) )?>&nbsp;<?=stripslashes( utf8_encode( $_client->prenom ) )?></a>
									</td>
									<td width="30" align="center">
										<?
										// Ce client est actif
										if ($_client->actif == 1) {
											$image = "ok" . $fonce . ".gif";
											$alt = "Client actif";
										}
										else {
											$image = "croix" . $fonce . ".gif";
											$alt = "Client inactif";
										}
										?>
										<img src="../images/<?=$image?>" border="0" title="<?=$alt?>">
									</td>
									<td width="40" align="right" valign="middle">
										<a href="javascript:afficher(<?=$_client->num_client?>);"><img src="../images/icones/edit.gif" border="0" title="Modifier ce client"></a>
										<a href="javascript:supprimer(<?=$_client->num_client?>);"><img src="../images/icones/delete.gif" border="0" title="Supprimer ce client"></a>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
													<? } ?>
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
												<div style="height:550;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td align="center"><font color="#CC3300"><b>Aucun client dans la base.</b></font></td>
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