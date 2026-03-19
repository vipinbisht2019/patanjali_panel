(function($) {
    'use strict';

    // hidePageLoader();

    // if ($('#datatable').length > 0) {
        
        initPlant_week('#plant_week', 'All');
		 initPlant_week5('#plant_week5', 'All');
		 
		 pointsummery();
		 monthlypointsummery();
		 
		 
		  //initPlant_week6('#plant_week6', 'All');
        //initRootCategory('#filterCategory', 'All');
        // initState('#filterState', 'All');
        // initGroup('#group', 'All');
    // }
    
    
        
        // get Main category which assigned to plant
$('#plant_week').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#filterCategoryforweekchart');
        var mainCatOption = '<option value="">Select</option>';
        
        //showPageLoader();
        
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
                 
                 // hidePageLoader();
                
            }, 
            error: function(error, xhr){
              //  hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
	$('#plant_week5').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#filterCategoryforweekchart5');
        var mainCatOption = '<option value="">Select</option>';
        
        //showPageLoader();
        
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
                  
               //   hidePageLoader();
                
            }, 
            error: function(error, xhr){
              //  hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
	$('#plant_week6').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#filterCategoryforweekchart6');
        var mainCatOption = '<option value="">Select</option>';
        
        //showPageLoader();
        
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
                  
                //  hidePageLoader();
                
            }, 
            error: function(error, xhr){
              //  hidePageLoader();
                console.log(xhr);
            }
        });
 
    });
    

    // $('#filterCategory').change(function() {
        // var catId = $(this).find(':selected').val();
        // initSubCategory('#filterSubCategory', 'All', catId);
    // });

    // $('#filterSubCategory').change(function() {
        // var catId = $(this).find(':selected').val();
        // var selectBox = $('#filterProduct');
        // var option = '<option value="">All</option>';

        // if(catId > 0){

            // var dataString = {
                // id:catId
            // }

            // $.ajax({  
                // type: "POST",  
                // url: API_URL+'/list/categoryProduct',      
                // data: JSON.stringify(dataString),
                // contentType: "application/json; charset=utf-8",
                // dataType: "json",
                // cache: false,
                // success: function(response){
                  // if(response.success==1){
                    // $.each(response.data, function(i, object){
                     // option+='<option value="'+object.id+'" data-series="'+object.productSeries+'" data-mrp="'+object.productMrp+'">('+object.productSeries+') '+ object.productName+'</option>';
                    // });
                  // }
                  // selectBox.html(option);
                // }, error: function(error, xhr){
                   // alert(xhr);
                // }
            // });

        // } else {
            // selectBox.html(option);
        // }
    // });
    function initmonthlywelcome()
    {
       // alert($('#filterCategoryforweekchart :selected').val());
        var dataString = {
            year: $('#filterYear4 :selected').val(),
            plantId: $('#plant_week :selected').val(),
            month: $('#month4 :selected').val(),
           
           // companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerTypeweekchart :selected').val(),
            categoryId: $('#filterCategoryforweekchart :selected').val(),
           
           
        }
//console.log(dataString);
        $.ajax({
            type: "POST",
            url: API_URL + '/report/monthlyscanTrendModuleByCategory',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
             //   hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                  //  alert('here')
                     $("#chart7").html('');
                    couponcount7 = response.couponcount;
                    usercount7 = response.usercount;
                    // console.log(couponcount);
                    // console.log(usercount)
                    chart7();
                   
                } else {
                    noResult();
                }
            },
            complete: function(response) {
              //  hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });



    }
    function initmonthlywelcomechart8()
    {
       // alert($('#filterCategoryforweekchart :selected').val());
        var dataString = {
            year: $('#filterYear5 :selected').val(),
            plantId: $('#plant_week5 :selected').val(),
            month: $('#month5 :selected').val(),
           
           // companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerTypeweekchart5 :selected').val(),
            categoryId: $('#filterCategoryforweekchart5 :selected').val(),
           
           
        }
//console.log(dataString);
        $.ajax({
            type: "POST",
            url: API_URL + '/report/monthlyscanTrendModuleByCategory',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
               // hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                  //  alert('here')
                     $("#chart8").html('');
                    couponcount8 = response.couponcount;
                    usercount8 = response.usercount;
                    // console.log(couponcount);
                    // console.log(usercount)
                    chart8();
                   
                } else {
                    noResult();
                }
            },
            complete: function(response) {
              //  hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });



    }
    function initwelcome()
    {
       // alert($('#filterCategoryforweekchart :selected').val());
        var dataString = {
            year: $('#filterYear4 :selected').val(),
           plantId: $('#plant_week :selected').val(),
            month: $('#month4 :selected').val(),
           
           // companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerTypeweekchart :selected').val(),
            categoryId: $('#filterCategoryforweekchart :selected').val(),
           
           
        }
//console.log(dataString);
        $.ajax({
            type: "POST",
            url: API_URL + '/report/WelcomescanTrendModuleByCategory',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
             //   hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {

                    
                    //alert('here')
                    $("#chart4").html('');
                    couponcount = response.couponcount;
                    usercount = response.usercount;
                    console.log(couponcount);
                    console.log(usercount)
                    chart4();
                   
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
    function initwelcomechart5()
    {
       // alert($('#filterCategoryforweekchart :selected').val());
        var dataString = {
            year: $('#filterYear5 :selected').val(),
            plantId: $('#plant_week5 :selected').val(),
            month: $('#month5 :selected').val(),
           
           // companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerTypeweekchart5 :selected').val(),
            categoryId: $('#filterCategoryforweekchart5 :selected').val(),
           
           
        }
//console.log(dataString);
        $.ajax({
            type: "POST",
            url: API_URL + '/report/WelcomescanTrendModuleByCategory',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    //alert('here')
                    $("#chart5").html('');
                    couponcount5 = response.couponcount;
                    usercount5 = response.usercount;
                    console.log(couponcount5);
                    console.log(usercount5)
                    chart5();
                   
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
    // function initwelcomechart6()
    // {
     //  alert($('#filterCategoryforweekchart :selected').val());
        // var dataString = {
            // year: $('#filterYear6 :selected').val(),
            // plantId: $('#plant_week5 :selected').val(),
            // month: $('#month6 :selected').val(),
           
         //  companyId: $('#group :selected').val(),         
            // customerType: $('#filterCustomerTypeweekchart6 :selected').val(),
            // categoryId: $('#filterCategoryforweekchart6 :selected').val(),
           
           
        // }
//console.log(dataString);
        // $.ajax({
            // type: "POST",
            // url: API_URL + '/report/WelcomescanTrendModuleByCategory',
            // data: JSON.stringify(dataString),
            // contentType: "application/json; charset=utf-8",
            // dataType: "json",
            // cache: false,
            // beforeSend: function() {
                // hidePageLoader();
            // },
            // success: function(response) {
                // if (response.success == 1) {
                  //  alert('here')
                    // $("#chart6").html('');
                    // couponcount6 = response.couponcount;
                    // usercount6 = response.usercount;
                    // console.log(couponcount);
                    // console.log(usercount)
                    // chart5();
                   
                // } else {
                    // noResult();
                // }
            // },
            // complete: function(response) {
                // hidePageLoader();
            // },
            // error: function(xhr, status, error) {
                // console.log(xhr.responseText);
                // showResponseErrorMsg("Server was unable to process request");
            // }
        // });



    // }
        
    function initPlant_week(selectBox, defaultLabel){
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
                        if(object.plant_id==3)
                        {
                      plantOption +='<option value="'+object.plant_id+'" selected>' +object.plant_name+'</option>';
                      var dataString = {
                        plantId:object.plant_id
                    }
                 
                    
                    }
                        else{

                            plantOption +='<option value="'+object.plant_id+'">' +object.plant_name+'</option>';
                        
                        }
                    });
                    selectPlantBox.html(plantOption);
                       // load the main cat dropdown
                 var selectMainCatBox = $('#filterCategoryforweekchart');
                 var mainCatOption = '<option value="">Select</option>';
                 var dataString = {
                    plantId:3
                }
                 
                 //showPageLoader();
                 
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
                                 if(object.id==16)
                                 {
                                     mainCatOption +='<option value="'+object.id+'" selected>' +object.category_name+'</option>';
                             
                                 }
                                 else{
                               mainCatOption +='<option value="'+object.id+'">' +object.category_name+'</option>';
                             
                             }

                             });
                           }
                           selectMainCatBox.html(mainCatOption);
                           initmonthlywelcome();
                           initwelcome();
                           
                         //  hidePageLoader();
                         
                     }, 
                     error: function(error, xhr){
                       //  hidePageLoader();
                         console.log(xhr);
                     }
                 }); 
             
             
                  }
                  
                
               
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }
	function initPlant_week5(selectBox, defaultLabel){
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
                    if(object.plant_id==3)
                    {
                  plantOption +='<option value="'+object.plant_id+'" selected>' +object.plant_name+'</option>';
                  
                
                }
                    else{

                        plantOption +='<option value="'+object.plant_id+'">' +object.plant_name+'</option>';
                    
                    }
                });
                selectPlantBox.html(plantOption);
                // load the main cat dropdown
          var selectMainCatBox = $('#filterCategoryforweekchart5');
          var mainCatOption = '<option value="">Select</option>';
          var dataString = {
             plantId:3
         }
          
          //showPageLoader();
          
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
                          if(object.id==17)
                          {
                              mainCatOption +='<option value="'+object.id+'" selected>' +object.category_name+'</option>';
                      
                          }
                          else{
                        mainCatOption +='<option value="'+object.id+'">' +object.category_name+'</option>';
                      
                      }

                      });
                    }
                    selectMainCatBox.html(mainCatOption);
                    initwelcomechart5();
                    initmonthlywelcomechart8();
                    
                  //  hidePageLoader();
                  
              }, 
              error: function(error, xhr){
                //  hidePageLoader();
                  console.log(xhr);
              }
          }); 
                
                  }
              
            }, error: function(error, xhr){
               alert(xhr);
            }
        });
    }
	// function initPlant_week6(selectBox, defaultLabel){
        // var selectPlantBox = $(selectBox);
        // var plantOption = '<option value="">'+defaultLabel+'</option>';
        // $.ajax({  
            // type: "GET",  
            // url: API_URL+'/plant/getPlantList', 
            // data: '',
            // dataType: "json",
            // cache: false,
            // success: function(response){
               // if(response.success==1){
                // $.each(response.data, function(i, object){
                    // if(object.plant_id==3)
                    // {
                  // plantOption +='<option value="'+object.plant_id+'" selected>' +object.plant_name+'</option>';
                  // var dataString = {
                    // plantId:object.plant_id
                // }
            
                 //load the main cat dropdown
                // var selectMainCatBox = $('#filterCategoryforweekchart6');
                // var mainCatOption = '<option value="">Select</option>';
                
               // showPageLoader();
                
                    // $.ajax({  
                    // type: "POST",  
                    // url: API_URL+'/plant/getPlantsMainCategory',      
                    // contentType: "application/json; charset=utf-8",
                    // data: JSON.stringify(dataString),
                    // dataType: "json",
                    // cache: false,
                    // success: function(response){
                        // if(response.success==1){
                            // console.log(response.data);
                            // $.each(response.data, function(i, object){
                                // if(object.id==16)
                                // {
                                    // mainCatOption +='<option value="'+object.id+'" selected>' +object.category_name+'</option>';
                            
                                // }
                                // else{
                              // mainCatOption +='<option value="'+object.id+'">' +object.category_name+'</option>';
                            
                            // }
                            // });
                          // }
                          // selectMainCatBox.html(mainCatOption);
                          
                          // hidePageLoader();
                        
                    // }, 
                    // error: function(error, xhr){
                        // hidePageLoader();
                        // console.log(xhr);
                    // }
                // });  
                
                // }
                    // else{

                        // plantOption +='<option value="'+object.plant_id+'">' +object.plant_name+'</option>';
                    
                    // }
                // });
                  // }
              // selectPlantBox.html(plantOption);
            // }, error: function(error, xhr){
               // alert(xhr);
            // }
        // });
    // }
    
    
 


    function initData(dataArray) {
        var dataResult = $('#dataTableResult');
        var r = '';
        $.each(dataArray, function(i, object) {
            r += '<div class="tr meta">';
            r += '<div class="td inlineText">' + object.dealerCode + '</div>';
            r += '<div class="td inlineText">' + object.name + '</div>';
            r += '<div class="td inlineText">' + object.mobile + '</div>';
            r += '<div class="td inlineText">' + object.type + '</div>';
            r += '<div class="td inlineText">' + object.beat + '</div>';
            $.each(object.meta, function(i, meta) {
                r += '<div class="td">';
              
             /*   if(i%2 == 0)	
                {	
                    var greys= "lightgrey";	
                    	
                } else {	
                    var greys= "";	
                }	
                */
                var greys= "";	
                r += '<span style="background:'+greys+'">'+meta.num +'</span><span style="background:'+greys+'">'+meta.point +'</span>';
              
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
	 function monthlypointsummery()
    {
       // alert($('#filterCategoryforweekchart :selected').val());
        var dataString = {
            year: $('#filterYear6 :selected').val(),
           // plantId: $('#plant_week :selected').val(),
            month: $('#month6 :selected').val(),
           
           // companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerType6 :selected').val(),
           // categoryId: $('#filterCategoryforweekchart :selected').val(),
           
           
        }
//console.log(dataString);
        $.ajax({
            type: "POST",
            url: API_URL + '/point/monthlypointsSummary',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $("#chart9").html('');
            },
            success: function(response) {
                if (response.success == 1) {
					console.log(response);
                  //  alert('here')
                     $("#chart9").html('');
                    couponcount9 = response.couponcount;
                    usercount9 = response.usercount;
                    totaluser9 = response.totaluser;
                    // console.log(couponcount);
                    // console.log(usercount)
                    chart9();
                   
                } else {
                    noResult();
                }
            },
            complete: function(response) {
              //  hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });



    }
	function pointsummery()
    {
       // alert($('#filterCategoryforweekchart :selected').val());
        var dataString = {
            year: $('#filterYear6 :selected').val(),
          
            month: $('#month6 :selected').val(),
           
           // companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerType6 :selected').val(),
           
           
           
        }
//console.log(dataString);
        $.ajax({
            type: "POST",
            url: API_URL + '/point/WelcomepointsSummary',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
             //   hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    //alert('here')
                      $("#chart10").html('');
                      couponcount6 = response.couponcount;
                      usercount6 = response.usercount;
                      totaluser6 = response.totaluser;
                    // console.log(couponcount);
                    // console.log(usercount)
                      chart10();
                   
                } else {
                    noResult();
                }
            },
            complete: function(response) {
            //    hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });



    }

    // function initPagination(response, dataString) {
    //     if ($('.simple-pagination').length) {
    //         $('#dataPagination').pagination('destroy');
    //     }

    //     if (response.total > dataString.limit) {
    //         $('#dataPagination').pagination({
    //             items: response.total,
    //             itemsOnPage: dataString.limit,
    //             currentPage: dataString.page,
    //             cssStyle: 'light-theme',
    //             onPageClick: function(pageNumber, event) {
    //                 $('#datatable').data('page', pageNumber);
    //                 $("html, body").animate({
    //                     scrollTop: 0
    //                 }, "fast");
    //                 initSearchResult();
    //             },
    //         });
    //     }
    // }

    $('#chartsearch4').click(function(){


        initwelcome();
        initmonthlywelcome()


    });
	 $('#chartsearch6').click(function(){

	pointsummery();
	monthlypointsummery();
	 
	 });
    $('#chartsearch5').click(function(){


        initwelcomechart5();
        initmonthlywelcomechart8()


    });
    $('#getSearchResult_week').click(function(){

        $('#datatable').data('page', 1);

        var dataString = {
            year: $('#filterYear :selected').val(),
            plantId: $('#plant_week :selected').val(),
            divisionId: $('#divisionunit :selected').val(),
            companyId: $('#group :selected').val(),         
            customerType: $('#filterCustomerTypeweekchart :selected').val(),
            categoryId: $('#filterCategoryforweekchart :selected').val(),
            subCategoryId: $('#filterSubCategory :selected').val(),
            productId: $('#filterProduct :selected').val(),
            state: $('#filterState :selected').val(),
            city: $('#filterCity :selected').val(),
            limit: $('#datatable').data('limit'),
            page: $('#datatable').data('page')
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/scanTrendCustomer',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
             //   hidePageLoader();
            },
            success: function(response) {
                if (response.success == 1) {
                    initData(response.data);
                } else {
                    noResult();
                }
            },
            complete: function(response) {
              //  hidePageLoader();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });
    });

   
    
    
    

})(jQuery);