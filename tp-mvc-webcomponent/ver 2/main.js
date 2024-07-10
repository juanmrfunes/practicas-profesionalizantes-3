import { WCCalculatorModel } from './WCCalculatorModel.js';
import { WCCalculatorView } from './WCCalculatorView.js';
import { WCCalculatorController } from './WCCalculatorController.js';

class CalculatorComponent extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });

        const model = new WCCalculatorModel();
        const view = new WCCalculatorView();
        new WCCalculatorController(model, view);

        this.shadowRoot.appendChild(view.getRootElement());
    }
}

customElements.define('calculator-component', CalculatorComponent);
