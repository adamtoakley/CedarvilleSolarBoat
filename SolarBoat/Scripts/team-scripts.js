/// <reference path="solar-splash-main.js" />
$(document).ready(function () {
    $(document).click(function (e) {
        if (!$(e.target).parents('.popover').length > 0) {
            hideAllPopovers();
        }
    });

    $('.member-info').each(function () {
        var member = $(this);
        var content = member.find('.member').html();

        member.popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            content: content,
            trigger: 'manual'
        });
        
        member.click(function (e) {
            hideAllPopovers(this);
            stuff = $(this);
            stuff.popover('show');
            e.preventDefault();
            return false;
        });
    });

    function hideAllPopovers(target) {
        $('.member-info').each(function () {
            if (target != this) {
                $(this).popover('hide');
            }
        });
    }
});