$(document).ready(function() {
    var balloonId = '#balloon';

    $('div.comments a.expand').live("mouseover", function() {
        $(this).find('i').removeClass('icon-comments').addClass('icon-comments_active');
    });

    $('div.comments a.expand').live("mouseout", function() {
        $(this).find('i').removeClass('icon-comments_active').addClass('icon-comments');
    });

    $('div.commentsForm a.avatar_switch').live("click", function() {
        var currentAvatar = $(this).parent().find('i.avatar');
        var hiddenField = $(this).parent().parent().parent().find('input.avatar_field');

        if (currentAvatar.hasClass('icon-avatar_boy')) {
            hiddenField.val(2);
            currentAvatar.addClass('icon-avatar_girl').removeClass('icon-avatar_boy');
        } else {
            hiddenField.val(1);
            currentAvatar.removeClass('icon-avatar_girl').addClass('icon-avatar_boy');
        }
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

    // Items
    $("div.comment.real, div.comment.level").live("click", function(e) {
        e.preventDefault();
        $('#commentsFormSecond').show();
        $('#commentsFormSecond').insertAfter(this);
        $('#commentsFormSecond input#parent_id').val($(this).attr('data-id'));
        return false;
    });

    $('.commentsForm div.textarea button.checkbox').live('click', function(e) {
        $(this).parent().parent().hide();
        $(this).parent().parent().parent().find('div.captcha').show();
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