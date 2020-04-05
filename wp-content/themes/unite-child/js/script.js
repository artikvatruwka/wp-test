(($) => {
    $('#agency-widget').change(() => {
        $.ajax({
            type: 'POST',
            url: real_estate_ajax.ajax_url,
            dataType: "html",
            data: { action : 'get_real_estate', agency : $('#agency-widget').children("option:selected").attr('value')},
            success: function( response ) {
                $( '#main' ).html( response );
            }
        });
    });
})(jQuery);