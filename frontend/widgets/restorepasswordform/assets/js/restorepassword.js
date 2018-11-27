
$(document).on("beforeSubmit", "#request-password-reset-form", function () {
    return false;
});

$(function() {
    $("#request-password-reset-form").on("submit", function(e) {
        e.preventDefault();

        if ($(this).find('.has-error').length)
        {
            return false;
        }

        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if(data['success'])
                    $('#system-messages').html('<div class="alert alert-success">'+data['message']+'</div>').fadeIn("slow", function() {$('#system-messages').delay(5000).fadeOut("slow")});
                else
                    $("#system-messages").html('');
            }
        });
    });
});