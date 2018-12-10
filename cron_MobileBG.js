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
    getUsers().then(users => {
        users.forEach(user => {
            getListenings(user._id, collectionId).then(Listenings => {
                if (Listenings.length > 0) {
                    ListeningCollection.getNewCarsFromListenings(Listenings).then(newCars => {
                        if (newCars && newCars.length > 0) {
                            let userMailer = new Mailer(user.email);
                            userMailer.getTemplateForNewCars(newCars).then(template => {
                                userMailer.sendMail(template);
                            });
                        }
                    })
                }
            });
        });
    });
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

function getListenings(userId, collectionId) {
    return new Promise((resolve, reject) => {
        ListeningCollection.find({ userId: userId, collectionId: collectionId }, async (err, Listenings) => {
            if (err) {
                reject(err);
            }
            resolve(Listenings);
        });
    })
}

/* COLLECTION 1 */
setInterval(() => { startSearch(1); }, 1000 * 120);

/* COLLECTION 2 */
setInterval(() => { startSearch(2); }, 1000 * 120);

/* COLLECTION 3 */
setInterval(() => { startSearch(3); }, 1000 * 120);

/* COLLECTION 4 */
setInterval(() => { startSearch(4); }, 1000 * 120);

/* COLLECTION 5 */
setInterval(() => { startSearch(5); }, 1000 * 120);
