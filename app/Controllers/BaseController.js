const path = require('path');

class BaseController {
    static index(req, res) {
        res.sendFile(path.resolve('dist/index.html'));
    }
}

module.exports = BaseController;