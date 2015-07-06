<?
class commande {
	var $num_commande = 0;
	var $num_client = 0;
	var $num_etat = 0;
	var $num_etat_paiement = 0;
	var $prix = '';
	var $transaction_id = '';
	var $date_creation = '';
	
	// Charge une commande
	function load($num_commande=0) {
		$num_commande = intval($num_commande);
		if ($num_commande <= 0) return false;
		
		$requete = "SELECT * FROM commande";
		$requete .= " WHERE num_commande = '" . $num_commande . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_commande = $data["num_commande"];
		//echo "--> ID : " . $this->num_commande . "<br>";
		$this->num_client = $data["num_client"];
		$this->num_etat = $data["num_etat"];
		$this->num_etat_paiement = $data["num_etat_paiement"];
		$this->prix = $data["prix"];
		$this->transaction_id = $data["transaction_id"];
		$this->date_creation = $data["date_creation"];
		
		return true;
	}
	
	// Ajoute une commande
	function ajouter() {
		$requete = "INSERT INTO commande(num_client, num_etat, num_etat_paiement, prix, transaction_id, date_creation) VALUES(";
		$requete .= "'" . $this->traiter_champ( $this->num_client ) . "', '" . $this->traiter_champ( $this->num_etat ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->num_etat_paiement ) . "', '" . $this->traiter_champ( $this->prix ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->transaction_id ) . "', '" . $this->traiter_champ( $this->date_creation ) . "')";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une commande
	function modifier() {
		$requete = "UPDATE commande SET";
		$requete .= " num_client = '" . $this->traiter_champ( $this->num_client ) . "',";
		$requete .= " num_etat = '" . $this->traiter_champ( $this->num_etat ) . "',";
		$requete .= " num_etat_paiement = '" . $this->traiter_champ( $this->num_etat_paiement ) . "',";
		$requete .= " prix = '" . $this->traiter_champ( $this->prix ) . "',";
		$requete .= " transaction_id = '" . $this->traiter_champ( $this->transaction_id ) . "',";
		$requete .= " date_creation = '" . $this->traiter_champ( $this->date_creation ) . "'";
		$requete .= " WHERE num_commande = " . $this->num_commande;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_commande : false;
	}
	
	function setValue( $champ='', $valeur='' ) {
		if ( $champ == '' || $valeur == '' ) return false;
		else {
			$requete = "UPDATE commande SET ";
			$requete .= $champ . " = '" . $valeur . "'";
			$requete .= " WHERE num_commande = " . $this->num_commande;
			//echo $requete . "<br>";
			$result = mysql_query($requete);
			
			return ( $result ) ? $this->num_commande : false;
		}
	}
	
	// Interface entre les formulaire et la base
	function gererDonnees( $post=array() ) {
		$modification = $this->load( $post["num_commande"] );
		
		$this->num_etat = utf8_decode( $post["num_etat"] );
		$this->num_etat_paiement = utf8_decode( $post["num_etat_paiement"] );
		$this->transaction_id = utf8_decode( $post["transaction_id"] );
		
		// C'est un ajout
		if ( !$modification ) {
			$this->num_client = utf8_decode( $post["num_client"] );
			$this->prix = utf8_decode( $post["prix"] );
			$this->date_creation = date("Y-m-d");
			return $this->ajouter();
		}
		else {
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
	
	// Retourne la liste des commandes
	function getListe( $num_client=0, $num_etat=0, $recherche_etat_paiement='', $liste_exclusion='', $tri='commande.date_creation', $ordre='ASC') {
		$commande = new commande();
		
		if ( $tri == "" ) $tri = "commande.date_creation";
		if ( $ordre == "" ) $ordre = "ASC";
		
		$requete = "SELECT * FROM commande";
		$requete .= " INNER JOIN client ON client.num_client = commande.num_client";
		$requete .= " WHERE num_commande > 0";
		
		if ( intval( $num_client ) > 0 ) $requete .= " AND commande.num_client = '" . $num_client . "'";
		if ( intval( $num_etat ) > 0 ) $requete .= " AND commande.num_etat = '" . $num_etat . "'";
		if ( $recherche_etat_paiement ) $requete .= " AND " . $recherche_etat_paiement;
		if ( $liste_exclusion != "" ) $requete .= " AND commande.num_commande NOT IN (" . $liste_exclusion . ")";
		if ( $supprime != "" ) $requete .= " AND supprime = " . $supprime;
		$requete .= " ORDER BY " . $tri . " " . $ordre;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau_commande = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement
				if ( $commande->load( $data["num_commande"] ) ) {
					//echo "-->" . $this->num_client . "<br>";
					$tableau_commande[$i] = new commande();
					
					$tableau_commande[$i]->num_commande = $commande->num_commande;
					$tableau_commande[$i]->num_client = $commande->num_client;
					$tableau_commande[$i]->num_etat = $commande->num_etat;
					$tableau_commande[$i]->num_etat_paiement = $commande->num_etat_paiement;
					$tableau_commande[$i]->prix = $commande->prix;
					$tableau_commande[$i]->transaction_id = $commande->transaction_id;
					$tableau_commande[$i]->date_creation = $commande->date_creation;
					
					$i++;
				}
			}
		}
		
		return $tableau_commande;
	}
}
?>