$(document).ready(function() {
    // Selectors list
    var elements = {
        loader: '<div class="loader"></div>'
    };

    var places = {
        document: 'html, body',

        sortLink: 'a.sortBy',
        sortLinksAll: '#shades .shade .inner a.sortBy',
        shadesAll: '#shades .shade',
        innerShade: '#shades .shade .inner',
        sortType: '#itemsForm #sort_type',
        sortDirection: '#itemsForm #sort_dir',

        expandAjaxLink: 'div.item a.expand',
        avatarSwitch: '.commentsForm a.avatar_switch',
        expandLink: '.comments a.expand',
        closeLink: '.social a.close',
        expandedLink: '.item a.expanded',

        comment: '.comment.real, .comment.level',
        submitCommentButton: '.commentsForm .button button',
        nestedCommentForm: '.commentsFormNested',
        nestedCommentFormParentField: '.commentsFormNested input.parent_id',

        balloon: '#balloon',
        balloonText: '#balloon_text'
    };

    $(places.expandAjaxLink).live("click", function(e) {
        e.preventDefault();
        var itemId = $(this).parent().parent().parent().attr('data-id');
        var itemSelector = '#item_' + itemId;
        var commentsSelector = '#comments_' + itemId;
        var requestUrl = $(this).attr('href') + '?modal';

        $(itemSelector).find('div.number').html(elements.loader);

        $.ajax(requestUrl)
            .done(function(data){
                $(itemSelector).replaceWith(data);
                $(itemSelector).parents('.item_container').addClass('active');
                $(commentsSelector).addClass('active');

                var target_offset = $(commentsSelector).offset();
                var target_top = target_offset.top;

                $(places.document).animate({scrollTop: target_top}, 1500);
            })
            .fail(function() { alert("Произошла ошибка. Повторите свой запрос позднее."); })

        return false;
    });

    // Sortables
    $(places.sortLink).live("click", function(e) {
        e.preventDefault();
        $(places.sortType).val($(this).attr('data-type'));
        $(places.sortDirection).val($(this).attr('data-dir'));

        $(places.sortLinksAll).show();
        $(this).hide();

        $(places.shadesAll).removeClass('active');
        $(this).parent().parent().addClass('active');

        $(places.innerShade).removeClass('active');
        $(this).parent().addClass('active');

        $('#itemsForm').submit();
        return false;
    });

    $('#itemsForm').submit(function(){
        $.fn.yiiListView.update('itemsList', {
            data: $(this).serialize()
        });
        return false;
    });

    // Close expanded item
    $(places.closeLink).live("click", function(e) {
        e.preventDefault();
        var parent = $(this).parents('div.item_container');
        parent.removeClass('active');
        parent.find('.comments_list').hide();
        parent.find('.social').hide();
        return false;
    });

    // Re-open closed expanded item
    $(places.expandedLink).live("click", function(e) {
        e.preventDefault();
        var parent = $(this).parents('div.item_container');
        parent.addClass('active');
        parent.find('.comments_list').show();
        parent.find('.social').show();

        var target_offset = parent.find('.comments_list').offset();
        var target_top = target_offset.top;

        $(places.document).animate({scrollTop: target_top}, 1500);
        return false;
    });

    // Comments form avatar switcher
    $(places.avatarSwitch).live("click", function() {
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

    // Nested form copy
    $(places.comment).live("click", function(e) {
        e.preventDefault();
        $(places.nestedCommentForm).show();
        $(places.nestedCommentForm).insertAfter(this);
        $(places.nestedCommentFormParentField).val($(this).attr('data-id'));
        return false;
    });

    // Show captcha after submit
    $(places.submitCommentButton).live('click', function() {
        var textVal = $(this).parents('div.controls').find('textarea').val();
        if (textVal.length == 0) {
            alert('Ошибка: вы не ввели текст комментария')
        } else {
            $(this).parents('div.controls').hide();
            $(this).parents('form').find('div.captcha').show();
        }
    });

    // Comments icon highlight
    $(places.expandLink).live("mouseover", function() {
        $(this).find('i').removeClass('icon-comments').addClass('icon-comments_active');
    });

    $(places.expandLink).live("mouseout", function() {
        $(this).find('i').removeClass('icon-comments_active').addClass('icon-comments');
    });

    // Bird and balloon
    $('#companion').click(function(){
        var displayFlag = ($(places.balloon).css('display') == 'none');

        $(places.balloon).toggle(displayFlag);

        if (displayFlag) {
            $(places.balloonText).teletype({
                text: teletypeText
            });
        }
    });

    $(places.balloonText).teletype({
        text: teletypeText
    });
});