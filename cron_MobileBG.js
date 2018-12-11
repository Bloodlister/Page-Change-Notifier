const fs = require('fs');
const mongoose = require('mongoose');
const Mailer = require('./app/Mailing.js').MobileBG;
const UserCollection = require('./app/MongooseModels/User.js');
const ListeningCollection = require('./app/MongooseModels/Listening.js');

let mongooseSettings = {
    useNewUrlParser: true,
    useCreateIndex: true,
};

if (!process.env.CONNECTION_STRING) {
    const MongoStoreOptions = require('./settings.js');
    mongoose.connect(MongoStoreOptions.connectionString, mongooseSettings);
} else {
    mongoose.connect(process.env.CONNECTION_STRING, mongooseSettings);
}

function startSearch(collectionId) {
    return new Promise((resolve, reject) => {
        getUsers().then(users => {
            users.forEach(user => {
                getListenings(user._id, collectionId, 1).then(Listenings => {
                    if (Listenings.length > 0) {
                        ListeningCollection.getNewCarsFromListenings(Listenings).then(newCars => {
                            if (newCars && newCars.length > 0) {
                                let userMailer = new Mailer(user.email);
                                userMailer.getTemplateForNewCars(newCars).then(template => {
                                    userMailer.sendMail(template);
                                    resolve("Done with collection: " + collectionId);
                                });
                            } else {
                                resolve("Done with collection: " + collectionId);
                            }
                        })
                    } else {
                        resolve("Done with collection: " + collectionId);
                    }
                })
                .catch(err => { reject(err) })
            });
        }).catch(err => reject(err));
    })
}

function getUsers() {
    return new Promise((resolve, reject) => {
        UserCollection.find({}, (err, users) => {
            if(err) {
                reject (err);
            }
            resolve(users);
        });
    })
}

function getListenings(userId, collectionId, page) {
    return new Promise((resolve, reject) => {
        ListeningCollection.find({ userId: userId, collectionId: collectionId }, (err, Listenings) => {
            if (err) {
                reject(err);
            }
            resolve(Listenings);
        });
    })
}

/* COLLECTION 1 */
setInterval(() => { 
    startSearch(1).then(res => {
        fs.appendFile('logs/Success.log', res + "\n");
    }).catch(err => {
        fs.appendFile('logs/Errors.log', JSON.stringify(err.message));
    });
}, 1000 * 10);

/* COLLECTION 2 */
setInterval(() => { 
    startSearch(2).then(res => {
        fs.appendFile('logs/Success.log', res + "\n");
    }).catch(err => {
        fs.appendFile('logs/Errors.log', JSON.stringify(err.message));
    }); 
}, 1000 * 10);

/* COLLECTION 3 */
setInterval(() => { 
    startSearch(3).then(res => {
        fs.appendFile('logs/Success.log', res + "\n");
    }).catch(err => {
        fs.appendFile('logs/Errors.log', JSON.stringify(err.message));
    }); 
}, 1000 * 10);

/* COLLECTION 4 */
setInterval(() => { 
    startSearch(4).then(res => {
        fs.appendFile('logs/Success.log', res + "\n");
    }).catch(err => {
        fs.appendFile('logs/Errors.log', JSON.stringify(err.message));
    }); 
}, 1000 * 10);

/* COLLECTION 5 */
setInterval(() => { 
    startSearch(5).then(res => {
        fs.appendFile('logs/Success.log', res + "\n");
    }).catch(err => {
        fs.appendFile('logs/Errors.log', JSON.stringify(err.message));
    }); 
}, 1000 * 10);
