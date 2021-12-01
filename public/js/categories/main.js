$(function(){

    setAjaxHeader();
    
    // Form post
    $('#category-post').on('submit', function(e){
        e.preventDefault();
        const public = 1;
        const private = 2;
        const title = $('#category-title').val();
        const type = $('#public').is(':checked') ? public : private;
        const checkbox = $(".list_questions");
        const questions = [];
        
        // Push list input to array for post
        checkbox.map(function() {
            this.checked ? questions.push(this.value) : '';
            return questions;
        });

        // Check store or update
        const categoryId = $('#id-category').val();
        let url;
        let method;
        if(categoryId == undefined){
            url = '/admin/categories';
            method = 'POST';
        }else{
            url = '/admin/categories/' + categoryId;
            method = 'PUT';
        }

        $.ajax({
            type: method,
            url: url,
            data: {title, type, questions},
            success: function(response){
                if(!response.status){
                    if ('title' in response.mess){
                        $('#category_err_title').text(response.mess.title);
                    }else{
                        $('#category_err_title').text('');
                    }
                    if('questions' in response.mess){
                        $('#category_err_checkbox').text(response.mess.questions);
                    }else{
                        $('#category_err_checkbox').text('');
                    }
                }else{
                    window.location.href = "/admin/categories";
                }
            }
        });
    });
});

