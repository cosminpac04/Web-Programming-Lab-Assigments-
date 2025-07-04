$(document).ready(function() {
    const images = [
        'images/moto1.jpg',
        'images/moto2.jpg',
        'images/moto2.jpg',
        'images/moto1.jpg',
        'images/moto2.jpg',
        'images/moto1.jpg',
        'images/moto2.jpg',
        'images/moto1.jpg',
        'images/moto1.jpg',
        'images/moto2.jpg',
        'images/moto2.jpg',
        'images/moto1.jpg',
        'images/moto2.jpg',
        'images/moto1.jpg',
        'images/moto2.jpg',
        'images/moto1.jpg',
    ];

    let isSliding = true;
    const slideDuration = 1000;
    const $slider = $('.image-slider');
    let clickCount = parseInt(localStorage.getItem('sliderClickCount')) || 0;
    
    $('<div>')
        .addClass('click-counter')
        .text('Clicks: ' + clickCount)
        .appendTo('body');

    images.forEach(src => {
        $('<img>')
            .addClass('slider-img')
            .attr('src', src)
            .appendTo($slider);
    });

   //s $('.slider-img').clone().appendTo($slider);

    function slide() {
        if (!isSliding) return;

        const imageWidth = $('.slider-img').first().outerWidth(true);

        $slider.animate(
            { left: -imageWidth + 'px' },
            {
                duration: slideDuration,
                easing: 'linear',
                complete: function() {
                    $slider.find('.slider-img').first().appendTo($slider);
                    $slider.css('left', '0');
                    if (isSliding) slide();
                }
            }
        );
    }

    setTimeout(slide, 1000);

    $('.image-slider').on('click', '.slider-img', function() {
        isSliding = false;
        $slider.stop();
        $('.lightbox-img').attr('src', $(this).attr('src'));
        $('.lightbox').addClass('active');
        
        clickCount++;
        localStorage.setItem('sliderClickCount', clickCount);
        $('.click-counter').text('Clicks: ' + clickCount);
    });

    $('.lightbox').on('click', function() {
        $(this).removeClass('active');
        isSliding = true;
        slide();
    });


});
