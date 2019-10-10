$(document).ready(function(){
    $('.button-like').click(function(){
        var params = {
            'id': $(this).attr('data-id')
        };
        var button = $(this);
        $.post('/post/default/like',params, function(data){
            button.siblings('.likes').html(data);
            button.addClass('display-none');
            button.siblings('.button-dislike').removeClass('display-none');
        });
        return false;
    });
    $('.button-dislike').click(function(){
        var params = {
            'id': $(this).attr('data-id')
        };
        var button = $(this);
        $.post('/post/default/dislike',params, function(data){
            button.siblings('.likes').html(data);
            button.addClass('display-none');
            button.siblings('.button-like').removeClass('display-none');
        });
        return false;
    });
});