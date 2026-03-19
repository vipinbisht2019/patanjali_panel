function showPageLoader(){
    $(".preloader").show();
}

function hidePageLoader(){
    $(".preloader").fadeOut();
}

function initSearchLoader(){
    $(".preloader").show();
}

function hideSearchLoader(){
    $(".preloader").fadeOut();
}

function statusLable(status, type){
    return '<span class="statusLable '+type+'">'+status+'</span>';
}

function statusLableY(){
    return '<span class="statusY"><i class="mdi mdi-check"></i></span>';
}
function statusLableN(){
    return '<span class="statusN"><i class="mdi mdi-cross"></i></span>';
}



function bodyFix(){
    $('html, body').css({'overflow-y':'hidden'});
}

function bodyUnFix(){
    $('html, body').css({'overflow-y':''});
}
function showOverlay(){
    $(".bodyOverlay").addClass('show');
}

function hideOverlay(){
    $(".bodyOverlay").removeClass('show');
}


function makeid(){
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";	
	for( var i=0; i < 10; i++ )
		text += possible.charAt(Math.floor(Math.random() * possible.length));	
	return text;
}

function showResponseErrorMsg(message){
    $.toast({
      heading: 'Error',
      text: message,
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#F1484E',
      position: 'top-right'
    });
}

function showResponseSuccessMsg(message){
    $.toast({
      heading: 'Success',
      text: message,
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: 'rgba(0,0,0,.3)', //#13DD77
      position: 'botom-right'
    });
}

function showResponceMsg(target, msg, type){
	var selctor = target;
	selctor.removeClass('success error');
	selctor.html(msg);
	selctor.addClass(type);
}

// var AjaxRequest.prototype.response = function() {
//     return this.response;
// }

// var AjaxRequest.prototype.send = function(url, dataString){

//     $.ajax({
//         type: "POST",
//         url: url,
//         data: JSON.stringify(dataString),
//         contentType: "application/json; charset=utf-8",
//         dataType: "json",
//         cache: false,
//         beforeSend: function() {
//             hidePageLoader();
//         },
//         success: function(response) {
//             this.response = response;
//         },
//         complete: function(response) {
//             hidePageLoader();
//         },
//         error: function(xhr, status, error) {
//           console.log(xhr.responseText);
//           showResponseErrorMsg("Server was unable to process request");
//         }
//     });
// }



function validateForm(form){
  var error = 0;

  form.find('.validate').each(function(){
	var input = $(this);
	error+=validateField(input);								   
  });

  if(error > 0){ 
	 return false;
  } else {
	 return true;
  }
} // end validation

function validateField(input){
	//var input = $(this);

	if(input.is("select")){
		var val = input.find('option:selected').val();
	} else {
		var val = input.val();
	}
	
	var validationType = null;

	if(input.attr('data-validate')){
	    validationType = input.attr('data-validate');
	}

	//var errorAfertThis = input.attr('data-validate-id');
	var errorMsg = input.data('msg');
	var error = 0;
	var msg='Required field.';
	var filterEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var filterMobile = /^[789]\d{9}$/;
	
		if(val.length == 0){
			error=1;
		} 
		
		if(validationType=='email'){
			if(!filterEmail.test(val) ){
				msg='Please enter valid email address!';
				error=1;
			}
		}

		if(validationType=='mobile'){
			if(!filterMobile.test(val) ){
				msg='Please enter valid mobile number!';
				error=1;
			}
		}
		
		if(validationType=='cp'){
			var target_pass = input.attr('target-pass');
			var cpass = $('#'+target_pass).val();
			if( val!=cpass){
				msg='Password does not match the confirm password';
				error=1;
			}
		}
		//percentage
		if(validationType=='percentage'){
			if( val>100){
				msg='Invalide percentage value.';
				error=1;
			}
		}
		
		
		if(error==1){
			if(! input.hasClass("error")){	
			  if(errorMsg!=''){ msg=errorMsg; } 
			  input.addClass('error');
			  input.after('<span class="error">'+msg+'</span>');
			  input.closest('div').addClass('error');
			}
			
		} else {
			input.removeClass('error');
			input.next("span.error").remove();
			input.closest('div').removeClass('error');
		}
		
		return error;
}

function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {

    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    var CSV = '';    
    if (ShowLabel) {
        var row = "";
        for (var index in arrData[0]) {
            row += index + ',';
        }
        row = row.slice(0, -1);
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }
        row.slice(0, row.length - 1);
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "";
    fileName += ReportTitle.replace(/ /g,"_");   
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    var link = document.createElement("a");    
    link.href = uri;
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function initializeSession(){
    if(!(localStorage.getItem('session')) || localStorage.getItem('session')===false){
        window.location.href=APP_URL+'/login';
        return false;
    } else {
        var session = JSON.parse(localStorage.getItem('session'));
        $('.nav-profile-name').html(session.name);
        hidePageLoader();
        return session;
    }
}

function initRootCategory(selectBox, defaultLabel){
    var selectBox = $(selectBox);
    var option = '<option value="">'+defaultLabel+'</option>';

        $.ajax({  
            type: "POST",  
            url: API_URL+'/list/category',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.id+'">'+object.categoryName+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               //alert(xhr);
            }
        });
}

