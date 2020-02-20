$(document).ready(function(){
    $('.show-friends').click(function(){
        $('.modal-window').css('display', 'block');
        $('.close-friends-view').click(function(){
            $('.modal-window').css('display', 'none');
            console.log('aa');
        });
    });
});