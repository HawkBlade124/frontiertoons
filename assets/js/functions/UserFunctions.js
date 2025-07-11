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

$('.profileSidebarBtn').click(function () {
    if($(this).has('active')){
        $('.profileSidebarBtn').find('active').removeClass('active');
        $('.profileSidebarBtn').addClass('active');
        $('.profileResults').data('profileTab').addClass('active');
    }
});


})
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
        url: '../../includes/UserFunctions.php',
        type: 'POST',
        data: {
            action: 'updateField',
            field: field,
            value: value,
            userID: userID
        },
        success: function(response) {
            $('#profileUpdateMsg').html('Updated successfully! Page will refresh in 5 seconds.');
            if (response.status === 'success') {
                $btn.html('<i class="fa-solid fa-spinner fa-spin-pulse"></i>');                
                setTimeout(() => {                    
                    $btn.html('Saved!');
                    setTimeout(() => {
                        window.location.href = '/dashboard'
                    }, 2500);
                }, 2000)
            }
        },
        error: function() {
            $('#profileUpdateMsg').html('Error updating profile.');
        }
    });
}
function deleteAccount() {
    if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        $.ajax({
            url: '../../includes/UserFunctions.php',
            type: 'POST',
            data: {
                action: 'deleteAccount'
            },
            success: function(response) {
                if (response.status === 'success') {
                    alert('Account deleted successfully.');
                    window.location.href = '/logout.php'; // Redirect to logout or home page
                } else {
                    alert('Error deleting account: ' + response.message);
                }
            },
            error: function() {
                alert('Error processing request.');
            }
        });
    }
}