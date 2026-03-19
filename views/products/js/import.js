(function($) {
    'use strict';
    initRootCategory('#mainCategory', 'Select');
    $('#mainCategory').change(function() {
        var catId = $(this).find(':selected').val();
        initSubCategory('#subCategory', 'Select', catId);
    });
    hidePageLoader();

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        // var status = '';
        // var popular = '';
        $.each(dataArray, function(i, object) {
            // status = (object.isActive==1) ? statusLable('Active', 'success')+'</a>' : statusLable('In-Active', 'red');
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.categoryName + '</div>';
            r += '<div class="td inlineText">' + object.mainCategoryName + '</div>';
            r += '<div class="td action">';
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '" data-id="' + object.parentId + '" data-name="' + object.categoryName + '" data-text="' + object.description + '"><i class="mdi mdi-pencil"></i></a>';
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
            r += '</div>';
            r += '</div>';
            //s++;
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


    $('.uploadBtn').click(function() {
        var productFileUploadForm = $('#productFileUploadForm');
         if(validateForm(productFileUploadForm)){
            $('#fileInpt').click();
     } else {
             return false;
         }
        $('#fileInpt').click();
    });

    function initFileResponse(loader, response) {
        loader.html('');
        loader.hide();
        $('#fileInptWrap').html('<input type="file" id="fileInpt" name="file" value="">');

        var s = '';
        s += '<div class="flexRow flex-space-between">';
        s += '<div class="">';
        s += '<label>File Name</label>';
        s += '<span>'+response.uploaded_name+'</span>';
        s += '</div>';
        s += '<div class="">';
        s += '<label>No of Records.</label>';
        s += '<span>'+response.totalRows+'</span>';
        s += '</div>';
        s += '<div class=""><label>Records Imported</label><span class="currentRecordImported">0</span></div>';
        s += '<div class="">';
        s += '<a href="javascript:;" class="cs-btn btn-dark startImportButton">Start Data Import</a>';
        s += '</div>';
        s += '</div>';

        $('#importFileResponse').html(s);
        $('#importFileResponse').data('id', response.id);
        $('#importFileResponse').data('total', response.totalRows);
        $('#importFileResponse').data('page', 0);
        $('#importFileResponse').data('completed', 0);
        $('#importFileResponse').data('filename', response.uploaded_name);
        //$('#importFileResponse').data('start-id', response.id);
    }

    $('body').on('click', '.startImportButton', function(){
        var id = $('#importFileResponse').data('id');
        var total = $('#importFileResponse').data('total');
        var page = $('#importFileResponse').data('page');
        var completed = $('#importFileResponse').data('completed');
        var filename = $('#importFileResponse').data('filename');
        $('.startImportButton').css({'visibility':'hidden'});
        if(total!=completed){
            initImport(id, total, page, filename);
        }
    });

    function initImport(id, total, page, filename){

        var categoryId = $('#subCategory :selected').val();
        var dataString = {
            id:id,
            page:page,
            total:total,
            filename:filename,
            categoryId:categoryId
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/importProductData',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {
                    // $('.currentRecordImported').text(response.total);
                    // if(response.is_completed==0){
                    //     $('#importFileResponse').data('page', response.page);
                    //     $('.startImportButton').click();
                    // } else {
                    //     showResponseSuccessMsg("Product file data successfully imported.");
                    //     window.location.href=APP_URL+'/products';
                    // }

                    showResponseSuccessMsg("Product file data successfully imported.");
                    window.location.href=APP_URL+'/products';
                    
                } else {
                    showResponseErrorMsg(response.message);
                }
                //hidePageLoader();
            },
            error: function(error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                //hidePageLoader();
            }
        });

    }



    $('body').on('change', '#fileInpt', function() {
        var fileVal = $(this).val();
        var sizeinbytes = this.files[0].size;
        console.log(this.files[0]);
        var fileExtension = ['xls', 'xlsx'];
        if ($.inArray(fileVal.split('.').pop().toLowerCase(), fileExtension) == -1) {
            showResponseErrorMsg("Only formats are allowed : " + fileExtension.join(', '));
            return false;
        } else if (sizeinbytes > 8000000) {
            showResponseErrorMsg("File size not more then 4 MB");
            return false;
        }
        var form = $('#productFileUploadForm');
        var formData = new FormData(form[0]);
        var action = APP_URL + '/api/uploadProductFile';
        var fileLoader = form.next('.importFileLoader');
        form.hide();

        initProgressLoader(fileLoader, this.value);
        $.ajax({
            url: action,
            type: 'POST',
            xhr: function(e) {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function(e) {
                        progressUpload(e, fileLoader);
                    }, false);
                }
                return myXhr;
            },
            success: function(response) {

                if (response.success == 1) {
                    initFileResponse(fileLoader, response);
                } else {
                    progressUploadRemove(fileLoader);
                }

            },
            error: function(jqXHR, exception) {
                console.log('jqXHR', jqXHR);
                console.log('exception', exception);
                progressUploadRemove(fileLoader);
            },
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false
        });
    });

    function initProgressLoader(fileLoader, fileInput) {
        var filename = fileInput.replace(/^.*[\\\/]/, '');
        var s = '';
        s += '<div class="imageItem in-progress">';
        s += '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">';
        s += '<span class="percentage-progress">0%</span>';
        s += '<span class="progress-bar"><span style="width: 0%;"></span></span>';
        s += '</div>';
        fileLoader.html(s);
        fileLoader.show();
    }

    function progressUploadRemove(loader) {
        loader.html('');
        loader.hide();
        $('#productFileUploadForm').show();
        $('#fileInptWrap').html('<input type="file" id="fileInpt" name="file" value="">');
    }

    function progressUploadComplete(loaderid, response) {

    }

    function progressUpload(e, loader) {
        var percent = loader.find('.percentage-progress');
        var progressBar = loader.find('.progress-bar > span');
        if (e.lengthComputable) {
            var val = 0;
            val = Math.round((e.loaded / e.total) * 100);

            if (val == 100) {
                percent.text("Analyzing product sheet data ...");
            } else {
                percent.text(val + '%');
            }
            progressBar.css({
                width: val + '%'
            });
        }
    }
})(jQuery);