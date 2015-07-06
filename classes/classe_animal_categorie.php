<?
class animal_categorie {
	var $num_animal_categorie = 0;
	var $num_parent = 0;
	var $nom = '';
	var $niveau = 0;
	
	// Charge une catégorie grâce à son num_animal_categorie
	function load($num_animal_categorie=0) {
		if ($num_animal_categorie == 0) return false;

		$requete = "SELECT * FROM animal_categorie";
		$requete .= " WHERE num_animal_categorie = '" . addslashes( $num_animal_categorie ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_animal_categorie = $data["num_animal_categorie"];
		$this->num_parent = $data["num_parent"];
		$this->nom = $data["nom"];
		$this->niveau = $data["niveau"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO animal_categorie(num_parent, nom, niveau) VALUES(";
		$requete .= $this->num_parent . ", '" . $this->traiterNom( $this->nom ) . "', " . $this->niveau . ")";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE animal_categorie SET";
		$requete .= " num_parent = " . $this->num_parent . ",";
		$requete .= " nom = '" . $this->traiterNom( $this->nom ) . "',";
		$requete .= " niveau = " . $this->niveau;
		$requete .= " WHERE num_animal_categorie = " . $this->num_animal_categorie;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_animal_categorie : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$categorie = new animal_categorie();
		
		// Suppression des sous-catégories éventuelles
		$liste_sous_categorie = $this->getListe( '', $this->num_animal_categorie );
		
		if ( !empty( $liste_sous_categorie ) ) {
			foreach($liste_sous_categorie as $_sous_categorie) {
				//echo "suppression de " . $_sous_categorie->num_animal_categorie . "<br>";
				$categorie->load( $_sous_categorie->num_animal_categorie );
				$categorie->supprimer();
			}
		}
		
		// Suppression de la catégorie
		$requete = "DELETE FROM animal_categorie WHERE num_animal_categorie = " . $this->num_animal_categorie;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_animal_categorie"] ) );
		
		$this->num_parent = $post["num_parent"];
		$this->nom = utf8_decode( $post["nom"] );
		
		// On ajoute 1 par rapport au niveau de la catégorie parent
		$_temp = new animal_categorie();
		$this->niveau = ( $_temp->load( $this->num_parent ) ) ? $_temp->niveau + 1 : 0;
		
		return ( intval($this->num_animal_categorie) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $num_parent=0 ) {
		$categorie = new animal_categorie();
		
		$requete = "SELECT * FROM animal_categorie";
		$requete .= " WHERE num_animal_categorie > 0";
		$requete .= " AND num_parent = " . intval( $num_parent );
		$requete .= " ORDER BY nom ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_animal_categorie"] ) ) {
					$tableau[$i] = new animal_categorie();
					
					$tableau[$i]->num_animal_categorie = $categorie->num_animal_categorie;
					$tableau[$i]->num_parent = $categorie->num_parent;
					$tableau[$i]->nom = $categorie->nom;
					$tableau[$i]->niveau = $categorie->niveau;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
	
	function getListeReccursive( $num_parent=0 ) {
		$liste_initiale = $this->getListe( $num_parent );
		
		// Retourne un tableau
		$tableau = array();
		$i = 0;
		
		foreach( $liste_initiale as $_categorie ) {
			$tableau[$i] = new animal_categorie();
			
			$tableau[$i]->num_animal_categorie = $_categorie->num_animal_categorie;
			$tableau[$i]->num_parent = $_categorie->num_parent;
			$tableau[$i]->nom = $_categorie->nom;
			$tableau[$i]->niveau = $_categorie->niveau;
			
			$i++;
			
			// Liste des sous-catégories de cette catégorie
			$liste_sous_categorie = $this->getListeReccursive( $_categorie->num_animal_categorie );
			
			// On a bien des sous-catégories
			if ( !empty( $liste_sous_categorie ) ) {
				foreach( $liste_sous_categorie as $_sous_categorie ) {
					$tableau[$i] = new animal_categorie();
					
					$tableau[$i]->num_animal_categorie = $_sous_categorie->num_animal_categorie;
					$tableau[$i]->num_parent = $_sous_categorie->num_parent;
					$tableau[$i]->nom = $_sous_categorie->nom;
					$tableau[$i]->niveau = $_sous_categorie->niveau;

					$i++;
				}
			}
		}
		
		return $tableau;
	}
	
	private function getParent( $num_animal_categorie=0, $chemin='' ) {
		$temp = "";
		$categorie = new animal_categorie();
		
		if ( $categorie->load( $num_animal_categorie ) ) {
			//echo "#" . $num_animal_categorie . " : " . $categorie->nom . " (ID Parent : " . $categorie->num_parent . ")<br>";
			$chemin = ( $chemin != '' ) ? $num_animal_categorie . ";" . $categorie->nom . "-" . $chemin : $num_animal_categorie . ";" . $categorie->nom;
			
			if ( $categorie->num_parent > 0 ) {
				//echo "-->" . $chemin . "<br>";
				$temp = $this->getParent( $categorie->num_parent, $chemin );
			}
			else {
				$temp = $chemin;
				//echo "---->" . $temp . "<br>";
			}
		}
		
		return ( $temp );
	}
	
	private function getLink( $texte='', $get=true ) {
		$tab = explode( ";", $texte );
		
		// On ne veut pas le lien
		if ( $get ) {
			$lien = "&nbsp;<a href='animal-" . $tab[0] . ".html'>" . $tab[1] . "</a>&nbsp;";
			return $lien;
		}
		else return $tab[1];
	}
	
	function getTitre( $num_animal_categorie=0 ) {
		$titre = "";
		
		$temp = utf8_encode( $this->getParent( $num_animal_categorie, '' ) );
		$tab = explode( "-", $temp );
		
		$titre = $this->getLink( $tab[0] );
		$re_temp = "";
		for ($i=1; $i<count($tab); $i++) {
			$re_temp .= $this->getLink( $tab[ $i ] ) . "-";
		}
		
		$titre .= " ";
		if ( $re_temp != '' ) $titre .= "-" . substr( $re_temp, 0, ( strlen( $re_temp ) - 1) );
		
		// Liste des sous-catégories dont le parent est la catégorie en cours
		$liste = $this->getListe( $num_animal_categorie );
		
		if ( !empty( $liste ) ) {
			if ( $re_temp != "" ) $titre .= "-&nbsp;";
			$titre .= "<select class='' name='num_categorie_animal' onchange='changer_categorie();'>";
			$titre .= "	<option value='' selected>-- Choisir --</option>";
			foreach( $liste as $_categorie ) {
				$titre .= "	<option value='" . $_categorie->num_animal_categorie . "'>" . utf8_encode( $_categorie->nom ) . "</option>";
			}
			
			$titre .= "</select>";
		}
		
		return $titre;
	}
}
?>