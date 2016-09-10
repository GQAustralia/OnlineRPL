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
                
                if($('#matrixUpload').length) 
					{
						$("#matrixUpload").ajaxForm({
							beforeSubmit: function() {
								$('#matrix_load').show();
							},
							success: function(responseText, statusText, xhr, $form) {
								console.log(responseText);
								
								$('#resume_msg').css("display", "block");
								$('#matrix_load').prev().html('');
								$('#matrix_load').hide();
								if (responseText) {
									var result = jQuery.parseJSON(responseText);
									var name = result.name.split('.');
									var html = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" id="idfiles_' + result.id + '"><div class="gq-dashboard-courses-detail"><span class="gq-dashboard-points-icon">\n\
													<a class="modalClass viewModalClass" data-toggle="modal" data-target="#myModal" otherfiles="others" fileid="' + result.id + '" filetype="' + result.type + '">\n\
														<div class="gq-del-evidence"></div></a>\n\
													<div class="tooltip-home top">\n\
														<div class="tooltip-arrow"></div>\n\
														<span class="">Delete ID File</span>\n\
													</div>\n\
												</span>\n\
												<a href = "' + amazon_link + result.path + '" class="fancybox fancybox.iframe"><div class="gq-id-files-content-icon-wrap gq-id-files-content-doc-icon"></div></a><div class="gq-id-files-content-row-wrap"><div class="gq-id-files-content-row"><label>Title</label><span>' + name[0] + '</span></div><div class="gq-id-files-content-row"><label>Added on</label><span>' + result.date + '</span></div></div></div></div>';
									if ($('#matrix_no_files').html() === 'No trainer matrix found') {
										$('.matrix_files').html(html);
									} else {
										$('.matrix_files').append(html);
									}
									$('#resume_msg').css("display", "block");
								}
							},
							resetForm: true
						});
					}
					def.resolve('success');
                console.log("Congratz, upload is complete now");

            };

            s3uploadsTm[k].start();
            k++;
            promises.push(def);
        }//);

        return $.when.apply(undefined, promises).promise();
   }
    
   