export class WCCalculatorController {
    constructor(model, view) {
        this.model = model;
        this.view = view;

        this.view.bindButtonClick(this.handleButtonClick.bind(this));
    }

    handleButtonClick(buttonId) {
        switch (buttonId) {
            case 'button0':
            case 'button1':
            case 'button2':
            case 'button3':
            case 'button4':
            case 'button5':
            case 'button6':
            case 'button7':
            case 'button8':
            case 'button9':
            case 'buttonDecimalPoint':
                this.model.append(buttonId.replace('button', ''));
                break;
            case 'buttonPlus':
                this.model.append('+');
                break;
            case 'buttonMinus':
                this.model.append('-');
                break;
            case 'buttonProduct':
                this.model.append('x');
                break;
            case 'buttonDivision':
                this.model.append('/');
                break;
            case 'buttonClear':
                this.model.clear();
                break;
            case 'buttonCalculate':
                this.model.calculate().then(() => {
                    this.view.updateDisplay(this.model.getDisplay());
                });
                return; // Exit early to prevent updating display immediately
        }
        this.view.updateDisplay(this.model.getDisplay());
    }
}
