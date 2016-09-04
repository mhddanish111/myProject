function hideFloatCart(){
	document.getElementById('myFloatCart').style.display='none'
	document.getElementById('cart').style.display='block'
	/*
	if(countProduct==0){
		document.getElementById('cart').style.display='none'
	}
	*/
}
function showFloatCart(){
	document.getElementById('myFloatCart').style.display='block'
	document.getElementById('cart').style.display='none'
	//updateCartDisplay();
}
