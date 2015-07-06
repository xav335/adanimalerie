alert("www");
jQuery.noConflict();

jQuery(document).ready(function(){
	hideContent = function(contentString){
		jQuery("#div_supplement").fadeOut( 1000 ,function() {
			showContent(contentString);playSound(0);
		});
	};
	showContent = function (contentString) {
		jQuery.ajax({
			type: "GET",
			url: contentString,
			dataType:"html",
			success: function(data){
				jQuery("#div_supplement").html(data);
				jQuery("#div_supplement").slideDown(1000);
			},
			error: function () {
				alert("Page "+contentString+" not found");
			}
		}); 
	};
	
	if(jQuery(document).getUrlParam("page")!=null) { 			
 			hideContent(jQuery(document).getUrlParam("page"));	
 	} else {
 			showContent("liste_categorie.php");	
	}
});