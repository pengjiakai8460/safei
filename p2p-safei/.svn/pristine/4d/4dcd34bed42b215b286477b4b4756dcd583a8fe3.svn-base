function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
function install() {

    // 未认证用户不可下载应用
    if (downloadOnlyForCertification && !userIsCertification) {
        alert(unableDownload);
        return false;
    }

    if (aType == 'ios') {
        if (!isMobileRequest) {
            alert(askBrowserAlert);
            return;
        }
    }

    if (aType == 'ios' && browseType == 'android') {
        alert(forIosAlert);
        return;
    } else if (aType == 'android' && browseType == 'ios') {
//        alert(forAndroidAlert);
//        return;
    }

//    if ( isWechatRequest && aType == 'android') {
    if ( isWechatRequest) {
        alert(reminderWechatContent);
        return;
    }

    if (isQQRequest && aType == 'android') {
        alert(reminderQQContent);
        return ;
    }

    if (isUCRequest && !isIOS) {
        alert(reminderUCContent);
        return ;
    }

    url = "/app/install/" + aKey;
    window.location.href = url;
}

function install_loading() {

    // 未认证用户不可下载应用
    if (downloadOnlyForCertification && !userIsCertification) {
        alert(unableDownload);
        return;
    }

    if (aType == 'ios') {
        if (!isMobileRequest) {
            alert(askBrowserAlert);
            return;
        }
    }

    // 安卓应用pc下载需要支付时提醒
    if (aType == 'android' && downloadPayMoney > 0 && !isMobileRequest) {
        console.log(downloadPayMoney)
        alert(askBrowserAlert);
        return;
    }

    if (aType == 'ios' && browseType == 'android') {
        alert(forIosAlert);
        return;
    } else if (aType == 'android' && browseType == 'ios') {
//        alert(forAndroidAlert);
//        return;
    }

//    if ( isWechatRequest && aType == 'android') {
    if ( isWechatRequest) {
        alert(reminderWechatContent);
        return;
    }

    if ( isWeiboRequest) {
        alert(reminderWeiboContent);
        return;
    }

    if (isQQRequest && aType == 'android') {
        alert(reminderQQContent);
        return ;
    }

    if (isUCRequest && !isIOS) {
        alert(reminderUCContent);
        return ;
    }

    if(aType == 'ios'){
        $("#down_load").hide();
        $(".loading").css("display","inline-block");
        setTimeout('check()',5000);
    }

    url = "/app/install/" + aKey;
    window.location.href = url;
}
 function check() {
    $(".loading").hide();
    $("#showtext").show();
 }

function saveData() {
    $.ajax({
        type : "POST",
        data : $('#form').serialize(),
        dataType: 'json',
        beforeSend: function( xhr ) {
            if (isMobileRequest) {
                $('#submitButton').text( submiting ).attr('disabled', 'disabled');
            } else {
                $('#submitButton').text( submiting ).addClass('btn-u-default').attr('disabled', 'disabled');
            }
        },
        success : function(result, textStatus, jqXHR) {
                      
            code = result.code;
            href = result.extra.href;
            if (code == 0) {
//                window.location.reload();
                window.location.href = href;
            } else {
                alert(result.message);
                $('#submitButton').text( submitText ).removeClass('btn-u-default').removeAttr('disabled');
            }
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('#submitButton').text( submitText ).removeClass('btn-u-default').removeAttr('disabled');
        }
    });
}
    
function initView() {
    $('.history_row').click(function() {
       appkey = $(this).attr('appkey');
       window.location.href = '/' + appkey;
    });
}

function reditectAppStore() {
    if ( isWechatRequest) {
        alert(reminderWechatDownloadContent);
        return;
    }

    if ( isWeiboRequest) {
        alert(reminderWeiboDownloadContent);
        return;
    }

    if (isQQRequest && aType == 'android') {
        alert(reminderQQDownloadContent);
        return ;
    }

    if (isUCRequest && !isIOS) {
        alert(reminderUCDownloadContent);
        return ;
    }

    url = appStoreUrl;
    window.location.href = url;
}

