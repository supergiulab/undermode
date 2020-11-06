// Main Javascript file
// @package undermode
( function( $ ) {
	"use strict";
    ///* Login Form
    $("#um-login-link").click(function(event){
        event.preventDefault();
        $("#um-login").toggleClass("open");
    });

    ///* Login Form Placeholder
    $("#user_login").attr('placeholder', 'Username');
    $("#user_email").attr('placeholder', 'Email');
    $("#user_pass").attr('placeholder', 'Password');
} )( jQuery );