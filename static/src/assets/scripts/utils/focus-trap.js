import EventHandler from './dom/event-handler.js';
import SelectorEngine from './dom/selector-engine.js';

const NAME = 'focustrap';
const DATA_KEY = 'ssm.focustrap';
const EVENT_KEY = `.${DATA_KEY}`;
const EVENT_FOCUSIN = `focusin${EVENT_KEY}`;
const EVENT_KEYDOWN_TAB = `keydown.tab${EVENT_KEY}`;

const TAB_KEY = 'Tab';
const TAB_NAV_FORWARD = 'forward';
const TAB_NAV_BACKWARD = 'backward';

const Default = {
    autofocus: true,
    trapElement: null, // The element to trap focus inside of
};

class FocusTrap {
    constructor(config) {
        this._config = this._getConfig(config);
        this._isActive = false;
        this._lastTabNavDirection = null;
    }

    // Getters
    static get Default() {
        return Default;
    }

    static get NAME() {
        return NAME;
    }

    // Public
    activate() {
        if (this._isActive) {
            return;
        }

        if (this._config.autofocus) {
            this._config.trapElement.focus();
        }

        EventHandler.off(document, EVENT_KEY); // guard against infinite focus loop
        EventHandler.on(document, EVENT_FOCUSIN, (event) => this._handleFocusin(event));
        EventHandler.on(document, EVENT_KEYDOWN_TAB, (event) => this._handleKeydown(event));

        this._isActive = true;
    }

    deactivate() {
        if (!this._isActive) {
            return;
        }

        this._isActive = false;
        EventHandler.off(document, EVENT_KEY);
    }

    // Private
    _handleFocusin(event) {
        const { trapElement } = this._config;

        if (event.target === document || event.target === trapElement || trapElement.contains(event.target)) {
            return;
        }

        const elements = SelectorEngine.focusableChildren(trapElement);

        if (elements.length === 0) {
            trapElement.focus();
        } else if (this._lastTabNavDirection === TAB_NAV_BACKWARD) {
            elements[elements.length - 1].focus();
        } else {
            elements[0].focus();
        }
    }

    _handleKeydown(event) {
        if (event.key !== TAB_KEY) {
            return;
        }

        this._lastTabNavDirection = event.shiftKey ? TAB_NAV_BACKWARD : TAB_NAV_FORWARD;
    }

    _getConfig(config) {
        config = {
            ...this.constructor.Default,
            ...(typeof config === 'object' ? config : {}),
        };
        return config;
    }
}

export default FocusTrap;
