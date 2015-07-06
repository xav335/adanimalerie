<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_commande = ( $_GET["n"] != "" ) ? $_GET["n"] : $_POST["num_commande"];
	
	$etat = new etat();
	$commande = new commande();
	$commande_produit = new commande_produit();
	$client = new client();
	$categorie = new produit_categorie();
	$produit = new produit();
	
	$affichage_div_ok = "none";
	
	// Modification de l'état de la commande
	if( $mon_action == "modifier" ) {
		//echo "Modification...<br>";
		$commande->gererDonnees( $_POST );
		$affichage_div_ok = "block";
	}
	
	// Liste des états de commandes disponibles
	$liste_etat = $etat->getListe();
	
	// Chargement d'une commande
	$commande->load( $num_commande );
	
	// Chargement du client
	$client->load( $commande->num_client );
	
	// Etat de la commande
	$etat->load( $commande->num_etat );
	
	// Liste des commandes
	$liste = $commande_produit->getListe( $num_commande, 0 );
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function modifier() {
			document.formulaire.mon_action.value = "modifier";
			document.formulaire.submit();
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#fff;">
	<form name="formulaire" method="POST" action="detail_commande.php">
		<input type="hidden" name="mon_action" value="">
		<input type="hidden" name="num_commande" value="<?=$num_commande?>">
		
		<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
		<tr>
			<td class="titrepage" height="30" valign="top">D&eacute;tail de la commande</td>
		</tr>
		<tr>
			<td>
				
				<div style="margin-top: 10px; padding-left:10px; margin-bottom:10px; background-color: #E4FDC3; border: 1px solid green; display: <?=$affichage_div_ok?>">
					<p><font color="green"><b>[--- Mise &agrave; jour r&eacute;alis&eacute;e avec succ&egrave;s ---]</b></font></p>
				</div>
				
				<fieldset style="display:block;margin:0;">
					<legend><font color="#688FD5"><b>Informations sur la commande</b></font></legend>
					
					<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
					<tr>
						<td width="130" height="25">Client :</td>
						<td width="*"><?=stripslashes( utf8_encode( $client->nom ) )?>&nbsp;<?=stripslashes( utf8_encode( $client->prenom ) )?></td>
					</tr>
					<tr>
						<td height="25">Commande pass&eacute;e le :</td>
						<td><?=traitement_date_affiche( $commande->date_creation )?></td>
					</tr>
					<tr>
						<td height="25">Etat :</td>
						<td>
							<select name="num_etat">
							<?
							foreach($liste_etat as $_etat) {
								?>
								<option value="<?=$_etat->num_etat?>" <? if ($commande->num_etat == $_etat->num_etat) { ?> selected <? } ?>><?=stripslashes( utf8_encode( $_etat->texte ) )?></option>
								<?
							}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td height="25">Etat du paiement :</td>
						<td>
							<select name="num_etat_paiement">
								<option value="0" <? if ( $commande->num_etat_paiement == 0 ) { ?> selected <? } ?>>Annulé</option>
								<option value="1" <? if ( $commande->num_etat_paiement == 1 ) { ?> selected <? } ?>>En cours</option>
								<option value="2" <? if ( $commande->num_etat_paiement == 2 ) { ?> selected <? } ?>>Validé</option>
							</select>
						</td>
					</tr>
					<tr>
						<td height="25">Total :</td>
						<td><b><?=$commande->prix?>&euro;</b></td>
					</tr>
					<tr>
						<td height="25" colspan="2" align="right"><input type="button" value="Valider" onclick="modifier();"></td>
					</tr>
					</table>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<fieldset style="display:block;margin:0;">
					<legend><font color="#688FD5"><b>Liste des articles</b></font></legend>
					<? 
					if ( !empty( $liste ) ) {
						?>
						<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
						<tr>
							<td align="left" valign="top">
								<div style="height:175;overflow :auto;">
									<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
									<tr>
										<td>
											<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
											<tr>
												<td width="*"><b>Article</b></td>
												<td width="60" align="left"><b>Montant</b></td>
											</tr>
											</table>
										</td>
									</tr>
									<?
									$index = 1;
									
									// On liste tous les clients
									foreach($liste as $_produit) {
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
									<td width="*" height="20"><?=stripslashes( utf8_encode( $_produit->nom ) )?></td>
									<td width="60" align="left"><?=$_produit->prix_unitaire?>&euro;</td>
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
					?>
				</fieldset>
			</td>
		</tr>
		</table>
	</form>
</body>
</html>
<? include('../../include_connexion/connexion_site_off.php'); ?>