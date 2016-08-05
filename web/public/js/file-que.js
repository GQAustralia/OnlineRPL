$(document).ready(function() {
     var ccode=$('#select_hid_course').val();
        var ucode=$('#select_hid_unit').val();
        console.log(ccode+':'+ucode);
	$(".upload").upload({
                        action: "/addEvidences",
                       postData: {'file[hid_unit]':$('#select_hid_course').val(),'file[hid_course]':$('#select_hid_unit').val()}
		}).on("start.upload", onStart)
		.on("complete.upload", onComplete)
		.on("filestart.upload", onFileStart)
		.on("fileprogress.upload", onFileProgress)
		.on("filecomplete.upload", onFileComplete)
		.on("fileerror.upload", onFileError)
		.on("queued.upload", onQueued)
                .on('beforeSend',onBeforeSend);

	$(".filelist.queue").on("click", ".cancel", onCancel);
	$(".cancel_all").on("click", onCancelAll);
});

function onCancel(e) {
	console.log("Cancel");
	var index = $(this).parents("li").data("index");
	$(this).parents("form").find(".upload").upload("abort", parseInt(index, 10));
}

function onCancelAll(e) {
	console.log("Cancel All");
	$(this).parents("form").find(".upload").upload("abort");
}

function onBeforeSend(formData, file) {
	console.log("Before Send");
        var ccode=$('#select_hid_course').val();
        var ucode=$('#select_hid_unit').val();
                
	formData.append("test_field", "test_value",ccode,ucode,"select_hid_course","select_hid_unit");
	// return (file.name.indexOf(".jpg") < -1) ? false : formData; // cancel all jpgs
       
	//return formData;
}

function onQueued(e, files) {
	console.log("Queued");
	var html = '';
	var todayDate= new Date();
var dateStr=[todayDate.getDate(), todayDate.getMonth()+1, todayDate.getFullYear()].join('/');

	/*for (var i = 0; i < files.length; i++) {
	
		html += '<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span><span class="cancel">Cancel</span><span class="progress">Queued</span></li>';
	}*/
	var icon;
	
	for (var i = 0; i < files.length; i++) {
	
	if(files[i].file.type=='mp3' || files[i].file.type=='audio/wav'){
		icon='mic';
	}else if(files[i].file.type=='mpeg' || files[i].file.type=='video/x-ms-wmv' ){
		icon='videocam';
	}else{
		icon='description';
	}

	html +=" <div class='file-info' data-index='" + files[i].index+"'> <span class='icon'><i class='material-icons'>"+icon+"</i></span><span class='file-discription'>" + files[i].name +"<br>"+files[i].size+"| Added"+dateStr+"</span><span class='file-progress'><progress class='prgbar' value='0' max='100'></progress></span> <span class='clear'><a href='#' onclick='removeThisEle(this)'><i class='material-icons'>clear</i></a></span></div>"
	
		//html += '<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span><span class="cancel">Cancel</span><span class="progress">Queued</span></li>';
	}

console.log($(this).parents("form").find("fileListContainer"));
$('.fileListContainer').append(html);
	/*$(this).parents("form").find("fileListContainer")
		.append(html);
		debugger;*/
}
function removeThisEle(req){
    $(req).closest('.file-info').remove();
    //debugger;
}
function onStart(e, files) {
	console.log("Start");
	$(".fileListContainer")
		.find("div")
		.find(".progress").text("Waiting");
}

function onComplete(e) {
	console.log("Complete");
	// All done!
}

function onFileStart(e, file) {
	console.log("File Start");
        //.find(".prgbar").text("0%");
	$(".fileListContainer")
		.find("div[data-index=" + file.index + "]")
		.find(".progress").text("0%");
}

function onFileProgress(e, file, percent) {
	console.log("File Progress"+percent+':'+file.index);
	$(".fileListContainer")
		.find("div[data-index=" + file.index + "]")
		.find(".prgbar").val(percent);
}

function onFileComplete(e, file, response) {
	console.log("File Complete");
	if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
	$(".fileListContainer")
			.find("li[data-index=" + file.index + "]").addClass("error")
			.find(".progress").text(response.trim());
	}
	else {
		var $target = $(".fileListContainer").find("li[data-index=" + file.index + "]");
		$target.find(".file").text(file.name);
		$target.find(".progress").remove();
		$target.find(".cancel").remove();
		$target.appendTo($(this).parents("form").find(".filelist.complete"));
	}
}

function onFileError(e, file, error) {
	console.log("File Error");
	$(".fileListContainer")
		.find("li[data-index=" + file.index + "]").addClass("error")
		.find(".progress").text("Error: " + error);
}