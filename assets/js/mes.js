setTimeout(function() {
    var messages = document.querySelectorAll('#mes');
    messages.forEach(function(message) {
        message.remove();
    });
}, 3000);