const mongoose = require('mongoose');

if (!process.env.CONNECTION_STRING) {
    const MongoStoreOptions = require('./storeoptions.js');
    mongoose.connect(MongoStoreOptions.connectionString, { useNewUrlParser: true });
} else {
    mongoose.connect(process.env.CONNECTION_STRING, { useNewUrlParser: true });
}

const UserCollection = require('./app/MongooseModels/User.js');
const ListeningCollection = require('./app/MongooseModels/Listening.js');
const MobileBGCollection = require('./app/Collectors.js').MobileBG;

setInterval(() => {
    UserCollection.find({}, (err, users) => {
        users.forEach(user => {
            ListeningCollection.find({userId: user._id}, (err, Listenings) => {
                let newCars = [];
                let collection = new MobileBGCollection();
                Listenings.forEach(listening => {
                    
                    collection.searchForNewCars(listening.searchParams, listening.shownCars).then(result => {
                        console.log(result);
                    });
                });
            });
        });      
    });
}, 1000);