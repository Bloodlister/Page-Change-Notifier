const path = require('path');
const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');
const MongoStore = require('connect-mongo')(session);

const Routing = require('./routing.js');
const Middleware = require('./middleware.js');
const MongoStoreOptions = require('./storeoptions.js');

console.log(process.env.CONNECTION_STRING);

if (!process.env.CONNECTION_STRING) {
    mongoose.connect(MongoStoreOptions.connectionString, { useNewUrlParser: true });
} else {
    mongoose.connect(process.env.CONNECTION_STRING, { useNewUrlParser: true });
}

const app = express();
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: true}));

app.use(session({
    secret: 'Boobies',
    resave: true,
    saveUninitialized: false,
    store: new MongoStore({ mongooseConnection: mongoose.connection }),
}));

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, '/app/Views'));

Routing(app);
Middleware(app);

app.use(express.static(`${__dirname}/dist`));

const port = process.env.PORT || 5000;
app.listen(port);

console.log(`server started on port: ${port}`);
