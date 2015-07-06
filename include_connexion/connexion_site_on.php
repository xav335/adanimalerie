<?
	/*echo $host . "<br>";
	echo $user . "<br>";
	echo $pass . "<br>";
	echo $bdd . "<br>";*/
	
	// connexion (On retrouve ces variables dans "maj/classes/config.php")
	$mysql_link=@mysql_connect($host,$user,$pass)
	   or die("1 : Impossible de se connecter à la base de données");
	@mysql_select_db($bdd)
	   or die("2 : Impossible de se connecter à la base de données");
?>