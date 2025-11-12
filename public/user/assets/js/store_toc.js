const scrollSpyEl = document.querySelector('.scrollspy-main');
let headingText = '';
scrollSpyEl.addEventListener('activate.bs.scrollspy', () => {
    const activeLink = document.querySelector('#list-scrollspy .active');
    if (activeLink) {
        const headingId = activeLink.getAttribute('href');
        const activeHeading = document.querySelector(headingId);
        if (activeHeading) {
            headingText = activeHeading.textContent
            //console.log(headingText);
        }
    }
});
var el = document.getElementById('tableContent');
let accordian = document.getElementById('collapseOne');
accordian.classList.remove('show');
let accordianBTN = document.getElementById('accordianBTN');
document.addEventListener('scroll', () => {
    let b_top = el.getBoundingClientRect().top;
    if (window.innerWidth >= 992) {
        if (accordian.classList.contains('show') && b_top == 22) {
            accordianBTN.click();
        } else if (!accordian.classList.contains('show') && b_top > 22) {
            accordianBTN.click();
        }
        if (!accordian.classList.contains('show') && b_top <= 22) {
            accordianBTN.innerHTML = headingText
        } else {
            accordianBTN.innerHTML = 'Table of Content'
        }
    } else {
        if (window.scrollY > 250) {
            el.classList.remove("translator")
            accordian.classList.remove("show")
            //console.log("true");
            if (!accordian.classList.contains('show')) {
                accordianBTN.innerHTML = headingText
            } else {
                accordianBTN.innerHTML = 'Table of Content'
            }
        } else {
            // console.log("false");
            accordian.classList.remove("show")
            el.classList.add("translator");
        }
    }
});