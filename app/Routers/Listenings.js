const router = require('express').Router();
const {loggedIn} = require('../Middleware/loggedIn.js');
const ListeningsController = require('../Controllers/ListeningsController.js');

router.get('list', loggedIn, (req, res) => ListeningsController.listListenings(req, res));
router.get('edit/:id', loggedIn, (req, res) => ListeningsController.editListenings(req, res));
router.post('create', loggedIn, (req, res) => ListeningsController.createListening(req, res));
router.get('delete', loggedIn, (req, res) => ListeningsController.deleteListening(req, res));

module.exports = router;