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
            STUDIP.whatsnew.move(1);
        });
    });
});

STUDIP.whatsnew = {
    move: function(move) {
        var current = $('div.whatsnew nav div.active').index();
        if (current >= ($('div.whatsnew nav div').length) - 1 && move > 0) {
            STUDIP.whatsnew.close();
        } else {
            $('div.whatsnew nav div:eq(' + (current + move) + ')').click();
        }
    },
    close: function() {
        $.get(STUDIP.URLHelper.getURL('plugins.php/WhatsnewPlugin'));
        $('div.whatsnew').hide(1000);
    }
};

$(document).keydown(function(e) {
    if (e.keyCode === 37) {
        STUDIP.whatsnew.move(-1);
        return false;
    }
    if (e.keyCode === 39) {
        STUDIP.whatsnew.move(1);
        return false;
    }
});