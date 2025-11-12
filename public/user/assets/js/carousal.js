 var splide = new Splide('.splide', {
            type: 'loop',
            padding: '21rem',
            gap: '1.6rem',
            width: '100vw',
            pagination: false,
            breakpoints: {
                600: {
                    padding: '0.5rem',
                    gap: '5rem',
                },
                1000: {
                    padding: '1rem',
                    gap: '5rem',
                },
                1200: {
                    padding: '2rem',
                    gap: '5rem',
                },
                1300: {
                    padding: '2rem',
                    gap: '5rem',
                },
            },
        });

        splide.mount();
