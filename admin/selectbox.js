function addOnCon(objfrom,objto,objhidden){
	var index = parseInt(objfrom.selectedIndex);
	if (index<0){return false;}
	index2 = parseInt(objto.length);
	if (index2==0){
		for (var i = objfrom.options.length - 1; i >= 0; i--){
				if (objfrom.options[i].selected){
					var option = document.createElement("option");
					objto.options[objto.length] = option;
					option.text = objfrom.options[i].text;
					option.value = objfrom.options[i].value;
				}
			}
	}	
	
	if (index2>0){
		for(j=0;j<=objfrom.options.length-1;j++){
			var values = objfrom[j].value;
			var txxt = objfrom[j].text;
			if(objfrom.options[j].selected){
				for(i=0; i<=objto.length-1;i++){			
					if(objto[i].value==values){	
						alert(''+ txxt +' :   Already Exist in List');
						return false;
					}					
				}
			}
		}	
		for (var i = objfrom.options.length - 1; i >= 0; i--){
				if (objfrom.options[i].selected){
					var option = document.createElement("option");
					objto.options[objto.length] = option;
					option.text = objfrom.options[i].text;
					option.value = objfrom.options[i].value;
				}
			}
	}	
	
}

function removeOnCon(objto,objhidden){
	var indexRemove = parseInt(objto.selectedIndex);
	if (indexRemove<0){	
		alert("Please Select The Item.")
		objto.focus();
		return false;
	}
	for (var i = objto.options.length - 1; i >= 0; i--){
		if (objto.options[i].selected){
			objto.remove(i);
		}
	}
	
}

function select_all_options(optionsSel) {
	for (var i = 0; i < optionsSel.length; i++) {
	    optionsSel.options[i].selected = true;
	}
}

function allSelected(){
	select_all_options(document.getElementById("subscriberemail"));
}