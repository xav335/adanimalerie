<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="<?=$url_absolue?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
<!--
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,cleanup",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "bottom",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		
		theme_advanced_path : false,
		width : "600",

		// Style formats
		style_formats : [
			{title : 'Titre', inline : 'span', styles : {color : '#8E8E7E'}, classes : 'description_titre'},
			{title : 'Normal', inline : 'span', styles : {color : '#000000'}, classes : 'description_normal'}
		],
		
		// Example content CSS (should be your site CSS)
		content_css : "<?=$url_site?>/styles_tinymce.css",
	});
	
	// Custom save callback, gets called when the contents is to be submitted
	function customSave(id, content) {
	}
//-->
</script>
<!-- /tinyMCE -->
