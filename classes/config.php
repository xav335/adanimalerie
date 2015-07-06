<?
	// Définition des variables de connexion à la base à la base et certains chemins
	//echo "Dans config.php : " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
	SWITCH($_SERVER['DOCUMENT_ROOT']) {
	CASE '/var/www/adanimalerie':
		$host = "localhost"; 
		$user = "adanimalerie";
		$pass = "adanimalerie";
		$bdd  = "adanimalerie";
		$url_absolue = "http://adanimalerie.test/maj";
		$url_site = "http://adanimalerie.test";
		$chemin_site = "/";
		$compte_paypal = "seller_1340210729_biz@hotmail.com";
		$url_paypal = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		break;
		
	CASE '/home/web/a/adanimaleriedev/www':
		$host = "localhost"; 
		$user = "adanimalerie-dev";
		$pass = "adanimalerie-dev";
		$bdd  = "adanimalerie-dev";
		$url_absolue = "http://dev.adanimalerie.com/maj";
		$url_site = "http://dev.adanimalerie.com";
		$chemin_site = "/";
		$compte_paypal = "seller_1350922594_per@iconeo.fr";
		$url_paypal = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		break;
		
	DEFAULT:
		$host = "db400135273.db.1and1.com"; 
		$user = "dbo400135273";
		$pass = "c0deg0simple";
		$bdd  = "db400135273";
		$url_absolue = "http://www.adanimalerie.com/maj";
		$url_site = "http://www.adanimalerie.com";
		$chemin_site = "/";
		$compte_paypal = "seller_1340210729_biz@hotmail.com";
		$url_paypal = "https://www.paypal.com/fr/cgi-bin/webscr";
	}
	//echo $user . "<br>";
	// -----------------------------------------------------
	define ("NOMBRE_PAGE_SITE", 4);
	define ("TITRE_SITE", "adanimalerie.com");
	
	// Définition des différentes variables d'environnements
	define ("CHEMIN_SITE", $_SERVER['DOCUMENT_ROOT'] . $chemin_site);
	define ("URL_SITE", $url_site);
	define ("COMPTE_PAYPAL", $compte_paypal);
	define ("URL_PAYPAL", $url_paypal);
	// -----------------------------------------------------
	
?>