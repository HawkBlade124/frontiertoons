const $j = jQuery;

function getCookie(name){
  const m = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&') + '=([^;]*)'));
  return m ? decodeURIComponent(m[1]) : '';
}

function openDeletePopup(){
  $j('#deleteAccountPopup').css('display','flex'); // or .fadeIn()
}

function closeDeletePopup(){
  $j('#deleteAccountPopup').hide(); // or .fadeOut()
}

function requestAccountDeletion(){
  const csrfToken = getCookie('XSRF-TOKEN');

  $j.ajax({
    url: '/includes/auth-handler.php',
    type: 'POST',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: { action: 'deleteAccount' }
  })
  .done(function(response){
    if (response && response.success) {
      window.location.href = '/logout';
    } else {
      alert((response && response.error) || 'Failed to delete account.');
      console.log(response);
    }
  })
  .fail(function(xhr, status, error){
    alert('Error processing request: ' + error);
    console.log(xhr.responseText, status);
  })
  .always(function(){
    closeDeletePopup();
  });
}

// wire up clicks (no inline onclick)
$j(function(){
  $j('#deleteAccountBtn').on('click', openDeletePopup);
  $j('#cancelDelete').on('click', closeDeletePopup);
  $j('#confirmDelete').on('click', requestAccountDeletion);
});