$(document).ready(function(){
    var offset = Number($('#more-feeds').attr('data-offset'));
    $('#more-feeds').click(function(){
        var feedLine = $(document).find('.feed-line');
        var limit = Number($(this).attr('data-limit'));
        $.post('/site/more-feeds', {'offset':offset}, function(resp){
            var html = prepareHtml(resp);
            feedLine.append(html);
            offset =offset+limit;
            bindEventsToButtons(); 
        });
    });
}
);
function prepareHtml(data){
    var html ='';
    for(i = 0; i < data.length; i++){
        html +=         "<hr><article>"+
                            "<div class='feed-autor'><a href='/profile/"+getNickname(data[i])+"'><img src='"+data[i].autor_picture+"'>"+data[i].autor_name+"</a></div>"+
                            "<div class='feed-img'><img  src='/uploads/"+data[i].post_filename+"'><br></div>"+
                            data[i].post_description+
                            "<div>"+data[i].created_at+"</div>"+
                                "<div><p class='likes fa fa-heart'>"+data[i].count_likes+"</p>"+
                                buttonLike(data[i])+
                                buttonDislike(data[i])+
                                buttonReport(data[i])+
                            "</div>"+
                        "</article>";
    };
    return html;
}

function buttonLike(data){
    if(data.is_liked == 1){
        return "<a class='btn btn-primary button-like display-none' data-id='"+data.post_id+"'><i class='fa fa-thumbs-up'></i></a>";
    }
    return "<a class='btn btn-primary button-like' data-id='"+data.post_id+"'><i class='fa fa-thumbs-up'></i></a>";
}
function buttonDislike(data){
    if(data.is_liked == 1){
        return "<a class='btn btn-primary button-dislike' data-id='"+data.post_id+"'><i class='fa fa-thumbs-down'></i></a>";
    }
    return "<a class='btn btn-primary button-dislike display-none' data-id='"+data.post_id+"'><i class='fa fa-thumbs-down'></i></a>";
}
function buttonReport(data){
    if(data.is_reported == 1){
        return "<a class='btn btn-default button-report disabled' data-id='"+data.post_id+"'> пожаловаться</a><i class='fa fa-cog fa-spin fa-fw icon-spinner' style='display:none'></i>";
    }
    return "<a class='btn btn-default button-report' data-id='"+data.post_id+"'> пожаловаться</a><i class='fa fa-cog fa-spin fa-fw icon-spinner' style='display:none'></i>";
}

function bindEventsToButtons(){
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
}
function getNickname(data){
    if(data.autor_nickname !== undefined){
        return data.autor_nickname;
    }
    return data.autor_id;
}