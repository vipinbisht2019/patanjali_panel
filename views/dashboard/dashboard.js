(function ($) {
  'use strict';

  if ($('#datatable').length > 0) {
    initDataList();
  }

  function initData(dataArray) {
    var dataResult = $('#dataTableResult');
    var r = '';
    $.each(dataArray, function (i, object) {
      r += '<div class="tr align-items-center">';
      r += '<div class="td"><div><b>' + object.title + '</b><br>' + object.remark + '</div></div>';
      r += '<div class="td">' + object.createdOn + '</div>';

      r += '<div class="td action">';
      r += '<a href="javascript:;"  class="showDetail" data-id="' + object.id + '"><i class="mdi mdi-information" title="Detail Info"></i></a>';
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
    r += '<div class="td">No Record Found !!</div>';
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
        onPageClick: function (pageNumber, event) {
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
      url: API_URL + '/dashNegativeFeedback',
      data: JSON.stringify(dataString),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      beforeSend: function () {
        hidePageLoader();
      },
      success: function (response) {
        if (response.success == 1) {
          initData(response.data);
        } else {
          noResult();
        }
      },
      complete: function (response) {
        hidePageLoader();
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        showResponseErrorMsg("Server was unable to process request");
      }
    });
  }


  $('body').on('click', '.ajax-model-close', function () {
    initDataList();
  });


  $('body').on('click', '.showDetail', function () {
    var id = $(this).data('id');
    showPageLoader();
    $.ajax({
      type: "GET",
      url: API_URL + '/feedback/detail/' + id,
      data: '',
      dataType: "json",
      cache: false,
      success: function (response) {
        if (response.success == 1) {

          $('#productName').val(response.data.productName);
          $('#couponCode').val(response.data.couponCode);
          $('#title').val(response.data.title);
          $('#name').val(response.data.name);
          $('#mobile').val(response.data.mobile);
          $('#city').val(response.data.city);
          $('#createdOn').val(response.data.createdOn);

          $('.loaderWrap').hide();

          bodyFix();
          var modalBox = $('#displayModal');
          modalBox.addClass('show');
          modalBox.find('.modal-header h3').text('Product Feedback Detail');
        } else {
          showResponseErrorMsg(response.message);
        }
        hidePageLoader();
      },
      error: function (error, xhr) {
        console.log('error', error);
        console.log('xhr', xhr);
        showResponseErrorMsg("Unable to proccess this request.");
        hidePageLoader();
      }
    });
  });




})(jQuery);