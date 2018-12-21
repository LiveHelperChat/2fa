var twofaga = {
    verify : function(code) {
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/verifycode/' + $('#twofahash').val() + '/ga', {'code' : code}, function(data) {
            if (data.error == false) {
                document.location = data.url;
            } else {
                if (typeof data.url !== 'undefined') {
                    document.location = data.url;
                } else {
                    alert(data.msg);
                }
            }
        });
    }
}