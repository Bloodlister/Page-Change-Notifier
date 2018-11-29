const axios = require('axios');
const queryString = require('querystring');
const { JSDOM } = require('jsdom');
const mobileBgReducer = require('./Reducers.js').MobileBG;

class MobileBG {

    getRedirect(requestData) {
        return new Promise((resolve, reject) => {
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
                        resolve(this.getSlink(setCookie));
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

    getResultFromSetCookie(slink, page) {
        return new Promise((resolve, reject) => {
            axios({
                method: "get",
                url: 'https://www.mobile.bg/pcgi/mobile.cgi?act=3&f1=' + page + '&slink=' + slink,
            })
            .then(resp => {
                resolve(resp);
            })
            .catch(err => {
                reject(err);
            });
        });
    }

    getCarTablesFromHTML(html) {
        let form = new JSDOM(html).window.document.querySelectorAll('form[name="search"]')[0];

        let carTables = [];
        form.querySelectorAll('table').forEach(table => {
            if (table.querySelector('tbody').querySelectorAll('tr').length > 6) {
                carTables.push(table);
            }
        })

        return carTables;
    }

    getCarObjects(carTables) {
        let cars = [];
        carTables.forEach(htmlTable => {
            let carObj = new mobileBgReducer('<table>' + htmlTable.innerHTML + '</table>');
            
            if(carObj.link) {
                cars.push(carObj);
            }
        });

        return cars;
    }

    searchForNewCars(requestData, data) {
        return new Promise((resolve, reject) => {
            if (data.done || data.oldCars >= 5 || data.oldTopCars >= 5) {
                resolve(data);
            } else {
                this.getRedirect(requestData)
                .then(slink => {
                    this.getResultFromSetCookie(slink, data.page)
                    .then(resultPage => {
                        let cars = this.getCarObjects(this.getCarTablesFromHTML(resultPage.data));

                        //If there are records store them
                        if (cars.length > 0) {
                            cars.forEach(car => {
                                if(data.shownCars.indexOf(car.link) === -1) {
                                    data.newCars.push(car);
                                } else {
                                    if (car.isTopOffer) {
                                        data.oldTopCars++;
                                    } else {
                                        data.oldCars++;
                                    }
                                }
                            });
                        } else {
                            data.done = true;
                        }

                        data.page += 1;
                        resolve(this.searchForNewCars(requestData, data));
                    })
                });
            }
        });
    }
}

module.exports = {
    MobileBG: MobileBG
};