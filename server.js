const express = require('express');
const serveStatic = require('serve-static');
const MailerRouter = require('./app/Routers/Mailer.js');

const app = express();
app.use(serveStatic(`${__dirname}/dist`));

app.use('/', MailerRouter);

app.get('/', (req, res) => {
    res.sendFile('/dist/index.html');
});

const port = process.env.PORT || 5000;
app.listen(port);

console.log(`server started on port: ${port}`);
