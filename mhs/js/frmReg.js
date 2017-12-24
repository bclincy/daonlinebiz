$("#offRegister").validate({
		rules: {
			MHSAAID:{ required: true,
					  minlength: 4},	
			fname: "required",
			lname: "required",
			email: {
				required: true,
				email: true},
			address: "required",
			city: "required",
			zipcode: {
				required: true,
				minlength: 5
			},password: {
				required: true,
				minlength: 6
			},
			password2: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			},
		messages: {
			MHSAAID:{ required: "MHSAA ID is required",
					  minlenght: "At Least 4 characters" },
			fname:{ required: "First Name is required"},
			lname:{ required: "Need a Last Name"},
			email:{ required: 'Email Address Please',
					email: 'Please Enter a Valid Email'},
			address:{ required: 'Please Enter an Address'},
			city:{required: 'Enter your city'},
			zipcode:{required: 'Enter a zipcode',
					minlength: 'Zipcode is atleast 5 numbers'},
			password:{ required: 'Please Enter a password',
					   minlenght: 'Password has to be at least 6 characters'},
			password2:{ required:'Please Confirm Password',
						minlength:'Need atleast 6 characters',
						equalTo: 'Passwords don\'t Match'}		 
		}
	}
});
$("#regOff").validate({
		rules: {
			MHSAAID:{ required: true,
					  minlength: 4},	
			fname: {required: true },
			lname: {required: true},
			email: {
				required: true,
				email: true},
			address: "required",
			city: "required",
			zipcode:{
				required: true,
				minlength: 5
			},
		messages: {
			fname: "Enter your First Name",
			lname: "Enter your Last Name",
			MHSAAID: { required: "MHSAA # is Required",
					 minlength:jQuery.format("Enter at least {0} characters")},
			address: "Address is Required",
			city: "City is Required Field",
			zipcode: {
				required:"Zipcode is Required",
				number: "Only numbers"
			},	 
		}
	}
});
$(document).ready(
	function (){
		  $("#saveOfficial").attr("disabled", "disabled");
	$('#carrier').click(
		function(){
		$('#mobileinfo').slideToggle();
		});//end click function
	}//end function
);
$(':input').focus(
	function(){
		$(this).css('background-color', '#EE0000'); }
);
$(':input').blur(function(){
	$(this).css('background-color', '#FFF');
});
$("#phone, #mobile, #emergncyphone, #fax, #work").keyup(function() {
	this.value = this.value.replace(/[^0-9\.\-\(\)]/g,'');
	var curchr = this.value.length;
	var curval = $(this).val();
	if (curchr == 3) {
		$(this).val( curval  + "-");
	} else if (curchr == 7) {
		$(this).val(curval + "-");
	}
});
$('#zipcode, #MHSAAID').keyup(function(){
	this.value=this.value.replace(/[^0-9\-]/g,'');
});
$("#phone, #mobile, #emergncyphone, #fax, #work").dblclick(
	function(){
		this.focus(function() { $(this).select(); })
	}
);
$("#updateprofile").validate({
		rules: {
			MHSAAID:{ required: true,
					  minlength: 4},	
			fname: "required",
			lname: "required",
			email: {
				required: true,
				email: true},
			address: "required",
			city: "required",
			zipcode: {
				required: true,
				minlength: 5,
				number: true
			},	
		messages: {
			MHSAAID:{ required: "MHSAA ID is required",
					  minlenght: "At Least 4 characters" },
			fname:"First Name is required",
			lname:"Need a Last Name",
			email:{ required: 'Email Address Please',
					email: 'Please Enter a Valid Email'},
			address:'Please Enter an Address',
			city: 'Enter your city',
			zipcode:{required: 'Enter a zipcode',
					minlength: 'Zipcode is atleast 5 numbers'},
			password:{ required: 'Please Enter a password',
					   minlenght: 'Password has to be at least 6 characters'},
			password2:{ required:'Please Confirm Password',
						minlength:'Need atleast 6 characters',
						equalTo: 'Passwords don\'t Match'}		 
		}
	}
});
/*Query.validator.addMethod("phoneValidate", function(number, element) {
    number = number.replace(/\s+/g, ""); 
    return this.optional(element) || number.length > 9 &&
        number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");*/
$("regOffi").validate({
  rules: {
fname: {required: true  },
	lname: {required: true },
	MHSAAID: {required: true, minlength: 4, number: true},
	email: { required: true,
			 email: true},
	address: { required: true },
	city: {require: true},
	zipcode:{required: true, number:true}
  },//End Rules
  messages: {
			fname: "Enter your First Name",
			lname: "Enter your Last Name",
			MHSAAID: { required: "MHSAA # is Required",
					 minlength:jQuery.format("Enter at least {0} characters"),
					 number: "Only Numbers"},
			address: "Address is Required",
			city: "City is Required Field",
			zipcode: {
				required:"Zipcode is Required",
				number: "Only numbers"
			},
/*			username: {
				required: "Enter a username",
				minlength: jQuery.format("Enter at least {0} characters"),
				//remote: jQuery.format("{0} is already in use")
			},
			password: {
				required: "Provide a password",
				rangelength: jQuery.format("Enter at least {0} characters")
			},
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			},*/
			email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address",
				//remote: jQuery.format("{0} is already in use")
			}
  }//end message
});

