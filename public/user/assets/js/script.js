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

window.gtranslateSettings = {
    default_language: "en",
    languages: [
        "en",
        "it",
        "es",
        "fr",
        "de",
        "nl",
        "da",
        "pt",
        "ar",
        "zh-CN",
        "ms",
        "cs",
        "sk",
        "hu",
        "bg",
        "pl",
        "ro",
        "hr",
        "sl",
        "sr",
        "bs",
    ],
    wrapper_selector: ".gtranslate_wrapper",
};

let cookies_modal;
window.addEventListener("load", () => {
    let translator =
        document.getElementsByClassName("gt-current-lang")[0].firstElementChild;
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
    // let modal_open_btn = document.getElementsByClassName("CustomModalSubs")[0];

    // setTimeout(() => {
    //     if (!getCookie("Item_showes")) {
    //         modal_open_btn.click();
    //         setSessionCookie("Item_showes", "YES");
    //     }
    // }, 5000);
});
