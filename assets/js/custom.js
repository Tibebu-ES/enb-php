//not used - delete it later
function selectNoticeContentSource(val) {
	//window.alert("selectedSource="+val);
	if(val=="internal"){
		//disable file upload form element and hide the fileSelectorDiv
		document.getElementById("uploadNoticeFile").setAttribute("disabled","true");
		$("#contentSelectorDiv").addClass("hidden");

		//show content editor
		$("#contentEditorDiv").removeClass("hidden");
		document.getElementById("contentEditor").removeAttribute("disabled") ;
	}else if(val == "external"){
		//enable file upload form element & show the fileSelectordiv
		document.getElementById("uploadNoticeFile").removeAttribute("disabled");
		$("#contentSelectorDiv").removeClass("hidden");

		//hide content editor
		//document.getElementById("contentEditor").setAttribute("disabled","true");
		$("#contentEditorDiv").addClass("hidden");

	}

}

function init() {
//executes when ever the apage loads - in the body onload event -

	//check if the changepasswordoperation is notcomplete - by checking the session


}

//preview the selected notice images - in the Add_Notice - page
function loadFile(event) {
	try {
		var imgPreviewDiv = document.getElementById("imagePreviewDiv");
		imgPreviewDiv.innerHTML="";
		for(var i =0; i<event.target.files.length;i++){
			//creat dom elements - and add them to the div of id=imagePreviewDiv
			var imgElt = document.createElement("img");
			var attrCls = document.createAttribute("class");
			attrCls.value = "img-thumbnail";
			var attrWidth = document.createAttribute("width");
			attrWidth.value = "100";
			var attrHg = document.createAttribute("height");
			attrHg.value = "100";
			var attrSrc = document.createAttribute("src");
			attrSrc.value = URL.createObjectURL(event.target.files[i]);

			imgElt.setAttributeNode(attrWidth);
			imgElt.setAttributeNode(attrHg);
			imgElt.setAttributeNode(attrCls);
			imgElt.setAttributeNode(attrSrc);


			imgPreviewDiv.appendChild(imgElt);
		}

	}catch (e) {
		window.alert("Error Previewing"+e);
	}

}

//prompt the user - to confirm
//if the user confirms-press ok - delete the nnotice
//if cancel do nothing

function deleteNotice(url) {
	if(window.confirm("Are you sure to delete the selected notice?")){
		//var url = "../deleteNotice/"+nid+"/"+uname;
		//window.alert(url);
		window.location.replace(url);
	}else{

	}
}

function deleteUser(url) {
	if(window.confirm("All the notices created by the user will be deleted.Are you sure to delete the selected user? ")){
		window.location.replace(url);
	}else{

	}
}



