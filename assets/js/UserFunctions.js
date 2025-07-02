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
function triggerFilePicker() {
    document.getElementById("avatarInput").click();
}

function uploadImage() {
    const fileInput = document.getElementById("avatarInput");
    const file = fileInput.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append("userID", CURRENT_USER_ID); // Replace this with actual user ID
    formData.append("avatar", file);

    $.ajax({
        url: '/includes/UserFunctions.php',
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            location.reload();
        },
        error: function () {
            alert('Unable to update avatar');
        }
    });
}
