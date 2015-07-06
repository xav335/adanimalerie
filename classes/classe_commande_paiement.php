<?
class commande_paiement {
	var $num_paiement = 0;
	var $num_commande = 0;
	var $transaction_id = '';
	var $payer_email = '';
	var $montant = '';
	var $date_creation = '';
	
	// Charge une commande
	function load($num_paiement=0) {
		$num_paiement = intval($num_paiement);
		if ($num_paiement <= 0) return false;
		
		$requete = "SELECT * FROM commande_paiement";
		$requete .= " WHERE num_paiement = '" . $num_paiement . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_paiement = $data["num_paiement"];
		//echo "--> ID : " . $this->num_paiement . "<br>";
		$this->num_commande = $data["num_commande"];
		$this->transaction_id = $data["transaction_id"];
		$this->payer_email = $data["payer_email"];
		$this->montant = $data["montant"];
		$this->statut = $data["statut"];
		$this->date_creation = $data["date_creation"];
		
		return true;
	}
	
	// Charge un paiement
	function loadByTransactionID( $transaction_id='' ) {
		$requete = "SELECT * FROM commande_paiement";
		$requete .= " WHERE transaction_id = '" . $transaction_id . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return $this->load( $data["num_paiement"] );
	}
	
	// Ajoute une erreur
	function ajouter() {
		$requete = "INSERT INTO commande_paiement(num_commande, transaction_id, payer_email, montant, statut, date_creation) VALUES(";
		$requete .= $this->num_commande . ", '" . $this->traiter_champ( $this->transaction_id ) . "', '" . $this->traiter_champ( $this->payer_email ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->montant ) . "', '" . $this->traiter_champ( $this->statut ) . "', '" . $this->traiter_champ( $this->date_creation ) . "')";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Interface entre les formulaire et la base
	function gererDonnees( $post=array() ) {
		$this->num_commande = $post["num_commande"];
		$this->transaction_id = utf8_decode( $post["transaction_id"] );
		$this->payer_email = ( $post["payer_email"] );
		$this->montant = ( $post["montant"] );
		$this->statut = ( $post["statut"] );
		$this->date_creation = date("Y-m-d");
		return $this->ajouter();
	}
	
	function traiter_champ($payer_email='') {
		$payer_email = str_replace("\"", "", $payer_email);
		//$payer_email = utf8_decode( $payer_email );
		$payer_email = addslashes( $payer_email );
		
		return $payer_email;
	}
	
	function traiter_champ_affichage( $payer_email='' ) {
		$payer_email = stripslashes( $payer_email );
		$payer_email = utf8_encode( $payer_email );
		
		return $payer_email;
	}
	
	// Retourne la liste des commandes
	function getListe( $transaction_id=0, $liste_exclusion='', $tri='commande_paiement.date_creation', $ordre='ASC') {
		$commande = new commande();
		
		if ( $tri == "" ) $tri = "commande.date_creation";
		if ( $ordre == "" ) $ordre = "ASC";
		
		$requete = "SELECT * FROM commande_paiement";
		$requete .= " INNER JOIN client ON client.transaction_id = commande.transaction_id";
		$requete .= " WHERE num_paiement > 0";
		
		if ( intval( $transaction_id ) > 0 ) $requete .= " AND commande.transaction_id = '" . $transaction_id . "'";
		if ( $liste_exclusion != "" ) $requete .= " AND commande.num_paiement NOT IN (" . $liste_exclusion . ")";
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
				if ( $commande->load( $data["num_paiement"] ) ) {
					//echo "-->" . $this->transaction_id . "<br>";
					$tableau_commande[$i] = new commande();
					
					$tableau_commande[$i]->num_paiement = $commande->num_paiement;
					$tableau_commande[$i]->num_commande = $commande->num_commande;
					$tableau_commande[$i]->transaction_id = $commande->transaction_id;
					$tableau_commande[$i]->payer_email = $commande->payer_email;
					$tableau_commande[$i]->montant = $commande->montant;
					$tableau_commande[$i]->statut = $commande->statut;
					$tableau_commande[$i]->date_creation = $commande->date_creation;
					
					$i++;
				}
			}
		}
		
		return $tableau_commande;
	}
}
?>