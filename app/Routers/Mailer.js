const router = require('express').Router();
const MailerController = require('../Controllers/MailerController.js');
const LoggedIn = require('../Middleware/loggedIn.js');
router.expressUrlPath = '/';

router.get('/testEmail', (req, res) => { MailerController.testMail(req, res) });

router.get('/test', LoggedIn, (req, res) => { MailerController.test(req, res) });

module.exports = router;
