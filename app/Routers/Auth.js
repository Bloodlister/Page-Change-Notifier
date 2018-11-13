const router = require('express').Router();
const AuthController = require('../Controllers/AuthController.js');
const {loggedIn} = require('./../Middleware/loggedIn.js');
router.expressUrlPath = '/';

router.get('/login', loggedIn, (req, res) => { AuthController.login(req, res); });
router.post('/login', loggedIn, (req, res) => { AuthController.loginUser(req, res); });

router.get('/register', loggedIn, (req, res) => { AuthController.register(req, res); });
router.post('/register', loggedIn, (req, res) => { AuthController.registerUser(req, res); });

router.get('/logout', (req, res) => { AuthController.logout(req, res); });

module.exports = router;