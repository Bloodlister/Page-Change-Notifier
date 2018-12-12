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
    mongoose.connect(MongoStoreOptions.connectionString, mongooseSettings, (err) => {
        console.log(err);
    });
} else {
    mongoose.connect(process.env.CONNECTION_STRING, mongooseSettings, (err) => {
        console.log(err);
    });
}

function startSearch() {
    return new Promise((resolve, reject) => {
        console.log("=========================")
        console.log("START")
        console.log("=========================")
        getUsers().then(users => {
            users.forEach(user => {
                activateListenings(user, 0).then(result => {
                    resolve(result);
                });
            });
        }).catch(err => console.log(err));
    })
}

function getUsers() {
    return new Promise((resolve, reject) => {
        UserCollection.find({ _id: '5c0192a7340d31024b31600b' }, (err, users) => {
            if (err) {
                console.log(err);
            }
            resolve(users);
        });
    })
}

function getListenings(user, page) {
    return new Promise((resolve, reject) => {
        ListeningCollection.find({ userId: user._id }, null, { skip: page * 20, limit: 20 })
        .then(res => {
            resolve(res);
        })
        .catch(err => {
            console.log(err);
        });
    })
}

function activateListenings(user, page) {
    return new Promise((resolve, reject) => {
        getListenings(user, page).then(Listenings => {
            if (Listenings.length > 0) {
                ListeningCollection.getNewCarsFromListenings(Listenings).then(newCars => {
                    if (newCars && newCars.length > 0) {
                        let userMailer = new Mailer(user.email);
                        userMailer.getTemplateForNewCars(newCars).then(template => {
                            userMailer.sendMail(template);
                            resolve(activateListenings(user, page + 1));
                        });
                    } else {
                        resolve(activateListenings(user, page + 1));
                    }
                });
            } else {
                resolve(true);
            }
        }).catch(err => { console.log(err) })
    })
}

function getUsers() {
    return new Promise((resolve, reject) => {
        UserCollection.find({}, (err, users) => {
            if(err) {
                console.log(err);
            }
            resolve(users);
        });
    })
}

function getListenings(userId, page) {
    return new Promise((resolve, reject) => {
        ListeningCollection.find({ userId: userId }, (err, Listenings) => {
            if (err) {
                console.log(err);
            }
            resolve(Listenings);
        });
    })
}

/* COLLECTION 1 */
setInterval(() => { 
    startSearch().then(res => {
        fs.appendFile('logs/Success.log', res + "\n");
    }).catch(err => {
        fs.appendFile('logs/Errors.log', JSON.stringify(err.message));
    });
}, 1000 * 20);

// /* COLLECTION 2 */
// setInterval(() => { 
//     startSearch(2).then(res => {
//         fs.appendFile('logs/Success.log', res + "\n", (err) => {});
//     }).catch(err => {
//         fs.appendFile('logs/Errors.log', JSON.stringify(err.message), (err) => { });
//     }); 
// }, 1000 * 10);

// /* COLLECTION 3 */
// setInterval(() => { 
//     startSearch(3).then(res => {
//         fs.appendFile('logs/Success.log', res + "\n", (err) => { });
//     }).catch(err => {
//         fs.appendFile('logs/Errors.log', JSON.stringify(err.message), (err) => { });
//     }); 
// }, 1000 * 10);

// /* COLLECTION 4 */
// setInterval(() => { 
//     startSearch(4).then(res => {
//         fs.appendFile('logs/Success.log', res + "\n", (err) => { });
//     }).catch(err => {
//         fs.appendFile('logs/Errors.log', JSON.stringify(err.message), (err) => { });
//     }); 
// }, 1000 * 10);

// /* COLLECTION 5 */
// setInterval(() => { 
//     startSearch(5).then(res => {
//         fs.appendFile('logs/Success.log', res + "\n", (err) => { });
//     }).catch(err => {
//         fs.appendFile('logs/Errors.log', JSON.stringify(err.message), (err) => { });
//     }); 
// }, 1000 * 10);
