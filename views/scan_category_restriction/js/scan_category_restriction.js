(function ($) {
    'use strict';
    initCategory();
    function initCategory() {
        $.ajax({
            type: "POST",
            url: API_URL + '/list/category',
            data: JSON.stringify({}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (response) {
                hidePageLoader();
                if (response.success == 1) {
                    initCategoryData(response.data);
                } else {

                }
            },
            error: function (error, xhr) {
                hidePageLoader();
                console.log(xhr);
            }
        });
    }


    //hidePageLoader();

    function initCategoryData(dataArray) {
        var r = '';
        var s = 0;
        $.each(dataArray, function (i, object) {

            r += '<div class="tr inlineText" style="padding-top: 10px; padding-bottom: 10px; border-bottom: #e7e7e7 solid 1px;">';
            r += '<div class="td inlineText" style="padding-left: 10px;">' + object.categoryName + '</div>';

            r += '<div class="td inlineText" style="padding-right: 10px;">';
            r += '<input class="inputtxt" id="cat__' + object.id + '" data-id="' + object.id + '"></div>';

            r += '</div>';

        });

        $('#formDataRows').html(r);
        //formDataWrap.show();
    }

    function noResult() {
        var dataResult = $('#dataTableResult');
        var r = '<div class="tr noResult">';
        r += '<div class="td">No Result Found</div>';
        r += '</div>';
        dataResult.html(r);
    }


    $('#submitFormData').click(function () {
        var dataSet = [];
        var inputTxtVal = "";

        $('.inputtxt').each(function () {

            var elm = $(this);
            if ($(this).val() > 0) {
                dataSet.push({
                    catId: elm.data('id'),
                    scanLimit: $(this).val()
                });
            }

        });

        var dataString = {
            data: dataSet
        }

        showPageLoader();
        $.ajax({
            type: "POST",
            url: API_URL + '/scan_category_restriction/add',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (response) {
                hidePageLoader();
                if (response.success == 1) {
                    window.location = APP_URL + '/scan_category_restriction/cslist';
                    showResponseSuccessMsg(response.message);

                } else {
                    showResponseErrorMsg(response.message);
                }
            },
            error: function (error, xhr) {
                hidePageLoader();
                console.log(xhr);
            }
        });
    });


})(jQuery);