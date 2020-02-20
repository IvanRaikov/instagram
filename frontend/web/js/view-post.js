$(document).ready(function(){
    $('.close-post-view').click(function(){
        $('.post-view').css('display','none');
    });
    
    $('.post-img').click(function(){
        var postView = $('.post-view');
        var postInfo = postView.find('.post-info');
        var id = $(this).attr('data-id');
        $.post('/post/'+id,{'id':id}, function(resp){
            postView.find('img').attr('src', '/uploads/'+resp.file_name);
            postInfo.find('.description').html(resp.description);
            postInfo.find('.likes').html(resp.count_likes);
            var buttonLike = postInfo.find('.button-like');
            var buttonDislike = postInfo.find('.button-dislike');
            var buttonReport = postInfo.find('.button-report');
            buttonLike.attr('data-id', id);
            buttonDislike.attr('data-id', id);
            buttonReport.attr('data-id', id);
            if(resp.is_liked_by == 1){
                buttonLike.addClass('display-none');
                buttonDislike.removeClass('display-none');
            }else{
                buttonDislike.addClass('display-none');
                buttonLike.removeClass('display-none');
            }
            if(resp.is_reported == 1){
                buttonReport.addClass('disabled');
            }else{
                buttonReport.removeClass('disabled');
            }
            console.log(resp);
            postView.css('display','block');
        });
        
//        
    });
});