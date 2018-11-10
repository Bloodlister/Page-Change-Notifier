const express = require('express');
const serveStatic = require('serve-static');
const session = require('express-session');
const Routing = require('./routing.js');
const Middleware = require('./middleware.js');

const app = express();
app.use(session({secret: 'Boobies'}));

app.use(serveStatic(`${__dirname}/dist`));

Routing(app);
Middleware(app);

const port = process.env.PORT || 5000;
app.listen(port);

console.log(`server started on port: ${port}`);
