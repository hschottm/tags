'use strict';

(() => {
    function setExpanded(button, expanded) {
        const list = document.getElementById(button.getAttribute('aria-controls'));
        if (!list) return;
        list.hidden = !expanded;
        button.setAttribute('aria-expanded', String(expanded));
        button.classList.toggle('yes', !expanded);
    }
    function initialize() {
        document.querySelectorAll('[data-tagcloud-toggle]').forEach(button => {
            setExpanded(button, button.dataset.expanded === '1');
        });
    }
    document.addEventListener('click', event => {
        const button = event.target.closest('[data-tagcloud-toggle]');
        if (button) setExpanded(button, button.getAttribute('aria-expanded') !== 'true');
    });
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize);
    else initialize();
})();
