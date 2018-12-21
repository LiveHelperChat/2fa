var twofasms = {
    verify : function(code) {
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/verifycode/' + $('#twofahash').val() + '/sms', {'code' : code}, function(data) {
            if (data.error == false) {
                document.location = data.url;
            } else {
                if (typeof data.url !== 'undefined') {
                    document.location = data.url;
                } else {
                    $('#sms-2fa-errors-container').html('<div data-alert="" class="alert alert-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><ul class="validation-ul"><li>'+data.msg+'</li></ul></div>');
                }
            }
        });
    },
    resend : function() {
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/resend/' + $('#twofahash').val() + '/sms', function(data) {
            if (data.error == false) {
                $('#sms-2fa-errors-container').html('<div data-alert="" class="alert alert-info alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><ul class="validation-ul"><li>'+data.msg+'</li></ul></div>');
            } else {
                if (typeof data.url !== 'undefined') {
                    document.location = data.url;
                } else {
                    $('#sms-2fa-errors-container').html('<div data-alert="" class="alert alert-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><ul class="validation-ul"><li>'+data.msg+'</li></ul></div>');
                }
            }
        });
    }
}