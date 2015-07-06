<?
class utilisateur {
	var $num_utilisateur = 0;
	var $civilite = '';
	var $nom_utilisateur = '';
	var $prenom_utilisateur = '';
	var $mail_utilisateur = '';
	var $login = '';
	var $mdp = '';
	
	// Charge un utilisateur
	function load($num_utilisateur=0) {
		$num_utilisateur = intval($num_utilisateur);
		if ($num_utilisateur <= 0) return false;
		
		$requete = "SELECT * FROM utilisateur";
		$requete .= " WHERE num_utilisateur = '" . $num_utilisateur . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_utilisateur = $data["num_utilisateur"];
		$this->civilite = $data["civilite"];
		$this->nom_utilisateur = $data["nom_utilisateur"];
		$this->prenom_utilisateur = $data["prenom_utilisateur"];
		$this->mail_utilisateur = $data["mail_utilisateur"];
		$this->login = $data["login"];
		$this->mdp = $data["mdp"];
		
		return true;
	}
	
	// Charge un utilisateur d'apres son mail
	function loadByMail($mail='') {
		$requete = "SELECT * FROM utilisateur";
		$requete .= " WHERE mail_utilisateur = '" . $mail . "'";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return $this->load( $data["num_utilisateur"] );
	}
	
	// Modifie un utilisateur
	function modifierUtilisateur() {
		//echo $this->nouveau_mdp . "/" . $this->confirmation . "<br>";
		
		$requete = "UPDATE utilisateur SET";
		$requete .= " civilite = '" . $this->civilite . "',";
		$requete .= " nom_utilisateur = '" . addslashes(str_replace("\"", "", $this->nom_utilisateur)) . "',";
		$requete .= " prenom_utilisateur = '" . addslashes(str_replace("\"", "", $this->prenom_utilisateur)) . "',";
		$requete .= " mail_utilisateur = '" . addslashes(str_replace("\"", "", $this->mail_utilisateur)) . "',";
		$requete .= " login = '" . addslashes(str_replace("\"", "", $this->login)) . "',";
		$requete .= " mdp = '" . addslashes(str_replace("\"", "", $this->mdp)) . "'";
		
		$requete .= " WHERE num_utilisateur = " . $this->num_utilisateur;
		//echo $requete . "<br><br>";
		mysql_query($requete);
	}
	
	// Authentification d'un utilisateur
	function authentifier($login, $mdp) {
		
		// On recherche dans la base un utilisateur ayant ces identifiants
		$requete = "SELECT * FROM utilisateur";
		$requete .= " WHERE login = '" . mysql_real_escape_string( $login ) . "'";
		$requete .= " AND mdp = '" . mysql_real_escape_string( $mdp ) . "'";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// On a trouvé un utilisateur
		if (mysql_num_rows($liste) != 0) {
			return $liste;
		}
		
		// Personne --> Erreur!
		else
			return NULL;
	}
	
	// Authentification d'un utilisateur depuis une cle
	function authentifierCle($cle) {
		
		// On recherche dans la base un utilisateur ayant ces identifiants
		$requete = "SELECT * FROM utilisateur";
		$requete .= " WHERE cle = '" . mysql_real_escape_string( $cle ) . "'";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// On a trouvé un utilisateur
		if (mysql_num_rows($liste) != 0) {
			return $liste;
		}
		
		// Personne --> Erreur!
		else
			return NULL;
	}

	// Déconnexion de l'espace d'administration
	function deconnecter() {
		unset( $_SESSION["maj"] );
	}
}
?>