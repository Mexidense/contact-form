$('#contactForm').submit(function(event) {
    var $nameForm = $('#name').val();
    var $emailForm = $('#email').val();
    var $serviceForm = $('#service').val();
    var $messageForm = $('#message').val();

    $.post('email.php', { name: $nameForm, email: $emailForm, service: $serviceForm, message: $messageForm}, function (data) {
            alert('Email sent to: ' + $emailForm)
        }, 'json')
        .fail(function (xhr, status, error) {
            alert('Error: Check form values please');
        });
});    
