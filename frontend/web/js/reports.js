$(document).ready(function(){
    $('.button-report').click(function(){
        var button = $(this);
        var preloader = button.siblings('.icon-spinner');
        preloader.show();
        params = {'id':button.attr('data-id')};
        $.post('/post/default/complain', params, function(data){
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
});
