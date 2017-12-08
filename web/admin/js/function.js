$(function(){
	$("#windowAlert").dialog({
		autoOpen: false,
		width: 350
	});
});
function alertWindow(message, cancelButton,okFunct){
	document.getElementById("alertContent").innerHTML=message;
	if(cancelButton){
		document.getElementsByName("okButton")[0].value="Yes";
		var button = document.createElement("input");
		button.name="cancelButton";
		button.type = "button";
		button.value = "No";
		button.onclick = function(){
					closeAlert();
				};
		
		document.getElementById("alertButtons").appendChild(button);
		
	} else {
		document.getElementsByName("okButton")[0].value="Ok";
	}
	if(typeof(okFunct)!="function")
		okFunct = function(){closeAlert();};
	document.getElementsByName("okButton")[0].onclick = okFunct;
	$('#windowAlert').dialog('open');
}
function closeAlert(){
	var element = document.getElementsByName("cancelButton")[0];
	if(element!=null){
		element.parentNode.removeChild(element);
	}
	$("#windowAlert").dialog("close");
}