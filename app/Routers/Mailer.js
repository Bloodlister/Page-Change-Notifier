const router = require('express').Router();
const MailerController = require('../Controllers/MailerController.js');
const {loggedIn} = require('../Middleware/loggedIn.js');
router.expressUrlPath = '/';

router.get('/testEmail', loggedIn, (req, res) => { MailerController.testMail(req, res) });

// router.get('/test', loggedIn, (req, res) => { MailerController.test(req, res) });

module.exports = router;
