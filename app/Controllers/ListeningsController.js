const ListenerVerifierFactory = require('./../ListenerVerifier');
const Listening = require('./../MongooseModels/Listening.js');

class ListeningsController {
    //Display all listings
    //@route /list
    static listListenings(req, res) {
        res.send('List of all the active Listenings');
    }

    //Creates new Listenings
    //@type post
    //@route /create
    static createListening(req, res) {
        const verifier = ListenerVerifierFactory.create(req.body.listeningType);
        verifier.validListening(req.body.data, (err) => {
            if (err) {
                res.status(500).send('fail');
            } else {
                Listening.create(req.body, (err, listening) => {
                    if(err) {
                        res.status(500).send('fail');
                    } else {
                        res.status(200).send('success');
                    }
                })
            }
        });
    }

    //Deletes listing by id
    //@route /delete
    static deleteListening(req, res) {
        res.send('Delete Listening');
    }

    static editListenings(req, res) {
        res.send('Editing Listening');
    }
}

module.exports = ListeningsController;