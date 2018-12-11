const path = require('path');
const express = require('express');
const session = require('express-session');
const cookieParser = require('cookie-parser');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');
const MongoStore = require('connect-mongo')(session);

const Routing = require('./routing.js');
const Middleware = require('./middleware.js');

let mongooseSettings = { 
    useNewUrlParser: true,
    useCreateIndex: true,
};

if (!process.env.CONNECTION_STRING) {
    const MongoStoreOptions = require('./settings.js');
    mongoose.connect(MongoStoreOptions.connectionString, mongooseSettings);
} else {
    mongoose.connect(process.env.CONNECTION_STRING, mongooseSettings);
}

const app = express();
app.use(cookieParser());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: true}));

app.use((req, res, next) => {
    res.set({
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE',
        'Access-Control-Allow-Headers': 'Content-Type'
    })
    next();
})

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
