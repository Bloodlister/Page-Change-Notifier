class ListeningsController {
    static listListenings(req, res) {
        res.send('List of all the active Listenings');
    }

    static createListening(req, res) {
        res.send('Create Listening');
    }

    static deleteListening(req, res) {
        res.send('Delete Listening');
    }

    static editListenings(req, res) {
        res.send('Editing Listening');
    }
}

module.exports = ListeningsController;