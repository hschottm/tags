'use strict';

window.Tag = {
    selectedTag(tag, id) {
        const input = document.getElementById(id);
        if (!input) return;
        const tags = input.value.split(',').map(value => value.trim()).filter(Boolean);
        const selected = tags.some(value => value.toLocaleLowerCase() === tag.toLocaleLowerCase());
        input.value = (selected ? tags.filter(value => value.toLocaleLowerCase() !== tag.toLocaleLowerCase()) : [...tags, tag]).join(',');
        input.dispatchEvent(new Event('input', {bubbles: true}));
        input.dispatchEvent(new Event('change', {bubbles: true}));
    }
};
document.addEventListener('click', event => {
    const link = event.target.closest('[data-tag-target]');
    if (!link) return;
    event.preventDefault();
    window.Tag.selectedTag(link.dataset.tag, link.dataset.tagTarget);
});
