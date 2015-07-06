/*$(document).ready(function(){
	swapValue = [];
		$("input,textarea").each(function(i){
		swapValue[i] = $(this).val();
		$(this).focus(function(){
			//alert( $(this).val() );
			if ( ( $(this).val() != "ENVOYER" ) && ( $(this).val() != "S'INSCRIRE" ) ) {
				if ($(this).val() == swapValue[i]) {
					$(this).val("");
				}
				$(this).addClass("focus");
			}
		}).blur(function(){
			if ($.trim($(this).val()) == "") {
				$(this).val(swapValue[i]);
				$(this).removeClass("focus");
			}
		});
	});
});*/

function verif_form(){
	Form_ok=true;
	
	if(document.getElementById("nom").value =="Nom*"){
		document.getElementById("nom").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("nom").className = "champ";
	}
	
	if(document.getElementById("prenom").value =="Prénom*"){
		document.getElementById("prenom").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("prenom").className = "champ";
	}
	
	if(document.getElementById("adresse").value =="Adresse*"){
		document.getElementById("adresse").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("adresse").className = "champ";
	}
	
	if(document.getElementById("cp").value =="Code postal*"){
		document.getElementById("cp").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("cp").className = "champ";
	}
	
	if(document.getElementById("ville").value =="Ville*"){
		document.getElementById("ville").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("ville").className = "champ";
	}
	
	if(document.getElementById("tel").value =="N° de Téléphone*"){
		document.getElementById("tel").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("tel").className = "champ";
	}
	
	if(!checkMail(document.getElementById("email"))){
		document.getElementById("email").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("email").className = "champ";
	}
									
	if(document.getElementById("sujet").value =="Sujet*"){
		document.getElementById("sujet").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("sujet").className = "champ";
	}
									
	if(document.getElementById("msg").value =="Votre message*"){
		document.getElementById("msg").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("msg").className = "champ";
	}
	
	if (Form_ok == true){
		document.getElementById("mon_action").value = "envoyer";
		document.forms['contact'].submit();
		return true;
		//return false;
	}else{
		return false;
	}
}

function checkMail(email) {
	var valmail = email.value;
	var reg = new RegExp('^[a-zA-Z0-9]+([_|\.|-]{1}[a-zA-Z0-9]+)*@[a-zA-Z0-9\-\.]+([_|\.|-]­{1}[a-zA-Z0-9]+)*[\.][a-zA-Z]{2,3}$', 'i');
	if(!reg.test(valmail) || valmail == "")
	{
		return false;
	}
	else {
		return true;
	}
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

	return true;
}

function verifier_inscription() {
	Form_ok=true;
	
	if(document.getElementById("nom").value =="Nom*"){
		document.getElementById("nom").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("nom").className = "champ";
	}
	
	if(document.getElementById("prenom").value =="Prénom*"){
		document.getElementById("prenom").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("prenom").className = "champ";
	}
	
	if(document.getElementById("adresse").value =="Adresse*"){
		document.getElementById("adresse").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("adresse").className = "champ";
	}
	
	if(document.getElementById("cp").value =="Code postal*"){
		document.getElementById("cp").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("cp").className = "champ";
	}
	
	if(document.getElementById("ville").value =="Ville*"){
		document.getElementById("ville").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("ville").className = "champ";
	}
	
	if(document.getElementById("tel").value =="N° de Téléphone*"){
		document.getElementById("tel").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("tel").className = "champ";
	}
	
	if(!checkMail(document.getElementById("email"))){
		document.getElementById("email").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("email").className = "champ";
	}
	
	if(document.getElementById("mdp").value =="Mot de passe*"){
		document.getElementById("mdp").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("mdp").className = "champ";
	}
	
	if(document.getElementById("mdp2").value =="N° de Téléphone*"){
		document.getElementById("mdp2").className = "erreur_champ";
		Form_ok =false;
	}else{
		document.getElementById("mdp2").className = "champ";
	}
	
	if( document.getElementById("mdp").value != document.getElementById("mdp2").value ){
		document.getElementById("mdp").className = "erreur_champ";
		document.getElementById("mdp2").className = "erreur_champ";
		Form_ok =false;
	}
	
	if (Form_ok == true){
		document.getElementById("mon_action").value = "inscrire";
		document.forms['inscription'].submit();
		return true;
		//return false;
	}else{
		return false;
	}
}

function isNumber( champ ) {
	alert(champ);
	var txt = find(champ).value;
	txt = txt.replace(" ", "");
	find(champ).value = txt;
}

function find(obj) {
	//alert("Objet recherché : " + obj);
	return document.getElementById(obj)!= null ? document.getElementById(obj) : null ;
}