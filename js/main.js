$(document).ready(function() {
    $('#popUpMessage').css('display', 'none'); // or 'flex', depending on your layout

    // Signup
    $('#signupForm').on('submit', function(event) {
        event.preventDefault(); 
        const formData = $(this).serialize();

        // Clear previous errors
        $('#nameError, #emailError, #passwordError,#termsError').text('');

        $.ajax({
            url: './controller/signup.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const res = JSON.parse(response);

                if (res.success) {
                    // Redirect on success
                    $('#signupForm')[0].reset();
                    window.location.href = res.redirect;
                    console.log(res.message);
                } else {
                    // Show errors dynamically
                    if (res.errors) {
                        if (res.errors.name) {
                            $('#nameError').text(res.errors.name);
                        }
                        if (res.errors.email) {
                            $('#emailError').text(res.errors.email);
                        }
                        if (res.errors.password) {
                            $('#passwordError').text(res.errors.password);
                        }
                        if (res.errors.terms) {
                            $('#termsError').text(res.errors.terms);
                        }
                        console.log(res.errors);
                    }
                    console.log(res.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });
    
    // Signin
    $('#signinForm').on('submit', function(event) {
        event.preventDefault(); 
        
        const formData = $(this).serialize();
        $('#emailErrorSignin, #passwordErrorSignin').text('');  // Clear previous errors
    
        $.ajax({
            url: './controller/signin.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const res = JSON.parse(response);
                
                if (res.success) {
                    // Redirect on success
                    $('#popUpMessage').css('display', 'none');
                    $('#message').text('');
                    $('#status').text('');
                    $('#signinForm')[0].reset();
                    window.location.href = res.redirect; // Redirect to dashboard or target page
                } else {
                    // Show errors dynamically
                    if (res.errors) {
                        if (res.errors.email) {
                            $('#emailErrorSignin').text(res.errors.email);
                        }
                        if (res.errors.password) {
                            $('#passwordErrorSignin').text(res.errors.password);
                        }
                        if (res.errors.message) {
                            $('#message').text(res.errors.message);
                            $('#status').text('Error: ');
                            $('#popUpMessage').css('display', 'block');
                        }else{
                            $('#popUpMessage').css('display', 'none');
                            $('#message').text('');
                            $('#status').text('');
                        }
                        console.log(res.errors);
                    } else {
                        $('#message').text(res.message);
                        $('#status').text('Error: ');
                        $('#popUpMessage').css('display', 'block');
                    }
                }
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });
    
    //email Verification
    var resetToken = ""; // Store the generated reset token for verification

    // Handle email submission
    $("#emailForm").submit(function (e) {
    e.preventDefault();

    var resetEmail = $("#resetEmail").val();
    var submitButton = $("#reset-btn");


    submitButton.prop("disabled", true).text("Sending...");
    $.ajax({
        type: "POST",
        url: "./controller/send_verification.php",
        data: { resetEmail: resetEmail },
        success: function (response) {
            console.log(response);
            try {
                const res = JSON.parse(response);
                if (res.success) {
                    //   resetToken = res.token;
                    // alert(res.message);
                    $('#message').text('');
                    $('#status').text('');
                    $('#popUpMessage').css('display', 'none');

                    localStorage.setItem('resetToken', res.token);
                    $('#emailForm')[0].reset();
                    window.location.href = res.redirect;
                } else {
                    // alert("Error: " + res.message);
                    $('#message').text(res .message);
                    $('#status').text('Error: ');
                    $('#popUpMessage').css('display', 'block');
                    if (res.debug) {
                        console.log("PHPMailer Debug Output: " + res.debug);
                    }
                }
            } catch (error) {
                console.error("Error parsing JSON:", error);
            }
        },
        error: function (xhr, status, error) {
        alert(
            "Error: " +
            (xhr.responseJSON
                ? xhr.responseJSON.message
                : "Please try again later.")
        );
        //   console.log(xhr);
        },
        complete: function () {
            submitButton.prop("disabled", false).text("Send Email");
        },
    });
    });

    //verify code on reset password
    $('#codeForm').submit(function(e) {
        e.preventDefault();
        var otp1 = $('#otp-input1').val();
        var otp2 = $('#otp-input2').val();
        var otp3 = $('#otp-input3').val();
        var otp4 = $('#otp-input4').val();
        var otp5 = $('#otp-input5').val();
        var otp6 = $('#otp-input6').val();

        var resetCode = otp1 + otp2 + otp3 + otp4 + otp5 + otp6;
        var verifyButton = $('#verify-button');
        verifyButton.prop('disable', true).text('Verifying...');
    
        // Show loading message
        // responseMessage.removeClass('alert-info').addClass('alert-warning').text('Verifying code...').show();
        var resetToken = localStorage.getItem('resetToken'); 
        $.ajax({
            type: 'POST',
            url: './controller/verify_code.php',
            data: { token: resetToken, code: resetCode },
            dataType: 'json', 
            success: function(data) {
                console.log(data); 
                if (data.success) {
                    // responseMessage.removeClass('alert-warning').addClass('alert-success').text('Code verified. You can now reset your password.').show();

                    if(data.success){
                        $('#verify-button').prop('disabled', true).text('Redirecting...');
                    };
                    setTimeout(function() {
                        if(data.success){
                            $('#codeForm')[0].reset();
                            window.location.href = data.redirect;
                        };
                    }, 3000); 
                } else {
                    $('#message').text(data .message);
                    $('#status').text('Error: ');
                    $('#popUpMessage').css('display', 'block');
                    console.log("hi");
                    verifyButton.prop('disable', false).text('Verify');
                }
            },
            error: function() {
                // responseMessage.removeClass('alert-warning').addClass('alert-danger').text('There was an error verifying the code. Please try again.').show();
                verifyButton.prop('disable', false).text('Verify');
            }
        });
    });
     //reset password
    $('#resetPasswordForm').submit(function(e) {
        e.preventDefault();

        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        var responseMessage = $('#responseMessage');
        var submitButton = $('button[type="submit"]');

   
        submitButton.prop('disabled', true).text('Please wait...');
        $.ajax({
            type: 'POST',
            url: './controller/reset_password.php', 
            data: {
                newPassword: newPassword,
                confirmPassword: confirmPassword,
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $('#message').text(data.message);
                    $('#status').text('Succcess: ');
                    $('#popUpMessage').css('display', 'block');
                    setTimeout(function() {
                        $('#resetPasswordForm')[0].reset();
                        $('#message').text('');
                        $('#status').text('');
                        $('#popUpMessage').css('display', 'none');
                        window.location.href = data.redirect; 
                    }, 2000); 
                } else {
                    $('#message').text(data.message);
                    $('#status').text('Error: ');
                    $('#popUpMessage').css('display', 'block');
                    
                    submitButton.prop('disabled', true).text('Reset Password');
                }
            },
            error: function(xhr, status, error) {
                // console.log("AJAX Error:", status, error);
                // console.log("Response:", xhr.responseText); 
                // responseMessage.removeClass('alert-warning').addClass('alert-danger').text('There was an error processing your request.').show();
            },            
            complete: function() {
                submitButton.prop('disabled', false).text('Reset Password');
            }
        });
    });

});
