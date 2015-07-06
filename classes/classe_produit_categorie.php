<?
class produit_categorie {
	var $num_produit_categorie = 0;
	var $num_parent = 0;
	var $nom = '';
	var $niveau = 0;
	
	// Charge une catégorie grâce à son num_produit_categorie
	function load($num_produit_categorie=0) {
		if ($num_produit_categorie == 0) return false;

		$requete = "SELECT * FROM produit_categorie";
		$requete .= " WHERE num_produit_categorie = '" . addslashes( $num_produit_categorie ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		//echo "-- 1<br>";

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		//echo "-- 2<br>";

		$this->num_produit_categorie = $data["num_produit_categorie"];
		$this->num_parent = $data["num_parent"];
		$this->nom = $data["nom"];
		$this->niveau = $data["niveau"];
		//echo "-- 3<br>";
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO produit_categorie(num_parent, nom, niveau) VALUES(";
		$requete .= $this->num_parent . ", '" . $this->traiterNom( $this->nom ) . "', " . $this->niveau . ")";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE produit_categorie SET";
		$requete .= " num_parent = " . $this->num_parent . ",";
		$requete .= " nom = '" . $this->traiterNom( $this->nom ) . "',";
		$requete .= " niveau = " . $this->niveau;
		$requete .= " WHERE num_produit_categorie = " . $this->num_produit_categorie;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_produit_categorie : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$categorie = new produit_categorie();
		$produit = new produit();
		
		// Suppression des sous-catégories éventuelles
		$liste_sous_categorie = $this->getListe( $this->num_produit_categorie, false );
		
		if ( !empty( $liste_sous_categorie ) ) {
			foreach($liste_sous_categorie as $_sous_categorie) {
				//echo "suppression de " . $_sous_categorie->num_produit_categorie . "<br>";
				$categorie->load( $_sous_categorie->num_produit_categorie );
				$categorie->supprimer();
			}
		}
		
		// Suppression des produits composant cette catégorie
		$liste_produit = $produit->getListe( $this->num_produit_categorie );
		if ( !empty( $liste_produit ) ) {
			foreach( $liste_produit as $_produit ) {
				$temp = new produit();
				if ( $temp->load( $_produit->num_produit ) ) $temp->supprimer();
			}
		}
		
		// Suppression de la catégorie
		$requete = "DELETE FROM produit_categorie WHERE num_produit_categorie = " . $this->num_produit_categorie;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_produit_categorie"] ) );
		
		$this->num_parent = $post["num_parent"];
		$this->nom = utf8_decode( $post["nom"] );
		
		// On ajoute 1 par rapport au niveau de la catégorie parent
		$_temp = new produit_categorie();
		$_temp->load( $this->num_parent );
		$this->niveau = $_temp->niveau + 1;
		
		return ( intval($this->num_produit_categorie) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $num_parent=0, $affichage=false ) {
		$categorie = new produit_categorie();
		
		$requete = "SELECT * FROM produit_categorie";
		$requete .= " WHERE num_produit_categorie > 0";
		$requete .= " AND num_parent = " . intval( $num_parent );
		$requete .= " ORDER BY nom ASC";
		if ( $affichage ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_produit_categorie"] ) ) {
					$tableau[$i] = new produit_categorie();
					
					$tableau[$i]->num_produit_categorie = $categorie->num_produit_categorie;
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
			$tableau[$i] = new produit_categorie();
			
			$tableau[$i]->num_produit_categorie = $_categorie->num_produit_categorie;
			$tableau[$i]->num_parent = $_categorie->num_parent;
			$tableau[$i]->nom = $_categorie->nom;
			$tableau[$i]->niveau = $_categorie->niveau;
			
			$i++;
			
			// Liste des sous-catégories de cette catégorie
			$liste_sous_categorie = $this->getListeReccursive( $_categorie->num_produit_categorie );
			
			// On a bien des sous-catégories
			if ( !empty( $liste_sous_categorie ) ) {
				foreach( $liste_sous_categorie as $_sous_categorie ) {
					$tableau[$i] = new produit_categorie();
					
					$tableau[$i]->num_produit_categorie = $_sous_categorie->num_produit_categorie;
					$tableau[$i]->num_parent = $_sous_categorie->num_parent;
					$tableau[$i]->nom = $_sous_categorie->nom;
					$tableau[$i]->niveau = $_sous_categorie->niveau;

					$i++;
				}
			}
		}
		
		return $tableau;
	}
	
	private function getParent( $num_produit_categorie=0, $chemin='' ) {
		$temp = "";
		$categorie = new produit_categorie();
		
		if ( $categorie->load( $num_produit_categorie ) ) {
			//echo "#" . $num_produit_categorie . " : " . $categorie->nom . " (ID Parent : " . $categorie->num_parent . ")<br>";
			$chemin = ( $chemin != '' ) ? $num_produit_categorie . ";" . $categorie->nom . "-" . $chemin : $num_produit_categorie . ";" . $categorie->nom;
			
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
	
	function getSousCategorie( $num_produit_categorie=0, $liste='' ) {
		$temp = "";
		$categorie = new produit_categorie();
		$liste = $num_produit_categorie . ",";
		
		// Liste des catégories ayant celle-ci en parent
		$liste_sous_categorie = $this->getListe( $num_produit_categorie );
		
		if ( !empty( $liste_sous_categorie ) ) {
			foreach( $liste_sous_categorie as $_categorie ) {
				$temp .= $this->getSousCategorie( $_categorie->num_produit_categorie, $liste );
			}
		}
		else {
			$temp = $liste;
			//echo "---->" . $temp . "<br>";
		}
		
		return ( $temp );
	}
	
	private function getLinkOLD( $texte='', $initial=true ) {
		$tab = explode( ";", $texte );
		
		// Liste déroulante correspondant au niveau 0
		if ( $initial ) {
			
			// Liste des catégories de niveau 0
			$liste = $this->getListe( 0 );
			
			$lien = "<select class='' name='categorie_principale' onchange='changer_categorie_principale();'>";
			foreach( $liste as $_categorie ) {
				$selected = ( $_categorie->num_produit_categorie == $tab[0] ) ? "selected" : "";
				$lien .= "	<option value='" . strtolower( $_categorie->nom ) . "' " . $selected . " >" . utf8_encode( $_categorie->nom ) . "</option>";
			}
			$lien .= "</select>";
		}
		else {
			//$lien = "&nbsp;<a href='produit-" . $tab[0] . ".html'>" . $tab[1] . "</a>&nbsp;";
			
			// Liste des catégories
			$liste = $this->getListe( $tab[0], false );
			
			$lien = "&nbsp;<select class='' name='categorie_principale' onchange='changer_categorie_principale();'>";
			foreach( $liste as $_categorie ) {
				$selected = ( $_categorie->num_produit_categorie == $tab[0] ) ? "selected" : "";
				$lien .= "	<option value='" . strtolower( $_categorie->nom ) . "' " . $selected . " >" . utf8_encode( $_categorie->nom ) . "</option>";
			}
			$lien .= "</select>";
		}
		
		return $lien;
	}
	
	private function getLink( $texte='' ) {
		$tab = explode( ";", $texte );
		
		// Chargement de la catégorie
		$temp_categorie = new produit_categorie();
		$temp_categorie->load( $tab[0] );
		//echo "-----> " . $temp_categorie->nom . "<br>";
		
		// Liste des catégories
		$liste = $this->getListe( $temp_categorie->num_parent );
		
		$lien = "<select name='categorie_" . $tab[0] . "' id='categorie_" . $tab[0] . "' onchange='changer_categorie( " . $tab[0] . " );'>";
		foreach( $liste as $_categorie ) {
			$selected = ( $_categorie->num_produit_categorie == $tab[0] ) ? "selected" : "";
			$lien .= "	<option value='" . strtolower( $_categorie->num_produit_categorie ) . "' " . $selected . " >" . utf8_encode( $_categorie->nom ) . "</option>";
		}
		$lien .= "</select>";
		
		return $lien;
	}
	
	function getTitre( $num_produit_categorie=0 ) {
		$titre = "";
		
		if ( $this->load( $num_produit_categorie ) ) {
			$temp = utf8_encode( $this->getParent( $num_produit_categorie, '' ) );
			//echo "Temp : " . $temp . "<br>";
			$tab = explode( "-", $temp );
			
			for ($i=0; $i< count($tab); $i++) {
				//echo "--> " . $tab[ $i ] . "<br>";
				$titre .= $this->getLink( $tab[ $i ] ) . " - ";
			}
			
			// Liste des sous-catégories dont le parent est la dernière catégorie
			$_temp = explode( ";", $tab[ $i - 1 ] );
			$liste = $this->getListe( $_temp[ 0 ] );
			
			if ( !empty( $liste ) ) {
				$titre .= "<select name='categorie_0' id='categorie_0' onchange='changer_categorie( 0 );'>";
				$titre .= "	<option value='' selected>-- Choisir --</option>";
				foreach( $liste as $_categorie ) {
					$selected = ( $_categorie->num_produit_categorie == $num_cat_en_cours ) ? "selected" : "";
					$titre .= "	<option value='" . $_categorie->num_produit_categorie . "' " . $selected . " >" . utf8_encode( $_categorie->nom ) . "</option>";
				}
				
				$titre .= "</select>";
			}
			else $titre = substr( $titre, 0, ( strlen( $titre ) - 3) );
		}
		
		return $titre;
	}
	
	function getTitreOLD( $num_produit_categorie=0, $deroulant=false ) {
		$titre = "#";
		
		if ( $this->load( $num_produit_categorie ) ) {
			$temp = utf8_encode( $this->getParent( $num_produit_categorie, '' ) );
			echo "Temp : " . $temp . "<br>";
			$tab = explode( "-", $temp );
			
			// Affichage de la catégorie initiale
			$titre = $this->getLink( strtoupper( $tab[0] ), true );
			$re_temp = "";
			
			// On affiche PLUSIEURS niveaux de catégories
			//echo "----> " . count($tab) . "<br>";
			if ( count($tab) > 1 ) {
				for ($i=1; $i< ( count($tab) - 1 ); $i++) {
					echo "--> " . $tab[ $i ] . "<br>";

					if ( $i < ( count($tab) - 1 ) ) {
						$re_temp .= $this->getLink( $tab[ $i ], false ) . "-";
					}
				}
				
				// Pour la dernière catégorie
				echo "--> Der des der<br>";
				
				// Sous catégorie sélectionnée
				$_temp = explode( ";", $tab[ $i ] );
				$num_cat_en_cours = $_temp[ 0 ];
				echo "--> num_cat_en_cours : " . $num_cat_en_cours . "<br>";
				
				// Liste des sous-catégories dont le parent est la dernière catégorie
				$_temp = explode( ";", $tab[ $i - 1 ] );
				$liste = $this->getListe( $_temp[ 0 ], false );
				
				if ( !empty( $liste ) ) {
					$re_temp .= "&nbsp;<select class='' name='num_categorie_produit' onchange='changer_categorie();'>";
					$re_temp .= "	<option value='' selected>-- Choisir --</option>";
					foreach( $liste as $_categorie ) {
						$selected = ( $_categorie->num_produit_categorie == $num_cat_en_cours ) ? "selected" : "";
						$re_temp .= "	<option value='" . $_categorie->num_produit_categorie . "' " . $selected . " >" . utf8_encode( $_categorie->nom ) . "</option>";
					}
					
					$re_temp .= "</select>";
				}
			}
			
			// On affiche UNIQUEMENT une catégorie de base
			else {
				// Liste des sous-catégories dont le parent est la dernière catégorie
				$liste = $this->getListe( $num_produit_categorie, false );
				
				if ( !empty( $liste ) ) {
					$re_temp .= "&nbsp;<select class='' name='num_categorie_produit' onchange='changer_categorie();'>";
					$re_temp .= "	<option value='' selected>-- Choisir --</option>";
					foreach( $liste as $_categorie ) {
						$selected = ( $_categorie->num_produit_categorie == $num_cat_en_cours ) ? "selected" : "";
						$re_temp .= "	<option value='" . $_categorie->num_produit_categorie . "'>" . utf8_encode( $_categorie->nom ) . "</option>";
					}
					
					$re_temp .= "</select>";
				}
			}
			
			$titre .= " ";
			if ( $re_temp != '' ) $titre .= "-" . substr( $re_temp, 0, ( strlen( $re_temp ) - 1) );
		}
		
		return $titre;
	}
}
?>