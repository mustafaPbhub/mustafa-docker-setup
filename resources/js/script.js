function search(event) {
    const val = event.target;
    const searchResponse = val.nextElementSibling.classList;

    if (val.value.trim().length > 0) {
        if (searchResponse.contains("d-none")) {
            searchResponse.remove("d-none");
            setTimeout(() => {
                document.addEventListener(
                    "click",
                    (e) => {
                        if (
                            !val.nextElementSibling.contains(e.target) &&
                            e.target !== val
                        ) {
                            searchResponse.add("d-none");
                        }
                    },
                    { once: true }
                );
            }, 200);
        }
    } else {
        searchResponse.add("d-none");
    }
}

const searchInput = document.querySelector("input[type='search']");
searchInput.addEventListener("keyup", search);

window.gtranslateSettings = {"default_language":"en","languages":["en","it","es","fr","de","nl","da","pt","ar","zh-CN","ms","cs","sk","hu","bg","pl","ro","hr","sl","sr","bs"],"wrapper_selector":".gtranslate_wrapper"};

// let cookies_modal;
let modalTimeout;

// Function to open the custom modal with delay
function openCustomModalWithDelay() {
    clearTimeout(modalTimeout); // Clear any previous timeout to prevent multiple triggers

    modalTimeout = setTimeout(() => {
        let isAnyModalOpen = document.querySelector(".modal.show") !== null;

        if (!isAnyModalOpen && !getCookie("Item_showes")) {
            let modal_open_btn = document.getElementsByClassName("CustomModalSubs")[0];
            modal_open_btn.click();
            setSessionCookie("Item_showes", "YES");
        }
    }, 3000); // 3-second delay
}

// Page load event
window.addEventListener("load", () => {
    let translator = document.getElementsByClassName("gt-current-lang")[0].firstElementChild;
    translator.setAttribute("width", "33px");
    translator.setAttribute("height", "24.75px");

    // cookies_modal = document.getElementsByClassName("cookie-alert")[0];

    // if (
    //     !getCookie("consent") &&
    //     !getCookie("analyticsData") &&
    //     !getCookie("Rejected")
    // ) {
    //     cookies_modal.classList.add("show_cookie");
    // }

    // // Initial call to open modal with delay if no modal is open
    // openCustomModalWithDelay();

    // // Event listener for modal close
    // document.addEventListener("hidden.bs.modal", () => {
    //     // Call to open the custom modal after any other modal closes
    //     openCustomModalWithDelay();
    // });
});

// Functions for cookie handling remain unchanged


function readMore(ev) {
    const sect = document.getElementsByClassName("readMoreSection")[0];
    const fadeArea = document.getElementById("bgFade");

    sect.classList.remove("readMoreSection");
    fadeArea.classList.add("d-none");

    ev.parentElement.classList.add("d-none")
}

function changeText(e) {
    let change_vals = document.getElementById("change_value");
    change_vals.innerText = e.innerText;
    document.querySelectorAll(".changing_value").forEach((element) => {
        element.innerText = e.innerText;
    });
}

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


if(document.getElementById('bestSeller'))
{
    var splide = new Splide('#bestSeller', { 
        type: 'slide',
        padding: '0.75rem',
        perPage: 4,
        gap: '20px',
        arrows: false,
        trimSpace: false,
        pagination: false,
        rewind: false,  // Ensures no rewind in looping
        pagination: true,
        classes: {
            arrow: 'splide__arrow rounded-0 bg-primary-subtle custom-btn-04',
            pagination: 'splide__pagination splide__pagination--ltr top-100',
        },
        breakpoints: {
            991: {
                perPage: 3,
            },
            767: {
                perPage: 2,
            },
            575: {
                perPage: 2,
            },
            380: {
                perPage: 1,
                padding: 12,
            }
        }
    });
    splide.mount();
}
