(function($) {
    'use strict';

    hidePageLoader();

    if ($('#datatable').length > 0) {
        //initDataList();
        initRootCategory('#filterCategory', 'All');
    }

    $('#filterCategory').change(function() {
        var catId = $(this).find(':selected').val();
        initSubCategory('#filterSubCategory', 'All', catId);
    });

    $('#filterSubCategory').change(function() {
        var catId = $(this).find(':selected').val();
        var selectBox = $('#filterProduct');
        var option = '<option value="">All</option>';

        if(catId > 0){
            var dataString = {
                id:catId
            }

            $.ajax({  
                type: "POST",  
                url: API_URL+'/list/categoryProduct',      
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                  if(response.success==1){
                    $.each(response.data, function(i, object){
                      option+='<option value="'+object.id+'" data-series="'+object.productSeries+'" data-mrp="'+object.productMrp+'">'+object.productName+'</option>';
                    });
                  }
                  selectBox.html(option);
                }, error: function(error, xhr){
                   alert(xhr);
                }
            });

        } else {
            selectBox.html(option);
        }
    });


    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            r += '<div class="tr meta">';

            r += '<div class="td inlineText">' + object.name + '</div>';
            $.each(object.meta, function(i, meta) {
                r += '<div class="td">';
                r += '<span>'+meta.num +'</span><span>'+meta.point +'</span>';
                r += '</div>';
            });

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



    $('#getSearchResult').click(function(){

        $('#datatable').data('page', 1);

        var dataString = {
            year: $('#filterYear :selected').val(),
            categoryId: $('#filterCategory :selected').val(),
            subCategoryId: $('#filterSubCategory :selected').val(),
            productId: $('#filterProduct :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/locationScanedTrend',
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

    });


})(jQuery);