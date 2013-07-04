$(document).ready(function() {
    $('#companion').click(function(){
        var displayFlag = ($('#balloon').css('display') == 'none');

        $('#balloon').toggle(displayFlag);

        if (displayFlag) {
            $('#balloon_text').teletype({
                text: teletypeText
            });
        }

    });

    $('#balloon_text').teletype({
        text: teletypeText
    });
});