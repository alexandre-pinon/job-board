$(document).ready(function(){
    $('.modal').modal();
    $('.carousel').carousel();
    $('textarea#textarea').characterCounter();
    $('.short-description').dotdotdot({
        height: 165,
        fallbackToLetter: true,
        watch: true,
    });
    $('a.activator').click(function () {
        $(this).parent().parent().animate(
            {height: '500px'},
            'slow'
        );
    });
    $('.close-reveal').click(function () {
        $(this).parent().parent().animate(
            {height: '279.2px'},
            'slow'
        );
    });
});