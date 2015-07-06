<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_produit = $_POST["num_produit"];
	
	$categorie = new produit_categorie();
	$produit = new produit();
	
	// Suppression d'un cours
	if ($mon_action == "suppression") {
		//echo "Suppression...<br>";
		if ( $produit->load( $num_produit ) ) $produit->supprimer();
	}
	
	// Liste des categories disponibles
	$liste_produit = $produit->getListe();
	
	$menu = "produit";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	
	<!-- Titre de la page et CSS -->
	<? include_once('../includes/head.php'); ?>
	
	<link rel="stylesheet" href="../css/modal-message.css" type="text/css">
	
	<script language=Javascript>
	<!--
		<? include('../js/js.js'); ?>
		
		function supprimer(num) {
			if (confirm("Voulez vous vraiment supprimer cet enregistrement?")) {
				document.formulaire.action = "liste.php";
				document.formulaire.mon_action.value = "suppression";
				document.formulaire.num_produit.value = num;
				document.formulaire.submit();
			}
		}
		
		function afficher(num) {
			//alert(num);
			document.formulaire.action = "./ajout.php";
			document.formulaire.mon_action.value = "";
			document.formulaire.num_produit.value = num;
			document.formulaire.submit();
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
	<form name="formulaire" method="POST" enctype="multipart/form-data" action="liste.php">
		<input type="hidden" name="mon_action" value="">
		<input type="hidden" name="num_produit" value="">
		
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
							<td class="titrepage" height="30" valign="top">Liste des produits</td>
						</tr>
						<tr>
							<td>
								<fieldset style="display:block;margin:0;">
									<legend><font color="#688FD5"><b>Liste</b></font></legend>
									<? 
									if ( !empty( $liste_produit ) ) {
										?>
										<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
										<tr>
											<td align="left" valign="top">
												<div style="height:700;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td>
															<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
															<tr>
																<td width="*" align="left"><b>Titre</b></td>
																<td width="150" align="left"><b>Cat&eacute;gorie</b></td>
																<td width="100" align="center"><b>Coup de coeur</b></td>
																<td width="40">&nbsp;</td>
															</tr>
															</table>
														</td>
													</tr>
													<?
													$index = 1;
													$categorie_temp = new produit_categorie();
													
													// On liste tous les sites
													foreach( $liste_produit as $_produit ) {
														$index = $index + 1;
														
														if ($index % 2) {
															$choix_couleur = "#F5FFE5";
															$fonce = "_fonce";
														}
														else {
															$choix_couleur = "#E4FDC3";
															$fonce = "";
														}
														
														// Récupération du nom de la catégorie
														$nom_categorie = ( $categorie_temp->load( $_produit->num_produit_categorie ) ) ? stripcslashes( utf8_encode( $categorie_temp->nom ) ) : "-";
														?>
				<tr>
					<td>
						<table cellpadding=0 cellspacing=0 style="width:100%;background-color:<?=$choix_couleur?>;" border="0">
						<tr>
							<td>
								<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
								<tr>
									<td width="*" height="20">
										<a href="javascript:afficher(<?=$_produit->num_produit?>);" style="margin-left: <?=$decalage?>px;"><?=stripcslashes( utf8_encode( $_produit->nom ) )?></a>
									</td>
									<td width="150"><?=$nom_categorie?></td>
									<td width="100" align="center" valign="middle">
										<?
										// C'est un produit "Coup de coeur"
										if ($_produit->coup_de_coeur == 1) {
											$image = "ok" . $fonce . ".gif";
											$alt = "Coup de coeur";
											?>
											<img src="../images/<?=$image?>" border="0" title="<?=$alt?>">
											<?
										}
										else echo "&nbsp;";
										?>
									</td>
									<td width="40" align="right" valign="middle">
										<a href="javascript:afficher(<?=$_produit->num_produit?>);"><img src="../images/icones/edit.gif" border="0" title="Modifier le produit"></a>
										<a href="javascript:supprimer(<?=$_produit->num_produit?>);"><img src="../images/icones/delete.gif" border="0" title="Supprimer le produit"></a>
									</td>
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
									else {
										?>
										<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" border="0">
										<tr>
											<td align="left" valign="top">
												<div style="height:700;overflow :auto;">
													<table cellpadding=0 cellspacing=0 style="width:100%;" border="0">
													<tr>
														<td align="center"><font color="#CC3300"><b>Aucun produit dans la base.</b></font></td>
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