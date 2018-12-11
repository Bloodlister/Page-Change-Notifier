const mongoose = require('mongoose');
const Listenings = require('./app/MongooseModels/Listening.js');
const MongoStoreOptions = require('./settings.js');

mongoose.connect(MongoStoreOptions.connectionString, { useNewUrlParser: true });

Listenings.find({}, (err, listenings) => {
    listenings.forEach(listening => {
        listening.collectionId = Math.floor(Math.random() * 5) + 1;
        listening.save();
    });
});
