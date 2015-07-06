<?
class client {
	var $num_client = 0;
	var $nom = '';
	var $prenom = '';
	var $adresse = '';
	var $cp = '';
	var $ville = '';
	var $telephone = '';
	var $mail = '';
	var $mdp = '';
	var $code = '';
	var $actif = 0;
	var $supprime = 0;
	
	// Charge un client
	function load($num_client=0) {
		$num_client = intval($num_client);
		if ($num_client <= 0) return false;
		
		$requete = "SELECT * FROM client";
		$requete .= " WHERE num_client = '" . $num_client . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_client = $data["num_client"];
		//echo "--> ID : " . $this->num_client . "<br>";
		$this->nom = $data["nom"];
		$this->prenom = $data["prenom"];
		$this->adresse = $data["adresse"];
		$this->cp = $data["cp"];
		$this->ville = $data["ville"];
		$this->telephone = $data["telephone"];
		$this->mail = $data["mail"];
		$this->mdp = $data["mdp"];
		$this->code = $data["code"];
		$this->date_creation = $data["date_creation"];
		$this->actif = $data["actif"];
		$this->supprime = $data["supprime"];
		
		return true;
	}
	
	// Charge un client grâce à son mail
	function loadByMail( $mail='' ) {
		$requete = "SELECT * FROM client";
		$requete .= " WHERE mail = '" . mysql_real_escape_string( $mail ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return $this->load( $data["num_client"] );
	}
	
	function vider() {
		unset( $this );
	}
	
	// Ajoute un client
	function ajouter() {
		$requete = "INSERT INTO client(nom, prenom, adresse, cp, ville, telephone, ";
		$requete .= " mail, mdp, code, date_creation, actif, supprime) VALUES(";
		$requete .= "'" . $this->traiter_champ( $this->nom ) . "', '" . $this->traiter_champ( $this->prenom ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->adresse ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->cp ) . "', '" . $this->traiter_champ( $this->ville ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->telephone ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->mail ) . "', '" . $this->traiter_champ( $this->mdp ) . "', ";
		$requete .= "'" . $this->code . "', '" . $this->date_creation . "', ";
		$requete .= $this->actif . ", " . $this->supprime . ")";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie un client
	function modifier() {
		$requete = "UPDATE client SET";
		$requete .= " nom = '" . $this->traiter_champ( $this->nom ) . "',";
		$requete .= " prenom = '" . $this->traiter_champ( $this->prenom ) . "',";
		$requete .= " adresse = '" . $this->traiter_champ( $this->adresse ) . "',";
		$requete .= " cp = '" . $this->traiter_champ( $this->cp ) . "',";
		$requete .= " ville = '" . $this->traiter_champ( $this->ville ) . "',";
		$requete .= " telephone = '" . $this->traiter_champ( $this->telephone ) . "',";
		$requete .= " mail = '" . $this->traiter_champ( $this->mail ) . "',";
		$requete .= " mdp = '" . $this->traiter_champ( $this->mdp ) . "',";
		$requete .= " code = '" . $this->code . "',";
		$requete .= " actif = " . $this->actif . ",";
		$requete .= " supprime = " . $this->supprime;
		$requete .= " WHERE num_client = " . $this->num_client;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_client : false;
	}
	
	// Supprime un client
	function supprimer() {
		$requete = "UPDATE client SET";
		$requete .= " supprime = 1";
		$requete .= " WHERE num_client = " . $this->num_client;
		//echo $requete . "<br><br>";
		mysql_query($requete);
	}
	
	// Interface entre les formulaire et la base
	function gererDonnees( $post=array() ) {
		$modification = $this->load( $post["num_client"] );
		
		$this->nom = utf8_decode( $post["nom"] );
		$this->prenom = utf8_decode( $post["prenom"] );
		$this->telephone = utf8_decode( $post["tel"] );
		$this->mail = $post["email"];
		$this->mdp = utf8_decode( $post["mdp"] );
		$this->adresse = utf8_decode( $post["adresse"] );
		$this->cp = utf8_decode( $post["cp"] );
		$this->ville = utf8_decode( $post["ville"] );
		$this->actif = $post["actif"];
		
		// C'est un ajout
		if ( !$modification ) {
			$this->code = aleatoire(16);
			$this->date_creation = date("Y-m-d");
			$this->actif = ( $post["actif"] != "" ) ? $post["actif"] : 0;
			$this->supprime = 0;
			
			return $this->ajouter();
		}
		else {
			$this->ville = utf8_decode( $post["ville"] );
			return $this->modifier();
		}
	}
	
	function traiter_champ($texte='') {
		$texte = str_replace("\"", "", $texte);
		//$texte = utf8_decode( $texte );
		$texte = addslashes( $texte );
		
		return $texte;
	}
	
	function traiter_champ_affichage( $texte='' ) {
		$texte = stripslashes( $texte );
		$texte = utf8_encode( $texte );
		
		return $texte;
	}
	
	// Authentification d'un client
	function authentifier($mail, $mdp) {
		
		// On recherche dans la base un client ayant ces identifiants
		$requete = "SELECT * FROM client";
		$requete .= " WHERE mail = '" . mysql_real_escape_string( $mail ) . "'";
		$requete .= " AND mdp = '" . mysql_real_escape_string( $mdp ) . "'";
		$requete .= " AND actif = 1";
		$requete .= " AND supprime = 0";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		//echo "-->" . $data["num_client"] . "<br>";
		return $this->load( $data["num_client"] );
	}
	
	// Authentification d'un client depuis son code
	function authentifierCode($code) {
		
		// On recherche dans la base un client ayant ces identifiants
		$requete = "SELECT * FROM client";
		$requete .= " WHERE code = '" . mysql_real_escape_string( $code ) . "'";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		//echo "-->" . $data["num_client"] . "<br>";
		return $this->load( $data["num_client"] );
	}
	
	// Retourne l'existence d'un mail
	function isMailExist( $mail='' ) {
		//echo "---> mail : " . $mail . "<br>";
		$client = new client();
		
		return ( $client->loadByMail( $mail ) ) ? true : false;
		//return false;
	}
	
	// Retourne la liste des clients
	function getListeClient($actif="", $supprime=0, $tri="nom", $ordre="ASC") {
		$client = new client();
		
		$requete = "SELECT * FROM client";
		$requete .= " WHERE num_client > 0";
		
		if ( $actif != "" ) $requete .= " AND actif = " . $actif;
		if ( $supprime != "" ) $requete .= " AND supprime = " . $supprime;
		$requete .= " ORDER BY " . $tri . " " . $ordre;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau de clients
		$tableau_client = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du client
				if ( $client->load( $data["num_client"] ) ) {
					//echo "-->" . $this->nom . "<br>";
					$tableau_client[$i] = new client();
					
					$tableau_client[$i]->num_client = $client->num_client;
					$tableau_client[$i]->nom = $client->nom;
					$tableau_client[$i]->prenom = $client->prenom;
					$tableau_client[$i]->adresse = $client->adresse;
					$tableau_client[$i]->cp = $client->cp;
					$tableau_client[$i]->ville = $client->ville;
					$tableau_client[$i]->telephone = $client->telephone;
					$tableau_client[$i]->mail = $client->mail;
					$tableau_client[$i]->mdp = $client->mdp;
					$tableau_client[$i]->code = $client->code;
					$tableau_client[$i]->date_creation = $client->date_creation;
					$tableau_client[$i]->actif = $client->actif;
					$tableau_client[$i]->supprime = $client->supprime;
					
					$i++;
				}
			}
		}
		
		return $tableau_client;
	}
}
?>