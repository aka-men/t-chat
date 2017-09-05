/**
 * Created by abdelhak on 04/09/2017.
 */


$(document).ready(function(){

    $("body").on('keydown','#contenu',function(e){
        if(e.keyCode === 13){
            e.preventDefault();
            if($("#contenu").val().length > 0)
                $(this).closest('form').submit();
        }
    });

    $("body").on('submit','#formMsg',function(e){
       e.preventDefault();
       $this = $(this);
       $.post(
           $this.attr('action'),
           $this.serialize(),
           function(json){
               if(json.code === 1){
                   $("#contenu").val('');
                   refreshMsgList();
               }
               else if(json.code === 0)
                   alert("Une erreur est survenue lors de l'envoie du message !!");
           },
           'JSON'
       ).fail(function(){
           alert('Une erreur s\'est produite dans l\'application !!');
       });
    });

    setInterval(refreshMsgList,5000);

    function refreshMsgList() {
       var lastShown = parseInt($("#msgs").find('p:last').data('id'));
       if(isNaN(lastShown))
           lastShown = 0;
       console.log(lastShown);
       $.get(
           $("#msgs").data('url'),
           {'lastShown':lastShown},
           function(json){
               if(json.code === 1){
                  $.each(json.messages,function(index,msg){
                     var paragraphe = '<p data-id="'+msg['id']+'"><span title="'+msg['date']+'" class="username label label-success">'+msg['user']+'</span><span class="msg">'+msg['contenu']+'</span></p>';
                     $("#msgs").append(paragraphe);
                     scrollBottom();
                  });
               }
           },
           'JSON'
       ).fail(function(){
           alert('Une erreur s\'est produite dans l\'application !!');
       });
    }

    function scrollBottom() {
        var elm    = $('#msgs');
        var height = elm[0].scrollHeight;
        elm.scrollTop(height);
    }

    scrollBottom();

    setInterval(getUsersConnected,30000);

    function getUsersConnected(){
        $.get(
            $("#usersConnected").data('url'),
            {},
            function(json){
                $("#usersConnected").empty();
                if (json.code === 1){
                    $.each(json.users,function(index,value){
                        $("#usersConnected").append('<li class="list-group-item list-group-item-info">'+value+'</li>');
                    });
                }
            },
            'JSON'
        ).fail(function(){
            alert('Une erreur s\'est produite dans l\'application !!');
        });
    }
});