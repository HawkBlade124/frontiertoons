function sessionTimeOut(){
    const IDLE_LIMIT = 20 * 60 * 1000;  // 20 minutes
    const WARNING_LIMIT = 1 * 60 * 1000; // 1 minute after warning

    let idleTimer, warningTimer;

    function startIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(showTimeoutWarning, IDLE_LIMIT);
    }

    function showTimeoutWarning() {
        const shouldLogout = confirm("You have been inactive. You'll be logged out in 1 minute. Click OK to stay.");
        if (shouldLogout) {
        resetTimer();
        } else {
        warningTimer = setTimeout(() => {
            window.location.href = '/logout.php'; // update this to your logout path
        }, WARNING_LIMIT);
        }
    }

    function resetTimer() {
        clearTimeout(idleTimer);
        clearTimeout(warningTimer);
        startIdleTimer();
    }
}
$(function(){
    
    $('.profileSidebarBtn').click(function () {
        // Set active class on the clicked button
        $('.profileSidebarBtn').removeClass('active');
        $(this).addClass('active');

        // Show corresponding profile result
        var show = $(this).data('target');

        $('.profileResults').removeClass('active');
        $('.profileResults.' + show).addClass('active');
    });
})