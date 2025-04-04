$(document).ready(function() {
    $('#popUpMessage').css('display', 'none'); // or 'flex', depending on your layout

    $('#signupForm').on('submit', function(event) {
        event.preventDefault(); 
        const formData = $(this).serialize();

        // Clear previous errors
        $('#nameError, #emailError, #passwordError,#termsError').text('');

        $.ajax({
            url: './../../controller/signup.php',
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
    
    $('#signinForm').on('submit', function(event) {
        event.preventDefault(); 
        
        const formData = $(this).serialize();
        $('#emailErrorSignin, #passwordErrorSignin').text('');  // Clear previous errors
    
        $.ajax({
            url: './../../controller/signin.php',
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
    
});
