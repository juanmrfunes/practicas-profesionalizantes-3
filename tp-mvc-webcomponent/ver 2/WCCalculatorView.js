export class WCCalculatorView {
    constructor() {
        this.root = document.createElement('div');
        this.root.innerHTML = `
            <table>
                <tr>
                    <td colspan="4">
                        <input class="displayResult" id="display" type="text" value="" disabled>
                    </td>
                </tr>
                <tr>
                    <td><button id="button7" class="numberButton">7</button></td>
                    <td><button id="button8" class="numberButton">8</button></td>
                    <td><button id="button9" class="numberButton">9</button></td>
                    <td><button id="buttonPlus" class="operatorButton">+</button></td>
                </tr>
                <tr>
                    <td><button id="button4" class="numberButton">4</button></td>
                    <td><button id="button5" class="numberButton">5</button></td>
                    <td><button id="button6" class="numberButton">6</button></td>
                    <td><button id="buttonMinus" class="operatorButton">-</button></td>
                </tr>
                <tr>
                    <td><button id="button1" class="numberButton">1</button></td>
                    <td><button id="button2" class="numberButton">2</button></td>
                    <td><button id="button3" class="numberButton">3</button></td>
                    <td><button id="buttonProduct" class="operatorButton">x</button></td>
                </tr>
                <tr>
                    <td><button id="button0" class="numberButton">0</button></td>
                    <td><button id="buttonDecimalPoint" class="numberButton">.</button></td>
                    <td><button id="buttonCalculate" class="calculateButton">=</button></td>
                    <td><button id="buttonDivision" class="operatorButton">/</button></td>
                </tr>
                <tr>
                    <td colspan="4"><button id="buttonClear" class="clearButton">BORRAR</button></td>
                </tr>
            </table>
        `;
    }

    bindButtonClick(callback) {
        this.root.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', event => {
                callback(event.target.id);
            });
        });
    }

    updateDisplay(value) {
        this.root.querySelector('#display').value = value;
    }

    getRootElement() {
        return this.root;
    }
}
