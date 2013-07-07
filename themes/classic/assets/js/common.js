$(document).ready(function() {
    var balloonId = '#balloon';

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

    // Items
    $("div.comment.real").live("click", function(e) {
        e.preventDefault();
        $('#commentsFormSecond').show();
        $('#commentsFormSecond').insertAfter(this);
        $('#commentsFormSecond input#parent_id').val($(this).attr('data-id'));
        return false;
    });

    $("div.social a.close").live("click", function(e) {
        e.preventDefault();
        $(this).parent().parent().find('.comments_list').hide();
        $(this).parent().parent().find('.social').hide();
        return false;
    });

    $("div.item a.expanded").live("click", function(e) {
        e.preventDefault();
        var parent = $(this).parent().parent().parent();
        parent.find('.comments_list').show();
        parent.find('.social').show();

        var target_offset = parent.find('.comments_list').offset();
        var target_top = target_offset.top;

        $('html, body').animate({scrollTop: target_top}, 1500);
        return false;
    });

    // Balloon
    $('#balloon_text').teletype({
        text: teletypeText
    });
});