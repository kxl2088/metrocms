$(function () {
    $(".top-nav a:not(.dropdown-toggle,.open-popup,.modal-popup,.inline-modal,.modal-iframe,.modal-resize,.modal-small,.modal-ajax), .metro-sidenav a, #nav.accordion-nav a, #shortcuts a:not(.modal-popup,.inline-modal,.modal-iframe,.modal-resize,.modal-small,.modal-ajax), .spin").click(function(e) {
        e.preventDefault();
        $("#loading").show();

        var url = $(this).attr("href");

        setTimeout(function() {
            setTimeout(function() {showSpinner();},30);

            window.location=url;
        },0);

   });
});

function showSpinner() {
    var opts = {
        lines: 15, // The number of lines to draw
        length: 3, // The length of each line
        width: 4, // The line thickness
        radius: 30, // The radius of the inner circle
        rotate: 0, // The rotation offset
        color: '#fff', // #rgb or #rrggbb
        speed: 2, // Rounds per second
        trail: 70, // Afterglow percentage
        shadow: false, // Whether to render a shadow
        hwaccel: false, // Whether to use hardware acceleration
        className: 'spinner', // The CSS class to assign to the spinner
        zIndex: 2e9, // The z-index (defaults to 2000000000)
        top: 'auto', // Top position relative to parent in px
        left: 'auto' // Left position relative to parent in px
    };
    $('#loading_anim').each(function() {
        spinner = new Spinner(opts).spin(this);
    });
}