$(document).ready(function() {
    var splideSlider  = null ;
    var splide = null;
    $('.closeBtnMobile').on('click', function(){
        $('.main-container').hide();
        $('.slide_video').each(function() {
             this.autoplay = false;
            $(this).closest('.splide__slide').find('i').removeClass('bx-volume-mute').addClass('bx-volume-full');
            this.loop = false;
            this.pause();
        });
        splide.destroy();
    });

$(document).on('click', '.toggle-audio-mobile', function(e) {
    e.preventDefault();
    let video = $(this).closest('.splide__slide').find('.slide_video');

    if ($(this).find('i').hasClass('bx-volume-full')) {
        $(video).prop('muted', true);
        $(this).find('i').removeClass('bx-volume-full').addClass('bx-volume-mute');

    } else {
       $(video).prop('muted', false);
        $(this).find('i').removeClass('bx-volume-mute').addClass('bx-volume-full');
    }
});


$('.video').on('click', function() {
    let id  = $(this).data('id');
    localStorage.setItem('slider_id' , id);
    let widthofcurrentScreen = window.innerWidth;
    if(widthofcurrentScreen <= 900){
        $('.main-container').show();
         $('.slide_video').each(function() {
            if ($(this).data('id') === id) {
                const videoSlider = $(this)[0];
                if (videoSlider) {
                    videoSlider.autoplay = true;
                    videoSlider.loop = true;
                    videoSlider.play();
                }
            }
        });
        initMobileSplide(id)
    }
    else{
        $('.videoslider').show();
        $('.videoslider').addClass('d-flex');
        
        let id = $(this).data('id');
         $('.video-slider').each(function() {
            this.autoplay = false;
            this.loop = false;
            this.pause()
            this.currentTime = 0;
            const videoElement = $(this);
            const src = videoElement.attr('src');
            videoElement.attr('src', '');
            videoElement.attr('src', src)
          });
        $('.video-slider').each(function() {
            if ($(this).data('id') === id) {
                const videoSlider = $(this)[0];
                if (videoSlider) {
                    videoSlider.autoplay = true;
                    videoSlider.loop = true;
                    videoSlider.play();
                }
            }
        });
        initSplideDesktop(id)
    }


});

function initMobileSplide(id = null) {
    if (splide) {
        splide.destroy();
    }

    splide = new Splide('.slider-container', {
        direction: 'ttb',
        height: '100vh',
        width: '500px',
        wheel: true,
        arrows: false,
    });

    let activeVideo = null;
    splide.on('moved', function(newIndex) {
        $('.slide_video').each(function() {
            this.pause();
            this.currentTime = 0;
        });
        const newActiveSlide = $('.splide__slide').eq(newIndex);
        activeVideo = newActiveSlide.find('.slide_video');

        $('.slide_video').each(function(){
            let videoIndex = $(this).data('id');
            if(videoIndex == newIndex){
                activeVideo = $(this);
            }
        })
       
        if (activeVideo.length) {
            $(activeVideo[0]).prop('muted', false);
            $(activeVideo[0]).closest('.splide__slide').find('i').removeClass('bx-volume-mute').addClass('bx-volume-full');
            activeVideo[0].autoplay = true;
            activeVideo[0].loop = true;
            activeVideo[0].play();
        }
    });

    splide.mount();
    splide.go(id ?? 0);

    if (activeVideo && activeVideo.length) {
        $(activeVideo[0]).prop('muted', false);
        activeVideo[0].autoplay = true;
        activeVideo[0].loop = true;
        activeVideo[0].play();
    }
}



let spliderSlides = $(document).find('.video-slider') ;
            $(spliderSlides).on('click', function(){
                let index = $(this).data('id');
                splideSlider.go(index);
            })
            $('.closeBtn').on('click', function(){
                $('.videoslider').removeClass('d-flex')
                $('.videoslider').hide();
                $('.video-slider').each(function() {
                    this.autoplay = false;
                    this.loop = false;
                    this.pause();
                    this.currentTime = 0;
                    const videoElement = $(this);
                    const src = videoElement.attr('src');
                    videoElement.attr('src', '');
                    videoElement.attr('src', src)
                });

                splideSlider.destroy();
            })
            function initSplideDesktop(id , index){

            if(splideSlider != null){
                splideSlider.destroy();
            }
            splideSlider =  new Splide('#videoSlider', {
                    type: 'slide',
                    perPage: 3,
                    start:id,
                    speed: 500,
                    focus: 'center',
                    trimSpace: false,
                    updateOnMove: 1,
                    classes: {
                        pagination: "splide__pagination mt-4 p-3 top-100"
                    },
                    breakpoints: {
                    600:{

                        trimSpace:true,
                        focus: -.15,
                        perPage: 2,
                    },
                    850:{
                        perPage: 2,
                    },
                    1200: {
                        perPage: 3,
                    },
                },
                }).mount();
                 splideSlider.on('move', function(newIndex) {

                $('.video-slider').each(function() {
                    this.autoplay = false;
                    this.loop = false;
                    this.currentTime = 0;
                    this.pause();
                    const videoElement = $(this);
                    const src = videoElement.attr('src');
                    videoElement.attr('src', '');
                    videoElement.attr('src', src)
                });

                // Get active slide video
                const activeSlide = $('.splide__slide.is-active');
                const activeVideo = activeSlide.find('.video-slider')[0];

                if (activeVideo) {
                    activeVideo.autoplay = true;
                    activeVideo.loop = true;
                    activeVideo.play();
                }
            });
              }

           })
        $(document).on('click', '.toggle-audio', function(e) {
        e.preventDefault();
        let video = $(this).closest('.videoDiv').find('video');

        if ($(this).find('i').hasClass('bx-volume-full')) {
            $(video).prop('muted', true);
            $(this).find('i').removeClass('bx-volume-full').addClass('bx-volume-mute');

        } else {
           $(video).prop('muted', false);
            $(this).find('i').removeClass('bx-volume-mute').addClass('bx-volume-full');
        }});
