$(document).ready(function() {
    var balloonId = '#balloon';
    var commentsIcon = 'div.item .comments a';

    // Comments icon hover
    $(commentsIcon).mouseover(function() {
        $(this).find('i').addClass('sprite_comments_active');
    });

    $(commentsIcon).mouseout(function() {
        $(this).find('i').removeClass('sprite_comments_active');
    });

    // Bird
    $('#companion').click(function(){
        var displayFlag = ($(balloonId).css('display') == 'none');

        $(balloonId).toggle(displayFlag);

        if (displayFlag) {
            $('#balloon_text').teletype({
                text: teletypeText
            });
        }

    });

    // Balloon
    $('#balloon_text').teletype({
        text: teletypeText
    });
});