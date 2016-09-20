var s3uploadTm = null;
    var s3uploadsTm = [];
    var insertIdsTm = [];
    function pauseTm(k) {
        s3uploadsTm[k].pause();
    }

    function resumeTm(k) {
        s3uploadsTm[k].resume();
    }

    function cancelTm(k) {
        var conf = window.confirm('Are you sure?');
        if(conf){
            //var l = s3uploads[k].otherInfo.fileNum;
            s3uploadsTm[k].cancel();
            s3uploadsTm[k] = null;
        }
    }
    function filesSelectedToUploadTm(evt){
      
        processSchemaTm(evt)
    }

    function assessorTrainerMatrixUpload() { 
       
        if (!(window.File && window.FileReader && window.FileList && window.Blob && window.Blob.prototype.slice)) {
            alert("Sorry! You are using an older or unsupported browser. Please update your browser");
            return;
        }
      
        processSchemaTm(null);
        var file = $('#matrix_browse')[0].files[0];

    }
    
    function formatBytesTm(bytes,decimals) {
       if(bytes == 0) return '0 Byte';
       var k = 1000; // or 1024 for binary
       var dm = decimals + 1 || 2;
       var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
       var i = Math.floor(Math.log(bytes) / Math.log(k));
       return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }    

    var processSchemaTm = function(reqevt) {
        var promises = [];
        var files;

        if(reqevt != null){
         files=reqevt.dataTransfer.files;   
        }else{
            files = $('#matrix_browse')[0].files; 
        }

        var today = new Date();
        var dd = today.getDate(); 
        var mm = today.getMonth()+1; 
        var yy = today.getFullYear().toString().substr(2,2); 
        var curDate = dd+'/'+mm+'/'+yy;
        
        var k = s3uploadsTm.length;
        //jQuery.each(jQuery('#file')[0].files, function(i, file) {
        for (var i = 0, file; file = files[i]; i++) {
		
         var calFileSize = formatBytesTm(file.size, 0);
       // jQuery.each(files[0].files, function(i, file) {
            //var btn = '<button onclick="cancel('+k+')">Cancel</button>';
            var progressBar = '<div  id="progress-barsTm" > <img class="loader" src="' + base_url + 'public/images/loading.gif">\n\
 \n\
</div>';
            $("#progress-barsTm").append(progressBar);
            $("#fileListContainerTm").show().removeClass('hide');
        
           //var unitId = $('#hid_unit').val() || '';
           // var courseCode = $('#hid_course').val() || '';
           //var docType=$('#userfiles_type').val();
            var docType=$('#doc-type').attr('doc-type');
            var def = new $.Deferred();

            s3uploadsTm[k] = new S3MultiUpload(file, {user: 'user', pass: 'pass',fileNum: k,docType:docType});

            s3uploadsTm[k].onServerError = function(command, jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 403) {
                    alert("Sorry you are not allowed to upload");
                } else {
                    console.log("Our server is not responding correctly");
                }
            };

            s3uploadsTm[k].onS3UploadError = function(xhr) {
                s3uploadsTm[k].waitRetry();
                alert("Upload is failing, we will retry in " + s3uploads[k].RETRY_WAIT_SEC + " seconds");
            };

            s3uploadsTm[k].onProgressChanged = function(uploadingSize, uploadedSize, totalSize, fileNum) {
                $('#summed_progress_'+fileNum).attr('value', uploadedSize + uploadingSize);
                // $('#summed_progress').attr('max', totalSize);
            };

            s3uploadsTm[k].onUploadCompleted = function(data,obj) {
                var datas = {};
                datas.fileName = obj.uploadedName;
                datas.fileInfo = obj.fileInfo;
                datas.otherInfo = obj.otherInfo;
                var l = datas.otherInfo.fileNum;
               var date= new Date();
               var todayDate =   ("0" + date.getDate().toString()).substr(-2) + "/" + ("0" + (date.getMonth() + 1).toString()).substr(-2) + "/" + (date.getFullYear().toString()).substr(2);
               var fsize = bytesToSize(datas.fileInfo['size'])
                    $.ajax({
                    type: "POST",
                    url: base_url + "matrixupload",
                    data: datas,
                    dataType:'json',
                    success: function(res) {                       
                       // $('#userProfile').html('<div class="modal-title" id="myModalLabel">Uploaded Successfully</div><div class="btn_section"><button class="btn btn_red" onclick="javascript:location.reload();">OK</button></div>');
                       // $('#myModal').modal('show');
                       $("#resume_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><span>File Uploaded successfully!</span></div>');
                       
                       var html = ' <div class="file_info">\n\
                                        <span class="icon"><i class="material-icons">description</i></span>\n\
                                        <span class="file-discription">'+ datas.fileInfo['name']+'<br> '+ fsize +' | ADDED '+todayDate+' </span>\n\
                                        </div>';
                        
                        $("#fileListContainerTm").hide();
                        $("#matrix_no_files").hide();
                        
                        $("#trainerMatrix_block").append(html);
                    }
                }); 
		def.resolve('success');
                console.log("Congratz, upload is complete now");

            };

            s3uploadsTm[k].start();
            k++;
            promises.push(def);
        }//);

        return $.when.apply(undefined, promises).promise();
   }
   function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};
    
   