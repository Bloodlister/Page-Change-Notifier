const nodemailer = require('nodemailer');
const Email = require('email-templates');

class Mailer {
    static sendMail(email, html) {
        let fromEmail;
        if (!process.env.EMAIL_ADDRESS) {
            fromEmail = require('./../settings.js').mailing.email;
        }

        let email = Email({
            message: {
                from: fromEmail
            }
        });
    }
}

class MobileBG extends Mailer {
    notifyForNewCars(email, cars) {

    }
}

module.exports = {
    MobileBG: MobileBG,
};