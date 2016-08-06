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
            var l = s3uploads[k].otherInfo.fileNum;
            s3uploads[k].cancel();
            s3uploads[k] = null;
            if(typeof insertIds[l] != 'undefined') {
                console.log('Inserted Id',insertIds[l]);
            }
            $('#progressbar-'+k).remove();
        }
        
    }

    function upload() {

        if (!(window.File && window.FileReader && window.FileList && window.Blob && window.Blob.prototype.slice)) {
            alert("Sorry! You are using an older or unsupported browser. Please update your browser");
            return;
        }

        processSchema();
        var file = $('#file')[0].files[0];

    }

    var processSchema = function() {

        var promises = [];

        var files = document.getElementById("file").files;
        var k = s3uploads.length;
        jQuery.each(jQuery('#file')[0].files, function(i, file) {
            //var btn = '<button onclick="cancel('+k+')">Cancel</button>';
            var progressBar = '<div class="file-info" id="progressbar-'+k+'" data-index="0"> <span class="icon"><i class="material-icons">description</i></span><span class="file-discription">'+file.name+'<br>'+file.size+'| Added4/8/2016</span><span class="file-progress"><progress id="summed_progress_'+k+'" class="prgbar" value="0" max="100"></progress></span> <span class="clear"><a href="#" onclick="cancel('+k+')"><i class="material-icons">clear</i></a></span></div>';
            $("#progress-bars").append(progressBar);
            var unitId = $('#unitId').val() || '';
            var def = new $.Deferred();

            s3uploads[k] = new S3MultiUpload(file, {user: 'user', pass: 'pass',fileNum: k,unitId: unitId});

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

                var datas = {};
                datas.fileName = obj.uploadedName;
                datas.fileInfo = obj.fileInfo;
                datas.otherInfo = obj.otherInfo;
                var l = datas.otherInfo.fileNum;
                $.ajax({
        type: "POST",
        url: base_url + "addEvidences",
        data: datas,
        dataType:'json',
        success: function(res) {
            if (res.evidenceId){    
                insertIds[l] = res.evidenceId;
            }
            //setTimeout(function(){jQuery("#evd_close").trigger('click');},3000); 
        }
    }); 
                def.resolve('success');
                console.log("Congratz, upload is complete now");

            };

            s3uploads[k].start();
            k++;
            promises.push(def);
        });

        return $.when.apply(undefined, promises).promise();
    }
    
   