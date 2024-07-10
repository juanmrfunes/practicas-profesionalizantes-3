export class WCCalculatorModel {
    constructor() {
        this.display = '';
    }

    append(value) {
        this.display += value;
    }

    clear() {
        this.display = '';
    }

    async calculate() {
        try {
            const response = await fetch('/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ expression: this.display })
            });
            const data = await response.json();
            this.display = data.result;
        } catch (error) {
            this.display = 'Error';
        }
    }

    getDisplay() {
        return this.display;
    }
}
