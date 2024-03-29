var twofaemail = {
    verify : function(code) {
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/verifycode/' + $('#twofahash').val() + '/email', {'code' : code}, function(data) {
            if (data.error == false) {
                document.location = data.url;
            } else {
                if (typeof data.url !== 'undefined') {
                    document.location = data.url;
                } else {
                    $('#email-2fa-errors-container').html('<div data-alert="" class="alert alert-danger alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+data.msg+'</div>');
                }
            }
        });
    },
    resend : function() {
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/resend/' + $('#twofahash').val() + '/email', function(data) {
            if (data.error == false) {
                $('#email-2fa-errors-container').html('<div data-alert="" class="alert alert-info alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+data.msg+'</div>');
            } else {
                if (typeof data.url !== 'undefined') {
                    document.location = data.url;
                } else {
                    $('#email-2fa-errors-container').html('<div data-alert="" class="alert alert-danger alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+data.msg+'</div>');
                }
            }
        });
    }
}