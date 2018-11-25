const mongoose = require('mongoose');

const ListeningSchema = mongoose.Schema({
    listeningType: { type: String, required: true, trim: true, lowecase: true},
    data: { type: mongoose.Schema.Types.Mixed, required: true},
});

const Listening = mongoose.model('Listening', ListeningSchema);

module.exports = Listening;

