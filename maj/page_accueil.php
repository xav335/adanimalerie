<? require_once('../classes/config.php');?>
<? require_once('../classes/start_session_admin.php'); ?>
<? require_once('../classes/classes.php');?>
<? require_once('../include_connexion/connexion_site_on.php');?>

<html lang="fr">
<head>
	<title><?=TITRE_SITE?> - Administration -</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META name="Toolbar-imaging" http-equiv="imagetoolbar" CONTENT="no">
	
	<link rel="stylesheet" href="./css/style.css" type="text/css">
</head>

<body style="margin:5px 0;background:#688FD5;">
	<table cellpadding=0 cellspacing=0 style="width:968px;height:100%;" align="center" border="0">
	<tr>
		<td width="100%" style="height:64px;background:url(images/ref-struc-top.gif);">
	</tr>
	<tr style="background:#FFF;">
		<td>
			<table cellpadding=0 cellspacing=0 style="width:100%;height:100%;" align="center" border="0">
			<tr>
				<td style="width:4px;background:#A9BFE7;">
				
				<!-- Menu de gauche -->
				<? include_once("./includes/menu_gauche.php");?>
			
				<td width="*" style="vertical-align:top;padding:10px;">
					<-- Navigation avec le menu de gauche.
				</td>
				<td style="width:6px;background:url(images/ref-struc-border-right.gif) repeat-y;">&nbsp;</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="height:16px;background:url(images/ref-struc-bottom.gif);"></td>
	</tr>
	</table>
</body>
</html>
<? require_once('../include_connexion/connexion_site_off.php'); ?>