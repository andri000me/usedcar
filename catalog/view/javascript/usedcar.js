 
// var imported = document.createElement("script");
// imported.src = "catalog/view/javascript/sweetalert.html.js";  //saved in "other js" folder
// document.getElementsByTagName("head")[0].appendChild(imported);


function opendetailcontact(title,prodid)
{
	$.ajax({
	  url: 'index.php?route=account/mpmultivendor/orders/getSellerInformation',
	  type: 'post',
	  dataType: 'json',
	  data: {Product:prodid}, 
	  success: function(json) { 
				// var htmlTemplate='<div class="panel panel-default">'+
				// '<div class="panel-heading">'+title+'</div> '+
				// '<div class="panel-body" style="margin-left: -13px;margin-right: -13px;"> '+
				// '    <a class="btn btn-block btn-social">'+
				// '        <i class="fa fa-shopping-bag"></i> ' + json["seller"].store_name +
				// '    </a>'+
				// '    <a class="btn btn-block btn-social">'+
				// '        <i class="fa fa-user"></i> ' + json["seller"].store_owner +
				// '    </a>'+
			   // // '    <a class="btn btn-block btn-social">'+
				// //'        <i class="fa fa-building"></i> ' + json["seller"].city +
				// //'    </a> '+
				// '    <a href="javascript:onCallPhone(\''+json["seller"].telephone+'\')" class="btn btn-block btn-social">'+
				// '        <i class="fa fa-phone"></i> ' + json["seller"].telephone +
				// '    </a>';
				
				// if ((json["seller"].fax!=undefined)&&(json["seller"].fax.length>0))  htmlTemplate+='<a href="javascript:onCallWA(\''+json["seller"].fax+'\', \''+json["seller"].store_owner+'\', \'Nomor whatsapp tidak valid\');" class="btn btn-block btn-social"><i class="fa fa-whatsapp"></i> ' + json["seller"].fax +'</a>';
				// htmlTemplate+='<a href="javascript:onCallMail(\''+json["seller"].email+'\')" class="btn btn-block btn-social"><i class="fa fa-envelope"></i> ' + json["seller"].email +'</a>'; 
				// htmlTemplate+='</div></div>'; 
				// swal({
				  // title: "",
				  // html:htmlTemplate, 
				   // icon: "info",  
				   // buttons: {
					 // cancel: "OK"
				   // },
				   // dangerMode: true,
				  // });
				$("#exampleModalLabel").html(title);
				var htmlTemplate='<div class="">'+  
				'    <a class="btn btn-block btn-social">'+
				'        <i class="fa fa-shopping-bag"></i> ' + json["seller"].store_name +
				'    </a>'+
				'    <a class="btn btn-block btn-social">'+
				'        <i class="fa fa-user"></i> ' + json["seller"].store_owner +
				'    </a>'+ 
				'    <a href="javascript:onCallPhone(\''+json["seller"].telephone+'\')" class="btn btn-block btn-social">'+
				'        <i class="fa fa-phone"></i> ' + json["seller"].telephone +
				'    </a>';
				
				if ((json["seller"].fax!=undefined)&&(json["seller"].fax.length>0))  htmlTemplate+='<a href="javascript:onCallWA(\''+json["seller"].fax+'\', \''+json["seller"].store_owner+'\', \'Nomor whatsapp tidak valid\');" class="btn btn-block btn-social"><i class="fa fa-whatsapp"></i> ' + json["seller"].fax +'</a>';
				htmlTemplate+='<a href="javascript:onCallMail(\''+json["seller"].email+'\')" class="btn btn-block btn-social"><i class="fa fa-envelope"></i> ' + json["seller"].email +'</a>'; 
				htmlTemplate+='</div>'; 
				$("#divdetailcontact").html(htmlTemplate);
				$("#modalInformation").modal();
	  },
	  error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	  }
	});
}
 
function onCallWA(phone, name, messagenotvalid)
{
	var count = phone.length;
    var res1 = phone.substring(0, 1);
	var res2 = phone.substring(0, 2);
	var res3 = phone.substring(0, 3);
  
  
	if(res1=="0")
	{
		phone="62"+phone.substring(1,count);
	}
	else if(res2=="62")
	{
		phone=phone;
	}
	else if(res3=="+62")
	{
		phone="62"+phone.substring(3,count);
	}
	else
	{
		alert(messagenotvalid+" " + phone);
		return;
	} 
	
	window.location.href="https://api.whatsapp.com/send?phone="+phone+"&text=Halo%20"+name+"%20saya%20melihat%20mobil%20bekas%20Anda%20dari%20Garda%20Mall%20jual%20beli%20mobil%20bekas";
}
function  onCallPhone(phone)
{   
	window.location.href="tel://"+ phone;
}
function  onCallMail(mail)
{   
	window.location.href="mailto:"+ mail;
}
 
function isNumber(evt) {
	var iKeyCode = (evt.which) ? evt.which : evt.keyCode; 
	if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
	{
		return false;
	}
	if(iKeyCode==46) return false;
	return true;
}  

function isChar(evt) {
	var iKeyCode = (evt.which) ? evt.which : evt.keyCode;  
	if ((iKeyCode >=65 && iKeyCode <= 90) ||(iKeyCode >=97 && iKeyCode <= 122)||(iKeyCode == 8)||(iKeyCode == 9)||(iKeyCode == 32))
		return true;
	else 
		return false; 
} 

function isCharNumber(evt) {
	
	 if((!isChar(evt))&& (!isNumber(evt)))
	 {
		 return false
	 }
	 else
	 {
		 return true;
	 }
}

