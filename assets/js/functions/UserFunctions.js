$(function() {
    //Enables avatar upload functionality
    function avatarUpload() {
        document.getElementById("avatarInput").click();
    }
    //Enables avatar upload functionality
    function coverPhotoUpload() {
        document.getElementById("coverInput").click();
    }
    // Handle avatar file selection
    $('#avatarInput').on('change', function() {
        uploadImage(); // Call uploadImage when a file is selected
    });

    // Handle cover photo file selection
    $('#coverInput').on('change', function() {
        uploadCoverImage(); // Call uploadCoverImage when a file is selected
    });

function uploadImage() {
    const file = $('#avatarInput')[0].files[0];
    const userID = $('#dashboardAvatar img').data('userid'); // <- now correct

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
    formData.append('UserID', userID);

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
            console.error('AJAX Error:', xhr, status, error);
            alert('Unable to update avatar');
        }
    });
}



    function uploadCoverImage() {
        const file = $('#coverInput')[0].files[0];
        const userID = $('#coverPhoto').attr('data-userid');

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
        formData.append('CoverPhoto', file);
        formData.append('UserID', userID);

        $.ajax({
            url: '/includes/UserFunctions.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType:'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#popup').html('Cover Photo updated');
                } else {
                    console.log('Server response:', response);
                    alert('Error: ' + (response.message || 'Failed to update Cover Photo'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                alert('Unable to update Cover Photo');
            }
        });
    }

    window.avatarUpload = avatarUpload;
    window.coverPhotoUpload = coverPhotoUpload;
    window.uploadImage = uploadImage;
    window.uploadCoverImage = uploadCoverImage;

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
                console.log("Success callback response:", response);
                if (response.success) {
                    window.location.href = '/thank-you.html';
                } else {
                    alert(response.error || 'Registration failed.');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error callback triggered:", xhr, status, error);
                alert('Registration error: ' + (xhr.responseText || error || status));
            }
        });
    });
    $('#saveAll').on('click', function (e) {
        e.preventDefault();
        const $form = $('#resultsForm');
        const userID = $form.find('input[name="userID"]').val();
        const $btn = $(this).prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin-pulse"></i> Saving…');
        if (!userID) {
            $('#dashboardUpdateMsg').text('Missing user ID.');
            $btn.prop('disabled', false).text('Save All');
            return;
        }

        const formData = $form.serializeArray();

        $.ajax({
            url: '../includes/UserFunctions.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('#resultsUpdateMsg').text('Updated successfully! Refreshing…');
                    $btn.text('Saved!');
                    setTimeout(() => (window.location.href = '/dashboard'), 1500);
                } else {
                    $('#resultsUpdateMsg').text(res.message || 'Failed to update.');
                    $btn.prop('disabled', false).text('Save All');
                    console.log(res);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', {
                    status: jqXHR.status,
                    textStatus,
                    errorThrown,
                    responseText: jqXHR.responseText,
                    contentType: jqXHR.getResponseHeader('Content-Type')
                });

                let msg = 'Error updating profile.';
                try {
                    const parsed = JSON.parse(jqXHR.responseText);
                    if (parsed && parsed.message) msg = parsed.message;
                } catch (e) { 
                    
                 }

                $('#profileUpdateMsg').text(msg);
                $btn.prop('disabled', false).text('Save All');
            }
        });
    });
   function changeSocialMedia(button) {
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
            url: '/includes/UserFunctions.php',
            type: 'POST',
            data: {
                action: 'updateSocialMedia',
                field: field,
                value: value,
                user_id: userID 
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
                console.error('AJAX Error:', xhr, status, error);
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
                    console.log(xhr.responseText, status);
                }
            });
        }
    }

    window.changeSocialMedia = changeSocialMedia;
    window.deleteAccount = deleteAccount;
});