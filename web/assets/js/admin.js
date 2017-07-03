$(document).ready(function(){

    $('.members-stat a[href="#modal1"]').click(function(){

        // get member data from table
        var memberId = $(this).data('id');
        var scoresTotal = $(this).attr('data-scores-total');
        var scoresMonth = $(this).attr('data-scores-month');
        var scoresOther = $(this).attr('data-scores-other');
        var nickname = $(this).data('nickname');
        var link = $(this).data('profile-link');
        var editLink = $(this).data('edit-profile-link');

        // set member data into modal
        $('#modal1').find('#nickname').html('[Volvo Trucks] ' + nickname);
        $('#modal1').find('#nickname').attr('href', link);
        $('#modal1').find('#edit-link').attr('href', editLink);
        $('#modal1').find('#other-scores').html(scoresOther);
        $('#modal1').find('#month-scores').html(scoresMonth);
        $('#modal1').find('#total-scores').html(scoresTotal);
        $('#modal1').find('button.add-scores').attr('data-id', memberId);
    });

    $('.add-scores').click(function(){
        if(!confirm('Добавить '+$(this).data('scores')+' баллов?')){
            return false;
        }
        var clicked = $(this);
        var button = $(this);
        var data = {
            id : $(this).attr('data-id'),
            scores : $(this).data('scores'),
            target: $(this).data('target')
        }
        $.ajax({
            cache: false,
            dataType : 'json',
            type : 'POST',
            data : data,
            beforeSend : function(){
                //console.log($(this));
                button.find('i').replaceWith('<div class="preloader-wrapper active preloader">'+
                                                    '<div class="spinner-layer spinner-red-only">'+
                                                        '<div class="circle-clipper left">'+
                                                            '<div class="circle"></div>'+
                                                        '</div>' +
                                                        '<div class="gap-patch">'+
                                                            '<div class="circle"></div>'+
                                                        '</div>' +
                                                        '<div class="circle-clipper right">'+
                                                            '<div class="circle"></div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>');
            },
            success : function(response){
                if(response.status === 'OK'){
                    $('#modal1').find('#other-scores').html(response.scores.other);
                    $('#modal1').find('#month-scores').html(response.scores.month);
                    $('#modal1').find('#total-scores').html(response.scores.total);
                    $('[data-scores-other-id="'+data.id+'"]').html(response.scores.other == '0' ? '' : response.scores.other);
                    $('[data-scores-month-id="'+data.id+'"]').html(response.scores.month == '0' ? '' : response.scores.month);
                    $('[data-scores-total-id="'+data.id+'"]').html(response.scores.total == '0' ? '' : response.scores.total);
                    $('[data-id="'+data.id+'"]').attr('data-scores-total', response.scores.total);
                    $('[data-id="'+data.id+'"]').attr('data-scores-month', response.scores.month);
                    $('[data-id="'+data.id+'"]').attr('data-scores-other', response.scores.other);
                }
            },
            complete : function(){
                button.find('.preloader').replaceWith('<i class="material-icons left">add</i>');
            }
        });
    });

    $(document).on('change', '.upload-item [type=file]', function(){
        var uploader = $(this);
        var newBlock = uploader.parent().parent().clone();
        var files = $(this)[0].files;
        var data = new FormData();
        $.each(files, function(key, value){
            data.append(key, value);
        });
        $.ajax({
            url : window.location.href + '?ajax-action=upload-news-img',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            beforeSend: function(){
                uploader.parent().find('i').replaceWith('<div class="preloader-wrapper active">'+
                                                            '<div class="spinner-layer spinner-red-only">'+
                                                                '<div class="circle-clipper left">'+
                                                                    '<div class="circle"></div>'+
                                                                '</div>' +
                                                                '<div class="gap-patch">'+
                                                                    '<div class="circle"></div>'+
                                                                '</div>' +
                                                                '<div class="circle-clipper right">'+
                                                                    '<div class="circle"></div>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>');
            },
            success: function(response){
                if(response.status === 'OK'){
                    uploader.parent().attr('style', 'background-image: url('+response.file.path+'?t='+response.t+')');
                    uploader.after('<input type="hidden" name="picture[]" value="'+response.file.name+'">');
                }
            },
            complete : function(){
                uploader.parent().find('.preloader-wrapper').replaceWith('<i class="material-icons medium red-text text-shadow">clear</i>');
                uploader.parent().addClass('delete-item');
                if($(document).find('[name^=picture]').length < 10){
                    uploader.parent().parent().after(newBlock);
                }
                uploader.remove();
            }
        });
    });

    $(document).on('click', '.delete-item', function(){
        if(confirm('Удалить изображение?')) $(this).parent().remove();
    });

    $('#trailer-select').change(function(){
        var id = $(this).val();
        var target = $(this).data('target');
        if(target == 'mods'){
            $('#addmodform-picture').attr('value', '');
            $('#addmodform-picture').parent().parent().parent().find('input[type=text]').val('');
        }
        if(id != '0' && id != '-1'){
            var info = $('#trailer-info');
            $.ajax({
                cache: false,
                dataType : 'json',
                type : 'POST',
                data : {
                    id : id,
                    action : 'get_trailer'
                },
                beforeSend : function(){
                    info.append('<div class="preloader-wrapper tiny active">'+
                        '<div class="spinner-layer spinner-blue-only">'+
                        '<div class="circle-clipper left">'+
                        '<div class="circle"></div>'+
                        '</div>' +
                        '<div class="gap-patch">'+
                        '<div class="circle"></div>'+
                        '</div>' +
                        '<div class="circle-clipper right">'+
                        '<div class="circle"></div>'+
                        '</div>'+
                        '</div>'+
                        '</div>');
                },
                success : function(response){
                    if(response.status == 'OK'){
                        info.find('#trailer-name').html(response.name);
                        info.find('#trailer-description').html(response.description);
                        info.find('#trailer-image').attr('src', '/images/trailers/'+response.image);
                    }
                },
                complete : function(){
                    info.find('.preloader-wrapper').remove();
                }
            });
        }else{
            $('#trailer-image').attr('src', '/images/'+target+'/default.jpg');
            $('#trailer-description').html('');
            if(target == 'mods') $('#trailer-name').html('');
            else $('#trailer-name').html(id == '0' ? 'Любой прицеп' : 'Без прицепа');
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#trailer-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#addmodform-picture').change(function(){
        $('#trailer-description').html('');
        $('#trailer-name').html('');
        $('#trailer-select').val('0').trigger("change");
        readURL(this);
    });

});