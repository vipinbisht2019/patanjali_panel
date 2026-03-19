(function($) {
    'use strict';

	
    initPlant11('#plant11', 'All');
     searchBudget();

	/* budget_Charts();
		
	function budget_Charts()
		{

        $.ajax({
            type: "POST",
            url: API_URL + '/report/budgetChart',
        //    data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $("#budget_Chart").html('');
              //  hidePageLoader();
            },
        
        
            success: function(response) {
          
                $("#budget_Chart").html('');
		   
			   var total_points_created = response.data[0]['total_points_created'];
			   var total_points_scanned = response.data[0]['total_points_scanned'];
			   var total_points_transferred = response.data[0]['total_points_transferred'];
			   
			   
			budget_Charts1(total_points_created,total_points_scanned,total_points_transferred);
			
		
            },

            complete: function(response) {
           
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                showResponseErrorMsg("Server was unable to process request");
            }
        });

		//	budget_Charts1(11,22,33);
				
	}
    */
		
			
		
function budget_Charts1(total_points_created,total_points_scanned,total_points_transferred) {
		
var myChart = new Chart(document.getElementById("budget_Chart").getContext('2d'), {
	
	type: 'bar',
	data: {
		labels: ["Total point created", "Total point scanned", "Total point transferred"],
		datasets: [{
		//	label: 'Statistics',
			
			data: [total_points_created, total_points_scanned, total_points_transferred],
			borderWidth: 2,
		//	backgroundColor: '#6777ef',
		//	borderColor: '#6777ef',
		
			backgroundColor: [
          "#3e95cd",
          "#8e5ea2",
          "#3cba9f",
			],
			
		 borderColor: [
          "#3e95cd",
          "#8e5ea2",
          "#3cba9f",
			],
		
			borderWidth: 2.5,
			pointBackgroundColor: '#ffffff',
			pointRadius: 4
		}]
	},
	options: {
		legend: {
			display: false
		},
	/*	title: {
		display: true,
		text: "Predicted Profit in millions",
		},
	*/

		scales: {
			yAxes: [{
				gridLines: {
					drawBorder: false,
					color: '#f2f2f2',
				},
				ticks: {
					beginAtZero: true,
					stepSize: 0,
					fontColor: "#9aa0ac", // Font Color
				}
			}],
			xAxes: [{
				ticks: {
					display: false
				},
				gridLines: {
					display: false
				}
			}]
		},
	}
	
	});
	
	}
	
			
		
        //initRootCategory('#filterCategory', 'All');
       // initState('#filterState', 'All');
   // }
    
            // get Main category which assigned to plant
			
			
$('#plant11').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the main cat dropdown
        var selectMainCatBox = $('#filterCategory11');
        var mainCatOption = '<option value="">Select</option>';
        
       // showPageLoader();
        
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

        function initPlant11(selectBox, defaultLabel){
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
    
    // division list
$('#plant11').change(function() {
    var plantId = $(this).find(':selected').val();
    var dataString = {
            plantId:plantId
        }
    
         // load the plants dropdown
        var selectDivisionBox = $('#divisionunit11');
        var divisionOption = '<option value="">Select</option>';
        
        //showPageLoader();
        
            $.ajax({  
            type: "POST",  
            url: API_URL+'/division/getDivisionByPlant',      
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataString),
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.success==1){
                    $.each(response.data, function(i, object){
                      divisionOption +='<option value="'+object.unit_id+'">' +object.unit_name+'</option>';
                    });
                  }
                  selectDivisionBox.html(divisionOption);
                  
                //  hidePageLoader();
                
            }, 
            error: function(error, xhr){
              
			 // hidePageLoader();
                console.log(xhr);
            }
        });
 
    });

    
    $('#filterCategory11').change(function() {
        var catId = $(this).find(':selected').val();
        initSubCategory('#filterSubCategory11', 'All', catId);
    });
    
    $('#filterSubCategory11').change(function() {
        var catId = $(this).find(':selected').val();
        var selectBox = $('#filterProduct11');
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
                      option+='<option value="'+object.id+'" data-series="'+object.productSeries+'" data-mrp="'+object.productMrp+'">('+object.productSeries+') '+ object.productName+'</option>';
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

    
    function searchBudget()
    {
    //    alert('budget chart');

        var dataString = {
         //   year: $('#filterYear11 :selected').val(),
            plantId: $('#plant11 :selected').val(),
            divisionId: $('#divisionunit11 :selected').val(),
            categoryId: $('#filterCategory11 :selected').val(),
            subCategoryId: $('#filterSubCategory11 :selected').val(),
            productId: $('#filterProduct11 :selected').val(),            
            dates: $('#dates').val()
                
        }

        $.ajax({
            type: "POST",
            url: API_URL + '/report/budgetChart',
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $("#budget_Charts").html('');

              //  hidePageLoader();
            },
                
            success: function(response) {
                            
                $("#budget_Chart").html('');
               
               var total_points_created = response.data[0]['total_points_created'];
			   var total_points_scanned = response.data[0]['total_points_scanned'];
			   var total_points_transferred = response.data[0]['total_points_transferred'];
			   
			   
			budget_Charts1(total_points_created,total_points_scanned,total_points_transferred);
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
        

    $('#getSearchResult11').click(function(){
        searchBudget();

    });


})(jQuery);