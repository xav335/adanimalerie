<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_etat = $_POST["num_etat"];
	$num_etat_paiement = $_POST["num_etat_paiement"];
	
	/*echo "<pre>";
	print_r( $_POST );
	echo "</pre>";*/
	
	if ( $num_etat_paiement == '' ) $num_etat_paiement = -1;
	
	$etat = new etat();
	$commande = new commande();
	$client = new client();
	
	$etat_compte = ( $_POST["etat_compte"] == "" ) ? "" : $_POST["etat_compte"];
	$compte_supprime = ( $_POST["compte_supprime"] == "" ) ? "" : $_POST["compte_supprime"];
	$type_tri = $_POST["type_tri"];
	$ordre = $_POST["ordre"];
	
	// Modification de la commande
	if ($mon_action == "modification") {
		$result = $commande->gererDonnees( $_POST );
	}
	
	// Liste des états de commandes disponibles
	$liste_etat = $etat->getListe();
	
	// Liste des commandes
	if ( $num_etat_paiement >= 0 ) $recherche = "commande.num_etat_paiement = '" . $num_etat_paiement . "'";
	$liste = $commande->getListe( 0, $num_etat, $recherche, '', $type_tri, $ordre);
	
	$menu = "commande";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="../../js/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="../../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="../../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
	<script type="text/javascript">
		$(document).ready(function() {
			$(".iframe").fancybox({
				'width'				: '50%',
				'height'			: '65%',
		        'autoScale'     	: false,
		        'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			$(".iframe_bon").fancybox({
				'width'				: '80%',
				'height'			: '80%',
		        'autoScale'     	: false,
		        'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		});
	</script>
	
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
		
		function rechercher() {
			document.formulaire.target = "";
			document.formulaire.action = "liste.php";
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
							<td class="titrepage" height="30" valign="top">Liste des commandes</td>
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
												<option value="commande.date_creation" <? if ($type_tri == "commande.date_creation") { ?> selected <? } ?>>Par date de commande</option>
												<option value="num_etat" <? if ($type_tri == "num_etat") { ?> selected <? } ?>>Par &eacute;tat de commande</option>
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
										<td height="25" width="150" valign="middle">Etat de la commande :</td>
										<td align="left" valign="middle">
											<select name="num_etat">
												<option value="" selected>-- Tous --</option>
												<?
												foreach($liste_etat as $_etat) {
													?>
													<option value="<?=$_etat->num_etat?>" <? if ($num_etat == $_etat->num_etat) { ?> selected <? } ?>><?=stripslashes( utf8_encode( $_etat->texte ) )?></option>
													<?
												}
												?>
											</select>
										</td>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td height="25" width="150" valign="middle">Etat du paiement :</td>
										<td align="left" valign="middle">
											<select name="num_etat_paiement">
												<option value="" selected>-- Tous --</option>
												<option value="0" <? if ( $num_etat_paiement == 0 ) { ?> selected <? } ?>>Annulé</option>
												<option value="1" <? if ( $num_etat_paiement == 1 ) { ?> selected <? } ?>>En cours</option>
												<option value="2" <? if ( $num_etat_paiement == 2 ) { ?> selected <? } ?>>Validé</option>
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
									<legend><font color="#688FD5"><b>Liste des commandes</b></font></legend>
									
									<? 
									if ( !empty( $liste ) ) {
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
																<td width="*"><b>Client</b></td>
																<td width="100" align="left"><b>Date</b></td>
																<td width="60" align="left"><b>Montant</b></td>
																<td width="150" align="center"><b>Etat</b></td>
																<td width="150" align="center"><b>Paiement</b></td>
																<td width="40">&nbsp;</td>
															</tr>
															</table>
														</td>
													</tr>
													<?
													$index = 1;
													
													// On liste tous les clients
													foreach($liste as $_commande) {
														$index = $index + 1;
														
														if ($index % 2) {
															$choix_couleur = "#F5FFE5";
															$fonce = "_fonce";
														}
														else {
															$choix_couleur = "#E4FDC3";
															$fonce = "";
														}
														
														// Chargement du client
														$client->load( $_commande->num_client );
														
														// Chargement de l'etat de la commande
														$etat->load( $_commande->num_etat );
														
														// Etat du paiement
														if ( $_commande->num_etat_paiement == 0 ) $paiement = "<font color='#CC3300'>Annulé</font>";
														else if ( $_commande->num_etat_paiement == 1 ) $paiement = "<font color='#EAA327'>En cours</font>";
														else $paiement = "<font color='green'>Validé</font>";
														?>
				<tr>
					<td>
						<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
						<tr>
							<td>
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
								<tr>
									<td width="*" height="20"><?=stripslashes( utf8_encode( $client->nom ) )?>&nbsp;<?=stripslashes( utf8_encode( $client->prenom ) )?></td>
									<td width="100" align="left"><?=traitement_date_affiche( $_commande->date_creation )?></td>
									<td width="60" align="left"><?=$_commande->prix?>&euro;</td>
									<td width="150" align="center"><?=stripslashes( utf8_encode( $etat->texte ) )?></td>
									<td width="150" align="center"><?=$paiement?></td>
									<td width="40" align="center" valign="middle">
										<a class="iframe" href="detail_commande.php?n=<?=$_commande->num_commande?>"><img src="../images/icones/edit.gif" border="0" title="Modifier ce client"></a>
										<a class="iframe_bon" href="bon_de_livraison.php?n=<?=$_commande->num_commande?>"><img src="../images/icones/textalign.gif" border="0" title="Imprimer le bon de livraison"></a>
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
														<td align="center"><font color="#CC3300"><b>Aucune commande dans la base.</b></font></td>
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