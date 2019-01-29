jQuery(document).ready(function(e)
{
    window.onscroll = function() {myFunction()};

    function myFunction() {
        if (document.body.scrollTop > 320 || document.documentElement.scrollTop > 320) {
            // e( "table.publicTable.Moveable_header" ).addClass( "show" );
            e( ".publicTable.Moveable_header" ).addClass( "show" );

        } else {
            e( ".publicTable.Moveable_header" ).removeClass( "show" );
            // e( "table.publicTable.Moveable_header" ).removeClass( "show" );
         }
    }
});



$( window ).load(function() {
    $(".MainLoading").removeClass("show");
});