$(function(){
    var $window = $(window),
        windowWidth = $window.width();

    $.reject({
        reject : {
            msie: 9
        },
        imagePath: '/js/jReject/images/'
    });

    $('.local-link').localScroll({offset: 0, duration: 1000});

    $window.scroll(function(){
        if ($window.scrollTop() > 800) {
            $("#back-to-top").fadeIn(200);
        }
        else {
            $("#back-to-top").fadeOut(200);
        }
    });



    if (windowWidth >= 1201) {
        $('.parallax').each(function(){
            $(this).parallax("50%", 0.2);
        });
    }

    if (windowWidth > 767) {
        $('#header').sticky({});
    }

    if (!isMobile()) {

        $('.item-top').each(function() {
            var $self = $(this);

            $self.appear(function() {
                var delay = $self.data('appear-delay') || 150,
                    speed = $self.data('appear-speed') || 700;

                $self.delay(delay).animate({
                    opacity : 1,
                    top : "0px"
                }, speed);
            });
        });
        $('.item-bottom').each(function() {
            var $self = $(this);

            $self.appear(function() {
                var delay = $self.data('appear-delay') || 150;

                $self.delay(delay).animate({
                    opacity : 1,
                    bottom : "0px"
                }, 1000);
            });
        });
        $('.item-left').each(function() {
            var $self = $(this),
                accY = $self.data('appear-acc-y') || 0;

            $self.appear(function() {
                var delay = $self.data('appear-delay') || 150;

                $self.delay(delay).animate({
                    opacity : 1,
                    left : "0px"
                }, 1000);
            },
            {
                accY: accY
            });
        });
        $('.item-right').each(function() {
            var $self = $(this),
                accY = $self.data('appear-acc-y') || 0;

            $self.appear(function() {
                var delay = $self.data('appear-delay') || 150;

                $self.delay(delay).animate({
                    opacity : 1,
                    right : "0px"
                }, 1000);
            },
            {
                accY: accY
            });
        });
        $('.item-fade-in').each(function() {
            var $self = $(this);

            $self.appear(function() {
                var delay = $self.data('appear-delay') || 150;

                $self.delay(delay).animate({
                    opacity : 1
                }, 1000);
            });
        });

    }
});


function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}