function initScreenUploader() {
        $fub = $('#uploader-files');
        var uploader = new qq.FineUploaderBasic({
            button: $fub[0],
            request: {
                endpoint: '/report/uploadFile'
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'zip', 'rar']
            },
            maxConnections: 1,
            callbacks: {
                onSubmit: function(id, fileName) {
                    $('#loading').show();
                },
                onUpload: function(id, fileName) {
                },
                onProgress: function(id, fileName, loaded, total) {
                },
                onError: function(event, id, reason ) {
                    alert(reason);
                },
                onComplete: function(id, fileName, responseJSON) {
                    $('#loading').hide();
                    if (responseJSON.success) {
                        $("#fileList").show();
                        var html;
                        html = "<li id=\"file" + responseJSON.key + "\">";
                        html += "<input type=\"hidden\" name=\"files[]\" value=\""+responseJSON.key+"\">";
                        html += "<input type=\"hidden\" name=\"fileNames[]\" value=\""+responseJSON.name+"\">";
                        html += responseJSON.name +"<a onclick=\"javascript:fileDelete('"+responseJSON.key+"');\" style='padding-left:10px;' class='app_edit_screenshot_delete_button' href='javascript:void(0);'>" + reportFileDeleteBtn +"</a>";
                        html += "</li>"
                        $("#fileList").append(html);
                   }
                }
            },
            debug: true
        });
    }

     function fileDelete(key) {
        if (!confirm(deleteFileConfirm)) {
            return;
        }

        $('#file' + key).remove();
    }

function pay_down_load() {

    // 未认证用户不可下载应用
    if (downloadOnlyForCertification && !userIsCertification) {
        alert(unableDownload);
        return;
    }

    if (aType == 'ios') {
        if (!isMobileRequest) {
            alert(askBrowserAlert);
            return;
        }
    }

    if (aType == 'ios' && browseType == 'android') {
        alert(forIosAlert);
        return;
    } else if (aType == 'android' && browseType == 'ios') {
//        alert(forAndroidAlert);
//        return;
    }

//    if ( isWechatRequest && aType == 'android') {
    if ( isWechatRequest) {
        alert(reminderWechatContent);
        return;
    }

    if ( isWeiboRequest) {
        alert(reminderWeiboContent);
        return;
    }

    if (isQQRequest && aType == 'android') {
        alert(reminderQQContent);
        return ;
    }

    if (isUCRequest && !isIOS) {
        alert(reminderUCContent);
        return ;
    }

//    if(aType == 'ios'){
//        $("#down_load").hide();
//        $(".loading").css("display","inline-block");
//        setTimeout('check()',5000);
//    }

    if (!isUserLogged) {
        checkLogin();
        return;
    }

    url = "/pay/payDownload/" + aKey;
    window.location.href = url;
}

function loadOtherApps() {
    console.log(appTemplate);
    var page = $('#pageNum').val();
    var html = '';
    $.ajax({
        url  : "/app/loadOtherApps",
        type : "POST",
        data : {'page': page, 'aKey':aKey},
        dataType: 'json',
        cache: false,
        beforeSend: function( xhr ) {
        },
        success : function(result, textStatus, jqXHR) {
            if (result.code == 0) {
                var list = result.extra.list;
                var pageCount = result.extra.pageCount;
                var chtml = '';
                if (list.length) {
                    $.each(result.extra.list, function(k, item) {
                        chtml += '<tr appkey="' + item.a_key + '" class="history_row">';
                        if (appTemplate == 'gray' || appTemplate == 'fashion') {
                             chtml += '<td class="text-center" width="30%">' + item.a_version + ' (build ' + item.getBuildVersion + ')</td>';
                             chtml += '<td class="text-left" width="50%">' + item.a_update_description + '</td>';
                             chtml += '<td class="text-center" width="20%">' + item.a_created + '</td>';
                        } else {
                            chtml += '<td class="text-center" style="min-width:120px;">' + item.a_version + ' (build ' + item.getBuildVersion + ')</td>';
                            chtml += '<td class="text-center" style="min-width:100px;">' + item.a_created;
                            if (item.a_update_description) {
                                chtml += '<br />' + item.a_update_description;
                            }

                            chtml += '</td>';
                        }

                        chtml += '</tr>';
                    });

                    $('#ajaxMore').before(chtml);
                    initView();
                }

                $('#pageNum').val(parseInt(page)+1);

                if (page >= pageCount) {
                    $('#ajaxMore').hide();
                }

            } else {
                $('#ajaxMore').hide();
            }

        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('#loading').hide();
        }
    });
}

