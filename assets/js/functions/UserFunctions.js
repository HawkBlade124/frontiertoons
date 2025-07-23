$(function() {
    // Pass userID from PHP to JavaScript
    var userID = $('#dashboardAvatar').attr('data-userID');

    function triggerFilePicker() {
        document.getElementById("avatarInput").click();
    }

    function uploadImage() {
        const fileInput = document.getElementById("avatarInput");
        const file = fileInput.files[0];
        if (!file) {
            alert('Please select an image to upload.');
            return;
        }

        if (!userID || isNaN(userID) || parseInt(userID) <= 0) {
            console.error('Invalid UserID:', userID);
            alert('Error: Invalid user ID. Please ensure you are logged in.');
            return;
        }

        const formData = new FormData();
        formData.append('Avatar', file);
        formData.append('UserID', userID); // Updated to PascalCase

        $.ajax({
            url: '/includes/UserFunctions.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#popup').html('Avatar updated');
                } else {
                    console.log('Server response:', response);
                    alert('Error: ' + (response.message || 'Failed to update avatar'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Unable to update avatar');
            }
        });
    }    

    window.triggerFilePicker = triggerFilePicker;
    window.uploadImage = uploadImage;

    $('.loginForm').submit(function(e) {
        e.preventDefault();

        const csrfToken = document.cookie
            .split('; ')
            .find(row => row.startsWith('XSRF-TOKEN='))
            ?.split('=')[1];

        if (!csrfToken) {
            alert('Error: CSRF token missing. Please refresh the page and try again.');
            return;
        }

        const username = $('#username').val();
        const password = $('#password').val();

        if (!username || !password) {
            alert('Please enter both username and password.');
            return;
        }

        $.ajax({
            url: '/includes/auth-handler.php',
            type: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: JSON.stringify({
                action: 'login',
                Username: username, 
                Password: password 
            }),
            success: function(response) {                
                if (response.success) {
                    window.location.href = '/dashboard';
                } else {
                    alert(response.error || 'Login failed.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Login error:', xhr.responseText);
                alert('An error occurred during login: ' + (xhr.responseJSON?.error || 'Unknown error'));
            }
        });
    });

    $('.registrationForm').submit(function(e) {
        e.preventDefault();

        const csrfToken = document.cookie.split('; ').find(row => row.startsWith('XSRF-TOKEN='))?.split('=')[1];
        const data = {
            action: 'register',
            FirstName: $('input[name="FirstName"]').val(),
            LastName: $('input[name="LastName"]').val(),
            Email: $('input[name="Email"]').val(),
            Username: $('input[name="Username"]').val(),
            Password: $('input[name="Password"]').val(),
            Birthday: $('input[name="Birthday"]').val()
        };

        $.ajax({
            url: '/includes/auth-handler.php',
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: JSON.stringify(data),
            success: function(response) {
                if (response.success) {
                    window.location.href = '/login?registered=1';
                } else {
                    alert(response.error || 'Registration failed.');
                }
            },
            error: function(xhr) {
                alert('Registration error: ' + xhr.responseText);
            }
        });
    });

    function changeData(button) {
        const $btn = $(button);
        const field = $btn.data('field');
        const $container = $btn.closest('.inputGroup');
        const $input = $container.find(`input[name="${field}"], textarea[name="${field}"]`);

        const value = $input.val();
        const userID = $input.data('userid');

        if (!field || !value || !userID) {
            console.error('Missing required data');
            return;
        }

        $.ajax({
            url: '/includes/UserFunctions.php', // Updated path to match backend
            type: 'POST',
            data: {
                action: 'updateField',
                field: field,
                value: value,
                user_id: userID // Updated to match User Functions.php
            },
            success: function(response) {           
                if (response.status === 'success') {
                    $('#profileUpdateMsg').html('Updated successfully! Page will refresh in 5 seconds.');
                    $btn.html('<i class="fa-solid fa-spinner fa-spin-pulse"></i>');                
                    setTimeout(() => {                    
                        $btn.html('Saved!');
                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 2500);
                    }, 2000);
                } else {
                    $('#profileUpdateMsg').html('Error: ' + (response.message || 'Failed to update profile.'));
                }
            },
            error: function(xhr, status, error) {
                $('#profileUpdateMsg').html('Error updating profile.');
                console.error('AJAX Error:', status, error);
            }
        });
    }

    function deleteAccount() {
        const csrfToken = document.cookie.split('; ').find(row => row.startsWith('XSRF-TOKEN='))?.split('=')[1];

        if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
            $.ajax({
                url: '/includes/auth-handler.php',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    action: 'deleteAccount',
                    Username: currentUsername // Updated to PascalCase
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = '/logout';
                    } else {
                        alert(response.error || 'Failed to delete account.');
                        console.log(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error processing request: ' + error);
                    console.log(xhr.responseText);
                }
            });
        }
    }

    window.changeData = changeData;
    window.deleteAccount = deleteAccount;
});