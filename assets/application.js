$(document).ready(function() {
    $('div.whatsnew').animate({'background-color': 'rgba(0, 0, 0, 0.6)'}, 2000, function() {
        $('div.whatsnew img:first').animate({'opacity': '1'}, 2000);

        // Add navigation elements
        $('div.whatsnew img').each(function() {
            $('div.whatsnew nav').append($('<div>').click(function() {
                var index = $(this).index();

                // Show requested image
                $('div.whatsnew img').animate({'opacity': '0'}, 500);
                $('div.whatsnew img:eq(' + index + ')').animate({'opacity': '1'}, 500);

                // activate navigation
                $('div.whatsnew nav div').removeClass('active');
                $(this).addClass('active');
            }));
        });
        $('div.whatsnew nav div:first').addClass('active');

        // Click on image
        $('div.whatsnew img').click(function() {
            var current = $('div.whatsnew nav div.active').index();
            if (current >= ($('div.whatsnew nav div').length) - 1 ) {
                $('div.whatsnew').hide(1000);
            } else {
                $('div.whatsnew nav div:eq(' + (current + 1) + ')').click();
            }
        });
    });
});
