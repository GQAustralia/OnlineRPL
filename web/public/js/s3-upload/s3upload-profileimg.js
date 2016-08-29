var s3upload = null;
    var s3uploads = [];
    var insertIds = [];
    function pause(k) {
        s3uploads[k].pause();
    }

    function resume(k) {
        s3uploads[k].resume();
    }

    function cancel(k) {
        var conf = window.confirm('Are you sure?');
        if(conf){
            //var l = s3uploads[k].otherInfo.fileNum;
            s3uploads[k].cancel();
            s3uploads[k] = null;
//            console.log(typeof insertIds[l]);
//            if(typeof insertIds[l] != 'undefined') {
//                console.log('Inserted Id',insertIds[l]);
//            }
//            var fileId = $('#upload_id'+k).attr('data-upid');
//            var fileType = $('#upload_id'+k).attr('data-evdtype');
//            var delData = 'fid='+fileId+'&ftype='+fileType;
//            if(fileId != '' && fileType !='') {
//                $.ajax({
//                    type: "POST",
//                    url: base_url + "deleteEvidenceFile",
//                    data: delData,
//                    dataType:'json',
//                    success: function(result) {
//                        console.log('Evidence Deleted');
//                    }
//                });
//            }
//            $('#progressbar-'+k).remove();
//            
//            console.log('child length :: '+$("#progress-bars .file-info").length);
//            if($(".file-info").length == 0) {
//                $("#fileListContainer").addClass('hide');
//            }
        }
    }
    function filesSelectedToUpload(evt){
      
        processSchema(evt)
    }

    function profileImageUpload() {
        
        if (!(window.File && window.FileReader && window.FileList && window.Blob && window.Blob.prototype.slice)) {
            
            alert("Sorry! You are using an older or unsupported browser. Please update your browser");
            return;
        }
        
        processSchema(null);
        var file = $('#userprofile_userImage')[0].files[0];

    }
    
    function formatBytes(bytes,decimals) {
       if(bytes == 0) return '0 Byte';
       var k = 1000; // or 1024 for binary
       var dm = decimals + 1 || 2;
       var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
       var i = Math.floor(Math.log(bytes) / Math.log(k));
       return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }    

    var processSchema = function(reqevt) {

        var promises = [];

        var files;
        
        if(reqevt != null){
         files=reqevt.dataTransfer.files;   
        }else{
            files = $('#userprofile_userImage')[0].files; 
        }

        var today = new Date();
        var dd = today.getDate(); 
        var mm = today.getMonth()+1; 
        var yy = today.getFullYear().toString().substr(2,2); 
        var curDate = dd+'/'+mm+'/'+yy;
        
        var k = s3uploads.length;
        //jQuery.each(jQuery('#file')[0].files, function(i, file) {
        for (var i = 0, file; file = files[i]; i++) {
		
         var calFileSize = formatBytes(file.size, 0);
       // jQuery.each(files[0].files, function(i, file) {
            //var btn = '<button onclick="cancel('+k+')">Cancel</button>';
            var progressBar = '<div  id="progress-bars" > <img src="' + base_url + 'public/images/loading.gif">\n\
 \n\
</div>';
            $("#progress-bars").append(progressBar);
            $("#fileListContainer").show().removeClass('hide');
            var userId=$('#userVal').val();;
           
            var def = new $.Deferred();

            s3uploads[k] = new S3MultiUpload(file, {user: 'user', pass: 'pass',fileNum: k,userId:userId});

            s3uploads[k].onServerError = function(command, jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 403) {
                    alert("Sorry you are not allowed to upload");
                } else {
                    console.log("Our server is not responding correctly");
                }
            };

            s3uploads[k].onS3UploadError = function(xhr) {
                s3uploads[k].waitRetry();
                alert("Upload is failing, we will retry in " + s3uploads[k].RETRY_WAIT_SEC + " seconds");
            };

            s3uploads[k].onProgressChanged = function(uploadingSize, uploadedSize, totalSize, fileNum) {
                $('#summed_progress_'+fileNum).attr('value', uploadedSize + uploadingSize);
                // $('#summed_progress').attr('max', totalSize);
            };

            s3uploads[k].onUploadCompleted = function(data,obj) {
               var userId = $('#userVal').val();
               var userType = $('#hdn-type').val();
                var datas = {};
                datas.fileName = obj.uploadedName;
                datas.fileInfo = obj.fileInfo;
                datas.otherInfo = obj.otherInfo;
                var l = datas.otherInfo.fileNum;
                $.ajax({
                    type: "POST",
                    url: base_url + "uploadProfilePic/"+userId,
                    data: datas,
                    dataType:'json',
                    success: function(res) {                       
                       // $('#userProfile').html('<div class="modal-title" id="myModalLabel">Uploaded Successfully</div><div class="btn_section"><button class="btn btn_red" onclick="javascript:location.reload();">OK</button></div>');
                       // $('#myModal').modal('show');
//                       $("#profile_suc_msg2").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2>Profile Image Uploaded successfully!</h2></div>');
//                       location.reload();

                       $('#user_profile_image').attr('src',amazon_link+obj.uploadedName);                    
                    $("#profile_suc_msg2").show();
                    $("#profile_suc_msg2").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2>Profile Image updated successfully!</h2></div>');
                    $("#ajax-profile-error").hide();
                    $("#ajax-gq-profile-page-img").css("background-image", "url('" + amazon_link +  obj.uploadedName + "')");
                    if (userType == 0) {
                        $("#ajax-gq-profile-small-page-img").css("background-image", "url('" + amazon_link +  obj.uploadedName + "')");
                    }
                    if (userType == 2) {
                        $('#hdn-img').val(result);
                    }
                    $("#ajax-loading-icon").hide();
                    $("#fileListContainer").hide();
                    }
                }); 
                def.resolve('success');
                console.log("Congratz, upload is complete now");

            };

            s3uploads[k].start();
            k++;
            promises.push(def);
        }//);

        return $.when.apply(undefined, promises).promise();
   }
    
   