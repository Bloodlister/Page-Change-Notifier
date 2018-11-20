const path = require('path');

class BaseController {
    static index(req, res) {
        res.sendFile(path.resolve('dist/index.html'));
    }

    static test(req, res) {
        res.render('./../Views/test.ejs');
    }
}

module.exports = BaseController;