$(document).ready(function () {
    $(document).click(function (e) {
        if (!$(e.target).parents('.popover').length > 0) {
            $('.member-info').each(function () {
                $(this).popover('hide');
            });
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
            $(this).popover('show');
            e.preventDefault();
            return false;
        });
    });
});