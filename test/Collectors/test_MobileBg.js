const assert = require('assert');
const MobileBGCollector = require('../../app/Collectors').MobileBG;

const dataToSend = {
    topmenu: "1",
    rub: "1",
    act: "3",
    rub_pub_save: "1",
    f1: "1",
    f2: "1",
    f3: "1",
    f4: "1",
    f5: "",
    f6: "",
    f7: "",
    f8: "",
    f9: "лв.",
    f10: "",
    f11: "",
    f12: "",
    f13: "",
    f14: "",
    f15: "0",
    f16: "",
    f17: "",
    f18: "",
    f19: "0",
    f20: "7",
    f21: "01",
    f24: "0",
    f25: "",
    f26: "",
    f27: "",
    f28: "",
    f29: "",
    f30: "",
    f31: ""
};

const collector = new MobileBGCollector(dataToSend);
describe('Getting results from MobileBG', function() {
    let slink;
    describe('test one', () => {
        it('Calls the MobileBG search and gets the correct setCookie', (done) => {
            collector.getRedirect(dataToSend).then((res) => {
                assert.strictEqual(typeof res, 'string');
                slink = res;
                done();
            })
        });
    });

    let results = '';
    describe('test two', () => {
        it('Gets the result from the slink', (done) => {
            collector.getResultFromSetCookie(slink, 1).then(res => {
                assert.strictEqual(typeof res.data, 'string');
                assert.strictEqual(res.data.startsWith('<!DOCTYPE'), true);
                results = res.data;
                done();
            })
        });
    });

    let carsTable;
    describe('test three', () => {
        it('Gets the table containing all the car results', () => {
            carsTable = collector.getTableOfCarsFromResults(results);
            assert.strictEqual(carsTable.querySelectorAll('table').length > 5, true);
        });
    });

    describe('test four', () => {
        it('Returns collection of all the cars', () => {
            carObjects = collector.getCarObjects(carsTable);
            let testCar = carObjects[0];
            assert.strictEqual(typeof testCar.title, 'string');
            assert.strictEqual(testCar.title.length > 0, true);
            assert.strictEqual(testCar.image.endsWith('pic'), true);
            assert.strictEqual(testCar.isTopOffer, true);
        });
    });
});
