let e = document.getElementsByClassName('fixed-bottom-custom')[0];
let f = document.getElementsByTagName('footer')[0];
f.style.marginBottom = e.scrollHeight + 'px';
console.log(e.scrollHeight + 'px');

const getScrollThreshold = () => {
    const documentHeight = document.documentElement.scrollHeight;
    const windowHeight = window.innerHeight;
    return (documentHeight - windowHeight) * 0.5;
};

window.addEventListener('scroll', () => {
    const scrollThreshold = getScrollThreshold();

    if (window.scrollY > scrollThreshold) {
        e.classList.remove('translate');
    } else {
        e.classList.add('translate');

    }
});
let i = 0;
let j = 0;
let a = document.querySelectorAll('[data-csid1="true"]');
let b = document.querySelectorAll('[data-csid2="true"]');

function csid1(element) {
    element.setAttribute("data-bs-target", "#custom-" + j);
    element.setAttribute("aria-controls", "custom-" + j);
    j++;
}

function csid2(element) {
    element.id = `custom-${i}`;
    i++;
}

a.forEach(csid1);
b.forEach(csid2);
//data-coder-btn attribute
document.querySelectorAll('[data-coder-btn="show_code"]').forEach(button => {
    button.addEventListener('click', () => {
        // Find the sibling input with data-coder attribute
        const siblingInput = button.parentElement.querySelector('[data-coder="copy_coder"]');
        if (siblingInput) {
            // Copy the value to the clipboard
            navigator.clipboard.writeText(siblingInput.value)
                .then(() => {
                    alert("Code copied to clipboard!");
                })
                .catch(err => {
                    console.error("Failed to copy: ", err);
                });
        }
    });
});