(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            r += '<div class="tr align-items-center">';
            
            r += '<div class="td"><div><b>' + object.page_top_space + '</div></div>';
            
             r += '<div class="td"><div><b>' + object.space_two_row + '</div></div>';
             
              r += '<div class="td"><div><b>' + object.space_two_col + '</div></div>';
            
            r += '<div class="td"><div><b>' + object.space_left + '</div></div>';
            
            r += '<div class="td">' + object.coupon_width + '</div>';
            
              r += '<div class="td">' + object.coupon_height + '</div>';

            r += '<div class="td action">';
            
            r += '<a href="javascript:;" class="editListItem" data-id="' + object.id + '"><i class="mdi mdi-pencil"></i></a>';
        
            
            r += '</div>';

            r += '</div>';
        });
        dataResult.html(r);
    }


    function initDataList() {

        var dataString = {
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }


        $.ajax({
            type: "POST",
            url: API_URL + '/printPageSpace/list',
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


    $('#addNewRecord').click(function() {
        
        $('#inptTPS').val('');
        $('#inptTRS').val('');
        $('#inptTCS').val('');
        $('#inptLS').val('');
        $('#inptRS').val('');
        

        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.addClass('show');
    });
    
    
    $('body').on('click', '.editListItem', function() {

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/printPageSpace/detail/' + id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success == 1) {

                    $('#editId').val(response.data.id);
                    $('#inptTPS').val(response.data.page_top_space);
                    $('#inptTRS').val(response.data.space_two_row);
                    $('#inptTCS').val(response.data.space_two_col);
                    $('#inptLS').val(response.data.space_left);
                    $('#inptCW').val(response.data.coupon_width);
                    $('#inptCH').val(response.data.coupon_height);
                  
                   
                    bodyFix();
                    var modalBox = $('#addEditModal');
                    modalBox.addClass('show');
                    modalBox.find('.modal-header h3').text('Edit Print Page Space Details');
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
    });
    
    

    $('#editForm').submit(function(){
        var form = $(this);
        var dataString = {
            id: $('#editId').val(),
            inptTPS: $('#inptTPS').val(),
            inptTRS: $('#inptTRS').val(),
            inptTCS: $('#inptTCS').val(),
            inptLS: $('#inptLS').val(),
            inptCW: $('#inptCW').val(),
            inptCH: $('#inptCH').val()
        }

        var modalBox = $('#addEditModal');

        if(validateForm(form)){
            $.ajax({
                type: "POST",
                url: API_URL + '/printPageSpace/edit',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    hidePageLoader();
                },
                success: function(response) { 
                    if (response.success == 1) {
                        initDataList()
                        modalBox.find('.close').click();
                        showResponseSuccessMsg("Successfully Updated.");
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

        return false;
    });




})(jQuery);