function Alphanumeric(selector) {
	var pattern = /^[A-Za-z]*$/;
	var matches = pattern.exec(selector.context.value);

	if(matches == null || matches == undefined || matches == '')
	{
		var replace = selector.context.value.replace(/[\W_0-9]/g, "")
		selector.val(replace);
	}
}

function numberOnly(selector) {
	var pattern = /^[0-9]*$/;
	var matches = pattern.exec(selector.context.value);

	if(matches == null || matches == undefined || matches == '')
	{
		var replace = selector.context.value.replace(/[\W_A-Za-z]/g, "")
		selector.val(replace);
	}
}

function onGetCity(t, useselect, idcity)
{  
	$("#txtpropinsi").val($(t).val());
	$.ajax({
		url: 'index.php?route=account/mpmultivendor/product/getCityDetail',
		dataType: 'json', 
		data:{country:100,propinsi:$(t).val()},
		success: function(json) { 
			html = '<option value="">Semua kota</option>'; 
			if (json.result) {
				for (i = 0; i < json.result.length; i++) {
					html += '<option value="' + json.result[i].city_id + '"';
					
					if (json.result[i].city_id == useselect) {
						html += ' selected="selected"';
						//$("#input-location").val(useselect);
					}
					
					html += '>' + json.result[i].type + " "+json.result[i].name + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected">{{ text_none }}</option>';
			}
			
			$('#'+idcity).html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	}); 
}

function onchangeCity(t)
{  
	var city = ($('select[name=location_propinsi] option:selected').text() + ' - '+ $('select[name=location_city] option:selected').text());
 
	$("#txtcity").val($(t).val());
	$("#input-location").val(city);
	
}

function getPropinsi(txtselect, usepropinsi,usecity, idpropinsi,idcity)
{ 
	$.ajax({
		url: 'index.php?route=account/account/country&country_id=100',
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').prop('disabled', true);
		},
		complete: function() {
			$('select[name=\'country_id\']').prop('disabled', false);
		},
		success: function(json) {
			// if (json['postcode_required'] == '1') {
				// $('input[name=\'postcode\']').parent().parent().addClass('required');
			// } else {
				// $('input[name=\'postcode\']').parent().parent().removeClass('required');
			// }
			
			html = '<option value="">'+txtselect+'</option>';
			
			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';
					
					if (json['zone'][i]['zone_id'] == usepropinsi) {
						html += ' selected="selected"';
						$("#txtpropinsi").val(usepropinsi);
					}
					
					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected">{{ text_none }}</option>';
			}
			
			$('#'+idpropinsi).html(html); 
			if((usepropinsi!=null)&&(usepropinsi!='')&&(usepropinsi!=undefined)) onGetCity($('#'+idpropinsi),usecity,idcity);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function getManufacture(useselect,idmanufacture,txtselect)
{ 
	$.ajax({
			url: 'index.php?route=account/mpmultivendor/product/getmanufacturer',
			dataType: 'json',
			success: function(json) {
				 html = '<option value="">'+txtselect+'</option>';
			
				if (json.length>0) {
					for (i = 0; i < json.length; i++) {
						html += '<option value="' + json[i].manufacturer_id + '"';
						
						if (json[i].manufacturer_id == useselect) {
							html += ' selected="selected"'; 
						}
						
						html += '>' + json[i].name + '</option>';
					}
				} else {
					html += '<option value="0" selected="selected">{{ text_none }}</option>';
				} 
				$('#'+idmanufacture).html(html); 
			}
		});
}

function unformatnumber(idformat)
{ 
	var number=$("#" + idformat).val();
	$("#" + idformat).val(number.replace(/,/g, ""));
}
function formatNumber(idformat, idnonformat)
{
	var number=$("#"+idformat).val();
	if(!isNaN(number))  
	{ 
		$.ajax({
		url: 'index.php?route=account/mpmultivendor/product/numberformat',
		dataType: 'json',
		type: 'post', 
		data:{
			nominal:number
		},
		beforeSend: function() {
		  $('.btn.btn-primary').button('loading');
		},
		complete: function() {
		  $('.btn.btn-primary').button('reset'); 
		},
		success: function(json) {  
			$("#"+idformat).val(json['data']['formating']);
			$("#"+idnonformat).val(json['data']['nonformat']); 
		},
		error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
	else
	{
		$("#" + idnonformat).val($("#" + idformat).val());	
	}
	
}

$(document).ready(function(){
	var onload = window.onload;
    window.onload = function () {
        if (typeof onload == "function") {
            onload.apply(this, arguments);
        }

        var fields = [];
        var inputs = document.getElementsByTagName("input");
        var textareas = document.getElementsByTagName("textarea");

        for (var i = 0; i < inputs.length; i++) {
            fields.push(inputs[i]);
        }

        for (var i = 0; i < textareas.length; i++) {
            fields.push(textareas[i]);
        }

        for (var i = 0; i < fields.length; i++) {
            var field = fields[i];
            if (typeof field.onpaste != "function" && !!field.getAttribute("onpaste")) {
                field.onpaste = eval("(function () { " + field.getAttribute("onpaste") + " })");
            }
            if (typeof field.onpaste == "function") {
                var oninput = field.oninput;
                field.oninput = function () {
                    if (typeof oninput == "function") {
                        oninput.apply(this, arguments);
                    }
                    if (typeof this.previousValue == "undefined") {
                        this.previousValue = this.value;
                    }
                    var pasted = (Math.abs(this.previousValue.length - this.value.length) > 1 && this.value != "");
                    if (pasted && !this.onpaste.apply(this, arguments)) {
                        this.value = this.previousValue;
                    }
                    this.previousValue = this.value;
                };

                if (field.addEventListener) {
                    field.addEventListener("input", field.oninput, false);
                } else if (field.attachEvent) {
                    field.attachEvent("oninput", field.oninput);
                }
            }
        }
    }
});