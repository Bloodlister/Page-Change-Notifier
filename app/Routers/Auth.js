const router = require('express').Router();
const AuthController = require('../Controllers/AuthController.js');
router.expressUrlPath = '/';

router.get('/login', (req, res) => { AuthController.login(req, res); });
router.post('/login', (req, res) => { AuthController.loginUser(req, res); });

router.get('/register', (req, res) => { AuthController.register(req, res); });
router.post('/register', (req, res) => { AuthController.registerUser(req, res); });

module.exports = router;