function initSubCategory(selectBox, defaultLabel, mainCatId){
    var selectBox = $(selectBox);
    var option = '<option value="">'+defaultLabel+'</option>';

    if(mainCatId > 0){
        var dataString = {
            id:mainCatId
        }

        $.ajax({  
            type: "POST",  
            url: API_URL+'/list/subCategory',      
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.id+'">'+object.categoryName+'</option>';
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
}

function initCategoryProduct(selectBox, defaultLabel, catId){
    var selectBox = $(selectBox);
    var option = '<option value="">'+defaultLabel+'</option>';

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
                  option+='<option value="'+object.id+'">'+object.productName+' ('+object.productSeries+')</option>';
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
}

//initState
function initState(selectBox, defaultLabel){
    var selectBox = $(selectBox);
    var option = '<option value="">'+defaultLabel+'</option>';

        $.ajax({  
            type: "POST",  
            url: API_URL+'/list/state',      
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.stateCode+'">'+object.stateName+'</option>';
                });
              }
              selectBox.html(option);
            }, error: function(error, xhr){
               //alert(xhr);
            }
        });
}

function initCities(selectBox, defaultLabel, stateCode){
    var selectBox = $(selectBox);
    var option = '<option value="">'+defaultLabel+'</option>';

    if(stateCode > 0){
        var dataString = {
            stateCode:stateCode
        }

        $.ajax({  
            type: "POST",  
            url: API_URL+'/list/cities',      
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data, function(i, object){
                  option+='<option value="'+object.id+'">'+object.cityName+'</option>';
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
}

function initMultiOpt(sectionBox, streamBox, defaultLabel, classId){
    var sectionBox = $(sectionBox);
    var streamBox = $(streamBox);
    var sectionOption = (!sectionBox.prop('multiple')) ? '<option value="">'+defaultLabel+'</option>':'';
    var streamOption = (!streamBox.prop('multiple')) ? '<option value="">'+defaultLabel+'</option>':'';

    if(classId > 0){
        var dataString = {
            classId:classId
        }

        $.ajax({  
            type: "POST",  
            url: API_URL+'/ajax/getClassSectionStream',      
            data: JSON.stringify(dataString),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response){
              if(response.success==1){
                $.each(response.data.section, function(i, object){
                  sectionOption+='<option value="'+object.id+'">'+object.sectionName+'</option>';
                });
                $.each(response.data.stream, function(i, object){
                  streamOption+='<option value="'+object.id+'">'+object.streamName+'</option>';
                });
              }
              sectionBox.html(sectionOption);
              streamBox.html(streamOption);
              initMultiSelect(sectionBox);
              initMultiSelect(streamBox);
            }, error: function(error, xhr){
               alert(xhr);
            }
        });

    } else {
        sectionBox.html(sectionOption);
        streamBox.html(streamOption);
        initMultiSelect(sectionBox);
        initMultiSelect(streamBox);
    }
}


function checkNotifications() {
    setTimeout( function() {
        $.ajax({  
            type: "POST",  
            url: API_URL+'/getUnreadMessageCount',       
            data: '',
            dataType: "json",
            cache: false,
            success: function(response){
                if(response.count > 0){
                    $('.notifyyy .point').text(response.count);
                    $('.notifyyy').show();
                } else {
                    $('.notifyyy').hide();
                    $('.notifyyy .point').text(0);
                }
                checkNotifications();
            }
        });
    }, 30000);
}


$(document).ready(function(){ 

$(window).scroll(function(){
    if ($(window).scrollTop() >= 70) {
        $('body').addClass('topFix');
    }
    else {
        $('body').removeClass('topFix');
    }
});   

$('body').on('click','a.logout',function(event) {
    localStorage.removeItem('session');
    window.location.href=APP_URL+'/login';
    event.preventDefault();
    return false;
});

$('body').on('click','.alert .close',function(event) {
    $(this).closest('.alert').fadeOut().remove();
    event.preventDefault();
    return false;
});
	
$('body').on('click','a.disabled',function(event) {
    event.preventDefault();
	return false;
});

$('.table-flex').click(function(){
    if($('#filterPanel').length){
        var filterPanel = $('#filterPanel');
        if(filterPanel.hasClass('open')){
            filterPanel.removeClass('open');
        }
    }
});

$('.openFilterPanel').click(function(){
    var filterPanel = $('#filterPanel');
    if(filterPanel.hasClass('open')){
        $('#filterPanel').removeClass('open');
        bodyUnFix();
    } else {
        bodyFix();
        $('#filterPanel').addClass('open');      
    }
});

$('.filter-close').click(function(){
    $(this).closest('.filter-panel').removeClass('open');
    bodyUnFix();
});

$('.c-modal button.close').click(function(){
    $(this).closest('.c-modal').fadeOut('fast', function() {
        $(this).closest('.c-modal').removeClass('show');
        $(this).closest('.c-modal').stop().animate({'scrollTop': 0},100);
    });
});

if($('.notifyyy').length > 0){
    //checkNotifications();
}


/////////////////////// VALIDATION //////////////////////////

// alphabeticalcoma
$("body").on("keypress", "input.name", function (event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
});

// alphabeticalcoma
$("body").on("keypress", "input.abcs", function (event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[a-zA-Z, ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
});
  
// alphaNumeric   
$("body").on("keypress", "input.an", function (event) {
	  //alert('sagq');
	  if (event.charCode!=0) {
		  var regex = new RegExp("^[a-zA-Z0-9]+$");
		  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		  if (!regex.test(key)) {
			  event.preventDefault();
			  return false;
		  }
	  }
});

// alphabetical 
$("body").on("keypress", "input.ab", function (event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
});

$("body").on("keypress", "input.address", function (event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[a-zA-Z0-9,- ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
});

//numeric
$("body").on("keypress", "input.int", function (event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
});

//numeric
$("body").on("keypress", "input.decimal", function (event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[0-9.]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
});


// $('body').on('blur','.validate', function(){										  
// 	var input = $(this);
// 	validateField(input);						 
// });
//.datepicker({format:'dd/mm/yyyy'});
					   
						   
}); // END DOCUMENT READY


(function($){
    $.fn.serializeObject = function(){

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);