const axios = require('axios');
const queryString = require('querystring');
const { JSDOM } = require('jsdom');
const mobileBgReducer = require('./Reducers.js').MobileBG;

class MobileBG {
    constructor() {
        this.slink = null;
    }

    getRedirect(requestData) {
        let self = this;
        return new Promise(function(resolve, reject) {
            axios({
                method: "post",
                url: 'https://www.mobile.bg/pcgi/mobile.cgi',
                data: queryString.stringify(requestData),
                headers: { "Content-type": "application/x-www-form-urlencoded" },
            })
            .then(resp => {
                let valid = false;
                resp.headers['set-cookie'].forEach(setCookie => {
                    if (setCookie.startsWith('mobile_session_id_redirect') && setCookie.indexOf('slink') > -1) {
                        resolve(self.getSlink(setCookie));
                    }
                });
            })
            .catch(err => {
                reject(err);
            });
        });
    }

    getSlink(cookie) {
        cookie = cookie.replace(new RegExp(/.+slink%09/gi), '');
        cookie = cookie.replace(new RegExp(/%09.+/gi), '');

        return cookie;
    }

    getResultFromSetCookie(page) {
        return new Promise((resolve, reject) => {
            axios({
                method: "get",
                url: 'https://www.mobile.bg/pcgi/mobile.cgi?act=3&f1=' + page + '&slink=' + this.slink,
            })
            .then(resp => {
                resolve(resp);
            })
            .catch(err => {
                reject(err);
            });
        });
    }

    getTableOfCarsFromResults(html) {
        return new JSDOM(html).window.document.querySelectorAll('form[name="search"]')[0];
    }

    getCarObjects(carsTable) {
        let carEntries = carsTable.querySelectorAll('table');
        let cars = [];

        carEntries.forEach(htmlTable => {
            let carObj = new mobileBgReducer(htmlTable.innerHTML);
            
            if(carObj.link) {
                cars.push(carObj);
            }
        });

        return cars;
    }
}

module.exports = {
    MobileBG: MobileBG
};