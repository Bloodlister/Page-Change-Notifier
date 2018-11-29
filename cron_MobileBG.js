const mongoose = require('mongoose');

if (!process.env.CONNECTION_STRING) {
    const MongoStoreOptions = require('./settings.js');
    mongoose.connect(MongoStoreOptions.connectionString, { useNewUrlParser: true });
} else {
    mongoose.connect(process.env.CONNECTION_STRING, { useNewUrlParser: true });
}

const UserCollection = require('./app/MongooseModels/User.js');
const ListeningCollection = require('./app/MongooseModels/Listening.js');
const MobileBGCollection = require('./app/Collectors.js').MobileBG;
const Collection = require('./app/Collectors.js').MobileBGCarCollection;
const Mailer = require('./app/Mailing.js').MobileBG;

setInterval(() => {
    UserCollection.find({}, (err, users) => {
        users.forEach(user => {
            ListeningCollection.find({userId: user._id}, (err, Listenings) => {
                let newCars = [];
                let collection = new MobileBGCollection();
                let data = {}
                Listenings.forEach(listening => {
                    data = {
                        page:1,
                        shownCars: listening.shownCars,
                        seen: 0,
                        cars: new Collection(),
                    };

                    collection.getNewCars(listening.searchParams, data).then(({cars}) => {
                        Mailer.notifyForNewCars(user.email, cars);
                    });
                });
            });
        });      
    });
}, 1000);