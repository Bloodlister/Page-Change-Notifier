const path = require('path');
const nodemailer = require('nodemailer');
const Email = require('email-templates');

class Mailer {
    constructor(receiver) {
        this.receiverEmail = receiver;
    }

    async sendMail(html) {
        let senderEmail;
        let senderPassword;
        if (!process.env.SENDER_EMAIL && !process.env.SENDER_PASSWORD) {
            senderEmail = require('./../settings.js').sender.email;
            senderPassword = require('./../settings.js').sender.password;
        } else {
            senderEmail = process.env.SENDER_EMAIL;
            senderPassword = process.env.SENDER_PASSWORD;
        }

        let transporter = nodemailer.createTransport({
            service: 'gmail',
            auth: {
                user: senderEmail,
                pass: senderPassword,
            },
        });

        transporter.sendMail({
            from: senderEmail,
            to: this.receiverEmail,
            subject: "New Cars",
            html: html,
        }).then(() => {
            return true;
        });
    }
}

class MobileBG extends Mailer {
    /**
     * @param {MobileBG[]} cars 
     */
    getTemplateForNewCars(cars) {
        return new Promise((resolve, reject) => {
            let emailTemplate = new Email({
                juice: true,
                juiceResources: {
                    preserveImportant: true,
                    webResources: {
                        relativeTo: path.join(__dirname, '..', 'src')
                    }
                },
                views: {
                    options: {
                        extension: 'ejs',
                    },
                },
            });
    
            emailTemplate.render('MobileBG/html', {
                cars: cars,
            }).then(template => {
                resolve(template);
            });
        })
    }
}

module.exports = {
    MobileBG: MobileBG,
};