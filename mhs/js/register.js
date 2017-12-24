// JavaScript Document
$(document).ready(
	function (){ 
	 $('#renew').hide();
	 //$('#btnCheck').hover(function(){alert(1); }); 
	}
);
$('#MHSAAID').keyup(
function (){
	this.value=this.value.replace(/[^0-9\-]/g,'');
	var charcnt = this.value.length;
	if(charcnt > 3){ 
	$('#btnCheck').removeAttr('disabled'); }
		
});
$(':input').focus(
	function(){
		$(this).css('background-color', '#EE0000'); }
);
$(':input').blur(function(){
	$(this).css('background-color', '#FFF');
});
$("#phone, #mobile, #emergncyphone, #fax").keyup(function() {
	this.value = this.value.replace(/[^0-9\.\-\(\)]/g,'');
	var curchr = this.value.length;
	var curval = $(this).val();
	if (curchr == 3) {
		$(this).val( curval  + "-");
	} else if (curchr == 7) {
		$(this).val(curval + "-");
	}
});
$('#zipcode').keyup(function(){
	this.value=this.value.replace(/[^0-9\-]/g,'');
});
$("#phone, #mobile, #emergncyphone, #fax").dblclick(
	function(){
		this.focus(function() { $(this).select(); })
	}
);
$("#frmRegs").validate({
	rules: {
			MHSAAID: {required: true,
						minlength: 4
			},
			lname: "required",
			fname: "required",
			username: {
				required: true,
				minlength: 2
			},
			passwd: {
				required: true,
				minlength: 5
			},
			passwd2: {
				required: true,
				minlength: 5,
				equalTo: "#passwd"
			},
			email: {
				required: true,
				email: true
			},
			address: "required",
			city:"required",
			zipcode: {
				required: true,
				minlength: 5
			},
			secAnswer: "required"	
		},
		messages: {
			MHSAAID: {
				required: "please Enter a username",
				minlength: "Atleast 4 #"},
			fname: "Please enter your First Name",
			lname: "Please enter your Last Name",
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			passwd: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			passwd2: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: {
				required: "Please enter a valid email address",
				email: "Invalid Email format"
			},
			address: "Please provide an address",
			city: "Please provide a city",
			zipcode: {
				required: "Please enter 5 digit zipcode",
				minlength: "At least 5 digits"
			},
			secAnswer: "Please enter your answer to the security question"
		}
});
$('#passwd2').blur(
	function(){
		$('#btnReg').removeAttr('disabled');
	}
);
/*if($("#frmRegs").valid()){ $('#btnReg').removeAttr('disabled');}*/