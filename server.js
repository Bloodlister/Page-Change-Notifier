const express = require('express');
const path = require('path');
const serveStatic = require('serve-static');

app = express();
app.use(serveStatic(__dirname + "/dist"));

app.get('/', function(req, res) {
	res.sendFile('dist/index.html');
});

let port = process.env.PORT || 5000;
app.listen(port);

console.log('server started' + port);
