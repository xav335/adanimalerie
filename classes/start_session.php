<?
	// D�marrage d'une session
	session_start();
	
	// ---------------- Le client n'est pas connect� ---------------- //
	//echo "--- " . $_SESSION["site"]["connexion_site_etablie"] . "<br>";
	if ( $_SESSION["site"]["connexion_site_etablie"] != "valide" ) {
		//echo "Redirection...<br>";
		header("Location: ./se-connecter.html");
	}
	// -------------------------------------------------------------- //
?>