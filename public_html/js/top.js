
$(function() {
    var $topPicture = $('#top-slider');

    if($topPicture.length>0){
        $el = $topPicture;
        var ts = new TopSlider($el, $el.find('>.item'), 7000, 3500);
    }
});

function TopSlider($wrapper, $items, defaultDelay, speed){
    var z0 = -1, z1 = 0, z2 = 1,
        currentIndex = 0,
        timerId;

    init();

    function init(){
        initLoop();
    }

    function initLoop(){
        $firstItem().css({
            opacity: 1,
            zIndex: z1
        }).addClass('active');

        step();
    }

    function step(prev, delay, suppressEvent, stopAutoplay){
        timerId = setTimeout(function(){
            var nextIndex = !prev ? getNextIndex() : getPrevIndex(),
                $currentItem = $( $items[currentIndex] ),
                $nextItem = $( $items[nextIndex] ),
                callback = !stopAutoplay ? step : function(){};

            if(!suppressEvent){
                $wrapper.trigger('slider-animation-start', [currentIndex, nextIndex]);

                if(!prev){
                    $wrapper.trigger('slider-next');
                }
                else{
                    $wrapper.trigger('slider-prev');
                }
            }


            $currentItem.css({
                zIndex: z1
            });

            $nextItem.css({
                opacity: 0,
                zIndex: z2
            }).addClass('active')
                .animate({
                opacity: 1
            }, speed, function(){
                $currentItem.css({
                    zIndex: z0
                }).removeClass('active');
                $nextItem.css({
                    zIndex: z1
                });
                $wrapper.trigger('slider-animation-end', [currentIndex, nextIndex]);
                callback();
            });

            currentIndex = nextIndex;
        }, (delay !== undefined ? delay : defaultDelay));
    }

    this.next = function(){
        clearTimeout(timerId);
        step(false, 0, true, true);
    };

    this.prev = function(){
        clearTimeout(timerId);
        step(true, 0, true, true);
    };

    function getNextIndex(){
        var nextIndex = currentIndex + 1;

        return nextIndex < $items.length ? nextIndex : 0;
    }

    function getPrevIndex(){
        var prevIndex = currentIndex - 1;

        return prevIndex >= 0 ? prevIndex : $items.length-1;
    }

    function $firstItem(){
        return $( $items[0] );
    }
}
