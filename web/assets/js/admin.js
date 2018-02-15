$(document).ready(function(){

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
                uploader.parent().find('i').replaceWith(getPreloaderHtml());
            },
            success: function(response){
                if(response.status === 'OK'){
                    uploader.parent().attr('style', 'background-image: url('+response.file.path+'?t='+response.t+')');
                    uploader.after('<input type="hidden" name="picture[]" value="'+response.file.name+'">');
                }
            },
            complete : function(){
                uploader.parent().find('.preloader-wrapper').replaceWith('<i class="material-icons notranslate medium red-text text-shadow">clear</i>');
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

    $(document).on('change', '[id*=trailer-select-]', function(){
        var id = $(this).val();
        var target = $(this).data('target');
        if(target === 'mods'){
            $('#addmodform-picture').attr('value', '');
            $('#addmodform-picture').parent().parent().parent().find('input[type=text]').val('');
        }
        if(id !== '0' && id !== '-1'){
            renderTrailersPreview(target);
        }else{
            $('.trailer-preview img').attr('src', '/images/'+target+'/default.jpg');
            $('#trailer-description').html('');
            if(target === 'mods') $('#trailer-name').html('');
            else $('#trailer-name').html(id === '0' ? 'Любой прицеп' : 'Без прицепа');
        }
    });

    $('#addconvoyform-picture_full').change(function(){
		this.files[0].size > 2500000 ? $('.picture-small').show() : $('.picture-small').hide().find('[type=file]').val('');
    });

    $('#addmodform-picture, #trailersform-picture, #achievementsform-image, #addconvoyform-picture_full').change(function(){
        $('#trailer-description').html('');
        $('#trailer-name').html('');
        $('#trailer-select').val('0').trigger("change");
        readURL(this);
    });

    $('.action-dropdown-button').click(function(){
        $('.action-dropdown').not('#action-dropdown-'+$(this).data('id')).removeClass('active');
        var list = $('#action-dropdown-'+$(this).data('id'));
        $(list).hasClass('active') ? $(list).removeClass('active') : $(list).addClass('active');
    });

    $('button.add-trailer').click(function(e){
        e.preventDefault();
        if($('.row.inner').length < 4){
            var row = $('.row.inner').last();
            var select = $(row).find('select').clone().removeClass('select2-hidden-accessible');
            select.find('option[value=0], option[value=-1]').remove();
            var id = parseInt(select.attr('id').substring(15)) + 1;
            var selectHtml = select.attr('id', 'trailer-select-' + id).attr('name', 'AddConvoyForm[trailer][' + id + ']').wrap('<p/>').parent().html();
            row.after('<div class="row inner">' +
                '<div class="col l11 s10" style="padding-bottom: 20px;">' + selectHtml + '</div>' +
                '<div class="col l1 s2 center" style="line-height: 44px;">' +
                '<button class="red-text remove-trailer">' +
                '<i class="material-icons notranslate small">clear</i></button></div></div>');
            $('#trailer-select-' + id).select2();
            if($('.row.inner').length >= 4) $(this).hide();
            renderTrailersPreview('trailers');
        }
    });

    $(document).on('click', '.remove-trailer, .remove-trailer i', function(){
        $(this).parents('.row.inner').first().remove();
        $(this).parents('.tooltipped').tooltip('remove');
        if($('.row.inner').length < 4) $('button.add-trailer').show();
        renderTrailersPreview('trailers');
    });

}); // end of document ready

function readURL(input) {
    if (input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#trailer-image, #preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function renderTrailersPreview(target){
    var trailers = [];
    $.each($('.trailers-select'), function(i, select){
        trailers.push(select.value);
    });
    var info = $('#trailer-info');
    $.ajax({
        cache: false,
        dataType : 'json',
        type : 'POST',
        url : '/trailers/getinfo',
        data : {
            trailers : trailers
        },
        beforeSend : function(){
            info.animate({opacity : 0.5}, 300, function(){
                info.append('<div class="preloader-wrapper active">'+
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
            });
        },
        success : function(response){
            if(response.status == 'OK'){
                if(target == 'mods'){
                    $('#trailer-name').html(response.trailers[0].name);
                    $('#trailer-description').html(response.trailers[0].description);
                    $('#trailer-image').attr('src', '/images/trailers/'+response.trailers[0].picture);
                }else{
                    var cols = '12';
                    switch(response.trailers.length){
                        case 4 : cols = '6'; break;
                        case 3 : cols = '4'; break;
                        case 2 : cols = '6'; break;
                        case 1 :
                        default : cols = '12'; break;
                    }
                    info.find('.trailer-preview, .clearfix').remove();
                    $.each(response.trailers, function(i, trailer){
                        info.append('<div class="trailer-preview col s'+cols+'">'+
                            '<img src="/images/trailers/'+trailer.picture+'" class="responsive-img z-depth-2 materialboxed" id="trailer-image-'+i+'">'+
                            '</div>');
                    });
                    $('.materialboxed').materialbox();
                    info.append('<div class="clearfix">');
                }
            }
        },
        complete : function(){
            info.animate({opacity : 1}, 300, function(){
                info.find('.preloader-wrapper').remove();
            });
        }
    });
}

function loadMembersBans(steamid64){
    $.ajax({
        cache: false,
        dataType : 'json',
        type : 'POST',
        url : '/members/getbans',
        data : {
            steamid64 : steamid64
        },
        beforeSend : function(){
            Materialize.toast('Загружаем баны...', 3000);
            $('th.first').append('<div class="preloader-wrapper tiny active">'+
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
            if(response.status == 'OK'){
                var countBans = 0;
                $.each(response.bans, function(uid, banned){
                    if(banned == true){
                        $('tr[data-uid='+uid+']').removeClass('yellow lighten-4').addClass('red lighten-4');
                        countBans++;
                    }
                });
                if(countBans == 0){
                    Materialize.toast('Банов не найдено', 6000);
                }else if(countBans == 1){
                    Materialize.toast('Найден 1 бан!', 6000);
                }else if(countBans >= 2 && countBans <= 4){
                    Materialize.toast('Найдено '+countBans+' бана!!', 6000);
                }else{
                    Materialize.toast('Найдено '+countBans+' банов!!!', 6000);
                }
            }
        },
        error : function(jqXHR, error){
            $('th.first').find('.preloader-wrapper').remove();
            console.log(error);
        },
        complete : function(){
            $('th.first').find('.preloader-wrapper').remove();
        }
    });
} // end of loadMembersBans