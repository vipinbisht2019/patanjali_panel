(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var currentAuthoriseStatus = "";
        
        $.each(dataArray, function(i, object) {
            
             currentAuthoriseStatus =  (object.is_ofa == 1) ? statusLable('Open for all', 'success') : statusLable('Limited Authorise', 'red');
             
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.categoryName + '</div>';
            
            r += '<div class="td inlineText">' + currentAuthoriseStatus + '</div>';

            if(object.is_ofa==1){
                r += '<div class="td">';
                r += '<select class="modeSelect" style="padding:3px 10px; border-color:#ccc; border-radius:2px;">';
                    r += '<option value="0">Select</option>';
                    r += '<option value="2">Limited Authorisation</option>';
                    r += '<option value="3">Deauthorise</option>';
                    r += '</select>';
                r += '<button class="btn btn-success btn-sx" style="padding: 6px 20px 7px 20px; margin-left:5px; visibility: hidden;" data-id="' + object.id + '">Save</button>';
                r += '</div>'; 
            } else {
                r += '<div class="td">';
                r += '<select class="modeSelect" style="padding:3px 10px; border-color:#ccc; border-radius:2px;">';
                    r += '<option value="0">Select</option>';
                    r += '<option value="2">Limited Authorisation</option>';
                    r += '<option value="3">Deauthorise</option>';
                    r += '</select>';
                r += '<button class="btn btn-success btn-sx" style="padding: 6px 20px 7px 20px; margin-left:5px; visibility: hidden;" data-id="' + object.id + '">Save</button>';
                r += '</div>'; 
            }

            r += '<div class="td" style="flex:0 0 120px;">';
            r += '<button class="btn btn-primary importListItem" style="padding: 6px 20px 7px 20px; visibility: hidden; " data-id="' + object.id + '"><i class="mdi mdi-upload"></i> Import</button>';
            r += '</div>';
            r += '<div class="td" style="flex:0 0 120px;">';
            r += '<button class="btn btn-primary exportListItem" style="padding: 6px 20px 7px 20px; visibility: hidden; " data-id="' + object.id + '"><i class="mdi mdi-download"></i> Export</button>';
            r += '</div>';
            r += '</div>';
        });
        dataResult.html(r);
    }

    function noResult() {
        if ($('.simple-pagination').length) {
            $('#dataPagination').pagination('destroy');
        }
        var dataResult = $('#dataTableResult');
        var r = '<div class="tr noResult">';
        r += '<div class="td">No Result Found</div>';
        r += '</div>';
        dataResult.html(r);
    }

    function initPagination(response, dataString) {
        if ($('.simple-pagination').length) {
            $('#dataPagination').pagination('destroy');
        }

        if (response.total > dataString.limit) {
            $('#dataPagination').pagination({
                items: response.total,
                itemsOnPage: dataString.limit,
                currentPage: dataString.page,
                cssStyle: 'light-theme',
                onPageClick: function(pageNumber, event) {
                    $('#datatable').data('page', pageNumber);
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    initSearchResult();
                },
            });
        }
    }

    function initDataList() {

        var dataString = {
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/category/main',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    initData(response.data);
                } else {
                    noResult();
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    }

    $('body').on('change','.modeSelect', function(){
        var val = $(this).find(':selected').val();
        var row = $(this).closest('.tr');
        var saveButton = row.find('.btn-success');
        var importButton = row.find('.importListItem');
        var exportButton = row.find('.exportListItem');

        if(val==1){
            saveButton.css('visibility','visible');
            importButton.css('visibility','hidden');
            exportButton.css('visibility','hidden');
        } else if(val==2){
            saveButton.css('visibility','hidden');
            importButton.css('visibility','visible');
            exportButton.css('visibility','visible');

        } else if(val==3){
            saveButton.css('visibility','hidden');
            importButton.css('visibility','visible');
            exportButton.css('visibility','visible');

        } else {
            saveButton.css('visibility','hidden');
            importButton.css('visibility','hidden');
            exportButton.css('visibility','hidden');
        }
    });


    $('body').on('click','.exportListItem', function(){

        var mode = $(this).closest('.tr').find('select :selected').val();
        var categoryId = $(this).data('id');
        var action = '';
        var ReportTitle = '';

        if(mode==1 || mode==2){
            action = API_URL + '/exportLoyaltyAuthUsers';
            ReportTitle = 'Authrise User List';
        } else {
            action = API_URL + '/exportLoyaltyDeauthUsers';
            ReportTitle = 'Un-authrise User List';
        }

        $.ajax({
            type: "POST",
            url: action,
            data: JSON.stringify({categoryId:categoryId}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                showPageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    JSONToCSVConvertor(response.data, ReportTitle, true);
                } else {
                    showResponseErrorMsg(response.message);
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    });

    $('body').on('click','.btn-success', function(){
        var categoryId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: API_URL + '/loyaltyOpenForAll',
            data: JSON.stringify({categoryId:categoryId}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    showResponseSuccessMsg(response.message);
                } else {
                    showResponseErrorMsg(response.message);
                }
            },
            complete: function(response) {
                hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    });


        $('body').on('click', '.importListItem', function(){

            var mode = $(this).closest('.tr').find('select :selected').val();
            var categoryId = $(this).data('id');
            

            var loaderid = makeid();
            var uploadButton = $(this);
            var target = $('#userData');

            var fileID = 'file_'+makeid();
            var frm='<form action="'+API_URL+'/importLoyaltyUsers" enctype="multipart/form-data" style="display:none;">';
                frm+='<input type="hidden" name="mode" value="'+mode+'">';
                frm+='<input type="hidden" name="categoryId" value="'+categoryId+'">';
                frm+='<input type="file" name="file" id="'+fileID+'">';
                frm+='</form>';
                $('body').append(frm);

            $('#'+fileID).click();
            $('#'+fileID).change(function(){

                var fullPath = this.value;
                //progressAttachmentStart(uploadButton, loaderid, fullPath);

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
                                    //progressAttachment(e, loaderid);
                                }, false);
                            }
                            return myXhr;
                        },
                        success: function(response){
                            //progressAttachmentCompleted(loaderid);
                            
                            if(response.success==1){
                                showResponseSuccessMsg(response.message);
            
                            } else {
                                 showResponseErrorMsg(response.message);
        
                            }

                            form.remove();
                        },
                        error: function(jqXHR, exception){ 
                            console.log('jqXHR',jqXHR);
                            console.log('exception',exception);
                            //progressAttachmentCompleted(loaderid);
                            //uploadButton.show();
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


})(jQuery);