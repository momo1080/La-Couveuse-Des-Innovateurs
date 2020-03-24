jQuery(function($) {

    $('.field').on('change', function() {
        var social_field = $(this).attr('data-field');
        var peepso_field = $(this).val();

        $.post(peepsodata.site_url + '/wp-admin/admin.php?page=peepso-manage&tab=social-login', {
            social_field: social_field,
            peepso_field: peepso_field,
        }, function(response) {
        });
    });

});