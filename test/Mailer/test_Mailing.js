const path = require('path');
const Email = require('email-templates');
const MobileBG = require('./../../app/Reducers.js').MobileBG;

describe('Sending email', () => {

    it('Sends email', (done) => {
        let testEmail = new Email({
            send: true,
            juice: true,
            juiceResources: {
                preserveImportant: true,
                webResources: {
                    relativeTo: path.join(__dirname, '..', '..', 'src')
                }
            },
            views: {
                options: {
                    extension: 'ejs',
                },
            },
        });

        let car1 = new MobileBG('');
        car1.desc = 'jahsdvb kjahsdvb akjsghdv jkasdgvbjashdv akjsgdv jahsgdv jahsgdv jahgsdvbjhagsdvbjasd дата на произв. - май 2013 г., пробег - 163140 км, цвят - Бял, Перфектно състояние! ! ! Като Нов! ! ! Нов внос; E...<br>Особености - 4(5) Врати, Auto Start Stop function, Bluetoo...<br>Регион: Сливен, гр. Сливен';
        car1.title = 'test';
        car1.image = 'https://sc01-ha-b.mobile.bg/photos/1/med/11509028961101458_5.pic';
        car1.price = '1523 лв.';
        car1.link = 'https://youtube.com'

        let senderEmail;
        if (!process.env.SENDER_EMAIL) {
            senderEmail = require('./../../settings.js').sender.email;
        } else {
            senderEmail = process.env.SENDER_EMAIL;
        }

        testEmail.send({
            message: {
                to: senderEmail,
                from: senderEmail,
                subject: "Test email",
            },
            template: "MobileBG",
            locals: {
                cars: [car1, car1],
            },
        }).then(res => {
            console.log(res);
            done();
        }).catch(err => {
            console.log(err);
            done(err);
        })
    });
});