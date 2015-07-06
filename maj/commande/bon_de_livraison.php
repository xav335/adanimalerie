<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$num_commande = ( $_GET["n"] != "" ) ? $_GET["n"] : $_POST["num_commande"];
	
	$commande = new commande();
	$commande_produit = new commande_produit();
	$client = new client();
	$produit = new produit();
	
	// Chargement d'une commande
	$commande->load( $num_commande );
	
	// Chargement du client
	$client->load( $commande->num_client );
	
	// Liste des articles composant la commande
	$liste = $commande_produit->getListe( $num_commande, 0 );
	
	// Adresse du client
	$adresse = utf8_encode( $client->prenom . " " . $client->nom ) . "<br />";
	$adresse .= utf8_encode( $client->adresse . "<br />" . $client->cp . " " . $client->ville );
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<style type="text/css">
		td{
			font-size: 16px;
		}
		td.gras{
			font-weight: bold;
		}
		td.decalage_gauche{
			padding-left: 10px;
		}
		td.decalage_droite{
			padding-right: 10px;
		}
	</style>
	
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
	<div align="center">
		
		<table cellpadding=0 cellspacing=0 style="width:95%;" border="0">
		<tr>
			<td valign="top">
				<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
				<tr>
					<td width="40%" height="200" style="vertical-align: top; padding: 10px 0px 0px 20px;">
AD animalerie<br />
Zac du sablar<br />
25, allée pampara<br />
40100 DAX<br />
Tél. : 05 58 74 14 27<br />
Fax : 05 58 74 14 27
					</td>
					<td width="*" valign="top">
						<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
						<tr>
							<td height="40" colspan="2" align="center">
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="1">
								<tr>
									<td height="40" colspan="2" class="gras" align="center">Bon de commande</td>
								</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="20" colspan="2" >&nbsp;</td>
						</tr>
						<tr>
							<td height="40" colspan="2" align="center">
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="1">
								<tr>
									<td align="center">Code client</td>
									<td align="center">Date de commande</td>
								</tr>
								<tr>
									<td align="center"><?=$client->num_client?></td>
									<td align="center"><?=traitement_date_affiche( $commande->date_creation )?></td>
								</tr>
								</table>
								<br>
								
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="1">
								<tr>
									<td class="decalage_gauche">Adresse de livraison</td>
								</tr>
								<tr>
									<td class="decalage_gauche"><br /><?=$adresse?></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<? 
				if ( !empty( $liste ) ) {
					?>
					<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
					<tr>
						<td align="left" valign="top">
							<table cellpadding=0 cellspacing=0 style="width:100%;" border="1">
							<tr>
								<td>
									<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
									<tr>
										<td height="40" width="*" class="decalage_gauche">Désignation</td>
										<td width="100" align="center">Qté</td>
										<td width="150" align="center">Prix unitaire</td>
										<td width="100" align="right" class="decalage_droite">Total</td>
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
									$choix_couleur = "#EAECEF";
									$fonce = "_fonce";
								}
								else {
									$choix_couleur = "#DBDDE0";
									$fonce = "";
								}
								$prix_total = $_produit->quantite * $_produit->prix_unitaire;
								?>
				<tr>
					<td>
						<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
						<tr>
							<td>
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
								<tr>
									<td height="40" width="*" height="20" class="decalage_gauche"><?=stripslashes( utf8_encode( $_produit->nom ) )?></td>
									<td width="100" align="center"><?=$_produit->quantite?></td>
									<td width="150" align="center"><?=$_produit->prix_unitaire?>&euro;</td>
									<td width="100" align="right" class="decalage_droite"><?=$prix_total?>&euro;</td>
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
						</td>
					</tr>
					</table>
					<? 
				}
				?>
				<br />
				<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="1">
					<tr>
						<td align="left" valign="top">
							<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
							<tr>
								<td height="40" width="*">&nbsp;</td>
								<td width="100">&nbsp;</td>
								<td width="150" align="center">Total</td>
								<td width="100" align="right" class="decalage_droite"><?=$commande->prix?>&euro;</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
				<br /><br /><br /><br />
				Madame, Monsieur,<br />
				Nous vous remercions de votre commande et espérons qu'elle vous donnera toute satisfaction.
			</td>
		</tr>
		</table>
	</div>
	
	<script language=Javascript>
	<!--
		window.print();
	//-->
	</script>
</body>
</html>
<? include('../../include_connexion/connexion_site_off.php'); ?>