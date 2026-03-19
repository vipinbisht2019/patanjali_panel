(function($) {
    'use strict';

    init()
    hidePageLoader();

    $('#dataForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                company: $('#companyName').val(),
                email: $('#companyEmail').val(),
                mobile: $('#companyMobile').val(),
                logo: $('#logo').val(),
                pass: $('#pass').val(),
                cnfpass: $('#cnfrmpass').val()
            }
            
            if($('#pass').val() != $('#cnfrmpass').val())
            {
                alert('Password did not matched !!');
                $('#pass').focus();
                return false;
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/updateCompanyInfo',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        showResponseSuccessMsg(response.message);
                        $('#saveProfileInfo').text('Save Info');
                    } else {
                        showResponseErrorMsg(response.message);
                    }
                    hidePageLoader();
                },
                error: function(error, xhr) {
                    console.log('error', error);
                    console.log('xhr', xhr);
                    showResponseErrorMsg("Unable to proccess this request.");
                    hidePageLoader();
                }
            });
        }
        return false;
    });

    function init(){
            $.ajax({
                type: "POST",
                url: API_URL + '/company',
                data: '',
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {

                        $('#companyName').val(response.data.company_name);
                        $('#companyEmail').val(response.data.email);
                        $('#companyMobile').val(response.data.mobile);
                        $('#logo').val(response.data.logo);

                        if(response.data.logo!=''){
                            $('#logoWrap').html('<img src="'+APP_URL+'/uploads/logo/120/'+response.data.logo+'">');
                            $('#uploadBtn').text('Change Logo');
                            $('#saveProfileInfo').text('Save Info');
                        } else {
                            $('#saveProfileInfo').text('Add Info');
                        }

                        

                    } else {
                        
                    }
                    hidePageLoader();
                },
                error: function(error, xhr) {
                    console.log('error', error);
                    console.log('xhr', xhr);
                    showResponseErrorMsg("Unable to proccess this request.");
                    hidePageLoader();
                }
            });
    }


    //changeProductImage
    $('#uploadBtn').click(function(){

        var loaderid = makeid();
        var uploadButton = $(this);
        var target = $('#logo');

        var fileID = 'file_'+makeid();
        var frm='<form action="'+API_URL+'/uploadLogo" enctype="multipart/form-data" style="display:none;">';
            frm+='<input type="file" name="file" id="'+fileID+'">';
            frm+='</form>';
            $('body').append(frm);

        $('#'+fileID).click();
        $('#'+fileID).change(function(){

            var fullPath = this.value;
            progressAttachmentStart(uploadButton, loaderid, fullPath);
            uploadButton.hide();

            var form = $('#'+fileID).closest('form');
            var formData = new FormData( form[0] );
            var action = form.attr('action');

                $.ajax({
                    url: action,
                    type: 'POST',
                    xhr: function(e) {
                        var myXhr = $.ajaxSettings.xhr();
                        if(myXhr.upload){
                            myXhr.upload.addEventListener('progress', function(e){
                                progressAttachment(e, loaderid);
                            }, false);
                        }
                        return myXhr;
                    },
                    success: function(response){
                        progressAttachmentCompleted(loaderid);
                        
                        if(response.success==1){
                            //uploadButton.remove();
                            $('#logo').val(response.data.uploaded_name);
                            $('#logoWrap').html('<img src="'+response.data.src+'">');
                            $('#uploadBtn').text('Change Logo');

                        } else {
                            uploadButton.show();
                            
                        }
                        form.remove();
                    },
                    error: function(jqXHR, exception){ 
                        console.log('jqXHR',jqXHR);
                        console.log('exception',exception);
                        progressAttachmentCompleted(loaderid);
                        uploadButton.show();
                        form.remove();
                    },
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false
            });
        });
    });


    function makeid(){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";    
        for( var i=0; i < 10; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));   
        return text;
    }

    function progressAttachmentStart(uploadButton, loaderid, fullPath){
        var filename = fullPath.replace(/^.*[\\\/]/, '');
        var s='';
        s+='<div class="uploadLineLoader" id="uploadLineLoader__'+loaderid+'">';
            s+='<div class="upldrFile">'+filename+'</div>';
            s+='<div class="upldrProgress">0%</div>';
            s+='<div class="upldrBar"><div></div></div> ';
        s+='</div>';
        uploadButton.after(s);
    }

    function progressAttachmentCompleted(loaderid){
        $('#uploadLineLoader__'+loaderid).remove();
    }

    function progressAttachment(e, loaderid){
        var uploadFileWrap = $('#uploadLineLoader__'+loaderid);
        var percent = uploadFileWrap.find('.upldrProgress');  
        var progressBar = uploadFileWrap.find('.upldrBar > div'); 
        if (e.lengthComputable) {
              var val = 0;  
              val = Math.round((e.loaded / e.total) * 100);
              percent.text(val+'%');
              progressBar.css({width:val+'%'});          
        }   
    }


})(jQuery);