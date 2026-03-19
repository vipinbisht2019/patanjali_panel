(function($) {
    'use strict';
    
    initPlant('#plant', 'All');
    //initRootCategory('#mainCategory', 'Select');

    $('#mainCategory').change(function() {
         showPageLoader();
        var catId = $(this).find(':selected').val();
        initSubCategory('#subCategory', 'Select', catId);
         hidePageLoader();
    });

    $('#subCategory').change(function() {
        showPageLoader();
        var catId = $(this).find(':selected').val();
        initCategoryProduct('#categoryProduct', 'Select', catId);
        hidePageLoader();
    });


    function initPlant(selectBox, defaultLabel){
        var selectPlantBox = $(selectBox);
        var plantOption = '<option value="">'+defaultLabel+'</option>';
        $.ajax({  
            type: "GET",  
            url: API_URL+'/plant/getPlantList', 
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
               if(response.success==1){
                    $.each(response.data, function(i, object){
                      plantOption +='<option value="'+object.plant_id+'">' +object.plant_name+'</option>';
                    });
                  }
              selectPlantBox.html(plantOption);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }
    
        
// get Main category which assigned to plant
$('#plant').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#mainCategory');
        var mainCatOption = '<option value="">Select</option>';
        
        showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/plant/getPlantsMainCategory',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    console.log(response.data);
                    $.each(response.data, function(i, object){
                      mainCatOption +='<option value="'+object.id+'">' +object.category_name+'</option>';
                    });
                  }
                  selectMainCatBox.html(mainCatOption);
                  
                  hidePageLoader();
                
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });
 
    });



    hidePageLoader();

    function initFormData(dataArray) {
        var formDataWrap = $('#formDataWrap');
        var formDataRows = $('#formDataRows');
        var h = '';
        var r = '';
        var s = 0;

        h += '<div class="fx-col-100">Batch Size</div>';
        $.each(dataArray[0].data, function(k, f) {
            h += '<div class="fx-col-100">'+f.faceValue+'</div>';
        });

        $('#formDataWrap').find('.headRow').html(h);

        
          $.each(dataArray, function(i, d) {
              
            r += '<div class="rowSet rowSet_'+i+'" data-num="'+i+'">';
            r += '<div class="flexRow item-row" data-id="'+d.batchId+'">';
            r += '<div class="fx-col-100"><input type="text" class="form-control int batchSize" name="" value="'+d.batchSize+'" placeholder="Batch Size" readonly></div>';
            
            $.each(d.data, function(k, f) {
                r += '<div class="fx-col-100 fv" data-id="'+f.id+'" data-face-value-id="'+f.faceValueId+'">';
                r += '<input type="text" class="form-control int faceValueQty" name="" value="'+f.faceValueQty+'" placeholder="Qty" readOnly>';
                 
                r += '</div>';
            });
            
            r += '<a href="javascript:;" class="deleteListItem" data-id="' + d.batchId + '" title="Delete Batch"><i class="mdi mdi-delete"></i></a>';
 
            r += '</div>';
            r += '</div>';
          });

        

        formDataRows.html(r);
        formDataWrap.show();
    }

    function noResult() {
        var dataResult = $('#dataTableResult');
        var r = '<div class="tr noResult">';
        r += '<div class="td">No Result Found</div>';
        r += '</div>';
        dataResult.html(r);
    }


    $('#searchForm').submit(function(){

        var form = $(this);
        var plantId = $('#plant :selected').val();
        var catId = $('#mainCategory :selected').val();
        var subCatId = $('#subCategory :selected').val();
        var productId = $('#categoryProduct :selected').val();

        if(validateForm(form)){
            showPageLoader();
            $.ajax({  
                type: "POST",  
                url: API_URL+'/getCouponBatchData',      
                data: JSON.stringify({plantId:plantId, catId:catId, subCatId:subCatId, productId:productId}),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response){
                    hidePageLoader();
                    if(response.success==1){
                        initFormData(response.data);
                        $('#formDataWrap').show();
                    } else {
                        $('#formDataWrap').hide();

                    }
                }, 
                error: function(error, xhr){
                   hidePageLoader();
                   console.log(xhr);
                }
            });
        }

        return false;
    });

    //item-row
    $('#submitFormData').click(function(){

        var dataSet = [];
        var plantId = $('#plant :selected').val();
        var productId = $('#categoryProduct :selected').val();
        $('.item-row').each(function(){
            var elm = $(this);

            var dataSubSet = [];
            elm.find('.fv').each(function(){
                var fv = $(this);
                dataSubSet.push({
                    id:fv.data('id'),
                    faceValueId:fv.data('face-value-id'),
                    faceValueQty:fv.find('.faceValueQty').val()
                });
            });

            dataSet.push({
                id:elm.data('id'),
                productId:productId,
                plantId:plantId,
                batchSize:elm.find('.batchSize').val(),
                data:dataSubSet
            });
        });

        var dataString = {
            data:dataSet
        }

        showPageLoader();
        $.ajax({  
            type: "POST",  
            url: API_URL+'/couponBatch/add',      
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
                hidePageLoader();
                if(response.success==1){
                    initFormData(response.data);
                } else {

                }
            }, 
            error: function(error, xhr){
                hidePageLoader();
                console.log(xhr);
            }
        });

    });


    $('body').on('keyup', '.faceValueQty', function(){
        var row = $(this).closest('.item-row');
        var totalValue = row.find('.batchSize');
        var total=0;
        var v = 0;
        row.find('.faceValueQty').each(function(){
            if($(this).val().length > 0){
                v = parseFloat( $(this).val() );
            } else {
                v = 0;
            }
            
            total=total+v;
        });
        totalValue.val(total);
    });

    $('#addMoreRow').click(function(){
        
        $("#submitFormData").show();

        var i = $('#formDataRows').find('.rowSet:last-child').data('num') + 1
        var rowData = $('#formDataRows').find('.rowSet:first-child').html();
        //console.log(rowData);


        var r='<div class="rowSet rowSet_'+i+'" data-num="'+i+'">'+rowData;
        r+='<a href="javascript:;" class="removeRow"><i class="mdi mdi-close"></i></a>';
        r+='</div>';
        
      
        $('#formDataRows').append(r);
        $('.rowSet_'+i).find('.item-row').data('id',0);
        $('.rowSet_'+i).find('.item-row').data('product',0);
        $('.rowSet_'+i).find('.int').val('');
        $('.rowSet_'+i).find('.fx-col-100').data('id',0);
        
        $('.rowSet_'+i + ' .faceValueQty').prop('readonly', false);
        $('.rowSet_'+i + ' .deleteBatchBtn').remove();
        
        

    });

    $('body').on('click','.removeRow',function(){ 
        
        $(this).closest('.rowSet').remove();
         
        if(!$( ".removeRow" ).length)
           $("#submitFormData").hide();
        
    });
    
    
    
    $('body').on('click', '.deleteListItem', function() {

        if(!confirm('Are you sure want to delete this ?')){
            return false;
        }

        var id = $(this).data('id');
        showPageLoader();
        $.ajax({
            type: "GET",
            url: API_URL + '/couponBatchData/delete/'+id,
            data: '',
            dataType: "json",
            cache: false,
            success: function(response) {
                hidePageLoader();
                if (response.success == 1) { 
                    $( "#searchForm" ).submit();
                    showResponseSuccessMsg("Batch successfully deleted.");
                } else {
                    showResponseErrorMsg(response.message);
                }
            },
            error: function(error, xhr) {
                console.log('error', error);
                console.log('xhr', xhr);
                showResponseErrorMsg("Unable to proccess this request.");
                hidePageLoader();
            }
        });
    });



})(jQuery);