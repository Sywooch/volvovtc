$(document).on('ready', function(){

    $('.button-collapse').sideNav({
        menuWidth: 300, // Default is 300
        closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true
    });
    $('.scrollspy').scrollSpy();
    $('select').material_select();
    $('.parallax').parallax();
    $('.modal').modal();
    $('.datepicker').pickadate({
        min: new Date(1950,1,1),
        max: new Date(2010,12,31),
       // today: 'Сегодня',
        today: false,
        clear: 'Очистить',
        close: 'Закрыть',
        monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 60, // Creates a dropdown of 15 years to control year
        firstDay: 'Понедельник',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true
    });
    $('.datepicker-convoy').pickadate({
        min: new Date(2015,1,1),
        today: 'Сегодня',
        clear: 'Очистить',
        close: 'Закрыть',
        monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 2, // Creates a dropdown of 15 years to control year
        firstDay: 'Понедельник',
        formatSubmit: 'yyyy-mm-dd',
        format: 'dd mmmm yyyy',
        hiddenName: true
    });

    $(document).on('change', '#fulfill, #read-rules', function(){
        if($('#fulfill')[0].checked && $('#read-rules')[0].checked){
            $('#recruit-btn').removeClass('disabled');
        }else{
            $('#recruit-btn').addClass('disabled');
        }
    });

    $(document).on('change', '#vacationform-vacation_undefined, #memberform-vacation_undefined', function(){
        if($('#vacationform-vacation_undefined, #memberform-vacation_undefined')[0].checked){
            $('#vacationform-to_date, #memberform-vacation').attr('readonly', true).val('');
        }else{
            $('#vacationform-to_date, #memberform-vacation').attr('readonly', false);
        }
    });

    $('.profile-img [type=file]').change(function(){
        if(this.files.length > 0){
            $('.profile-img').after('<div class="white-text save-img-profile text-shadow">' +
                '<i class="material-icons notranslate medium-small">refresh</i>' +
                '</div>');
        }else{
            $('.profile-img').find('.save-img-profile').remove();
        }
    });

    $('.bg-img [type=file]').change(function(){
        if(this.files.length > 0){
            $('.bg-img').after('<div class="white-text save-img-bg text-shadow">' +
                '<i class="material-icons notranslate medium">refresh</i>' +
                '</div>');
            $('.bg-img').find('i').hide();
        }else{
            $('.bg-img').find('.save-img-bg').remove();
        }
    });
    
    $(document).on('click', '.save-img-profile i', function(){
        var files = $('.profile-img [type=file]')[0].files;
        var data = new FormData();
        $.each(files, function(key, value){
            data.append(key, value);
        });
        $.ajax({
            url : window.location.href + '?ajax-action=upload-profile-img',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            beforeSend: function(){
                $('.profile-img').parent().find('.save-img-profile i').replaceWith('<div class="preloader-wrapper active preloader-profile">'+
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
                    $('.profile-img').attr('style', 'background-image: url('+response.path+'?t='+response.t+')');
                }
            },
            complete : function(){
                $('.profile-img').parent().find('.preloader-profile').remove();
                $('.profile-img [type=file]').val('');
            }
        });
    });

    $(document).on('click', '.save-img-bg i', function(){
        var files = $('.bg-img [type=file]')[0].files;
        var data = new FormData();
        $.each(files, function(key, value){
            data.append(key, value);
        });
        $.ajax({
            url : window.location.href + '?ajax-action=upload-bg-img',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            beforeSend: function(){
                $('.profile-img').parent().find('.save-img-bg i').replaceWith('<div class="preloader-wrapper active">'+
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
                    $('.card-image').attr('style', 'background-image: url('+response.path+'?t='+response.t+')');
                }
            },
            complete : function(){
                $('.bg-img').parent().find('.preloader-wrapper').remove();
                $('.bg-img').find('i').show();
                $('.bg-img [type=file]').val('');
            }
        });
    });

    $('.notification-btn').click(function(){
        $('.notification-list').toggleClass('active');
        if($('.unread-notification').length > 0){
            var id = [];
            $('.unread-notification').each(function(i, unread){
                id.push($(unread).data('id'));
            });
            $.ajax({
                url : window.location.protocol + '//' + window.location.host + '/notifications?ajax-action=mark_notifications',
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType: 'json',
                success : function(response){
                    if(response.status === 'OK'){
                        $('.new-notifications').remove();
                        $('.unread-notification').each(function(i, unread){
                            //$(unread).css('background-color', '#fff');
                            $(unread).removeClass('unread-notification');
                        });
                    }
                }
            });
        }
    });

    $(document).on('click', '*',function(e){
        e.stopPropagation();
        if(!$(this).parents().hasClass('notification-btn-item')) $('.notification-list').removeClass('active');
    });

    $('.clear-notification').click(function(){
        var notificationItem = $(this).parent();
        var id = notificationItem.data('id');
        $.ajax({
            url : window.location.protocol + '//' + window.location.host + '/notifications?ajax-action=delete_notification',
            type: 'POST',
            data: {id : id},
            cache: false,
            dataType: 'json',
            success : function(response){
                if(response.status === 'OK'){
                    notificationItem.find('.tooltipped').tooltip('remove');
                    notificationItem.remove();
                    if($('.notification-list > li').length == 0){
                        $('.notification-list').append('<li class="grey lighten-3">Нет уведомлений!</li>');
                    }
                }
            }
        });
    });

    $('#signupform-steam, #profileform-steam').change(function(){
        var regexp = new RegExp('^(https?:\/\/)?steamcommunity\.com\/(id|profiles)\/[^\/]*\/?$');
        if(regexp.test($(this).val())){
            $('#signupform-visible_truckersmp, #profileform-visible_truckersmp').attr('disabled', false);
            $.ajax({
                url : window.location.protocol + '//' + window.location.host + '/signup?ajax-action=get_truckersmpid',
                type: 'POST',
                data: {steam_url : $(this).val()},
                cache: false,
                dataType: 'json',
                success : function(response){
                    if(response.status === 'OK'){
                        $('#signupform-truckersmp, #profileform-truckersmp').val(response.url);
                        $('#signupform-steamid64, #profileform-steamid64').val(response.steamid);
                    }
                }
            });
        }else{
            $('#signupform-visible_truckersmp, #profileform-visible_truckersmp').attr('disabled', true);
        }
    });

    $('#signupform-visible_truckersmp, #profileform-visible_truckersmp').change(function(){
        //console.log($(this)[0].checked);
        $(this)[0].checked ? $('#signupform-truckersmp, #profileform-truckersmp').show() : $('#signupform-truckersmp, #profileform-truckersmp').hide();
    });

    $('.send-reset').click(function(e){
        var input = $('.modal').find('[type=email]');
        var email = input.val();
        if($(input).hasClass('valid')){
            $.ajax({
                url : window.location.protocol + '//' + window.location.host + '/login?ajax-action=reset_password',
                type: 'POST',
                data: {'email' : email},
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    $('.modal .preloader').append('<div class="preloader-wrapper active small">'+
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
                        $('.modal h4').html('Готово!');
                        $('.modal p').html('На указаный E-Mail было отправлено письмо с последующими инструкциями по сбросу пароля.');
                        $('.modal .input-field').hide();
                        $('.send-reset').hide();
                    }else{
                        $('.modal p').html('Произошла ошибка припопытке сброса пароля. Проверьте E-Mail или обратитесь к администратору.');
                    }
                },
                complete : function(){
                    $('.modal .preloader').find('.preloader-wrapper').remove();
                }
            });
        }
    });

    $(document).on('click', '.modal .modal-close, .modal-overlay', function(){
        $('.modal h4').html('Сброс пароля');
        $('.modal p').html('Укажите свой E-Mail, и мы отправим Вам ссылку для сброса пароля.');
        $('.send-reset').show();
        $('.modal .input-field').show();
       // $('#modal1').modal('close');
    });

});