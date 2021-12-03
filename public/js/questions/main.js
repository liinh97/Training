$(function(){
    
    setAjaxHeader();

    // New input for anwser
    $('#btn-new-input').on('click', function(){
        $('.anwser-list').append('<div class="anwser-new-group"><input class="anwser-item" type="text"><button type="button" class="remove-input">x</button></div>');

        // Remove input
        $('.remove-input').on('click', function(){
            $(this).parent().remove();
        });
    });

    // Check store or update
    const questionID = $('#id-question').val();
    let url;
    let method;
    if(questionID == undefined){
        url = '/admin/questions';
        method = 'POST';
    }else{
        url = '/admin/questions/' + questionID;
        method = 'PUT';
    }

    // Form post
    $('#question-create').on('submit', function(e){
        e.preventDefault();

        const title = $('#question-title').val();
        const type_checkbox = $('#selection-type').val();
        const require = $('input[name=require]:checked').val();
        const more = $('input[name=more]:checked').val();
        const anwserItem = $('.anwser-item');
        const anwsers = [];
        
        // Push list input to array for post
        anwserItem.map(function(){
            if(this.value != ''){
                anwsers.push(this.value);
            }
        });

        $.ajax({
            type: method,
            url: url,
            data: {title, type_checkbox, anwsers, require, more},
            success: function(response){
                console.log(response)
                if(!response.status){
                    if ('title' in response.mess){
                        $('#question_err_title').text(response.mess.title);
                    }else{
                        $('#question_err_title').text('');
                    }
                    if('anwsers' in response.mess){
                        $('#question_err_anwser').text(response.mess.anwsers);
                    }else{
                        $('#question_err_anwser').text('');
                    }
                }else{
                    window.location.href = "/admin/questions";
                }
            }
        })
    });

});