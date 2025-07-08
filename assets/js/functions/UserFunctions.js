$(function(){
// Pass userID from PHP to JavaScript
    var userID = $('#dashboardAvatar').attr('data-userID');
    console.log('Initial userID:', userID, 'Type:', typeof userID);

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

        // Debug: Log userID before upload
        console.log('userID before upload:', userID, 'Type:', typeof userID);

        // Validate userID
        if (!userID || isNaN(userID) || parseInt(userID) <= 0) {
            console.error('Invalid userID:', userID);
            alert('Error: Invalid user ID. Please ensure you are logged in.');
            return;
        }

        // Create FormData object to send file and userID
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('userID', userID);

        $.ajax({
            url: '/includes/UserFunctions.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    console.log('Server response:', response);
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Unable to update avatar');
            }
        });
    }
    
    

    // Expose functions to global scope for event handlers
    window.triggerFilePicker = triggerFilePicker;
    window.uploadImage = uploadImage;
})

function changeData(button) {
    const $btn = $(button);
    const field = $btn.data('field');
    const $container = $btn.closest('.inputGroup');
    const $input = $container.find(`input[name="${field}"], textarea[name="${field}"]`);

    const value = $input.val();
    const userID = $input.data('userid');

    console.log({ field, value, userID });

    if (!field || !value || !userID) {
        console.error('Missing required data');
        return;
    }

    $.ajax({
        url: '../../includes/UserFunctions.php',
        type: 'POST',
        data: {
            action: 'updateField',
            field: field,
            value: value,
            userID: userID
        },
        success: function(response) {
            console.log('Server response:', response);
            $('#profileUpdateMsg').html('Updated successfully!');
            if (response.status === 'success') {
                location.reload(); // Refresh to show updated values
            }
        },
        error: function() {
            $('#profileUpdateMsg').html('Error updating profile.');
        }
    });
}
function deleteAccount() {
    if (confirm("Are you sure you want to delete your account?")) {
        const username = "<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>";
        const csrfToken = "<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>";
        fetch('/includes/auth-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=deleteUser&username=${encodeURIComponent(username)}&csrf_token=${encodeURIComponent(csrfToken)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                window.location.href = '/login'; // Redirect after deletion
            } else {
                alert(data.error || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
}