/*
$('#MSHAAID').blur(
	function(){ alert(1);}
);
$('lname').blur(function(){ alert(1);} ); 
$('#email').blur(function (){
	$.post("registprocessing.php",{ checkusr: $('#email').val(), time: "2pm" }, function(data) {
     if(data=='false'){
		 if($("#emailalready").length<1){
			
			 $(".email").show('slow').append("<span id=\"emailalready\">Login Email Already Exists <a href=\"../signin.php\">Sign in</a></span>");
		 }//Only show if it's not shown already
		 else{$("#emailalready").show(); }
	 }
	 else{ $("#emailalready").css('background-color', '#FFF').remove(); } 
 });//POST end
});

$('#frmPinfo').submit(function (){
 var noerror=true;
 $(this).find(".req").each(function (){
	var r = $(this);
	 if(r.attr("name")){
		 if(!r.val()){
			$("#"+r.attr("name")).css("background-color",'#F00').css('font-weight', 'bold');
			noerror=false;
		 }//end if
		 else{
			 $("#"+r.attr("name")).css("background-color",'FFF');
		 }
	 }
 }//end each 
 );
 if(!$("#frmPinfo").valid()){ noerror=$("#frmPinfo").valid(); }
if(noerror){
	$.post("registprocessing.php",{ checkusr: $('#email').val() }, function(data) {
     //Only show if it's not shown already
	 noerror=data; 
 });//POST end
return noerror; 
}
	/*
	$.post("registprocessing.php", $("#frmPinfo").serialize(), function(output){	
		if(output==0){
			$('.error').replaceWith('<div class="error"><h2>Email Exists already!</h2><p><a href="../signin.php">Sign In</a></p></div>');
		}
		else if(output==44){
			$('.error').replaceWith('<div class="error"><h2>Are You Human?</h2><p>Something is not right about the data you submited we entered </p></div>');
		}
		else if(output==1){
			$('.error').replaceWith('<div class="error"><h2>Passwords don\'t Match</h2><p>Something is not right about the data you submited we entered </p></div>');
		}
		else{ alert(output);
			return false;
		}//show
		});
}
 return false;
 
  
}); 
$("#phone, #mobile, #emergncyphone").keyup(function() {
	this.value = this.value.replace(/[^0-9\.\-\(\)]/g,'');
	var curchr = this.value.length;
	var curval = $(this).val();
	if (curchr == 3) {
		$(this).val("(" + curval + ")" + "-");
	} else if (curchr == 9) {
		$(this).val(curval + "-");
	}
});
$('#dob').keyup(function(){
	this.value = this.value.replace(/[^0-9\.\/]/g,'');
	var curchr = this.value.length;
	var curval = $(this).val();
	if(curchr==2){
		if(curval>12 ||curval<1){$(this).val(''); }
		else{ $(this).val(curval+'/');}
		
	}
	else if(curchr==3){
		var check=curval.split('/');
		if(check[1]>31 || check[1]<1){ check[1]='';}
		$(this).val(check[0]+'/'+check[1]+'/');
	}
	else if(curchr==5){
		var check=curval.split('/');
		if(check[2] > 2015 || check[2]<1930){check[2]='';}
		if(check[2] < 10){ check[2]= '20'+ check[2]; }
		$(this).val(check[0]+'/'+check[1]+'/'+check[2]);
	}
	
});
$('#zipcode', '#MHSAAID').keyup(function(){
	this.value=this.value.replace(/[^0-9\-]/g,'');
});
$('showargeement').click(function(){
	$('#agreement').slideToggle('slow');	
});

$('#fname,#lname').blur(function(){
	var capitalize=$(this).val();
	$(this).val(ucwords(capitalize)); 	
});
$("#frmPlayinfo").validate({
	rules: {
		fname: "required",
		lname: "required",
		school: "required",
		dob: {
    		 required: true,
    		date: true
    	},
		grade: "required",
		gender: "required",
		shortsizeid: "required",
		shirtsizeid: 'required',
		relationship: "required",
		
	},
	messages:{
		fname:{ required: "Name is required"},
		lname:{ required: "Need a Last Name"},
		school:{ required: 'Please enter a school'},
		dob:{
			required:'Date of Birth Required',
			date: 'Please enter a valid date'},
		grade:{ required: 'Please select a grade'},  	
	}
});
function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}
if($('#agree:checkbox:not(:checked)')){ $('#complete').attr('disabled', 'disabled'); }
	$('#agree:checkbox').click(
		function(){
			var agree=$('#agree').val();
			if($('#agree').is(':checked')){  $('#complete').removeAttr('disabled'); }
			else{ alert('You Must Agree to the Terms'); $('#complete').attr('disabled', 'disabled'); }
		}
);
$("#frmFinal").validate({
		rules: {
			emgencyCnt: "required",
			emergncyphone: "required",
			agree: "required"
	},
	messages:{
		emgencyCnt:{ required: "Emergency Contact Name is required"},
		emergncyphone:{ required: "Please enter a Valid Phone #"},
		agree:{ required: 'You have to Agree to the terms'}  	
	}
	
});	*/