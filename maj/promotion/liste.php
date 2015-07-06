<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_promotion = $_POST["num_promotion"];
	
	$ordre = $_POST["ordre"];
	$mouvement = $_POST["mouvement"];
	$id_changement = $_POST["id_changement"];
	
	$promotion = new promotion();
	
	// Suppression d'un cours
	if ($mon_action == "suppression") {
		//echo "Suppression...<br>";
		if ( $promotion->load( $num_promotion ) ) $promotion->supprimer();
	}
	
	// Liste des promotions disponibles
	$liste_promotion = $promotion->getListe();
	
	$menu = "promotion";
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
				document.formulaire.num_promotion.value = num;
				document.formulaire.submit();
			}
		}
		
		function afficher(num) {
			//alert(num);
			document.formulaire.action = "./ajout.php";
			document.formulaire.mon_action.value = "";
			document.formulaire.num_promotion.value = num;
			document.formulaire.submit();
		}
	//-->
	</script>
</head>

<body style="margin:5px 0;background:#688FD5;">
	<form name="formulaire" method="POST" action="liste.php">
		<input type="hidden" name="mon_action" value="">
		<input type="hidden" name="num_promotion" value="">
		
		<input type="hidden" name="mouvement" value="">
		<input type="hidden" name="id_changement" value="">
		<input type="hidden" name="ordre" value="">
		
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
							<td class="titrepage" height="30" valign="top">Liste des promotions</td>
						</tr>
						<tr>
							<td>
								<? 
								if ( !empty( $liste_promotion ) ) {
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
															<td width="100" align="center"><b>En ligne</b></td>
															<td width="40">&nbsp;</td>
														</tr>
														</table>
													</td>
												</tr>
												<?
												$index = 1;
												
												// On liste tous les sites
												foreach( $liste_promotion as $_promotion ) {
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
										<a href="javascript:afficher(<?=$_promotion->num_promotion?>);" ><?=stripcslashes( utf8_encode( $_promotion->titre ) )?></a>
									</td>
									<td width="100" align="center">
										<?
										// Cette promotion est active
										if ($_promotion->online == 1) {
											$image = "ok" . $fonce . ".gif";
											$alt = "Promo en ligne";
										}
										else {
											$image = "croix" . $fonce . ".gif";
											$alt = "Promo HORS ligne";
										}
										?>
										<img src="../images/<?=$image?>" border="0" title="<?=$alt?>">
									</td>
									<td width="40" align="right" valign="middle">
										<a href="javascript:afficher(<?=$_promotion->num_promotion?>);"><img src="../images/icones/edit.gif" border="0" title="Modifier la promotion"></a>
										<a href="javascript:supprimer(<?=$_promotion->num_promotion?>);"><img src="../images/icones/delete.gif" border="0" title="Supprimer la promotion"></a>
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
													<td align="center"><font color="#CC3300"><b>Aucune promotion dans la base.</b></font></td>
												</tr>
												</table>
											</div>
										</td>
									</tr>
									</table>
									<?
								}
								?>
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