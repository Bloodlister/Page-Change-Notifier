const mongoose = require('mongoose');
const Mailer = require('./app/Mailing.js').MobileBG;
const UserCollection = require('./app/MongooseModels/User.js');
const ListeningCollection = require('./app/MongooseModels/Listening.js');

if (!process.env.CONNECTION_STRING) {
    const MongoStoreOptions = require('./settings.js');
    mongoose.connect(MongoStoreOptions.connectionString, { useNewUrlParser: true });
} else {
    mongoose.connect(process.env.CONNECTION_STRING, { useNewUrlParser: true });
}

function startSearch(collectionId) {
    return new Promise((resolve, reject) => {
        getUsers().then(users => {
            users.forEach(user => {
                let page = 0;
                activateListenings(user, collectionId, page).then(result => {
                    resolve(result);
                });
            });
        }).catch(err => reject(err));
    })
}

function getUsers() {
    return new Promise((resolve, reject) => {
        UserCollection.find({ _id: '5c0192a7340d31024b31600b' }, (err, users) => {
            if (err) {
                reject(err);
            }
            resolve(users);
        });
    })
}

function getListenings(user, collectionId, page) {
    return new Promise((resolve, reject) => {
        ListeningCollection.find({ userId: user._id, collectionId: collectionId }, null, {skip: page * 1, limit: 1}).then(res => {
            resolve(res);
        });
    })
}

function activateListenings(user, collectionId, page) {
    return new Promise((resolve, reject) => {
        getListenings(user, collectionId, page).then(Listenings => {
            if (Listenings.length > 0) {
                ListeningCollection.getNewCarsFromListenings(Listenings).then(newCars => {
                    if (newCars && newCars.length > 0) {
                        let userMailer = new Mailer(user.email);
                        userMailer.getTemplateForNewCars(newCars).then(template => {
                            userMailer.sendMail(template);
                            resolve(activateListenings(user, collectionId, page + 1));
                        });
                    } else {
                        resolve(activateListenings(user, collectionId, page + 1));
                    }
                });
            } else {
                resolve("Done with collection: " + collectionId);
            }
        }).catch(err => { reject(err) })
    })
}

startSearch(0).then(res => { 
    console.log("Done");
    process.exit();
}).catch(err => {
    console.log(err);
    process.exit();
});