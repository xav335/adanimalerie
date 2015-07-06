<title>AD animalerie - Votre animalerie &agrave; Bordeaux</title>

<!-- Métas -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" lang="fr" content="animalerie" />
<meta name="description" content="AD animalerie, votre animalerie &agrave; Bordeaux" />
<meta name="author" content="AD animalerie" />

<!-- CSS -->
<link rel="stylesheet" href="../css/style.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" href="../fonts/stylesheet.css" type="text/css" charset="utf-8" />

<script type="text/javascript" language="javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/animalerie.js"></script>
<?
if ( $autorise_fancybox ) {
	?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="./js/jquery-1.4.3.min.js"><\/script>');
	</script>
	
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#play_flash").fancybox({
				'padding'			: 0,
				'width'				: '544',
				'height'			: '320',
				'autoScale'			: true,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$(".iframe").fancybox({
				'width'				: '85%',
				'height'			: '75%',
		        'autoScale'     	: false,
		        'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		});
	</script>
	<?
}
?>