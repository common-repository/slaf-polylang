(function ($) {
    'use strict';

    if ($('#restricted_language')) {
        $.get(ajaxurl, {'action': 'all_available_languages'}, function (response) {
            var options = JSON.parse(response);
            $(options).each(function (iterator, value) {
                $('#restricted_language').append('<option value="' + value.slug + '">' + value.name + '</option>')
            });

            var current = $('#restricted_language').attr('data-current')
            $('#restricted_language').find('option').each(function () {
                if ($(this).attr('value') == current) {
                    $(this).attr('selected', 'true');
                }
            });

        })
    }

})(jQuery);
