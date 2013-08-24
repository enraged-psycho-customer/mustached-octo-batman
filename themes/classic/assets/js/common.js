countMaxLines = function() {
    var height = parseInt($('#createForm textarea').css('height'));
    var lineHeight = parseInt($('#createForm textarea').css('line-height'));
    return Math.floor(height / lineHeight);
};

var elements = {
    loader: '<div class="loader"></div>',
    sortables: ['updated_at', 'comments_count', 'created_at'],
    currentLines: NaN,
    minLines: 5,
    maxLines: 20
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
    closeLink: '.social-common a.close, .item_text.open .quote_content',

    comment: '.comment.real, .comment.level',
    submitCommentButton: '.commentsForm .button button',
    nestedCommentForm: '.commentsFormNested',
    nestedCommentFormParentField: '.commentsFormNested input.parent_id',

    balloon: '#balloon',
    balloonText: '#balloon_text'
};

// Sortables
swapShades = function(object) {
    if (object.hasClass('active')) {
        object.removeClass('active');
        object.hide();
        object.slideDown('slow');
    } else {
        object.addClass('active');
        object.hide();
        object.fadeIn('slow');
    }
}

sortLinksSwitch = function(obj) {
    $(places.sortLinksAll).removeClass('active');
    $(obj).addClass('active');
};

$(document).ready(function() {
    elements.currentLines = countMaxLines();

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
                $(itemSelector).find('.comments_list').hide();
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


    $('.shade').live("click", function(e) {
        swapShades($(this));
    });

    $(places.sortLink).live("click", function(e) {
        e.preventDefault();
        swapShades($(this).parents('.shade'));
        return false;
    });

    $('.shade .arrowSort').live("click", function(e) {
        e.preventDefault();

        var currentIndex = 0;
        var length = elements.sortables.length;

        for (var i = 0; i < length; i++) {
            if ($('.shade a.' + elements.sortables[i]).hasClass('active')) {
                currentIndex = i;
            }
        }

        if ($(this).hasClass('up')) currentIndex -= 1;
        else currentIndex += 1;

        if (currentIndex < 0) currentIndex = length - 1;
        if (currentIndex >= length) currentIndex = 0;

        var object = $('.shade a.' + elements.sortables[currentIndex]);
        $(places.sortType).val(object.attr('data-type'));
        $(places.sortDirection).val(object.attr('data-dir'));
        sortLinksSwitch(object);

        $('#itemsForm').submit();
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
        //form.show();

        var formHtml = form.get(0).outerHTML;
        parentItem.find(places.nestedCommentForm).remove();

        $(this).after(formHtml);

        var clicked = parentItem.find(places.nestedCommentForm);
        console.log(clicked.css('opacity'));
        if (clicked.css("opacity") == "1") {
            clicked.hide().fadeIn('normal');
        } else {
            clicked.css("opacity", 1);
            clicked.show();
        }

        clicked.find('div.controls').show();
        clicked.find('div.captcha').hide();

        return false;
    });

    $('#createForm textarea').live('keydown', function() {
        var lines = $(this).val().split("\n");
        var currentCount = lines.length + 1;

        if (currentCount > elements.currentLines && currentCount < elements.maxLines ||
            currentCount < elements.currentLines && currentCount > elements.minLines) {
            var delta = currentCount - elements.currentLines;
            var deltaHeight = delta * parseInt($(this).css('line-height'));

            var currentHeight = parseInt($(this).css('height'));
            $(this).css('height', currentHeight + deltaHeight);

            elements.currentLines = currentCount;
        }

        if (currentCount > elements.maxLines) {
            $('a.scrollbar').fadeIn('slow');
        }
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

$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = this;
    });
}