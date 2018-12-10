const axios = require('axios');
const queryString = require('querystring');
const { JSDOM } = require('jsdom');
const mobileBgReducer = require('./Reducers.js').MobileBG;

class MobileBG {

    async getRedirect(requestData) {
        return new Promise((resolve, reject) => {
            axios({
                method: "post",
                url: 'https://www.mobile.bg/pcgi/mobile.cgi',
                data: queryString.stringify(requestData),
                headers: { "Content-type": "application/x-www-form-urlencoded" },
            })
            .then((resp, test) => {
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
                //The lower three are for the translation
                headers: {
                    'DNT': '1'
                },
                responseType: 'arraybuffer',
                responseEncoding: 'binary'
            })
            .then(resp => {
                resolve(resp);
            })
            .catch(err => {
                reject(err);
            });
        });
    }

    /**
     * @param {String} html 
     * @returns {HTMLTableElement}
     */
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

    /**
     * @param {HTMLTableElement[]} carTables 
     */
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

    /**
     * @param  {Object} requestData
     * @param  {Object} data
     * @param  {Number} data.page
     * @param  {Boolean} data.done
     * @param  {MobileBGCarCollection} data.cars
     */
    getCurrentCars(requestData, data) {
        if (data.cars.limitReached()) {
            return data;
        }
        
        if (!data.slink) {
            this.getRedirect(requestData).then(slink => {
                data.slink = slink;
            }).catch(err => {
                console.log(err);
            });
        }

        this.getResultFromSetCookie(data.slink, data.page).then(resultsPage => {
            let cars = this.getCarObjects(this.getCarTablesFromHTML(resultsPage.data));
    
            //If there are records store them
            if (cars.length > 0) {
                cars.forEach(car => {
                    data.cars.addCar(car);
                });
                data.page += 1;
                return this.getCurrentCars(requestData, data);
            } else {
                return data;
            }
        }).catch(err => {
            console.log(err);
        });
    }

    /**
     * Async recursion method . . .
     * 
     * @param  {Object} requestData
     * @param  {Object} data
     * @param  {Number} data.page
     * @param  {Boolean} data.done
     * @param  {MobileBGCarCollection} data.cars
     */
    async getNewCars(requestData, data) {
        if (data.cars.seenTopCar && data.cars.seenCar) {
            return data;
        }

        this.getSlink(requestData).then(slink => {
            if(!data.slink) {
                data.slink = slink;
            }

            return new Promise((resolve, reject) => {
                this.getResultFromSetCookie(data.slink, data.page).then(resultsPage => {
                    let cars = this.getCarObjects(this.getCarTablesFromHTML(resultsPage.data));
            
                    if (cars.length > 0) {
                        cars.forEach(car => {
                            if(car.isTopOffer && !data.cars.seenTopCar) {
                                data.cars.addNewCar(data.shownCars, car);
                            } else if (!car.isTopOffer && !data.cars.seenCar) {
                                data.cars.addNewCar(data.shownCars, car);
                            }
                            if(data.cars.seenCar) {
                                resolve(data);
                            }
                        });
            
                        data.page += 1;
                        resolve(this.getNewCars(requestData, data));
                    } else {
                        resolve(data);
                    }
                }).catch(err => {
                    reject(err);
                });
            });
        });
    }

    getSlink(requestData) {
        return new Promise((resolve, reject) => {
            this.getRedirect(requestData)
            .then(result => {
                resolve(result);
            }).catch(err => {
                reject(err);
            });
        });
    }
}

class MobileBGCarCollection {
    /**
     * @param  {Number} carLimit=-1 "-1" for no limit anything else for a limit
     */
    constructor(carLimit = -1) {
        this.carLimit = carLimit;
        this.newCars = [];
        this.topCars = [];
        this.seenTopCar = false; //Used to check if we have passed the top cars
        this.seenCar = false; //Used to check if we have passed the normal cars
        this.cars = [];
    }

    /**
     * @param  {MobileBG} car
     */
    addCar(car) {
        if (car.isTopOffer) {
            if (this.carLimit === -1 || this.topCars.length <= this.carLimit) {
                this.topCars.push(car);
            }
        } else {
            if (this.carLimit === -1 || this.cars.length <= this.carLimit) {
                this.cars.push(car);
            }
        }
    }

    /**
     * 
     * @param {String[]} seenCars 
     * @param {MobileBG} car 
     */
    addNewCar(seenCars, car) {
        if (this.carLimit === -1 || this.newCars.length <= this.carLimit) {
            if (seenCars.indexOf(car.link) > -1) {
                if(car.isTopOffer) {
                    this.seenTopCar = true;
                } else {
                    this.seenCar = true;
                }
            } else {
                this.newCars.push(car);
            }
        }
    }

    newCarLimitReacher() {
        if (this.newCars.length >= this.carLimit * 2) {
            return true;
        }
        return false;
    }

    /**
     * @returns {Boolean}
     */
    limitReached() {
        if(this.cars.length >= this.carLimit) {
            return true;
        }

        return false;
    }

    getCarLinks() {
        let links = [];

        this.topCars.forEach(car => {
            links.push(car.link);
        });
        this.cars.forEach(car => {
            links.push(car.link);
        });

        return links;
    }

    /**
     * @returns {Array}
     */
    getNewCarLinks() {
        let links = [];

        this.newCars.forEach(car => {
            links.push(car.link)
        })

        return links;
    }
}

module.exports = {
    MobileBG: MobileBG,
    MobileBGCarCollection: MobileBGCarCollection,
};