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
    $('#step4').modal('open');
    $.extend($.fn.pickadate.defaults, {
        clear: 'Очистить',
        close: 'Закрыть',
        today: 'Сегодня',
        monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        selectMonths: true,
        selectYears: 70,
        firstDay: 'Понедельник',
        formatSubmit: 'yyyy-mm-dd',
        format: 'dd mmmm yyyy',
        hiddenName: true
    });
    $('.datepicker-profile').pickadate({
        min: new Date(1950,1,1),
        max: new Date(2010,12,31),
        today: false
    });
    $('.datepicker-convoy').pickadate({
        min: -14,
        max: 365
    });
    $('.datepicker-member-start').pickadate({
        max: true,
        min: new Date(2015,1,6)
    });
    $('.datepicker-vacation').pickadate({
        min: true,
        max: 90
    });
	$('.datepicker-member-convoy').pickadate({
		max: 365,
		min: true,
		disable: [
			1, 3, 4, 6, 7
		]
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
                $('.profile-img').parent().find('.save-img-profile i').replaceWith(getPreloaderHtml('preloader-profile'));

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
                $('.profile-img').parent().find('.save-img-bg i').replaceWith(getPreloaderHtml());

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
        if(!$(this).parents().hasClass('achievement-action-dropdown-button')) $('.achievement-dropdown').removeClass('active');
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
                    $('.modal .preloader').append(getPreloaderHtml('small'))
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

    $(document).on('click', '.modal.reset-pwd .modal-close, .modal-overlay', function(){
        $('.modal .reset-pwd-title').html('Сброс пароля');
        $('.modal .reset-pwd-text').html('Укажите свой E-Mail, и мы отправим Вам ссылку для сброса пароля.');
        $('.send-reset').show();
        $('.modal .input-field').show();
       // $('#modal1').modal('close');
    });

    $('.get-achievement').click(function(){
        $('#get-ach').attr('data-achid', $(this).data('id'));
        $('.modal').find('.ach-modal-title').html($(this).data('title'));
    });

    $('#get-ach').click(function(){
        var button = $(this);
        var files = $(this).parents('.modal').find('[type=file]')[0].files;
        if(files.length == 1){
            var uid = $(this).data('uid');
            var achid = $(this).data('achid');
            var data = new FormData();
            $.each(files, function(key, value){
                data.append(key, value);
            });
            $.ajax({
                url : 'achievements/get?uid='+uid+'&achid='+achid,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Не обрабатываем файлы (Don't process the files)
                contentType: false, // Так jQuery скажет серверу что это строковой запрос
                beforeSend : function(){
                    button.replaceWith(getPreloaderHtml('tiny'));
                },
                success : function(response){
                    if(response.status == 'OK'){
                        Materialize.toast('Скриншот успешно оправлен на модерацию!', 6000);
                    }else{
                        Materialize.toast('Что-то пошло не так =(', 6000);
                    }
                },
                complete : function(){
                    $('.modal').modal('close');
                    $('.modal-footer').find('.preloader-wrapper').remove();
                    $('.modal').find('[type=file]').val('');
                    $('.modal').find('[type=text]').val('');
                }
            });
        }else{
            console.log('error');
        }
    });

    $('.convoy-participants button').click(function(){
        var button = $(this);
        var participate = button.data('participate');
        var userId = button.parents('.participate-btns').data('uid');
        var convoyId = button.parents('.participate-btns').data('cid');
        $.ajax({
            url : '/convoys/participants',
            type: 'POST',
            data: {
                participate : participate,
                user_id : userId,
                convoy_id : convoyId
            },
            cache: false,
            dataType: 'json',
            beforeSend : function(){
                button.css('opacity', '0.5').append(getPreloaderHtml('tiny', 'spinner-blue-only'));
            },
            success : function(response){
                if(response.status == 'OK'){
                    $('.participants-count').html(response.participants[100].length);
                    $('.participate-btns button').removeClass('disabled');
                    button.addClass('disabled');
                    if($('#modal').length){
                        console.log('true');
                    }
                }
            },
            complete : function(){
                button.css('opacity', '1');
                $('.participate-btns').find('.preloader-wrapper').remove();
            }
        });
    });

    $('#step4 a.modal-close').click(function(){
        console.log($('#step4 #accept')[0]);
        var uid = $(this).data('uid');
        var complete = $('#step4 #accept')[0].checked;
        $.ajax({
            url : '/members/step4',
            type: 'POST',
            data: {
                uid : uid,
                complete : complete
            },
            cache: false,
            dataType: 'json',
            beforeSend : function(){
                $('#step4').modal('close');
            },
            success : function(response){
                console.log(response);
            }
        });
    });

});

function getPreloaderHtml(preloaderClass, color){
    if(preloaderClass === undefined) preloaderClass = '';
    if(color === undefined) color = 'spinner-red-only';
    return '<div class="preloader-wrapper active '+preloaderClass+'">'+
        '<div class="spinner-layer '+color+'">'+
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
        '</div>';
}