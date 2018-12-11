const ListenerVerifierFactory = require('./../ListenerVerifier');
const Listening = require('./../MongooseModels/Listening.js');
const MobileBgCollector = require('./../Collectors.js').MobileBG;
const MobileBgCollection = require('./../Collectors.js').MobileBGCarCollection;

class ListeningsController {
    //Display all listings
    //@route /list
    static listListenings(req, res) {
        console.log(req.session.user_id);
        Listening.find({ userId: req.session.user_id }, (err, listenings) => {
            let responseData = [];
            listenings.forEach(listening => {
                responseData.push({
                    id: listening._id,
                    type: listening.listeningType,
                    search: listening.searchParams
                });
            });

            res.send(responseData);
        });
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
                let listeningData = {
                    collectionId: Math.floor(Math.random() * 5) + 1, // Placed with random collection ID to increase productivity
                    userId: req.session.user_id,
                    listeningType: req.body.listeningType,
                    searchParams: req.body.data,
                };

                Listening.create(listeningData, (err, listening) => {
                    if(err) {
                        res.status(500).send('fail');
                    } else {
                        let collector = new MobileBgCollector();
                        collector.getCurrentCars(listening.searchParams, {
                            page: 1,
                            cars: new MobileBgCollection(20),
                        }).then(result => {
                            listening.shownCars = result.cars.getCarLinks();
                            
                            listening.save((err, updatedListening) => {
                                if (err) {
                                    res.status(500).send('fail');
                                } else {
                                    res.status(200).send('success');
                                }
                            })
                        }).catch(err => {
                            console.log(err);
                        });
                    }
                })
            }
        });
    }

    //Deletes listing by id
    //@route /delete
    static deleteListening(req, res) {
        Listening.remove({ _id: req.body.listeningId}, (err) => {
            res.send({
                success: true,
            });
        });
    }

    static editListenings(req, res) {
        res.send('Editing Listening');
    }
}

module.exports = ListeningsController;