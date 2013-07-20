var settings = {
    avatarsCount: 11
};

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

    expandAjaxLink: '.item.closed',
    avatarSwitch: '.commentsForm a.avatar_switch',
    expandLink: '.comments a.expand',
    expandLinkImage: '.comments_image a.expand',
    closeLink: '.social a.close',
    expandedLink: '.item a.expanded',

    comment: '.comment.real, .comment.level',
    submitCommentButton: '.commentsForm .button button',
    nestedCommentForm: '.commentsFormNested',
    nestedCommentFormParentField: '.commentsFormNested input.parent_id',

    balloon: '#balloon',
    balloonText: '#balloon_text'
};

$(document).ready(function() {
    $(places.expandAjaxLink).live("click", function(e) {
        e.preventDefault();
        var itemId = $(this).attr('data-id');
        var itemSelector = '#item_' + itemId;
        var commentsSelector = '#comments_' + itemId;
        var requestUrl = $(this).find('a.expand').attr('href') + '?modal';

        $(itemSelector).find('div.number').html(elements.loader);

        $.ajax(requestUrl)
            .done(function(data){
                $(itemSelector).replaceWith(data);
                $(itemSelector).parents('.item_container').addClass('active');
                $(commentsSelector).addClass('active');
            })
            .fail(function() { alert("Произошла ошибка. Повторите свой запрос позднее."); })

        return false;
    });

    // Sortables
    $(places.sortLink).live("click", function(e) {
        e.preventDefault();
        $(places.sortType).val($(this).attr('data-type'));
        $(places.sortDirection).val($(this).attr('data-dir'));
        sortLinksSwitch(this);

        $('#itemsForm').submit();
        return false;
    });

    $('.shade').live("mouseover", function(e) {
        $(this).removeClass('active');
    }).live("mouseout", function(e) {
        $(this).addClass('active');
    });

    $('#itemsForm, #searchForm').submit(function(){
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
        return false;
    });

    // Comments form avatar switcher
    $(places.avatarSwitch).live("click", function() {
        var currentAvatar = $(this).parent().find('i.avatar');
        var hiddenField = $(this).parent().parent().parent().find('input.avatar_field');
        var avatarId = parseInt(currentAvatar.attr('data-avatar'));

        if ($(this).hasClass('up')) avatarId += 1;
        else avatarId -= 1;

        if (avatarId > settings.avatarsCount) avatarId = 1;
        if (avatarId == 0) avatarId = settings.avatarsCount;

        currentAvatar.removeClass().addClass('avatar').addClass('avatars');
        currentAvatar.addClass('avatar_' + avatarId).attr("data-avatar", avatarId);
        hiddenField.val(avatarId);
    });

    // Nested form copy
    $(places.comment).live("click", function(e) {
        e.preventDefault();
        var parentItem = $(this).parents('.comments_list');
        parentItem.find(places.nestedCommentForm).show();
        parentItem.find(places.nestedCommentForm).appendTo(this);
        parentItem.find(places.nestedCommentFormParentField).val($(this).attr('data-id'));

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
    }).live("mouseout", function() {
        $(this).find('i').removeClass('icon-comments_active').addClass('icon-comments');
    });

    $(places.expandLinkImage).live("mouseover", function() {
        $(this).find('i').removeClass('icon-image_icon').addClass('icon-image_icon_active');
    }).live("mouseout", function() {
        $(this).find('i').removeClass('icon-image_icon_active').addClass('icon-image_icon');
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

sortLinksSwitch = function(obj) {
    $(places.sortLinksAll).removeClass('active');
    $(obj).addClass('active');
};

var where, when; //added

$.fn.teletype = function(opts){
    var $this = this,
        defaults = {
            animDelay: 50
        },
        settings = $.extend(defaults, opts);

    var letters = settings.text.length; //added

    where = '#' + $($this).attr('id'); //added
    when = settings.animDelay; //added

    $(where).html("");

    $.each(settings.text, function(i, letter){
        setTimeout(function(){
            $this.html($this.html() + letter);
        }, settings.animDelay * i);
    });
};