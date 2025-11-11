$(function() {
    var $forms = $('.g-recaptcha').parents('form');

    $forms.each(function(){
        var $this = $(this),
            $submit = $this.find('input[type=submit]');

        if($this.hasClass('no-ajax')) return;

        $submit.on('click', function(){
            var $form = $(this).parents('form'),
                formId = $form.attr('id'),
                formData = $form.serialize(),
                widgetId = getWidgetId($form);

            sendAjaxForm(
                $form.attr('action'),
                formData +'&ajax='+formId,

                function(data) {
                    if(data.hasOwnProperty('length')) {
                        grecaptcha.execute(widgetId);
                    }
                    else {
                        showErrors($form, data);
                    }
                }
            );
            return false;
        });
    });
});


function onCaptchaSubmit(token, $form){
    var formData = $form.serialize(),
        widgetId = getWidgetId($form);

    sendAjaxForm(
        $form.attr('action'),
        formData,

        function(data) {
            grecaptcha.reset(widgetId);

            if(data.status=="success") {
                $form[0].reset();

                $("#myModal").modal("show");
            }
            else {
                showErrors($form, data);
            }
        }
    );
}
function onRecaptchaLoad(){
    $(".g-recaptcha").each(function() {
        var $container = $(this),
            $form = $container.parents('form'),

            widgetId = grecaptcha.render($container[0], {
                callback: function(token) {
                    onCaptchaSubmit(token, $form);
                }
            }, true);
        $container.data('widget-id', widgetId);
    });
}


function getWidgetId($form){
    return $form.find('.g-recaptcha').data('widget-id');
}
function showErrors($form, data){
    $.each(data, function(key, val) {
        var $parent = $form.find("#"+key).parent(),
            $error = $form.find("#"+key+"_em_");

        $parent.addClass("error");
        $error.text(val).show();
    });
}
function sendAjaxForm(url, data, onSuccess){
    $.ajax({
        'dataType': 'json',
        'type': 'POST',
        'url': url,
        'cache': false,
        'data': data,

        'success': onSuccess
    });
}


