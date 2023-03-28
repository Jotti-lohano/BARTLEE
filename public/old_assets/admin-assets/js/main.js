var eyeBtn = Array.from(document.querySelectorAll('.passDisplay'));
    eyeBtn.forEach(e => {
        e.addEventListener('click', function () {
            let passwordWrapper = e.closest('.passwordWrapper');
            let passInput = passwordWrapper.querySelector('input');
            if (passInput.classList.contains('passInput')) {
                if (passInput.type == 'password') {
                    passInput.setAttribute('type', 'text');
                    this.setAttribute('class', 'bi bi-eye-fill enter-icon right-icon position-absolute passDislay');
                }
                else {
                    passInput.setAttribute('type', 'password');
                    this.setAttribute('class', 'bi bi-eye-slash enter-icon right-icon position-absolute passDislay');
                }
            }
        })
    });

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

var sideToggle = document.body.querySelector('#navbarDropdown');
var getToggle =  document.querySelector('.dropdown-menu');
sideToggle.addEventListener('click', function() {
    getToggle.classList.toggle('show');
})

var sideToggles = document.body.querySelector('#notification');
var getToggles =  document.querySelector('.dropdown-notifcation');
sideToggles.addEventListener('click', function() {
    getToggles.classList.toggle('show');
})


jQuery('.edit').click(function(){
    jQuery('#edit').removeClass('text-right disabled border-0 px-0');
    jQuery('#edits').removeClass('text-right disabled border-0 px-0');
    jQuery(this).attr('disabled', true);
    jQuery('#edit').addClass('text-center');
    jQuery('#edits').addClass('text-center');
    jQuery(this).hide();
    jQuery('.update').show();
});

jQuery('.update').click(function(){
    jQuery('#edit').addClass('text-right disabled border-0 px-0');
    jQuery('#edits').addClass('text-right disabled border-0 px-0');
    jQuery('#edit').removeClass('text-center');
    jQuery('#edits').removeClass('text-center');
    jQuery(this).attr('disabled', false);
    jQuery(this).hide();
    jQuery('.edit').show();
});