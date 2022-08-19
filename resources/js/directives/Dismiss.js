function hideElement(el) {
    el.style.visibility = 'hidden';
}

function fadeElement(el, duration) {
    el.animate([{ opacity: 1 }, { opacity: 0 }], duration)
        .onfinish = () => hideElement(el);
}

function hideElementOnClick(el) {
    const listener = function clickHandler() {
        hideElement(el);
        el.removeEventListener('click', clickHandler);
    };

    el.addEventListener('click', listener);
}

export default {
    bind(el, binding) {
        setTimeout(() => fadeElement(el, 1000), binding.value);
        hideElementOnClick(el);
    },
}
