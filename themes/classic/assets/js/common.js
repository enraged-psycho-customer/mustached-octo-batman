var elements = {
    loader: '<div class="loader"></div>'
};

var garbage = {};

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
    closeLink: '.social-common a.close, .item.open .quote',

    comment: '.comment.real, .comment.level',
    submitCommentButton: '.commentsForm .button button',
    nestedCommentForm: '.commentsFormNested',
    nestedCommentFormParentField: '.commentsFormNested input.parent_id',

    balloon: '#balloon',
    balloonText: '#balloon_text'
};

$(document).ready(function() {
    $('#nav_mobile ul li a.prev, #nav_mobile ul li a.next').live('click', function(e) {
        var parentList = $(this).parents('ul');

        if ($(this).hasClass('prev')) {
            var lastItem = parentList.find('li:last').remove();
            parentList.prepend(lastItem);
        } else {
            var parentItem = $(this).parents('li');
            parentItem.remove();
            parentList.append(parentItem);
        }
    });

    $(places.expandAjaxLink).live("click", function(e) {
        e.preventDefault();

        // Close all other posts
        for (var id in garbage) {
            $('div.item#item_' + id).parents('.item_container').replaceWith(garbage[id]);
            delete garbage[id];
        }

        var itemId = $(this).attr('data-id');
        var itemSelector = '#item_' + itemId;
        var commentsSelector = '#comments_' + itemId;
        var requestUrl = $(this).find('a.expand').attr('href') + '?modal';

        garbage[itemId] = $(itemSelector).get(0).outerHTML;

        $(itemSelector).find('.max').html(elements.loader).fadeIn('slow');

        $.ajax(requestUrl)
            .done(function(data){
                $(itemSelector).replaceWith(data);
                $(itemSelector).find('.comments_list').fadeIn('slow');
                $(itemSelector).parents('.item_container').addClass('active');
                $(commentsSelector).addClass('active');
            })
            .fail(function() { alert("Произошла ошибка. Повторите свой запрос позднее."); })

        return false;
    });

    // Close expanded item
    $(places.closeLink).live("click", function(e) {
        e.preventDefault();
        var itemId = $(this).parents('div.item').attr('data-id');

        $(this).parents('.item_container').replaceWith(garbage[itemId]);
        delete garbage[itemId];

        return false;
    });

    $('a.externalToggle').live("click", function(e) {
        $(this).parents('.social-common').find('.external').toggle();
        $(this).find('i').toggleClass('icon-like');
        $(this).find('i').toggleClass('icon-like_active');
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

    // Submit sortables & filters
    $('#itemsForm, #searchForm').submit(function(){
        $.fn.yiiListView.update('itemsList', {
            data: $(this).serialize()
        });
        return false;
    });

    // Comments form avatar switcher
    $(places.avatarSwitch).live("click", function() {
        var currentAvatar = $(this).parents('div.avatar').find('i.avatar');
        var hiddenField = $(this).parents('div.containerForm').find('input.avatar_field');
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
        parentItem.find(places.nestedCommentFormParentField).val($(this).attr('data-id'));

        var form = parentItem.find(places.nestedCommentForm);
        form.show();

        var formHtml = form.get(0).outerHTML;
        parentItem.find(places.nestedCommentForm).remove();

        $(this).after(formHtml);

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

// Teletype
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