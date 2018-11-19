const mongoose = require('mongoose');

const ListeningSchema = mongoose.Schema({
    modelType: { type: String, required: true, trim: true, lowecase: true},
    search: { type: mongoose.Schema.Types.Mixed, required: true},
});

const Listening = mongoose.Model('Listening', ListeningSchema);

module.exports = Listening;

