const router = require('express').Router();
const BaseController = require('./../Controllers/BaseController.js');
const {loggedIn} = require('../Middleware/loggedIn.js');
router.expressUrlPath = '/';

router.get('/', loggedIn, (req, res) => { BaseController.index(req, res) });
router.get('/test', (req, res) => {BaseController.test(req, res)});

module.exports = router;