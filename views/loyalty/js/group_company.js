(function($) {
    'use strict';

    if ($('#datatable').length > 0) {
        initDataList();
    }

    initGroup('#group', 'Select');
    initSubGroup('#subgroup', 'Select');

    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        var currentAuthoriseStatus = "";
        $.each(dataArray, function(i, object) {
        //  r += '<div class="tr align-items-center">';
            r += '<div class="tr align-items-center">';
            r += '<div class="td inlineText">' + object.group_id + '</div>';
            r += '<div class="td inlineText">' + object.group_name + '</div>';
            r += '<div class="td inlineText">' + object.sub_group_id + '</div>';
            r += '<div class="td inlineText">' + object.sub_group_name + '</div>';
            r += '<div class="td inlineText">' + object.id + '</div>';
            r += '<div class="td inlineText">' + object.group_company_name + '</div>';
            r += '<div class="td inlineText">' + object.erp_id + '</div>';
            r += '<div class="td inlineText">';
            r += '<a href="javascript:;" class="editListItem" data-groupid="' + object.group_id + '" data-subgroupid="' + object.sub_group_id + '" data-id="' + object.id + '" data-name="' + object.group_company_name + '" data-erpid="' + object.erp_id +'" ><i class="mdi mdi-pencil"></i></a>';
            // r += '<a href="javascript:;" class="deleteListItem" data-id="' + object.id + '"><i class="mdi mdi-delete"></i></a>';
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
        var totalRecord = Object.keys(response).length+1;
        if (totalRecord > dataString.limit) {
            $('#dataPagination').twbsPagination({
                totalPages: totalRecord,  
                visiblePages: 5,  
                next: "Next",  
                prev: "Prev", 
                onPageClick: function(event, page) {
                    $('#datatable').data("page",page);
                    initDataList();
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
            url: API_URL + '/authorisation/groupCompanyList',
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
                    initPagination(response.data,dataString);
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
    // initDataList();


    $('body').on('click', '.editListItem', function() {
        
        var groupid = $(this).data('groupid');
        var subgroupid = $(this).data('subgroupid');
        var id = $(this).data('id');       
        var name = $(this).data('name');  
        var erpId = $(this).data('erpid');
        
        $('#group').val(groupid);
        $('#subgroup').val(subgroupid);
        $('#editId').val(id);
        $('#name').val(name);
        $('#erpid').val(erpId);

        bodyFix();
        var modalBox = $('#addEditModal');
        modalBox.addClass('show');
    });

    
    function initGroup(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/ajaxGetGroupList',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                     option+='<option value="'+object.id+'">'+object.name+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }

    function initSubGroup(selectBox, defaultLabel){
        var selectBox = $(selectBox);
        var option = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/ajaxGetSubGroupList',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                     option+='<option value="'+object.id+'">'+object.name+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }

    
    $('#group').change(function() {
      
        var groupId = $(this).find(':selected').val();
        
            var selectMainCatBox = $('#subgroup');
            var mainCatOption = '<option value="">All</option>';
            
         //   showPageLoader();
         
         if(groupId !=''){
            
             var dataString = {
                groupId:groupId
            }
            
                $.ajax({  
                type: "POST",  
                url: API_URL+'/ajaxGroupId',      
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(dataString),
                dataType: "json",
                cache: false,
                success: function(response){
                    if(response.success==1){
                        console.log(response.data);
                        $.each(response.data, function(i, object){
                          mainCatOption +='<option value="'+object.id+'">' +object.name+'</option>';
                        });
                      }
                      selectMainCatBox.html(mainCatOption);
                      
                     // hidePageLoader();
                    
                }, 
                error: function(error, xhr){
                    hidePageLoader();
                    console.log(xhr);
                }
            });
            
            } else {
                selectMainCatBox.html(mainCatOption);
                $('#group').html('<option value="">All</option>');
            } 
     
        });

        
    $('#editForm').submit(function() {
        var form = $(this);
        if (validateForm(form)) {

            var dataString = {
                id: $('#editId').val(),
                group: $('#group :selected').val(),
                subgroup: $('#subgroup :selected').val(),
                name: $('#name').val(),
                erpid: $('#erpid').val()                  
            }

            showPageLoader();
            $.ajax({
                type: "POST",
                url: API_URL + '/loyalty/editGroupCompany',
                data: JSON.stringify(dataString),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success == 1) {
                        bodyUnFix();
                        $('#addEditModal').removeClass('show');
                        initDataList();
                        showResponseSuccessMsg('Group successfully updated.');
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


})(jQuery);