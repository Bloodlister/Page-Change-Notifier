const router = require('express').Router();
const MailerController = require('../Controllers/MailerController.js');

router.get('/testEmail', (req, res) => {
    MailerController.testMail(req, res);
});

module.exports = router;
