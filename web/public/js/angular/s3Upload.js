angular.module('s3Upload', [])

        .directive('s3Upload', function ($window, $q) {
            return {
                restrict: 'EA',
                replace: true,
                scope: {
                    control: '=',
                    progressbar: '&',
                    uploadcomplete: '&',
                    uploadfailed: '&',
                    uploadstarted: '&',
                    validRegex: '@',
                    data: '@'

                },
                link: function (scope, element, attrs) {
                    scope.validRegex = scope.validRegex || /(\.jpg|\.jpeg|\.bmp|\.gif|\.png|\.rtf|\.pdf|\.csv|\.mp3|\.mp4|\.wmv|\.avi|\.mov|\.swf|\.flv|\.ods|\.mkv|\.wmv|\.txt|\.zip|\.rar|\.arj|\.tar.gz|\.tgz|\.docx|\.xlsx|\.one|\.pub|\.pptx|\.doc|\.docx|\.vsdx|\.accdb|\.mdb|\.rpmsg|\.mso|\.xlsb|\.xls|\.xlsx|\.oft|\.asd|\.mpp|\.thmx|\.xlsm|\.snp|\.obi|\.pst|\.ost|\.olm|\.xsn|\.vsd|\.laccdb|\.dotx|\.docm|\.ppt|\.dot|\.accdr|\.xlam|\.mde|\.wbk|\.onepkg|\.pptm|\.xltx|\.xla|\.pip|\.accde|\.ppsm|\.ppsx|\.vss|\.slk|\.crtx|\.xlt|\.svd|\.xlb|\.xlm|\.xlw|\.grv|\.potx|\.xar|\.iaf|\.mpd|\.pa|\.pps|\.ops|\.dotm|\.pot|\.oab|\.acl|\.mdt|\.mpt|\.xltm|\.xl|\.ade|\.vst|\.ppam|\.xsf|\.accdt|\.mda|\.accdc|\.mdw|\.xll|\.mat|\.vdx|\.sldx|\.mar|\.ppa|\.accda|\.maf|\.puz|\.vsx|\.mam|\.prf|\.potm|\.wll|\.xlc|\.vtx|\.accdp|\.sldm|\.accdu|\.maq|\.xslb|\.h1q|\.cnv|\.maw)$/i;
                    scope.internalControl = scope.control || {};
                    scope.internalData = scope.data || {};
                    if (S3MultiUpload == 'undefined') {
                        console.log('S3MultiUpload Not Found');
                    }
                    scope.s3uploads = [];
                    var insertIds = [];

                    function formatBytes(bytes, decimals) {
                        if (bytes == 0)
                            return '0 Byte';
                        var k = 1000; // or 1024 for binary
                        var dm = decimals + 1 || 2;
                        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                        var i = Math.floor(Math.log(bytes) / Math.log(k));
                        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                    }

                    scope.processSchema = function (reqevt, selection) {

                        var promises = [];

                        var files;

                        if (reqevt) {
                            files = reqevt.dataTransfer.files;
                        } else {
                            files = element[0].files;
                            console.log(files);
                        }

                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1;
                        var yy = today.getFullYear().toString().substr(2, 2);
                        var curDate = dd + '/' + mm + '/' + yy;

                        var k = scope.s3uploads.length;
                        if (files.length == 0) {
                                scope.uploadfailed({msg:'Select Some File'});
                            }
                        for (var i = 0, file; file = files[i]; i++) {
                            var calFileSize = formatBytes(file.size, 0);

                            if (!scope.validRegex.exec(file.name)) {
                                scope.uploadfailed({msg:'unsupported file format'});
                            }

                            var def = $q.defer();

                            if (scope.validRegex.exec(file.name))
                            {
                                var uploadObj = {
                                    user: 'user',
                                    pass: 'pass',
                                    fileNum: k
                                };
                                var userId = scope.data.userId || 0;
                                uploadObj.userDirectory = 'user-' + userId;
                                console.log(uploadObj);
                                uploadObj = angular.merge(uploadObj, scope.data);
                                console.log(uploadObj);
                                //var obj = {user: 'user', pass: 'pass', fileNum: k, hid_unit: unitId, hid_course: courseCode, userDirectory: 'user-' + userId};
                                
                                scope.s3uploads[k] = new S3MultiUpload(file, uploadObj);
                                
                                

                                scope.s3uploads[k].onServerError = function (command, jqXHR, textStatus, errorThrown) {
                                    if (jqXHR.status === 403) {
                                        scope.uploadfailed({msg:'Sorry you are not allowed to upload'});
                                        console.log("Sorry you are not allowed to upload");
                                    } else {
                                        scope.uploadfailed({msg:'Our server is not responding correctly'});
                                        console.log("Our server is not responding correctly");
                                    }
                                };

                                scope.s3uploads[k].onS3UploadError = function (xhr) {
                                    scope.s3uploads[k].waitRetry();
                                    console.log("Upload is failing, we will retry in " + scope.s3uploads[k].RETRY_WAIT_SEC + " seconds");
                                };

                                scope.s3uploads[k].onProgressChanged = function (uploadingSize, uploadedSize, totalSize, fileNum) {
                                    scope.progressbar({uploadingSize:uploadingSize, uploadedSize:uploadedSize, totalSize:totalSize, fileNum:fileNum});
                                };

                                scope.s3uploads[k].onUploadCompleted = function (data, obj) {
                                    scope.uploadcomplete({data:data, obj:obj});
                                    def.resolve('success');
                                    console.log("Congratz, upload is complete now");

                                };
                                
                                scope.s3uploads[k].onUploadStarted = function (file, fileNum, dataObj) {
                                    scope.uploadstarted({file:file,fileNum:fileNum,dataObj: dataObj});

                                };

                                scope.s3uploads[k].start();
                                k++;
                                promises.push(def);
                            }

                        }//);

                        return $.when.apply(undefined, promises).promise();
                    }
                    scope.internalControl.start = function (additionalObj,evt) {
                        if (!($window.File && $window.FileReader && $window.FileList && $window.Blob && $window.Blob.prototype.slice)) {
                            alert("Sorry! You are using an older or unsupported browser. Please update your browser");
                            return;
                        }
                        if(additionalObj) scope.data = additionalObj;
                        scope.processSchema(evt);
                    };
                    scope.internalControl.cancel = function (k) {
                        scope.s3uploads[k].cancel(k);
                    };
                    scope.internalControl.resume = function (k) {
                        scope.s3uploads[k].cancel(k);
                    };
                    scope.internalControl.pause = function (k) {
                        scope.s3uploads[k].cancel(k);
                    };

                }

            };
        });