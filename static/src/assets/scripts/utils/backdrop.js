import EventHandler from './dom/event-handler.js';
import { execute, executeAfterTransition, reflow } from './utilities.js';

const NAME = 'backdrop';
const CLASS_NAME_FADE = 'fade';
const CLASS_NAME_SHOW = 'show';
const EVENT_MOUSEDOWN = `mousedown.ssm.${NAME}`;

const Default = {
    className: 'modal-backdrop',
    clickCallback: null,
    isAnimated: false,
    isVisible: true, // if false, we use the backdrop helper without adding any element to the dom
    rootElement: document.body, // give the choice to place backdrop under different elements
};

class Backdrop {
    constructor(config) {
        this._config = this._getConfig(config);
        this._isAppended = false;
        this._element = null;
    }

    // Getters
    static get Default() {
        return Default;
    }

    static get NAME() {
        return NAME;
    }

    // Public
    show(callback) {
        if (!this._config.isVisible) {
            execute(callback);
            return;
        }

        this._append();

        const element = this._getElement();
        if (this._config.isAnimated) {
            reflow(element);
        }

        element.classList.add(CLASS_NAME_SHOW);

        this._emulateAnimation(() => {
            execute(callback);
        });
    }

    hide(callback) {
        if (!this._config.isVisible) {
            execute(callback);
            return;
        }

        this._getElement().classList.remove(CLASS_NAME_SHOW);

        this._emulateAnimation(() => {
            this.dispose();
            execute(callback);
        });
    }

    dispose() {
        if (!this._isAppended) {
            return;
        }

        EventHandler.off(this._element, EVENT_MOUSEDOWN);

        this._element.remove();
        this._isAppended = false;
    }

    // Private
    _getElement() {
        if (!this._element) {
            const backdrop = document.createElement('div');
            backdrop.className = this._config.className;

            if (this._config.isAnimated) {
                backdrop.classList.add(CLASS_NAME_FADE);
            }

            this._element = backdrop;
        }

        return this._element;
    }

    _getConfig(config) {
        config = {
            ...this.constructor.Default,
            ...(typeof config === 'object' ? config : {}),
        };
        return config;
    }

    _append() {
        if (this._isAppended) {
            return;
        }

        const element = this._getElement();

        this._config.rootElement.append(element);

        EventHandler.on(element, EVENT_MOUSEDOWN, () => {
            execute(this._config.clickCallback);
        });

        this._isAppended = true;
    }

    _emulateAnimation(callback) {
        executeAfterTransition(callback, this._getElement(), this._config.isAnimated);
    }
}

export default Backdrop;
