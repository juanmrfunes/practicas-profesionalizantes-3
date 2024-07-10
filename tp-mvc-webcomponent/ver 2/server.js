const express = require('express');
const app = express();
const port = 3000;

app.use(express.static('static'));
app.use(express.json());

app.post('/calculate', (req, res) => {
    const { expression } = req.body;
    try {
        const sanitizedExpression = expression.replace(/[^-()\d/*+.]/g, '');
        const result = eval(sanitizedExpression.replace(/x/g, '*'));
        res.json({ result });
    } catch (e) {
        res.status(400).json({ result: 'Error' });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
