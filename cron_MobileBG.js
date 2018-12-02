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

setInterval(() => {
    UserCollection.find({}, (err, users) => {
        users.forEach(user => {
            ListeningCollection.find({userId: user._id}, async (err, Listenings) => {
                if (Listenings.length > 0) {
                    let newCars = await ListeningCollection.getNewCarsFromListenings(Listenings);
                    console.log(newCars);
                    if (newCars && newCars.length > 0) {
                        let userMailer = new Mailer(user.email);
                        userMailer.getTemplateForNewCars(newCars).then(template => {
                            userMailer.sendMail(template);
                        });
                    }
                }
            });
        });      
    });
}, 1000 * 30);