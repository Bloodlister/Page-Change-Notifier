class BaseController {
    static index(req, res) {
        res.sendFile('/dist/index.html');
    }

    static test(req, res) {
        res.send('asdasd');
    }
}

module.exports = BaseController;