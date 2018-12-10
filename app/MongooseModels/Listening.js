const mongoose = require('mongoose');

const Collection = require('./../Collectors.js').MobileBGCarCollection;
const MobileBGCollection = require('./../Collectors.js').MobileBG;

const ListeningSchema = mongoose.Schema({
    collectionId: {
        type: Number,
        requried: true,
    },
    userId: {
        type: mongoose.Schema.Types.ObjectId,
        required: true,
    },
    listeningType: { 
        type: String, 
        required: true, 
        trim: true, 
        lowecase: true
    },
    searchParams: { 
        type: mongoose.Schema.Types.Mixed, 
        required: true
    },
    shownCars: {
        type: Array,
        default: [],
        required: false,
    }
});

/**
 * Call out to god if you ever have to change something in this one
 */
ListeningSchema.statics.getNewCarsFromListenings = async function(Listenings) {
    return new Promise(resolve => {
        
        let cars = Listenings.map(listening => {
            return new Promise(resolve => {
                let collection = new MobileBGCollection();
                let data = {
                    page: 1,
                    shownCars: listening.shownCars,
                    seen: 0,
                    cars: new Collection(),
                };

                if(data.cars.seenCar || data.cars.seenTopCar) {
                    data.cars.seenCar = false;
                    data.cars.seenTopCar = false;
                }
                collection.getNewCars(listening.searchParams, data).then(({cars}) => {
                    //Removing excess shown cars
                    let shownCarsToKeep = listening.shownCars;
                    if(listening.shownCars.length > 50) {
                        shownCarsToKeep = [];
                        listening.shownCars.forEach((carLink, index) => {
                            if (index % 2 == 1) {
                                shownCarsToKeep.push(carLink);
                            }
                        })
                    }
                    listening.shownCars = shownCarsToKeep;

                    listening.shownCars = listening.shownCars.concat(cars.getNewCarLinks());
                    listening.save((err, updatedListening) => {
                        if (!err) {
                            resolve(cars.newCars);
                        }
                    })
                });
            })
        });
        
        let result = Promise.all(cars);
        result.then(res => {
            let newCars = [];
            res.forEach(newCarsCollection => {
                newCars = newCars.concat(newCarsCollection);
            });
            resolve(newCars);
        });
    })
}

const Listening = mongoose.model('Listening', ListeningSchema);

module.exports = Listening;

