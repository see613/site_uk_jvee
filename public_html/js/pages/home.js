$(function(){
    let $servicesWrapper = $('.services'),
        $services = $servicesWrapper.find('.service');

    $('.welcome-slider .slider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 1000,
        dots: true,
        arrows: true,
        prevArrow: $('.welcome-slider .arrow-left'),
        nextArrow: $('.welcome-slider .arrow-right'),
        appendDots: $('.welcome-slider .slider-nav'),
        customPaging: function(slider, i) {
            return $('<span></span>');
        },
        fade: true
    });

    $('.reviews .slider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 1000,
        dots: true,
        arrows: false,
        appendDots: $('.reviews .slider-nav'),
        customPaging: function(slider, i) {
            return $('<span></span>');
        }
    });

    $services.each(function(i){
        let $this = $(this);

        gsap.to($this, {
            scrollTrigger: {
                trigger: $this,
                start: 'center 35%+=' + 15*i + 'px',
                end: () => "+="+ ($services.last().outerHeight(true) * ($services.length - i - 1)) +"px",
                pin: true,
                pinSpacing: false,
                scrub: true
            },
            duration: 1
        })
    })



});


