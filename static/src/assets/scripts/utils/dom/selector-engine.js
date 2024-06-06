import { isDisabled, isVisible, parseSelector } from '../utilities.js';

const getSelector = (element) => {
    let selector = '#' + element.getAttribute('aria-controls');

    if (!selector || selector === '#') {
        let hrefAttribute = element.getAttribute('href');

        // The only valid content that could double as a selector are IDs or classes,
        // so everything starting with `#` or `.`. If a "real" URL is used as the selector,
        // `document.querySelector` will rightfully complain it is invalid.
        if (!hrefAttribute || (!hrefAttribute.includes('#') && !hrefAttribute.startsWith('.'))) {
            return null;
        }

        // Just in case some CMS puts out a full URL with the anchor appended
        if (hrefAttribute.includes('#') && !hrefAttribute.startsWith('#')) {
            hrefAttribute = `#${hrefAttribute.split('#')[1]}`;
        }

        selector = hrefAttribute && hrefAttribute !== '#' ? parseSelector(hrefAttribute.trim()) : null;
    }

    return selector;
};

const SelectorEngine = {
    find(selector, element = document.documentElement) {
        return [].concat(...Element.prototype.querySelectorAll.call(element, selector));
    },

    findOne(selector, element = document.documentElement) {
        return Element.prototype.querySelector.call(element, selector);
    },

    children(element, selector) {
        return [].concat(...element.children).filter((child) => child.matches(selector));
    },

    focusableChildren(element) {
        const focusables = [
            'a',
            'button',
            'input',
            'textarea',
            'select',
            'details',
            '[tabindex]',
            '[contenteditable="true"]',
        ]
            .map((selector) => `${selector}:not([tabindex^="-"])`)
            .join(',');

        return this.find(focusables, element).filter((el) => !isDisabled(el) && isVisible(el));
    },

    getSelectorFromElement(element) {
        const selector = getSelector(element);

        if (selector) {
            return SelectorEngine.findOne(selector) ? selector : null;
        }

        return null;
    },

    getElementFromSelector(element) {
        const selector = getSelector(element);

        return selector ? SelectorEngine.findOne(selector) : null;
    },

    getMultipleElementsFromSelector(element) {
        const selector = getSelector(element);

        return selector ? SelectorEngine.find(selector) : [];
    },
};

export default SelectorEngine;
