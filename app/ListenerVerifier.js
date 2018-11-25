const axios = require('axios');
const queryString = require('querystring');

class Verifier {
    validListening(listeningData, callback) {
        throw Error('Not implemented');
    }
}

class MobileBG extends Verifier {
    validListening(listeningData, callback) {
        axios({
            method: "post",
            url: 'https://www.mobile.bg/pcgi/mobile.cgi',
            data: queryString.stringify(listeningData),
            headers: { "Content-type": "application/x-www-form-urlencoded" },
        })
        .then(resp => {
            let valid = false;
            resp.headers['set-cookie'].forEach(setCookie => {
                if (setCookie.startsWith('mobile_session_id_redirect') && setCookie.indexOf('slink') > -1) {
                    valid = true;
                }
            });
            valid ? callback(null) : callback('fail');
        })
        .catch(err => {
            callback(err);
        });
    }
}

class VerifierFactory {
    static create(verifierName) {
        return new this.verifiers[verifierName]();
    }
}

VerifierFactory.verifiers = {
    'MobileBG': MobileBG,
};

module.exports = VerifierFactory;