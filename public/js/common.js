function userSignup(formId)
	{
		var ret = $('#'+formId).validationEngine('validate');
		if(ret)
		{
			$('#'+formId).submit();
		}
	}
$(document).ready(function() {
	//$("#frmSignup").validationEngine();
	/*$('.register form').submit(function(){
        $(this).find("label[for='firstname']").html('First Name');
        $(this).find("label[for='lastname']").html('Last Name');
        $(this).find("label[for='phone']").html('Phone No.');
        $(this).find("label[for='email']").html('Email');
        $(this).find("label[for='password']").html('Password');
		$(this).find("label[for='password2']").html('Confirm Password');
        ////
        var firstname = $(this).find('input#fname').val();
        var lastname = $(this).find('input#lname').val();
        var phone = $(this).find('input#phone').val();
        var email = $(this).find('input#email').val();
        var password = $(this).find('input#password').val();
		var password2 = $(this).find('input#password2').val();
        if(firstname == '') {
            $(this).find("label[for='firstname']").append("<span style='display:none' class='red'> - Please enter your first name.</span>");
            $(this).find("label[for='firstname'] span").fadeIn('medium');
            return false;
        }
        if(lastname == '') {
            $(this).find("label[for='lastname']").append("<span style='display:none' class='red'> - Please enter your last name.</span>");
            $(this).find("label[for='lastname'] span").fadeIn('medium');
            return false;
        }
        if(phone == '') {
            $(this).find("label[for='phone']").append("<span style='display:none' class='red'> - Please enter a valid phone.</span>");
            $(this).find("label[for='phone'] span").fadeIn('medium');
            return false;
        }
        if(email == '') {
            $(this).find("label[for='email']").append("<span style='display:none' class='red'> - Please enter a valid email.</span>");
            $(this).find("label[for='email'] span").fadeIn('medium');
            return false;
        }
        if(password == '') {
            $(this).find("label[for='password']").append("<span style='display:none' class='red'> - Please enter a valid password.</span>");
            $(this).find("label[for='password'] span").fadeIn('medium');
            return false;
        }
		if(password2 == '') {
            $(this).find("label[for='password2']").append("<span style='display:none' class='red'> - Please enter a valid confirm password.</span>");
            $(this).find("label[for='password2'] span").fadeIn('medium');
            return false;
        }
    });*/


});


