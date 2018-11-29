const mongoose = require('mongoose');

const ListeningSchema = mongoose.Schema({
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

const Listening = mongoose.model('Listening', ListeningSchema);

module.exports = Listening;

