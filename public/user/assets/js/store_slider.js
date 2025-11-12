new Splide("#mySplide", {
    type: "loop",
    perPage: 3,
    focus: "center",
    autoplay: false,
    interval: 3000,
    padding: "10%",
    arrows: false,
    updateOnMove: true,
    classes: {
        pagination: "splide__pagination top-100 mt-4",
    },
    breakpoints: {
        1440: {
            perPage: 1,
            padding: "30%",
        },
        1024: {
            perPage: 1,
            padding: "25%",
        },
        768: {
            perPage: 1,
            padding: "10%",
        },
        576: {
            perPage: 1,
            padding: 0,
        },
    },
}).mount();