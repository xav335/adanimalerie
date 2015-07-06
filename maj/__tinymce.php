<!-- tinyMCE -->
<!--<script language="javascript" type="text/javascript" src="<?=$url_absolue?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>-->
<script language="javascript" type="text/javascript" src="<?=$url_absolue?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
<!--
	//alert("<?=$url_absolue?>");
	//alert("<?=$url_site?>");
	
	tinyMCE.init({
	
		// General options
		language : "fr",
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
		
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,|,image,media",
		theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,cleanup,code,visualchars",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell",
		//theme_advanced_buttons4 : "cite,abbr,acronym,del,ins,|",
		
		theme_advanced_toolbar_location : "bottom",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		// Example content CSS (should be your site CSS)
		content_css : "<?=$url_site?>/styles_tinymce.css"
	});
	
	// Custom save callback, gets called when the contents is to be submitted
	function customSave(id, content) {
	}
//-->
</script>
<!-- /tinyMCE -->
