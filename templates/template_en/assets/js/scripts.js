/*
 *
 *   start Poolad project
 *   data 03/01/2014
 *   ui : omid khosrojerdi
 *
 */
$(document).ready(function(){
    var $body            = $('body'),
        windowWidth      = $(window).width(),
        windowHeight     = $(window).height(),
        $toggleSideBar   = $('#toggleSideBar'),
        $sideBar         = $('.side-left');

    /* ------ Responsive Menu ------*/
    $('#pbx-tel').click(function(){
       $('.menu-hidden').toggleClass('hidden');
    });

    /* ------ Responsive Menu ------*/
    $toggleSideBar.on('click',function(){
        if($(this).hasClass('is-active')) {
            $(this).removeClass('is-active');
            $('.side-overlay').removeClass('active');
            $sideBar.removeClass('active');
            $body.removeClass('active');
        } else {
            $(this).addClass('is-active');
            $('.side-overlay').addClass('active');
            $sideBar.addClass('active');
            $body.addClass('active');
        }
    });

    $('.side-overlay').on('click', function () {
        $sideBar.removeClass('active');
        $(this).removeClass('active');
        $toggleSideBar.removeClass('is-active');
        $body.removeClass('active');
     });


    $('.side-left .sidebar .hasMenu').on('click', function (e) {
        e.preventDefault();

        if($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
            $(this).parent().find('.sidebar-child').first().removeClass('active');
        } else {
            $(this).parent().addClass('active');
            $(this).parent().find('.sidebar-child').first().addClass('active');
        }
    });

    $('.side-left .sidebar .hasMenu2').on('click', function (e) {
        e.preventDefault();

        if($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
            $(this).parent().find('.sidebar-child').removeClass('active');
        } else {
            $(this).parent().addClass('active');
            $(this).parent().find('.sidebar-child').addClass('active');
        }
    });

     /*$sideBar.find('li').has('ul').each(function(){
            $(this).find('a:eq(0)').addClass('hasMenu');
            $(this).find('ul').removeClass('animated fadeInRight');
        });*/

        /*$body.on('click','.hasMenu',function(){
            $(this).parent().find('ul').toggleClass('active');
        });*/

    /* ------ Check All ------*/
    $('label[for="checkAll"]').bind('click',function(){
        var input = $(this).find('input[id="checkAll"]');

        if(input.prop("checked")) {
            input.prop("checked",true);

            $('.companyTable tbody tr td:first-child input[type="checkbox"]').each(function(){
                $(this).prop("checked",true);
            });
        }else{
            input.prop("checked",false);

            $('.companyTable tbody tr td:first-child input[type="checkbox"]').each(function(){
                $(this).prop("checked",false);
            });
        }
    });

    //$('select').select2();

    /* ------ Recorder------*/
    // Utility method that will give audio formatted time
    getAudioTimeByDec = function(cTime,duration)
    {
        var duration = parseInt(duration),
            currentTime = parseInt(cTime),
            left = duration - currentTime, second, minute;
        second = (left % 60);
        minute = Math.floor(left / 60) % 60;
        second = second < 10 ? "0"+second : second;
        minute = minute < 10 ? "0"+minute : minute;
        return minute+":"+second;
    };

// Custom Audio Control using Jquery
    $("body").on("click",".audioControl", function(e)
    {
        var ID=$(this).attr("id");
        var progressArea = $("#audioProgress"+ID);
        var audioTimer = $("#audioTime"+ID);
        var audio = $("#audio"+ID);
        var audioCtrl = $(this);
        e.preventDefault();
        var R=$(this).attr('rel');
        if(R=='play')
        {
            $(this).removeClass('audioPlay').addClass('audioPause').attr("rel","pause");
            audio.trigger('play');
        }
        else
        {
            $(this).removeClass('audioPause').addClass('audioPlay').attr("rel","play");
            audio.trigger('pause');
        }

// Audio Event listener, its listens audio time update events and updates Progress area and Timer area
        audio.bind("timeupdate", function(e)
        {
            var audioDOM = audio.get(0);
            audioTimer.text(getAudioTimeByDec(audioDOM.currentTime,audioDOM.duration));
            var audioPos = (audioDOM.currentTime / audioDOM.duration) * 100;
            progressArea.css('width',audioPos+"%");
            if(audioPos=="100")
            {
                $("#"+ID).removeClass('audioPause').addClass('audioPlay').attr("rel","play");
                audio.trigger('pause');
            }
        });
// Custom Audio Control End
    });

    $("body").on('click','.recordOn',function()
    {
        $("#recordContainer").toggle();
    });
//Record Button
    $("#recordCircle").mousedown(function()
    {
        $(this).removeClass('startRecord').addClass('stopRecord');
        $("#recordContainer").removeClass('startContainer').addClass('stopContainer');
        $("#recordText").html("Stop");
        $.stopwatch.startTimer('sw'); // Stopwatch Start
        startRecording(this); // Audio Recording Start
    }).mouseup(function()
    {
        $.stopwatch.resetTimer(); // Stopwatch Reset
        $(this).removeClass('stopRecord').addClass('startRecord');
        $("#recordContainer").removeClass('stopContainer').addClass('startContainer');
        $("#recordText").html("Record");
        stopRecording(this); // Audio Recording Stop
    });

    var $profileNav = $body.find('.profile-nav.dropdown');
    $profileNav.on('click', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
        }
        else {
            $(this).addClass('open');
        }
    });

    $('.dropdown-toggle').dropdown();

    $body.on('keyup', '.search-task-items', function () {
        let val = $(this).val().toLowerCase(),
            boardItems = $body.find('.box-items');

        if (val === ''){
            boardItems.removeClass('hidden');
        } else {
            boardItems.each(function (){
                let text = $(this).text().toLowerCase();
                (text.indexOf(val) >= 0) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
            });
        }
    });
});