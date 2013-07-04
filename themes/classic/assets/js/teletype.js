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