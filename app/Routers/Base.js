const router = require('express').Router();
const BaseController = require('./../Controllers/BaseController.js');

router.get('/', (req, res) => { BaseController.index(req, res) });

module.exports = router;