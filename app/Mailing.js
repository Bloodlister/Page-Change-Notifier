const nodemailer = require('nodemailer');

class Mailer {
    static sendMail(email, html) {
        return new Promise((resolve, reject) => {
            let sender;
            let senderPass;
    
            if (!process.env.EMAIL_ACCOUNT) {
                const senderSettings = require('../settings.js').sender;
                sender = senderSettings.email;
                senderPass = senderSettings.password;    
            } else {
                sender = process.env.EMAIL_ACCOUNT;
                senderPass = process.env.EMAIL_PASSWORD;
            }
    
            var transporter = nodemailer.createTransport({
                service: 'gmail',
                auth: {
                    user: sender,
                    pass: senderPass,
                },
            });
    
            var mailOptions = {
                from: sender,
                to: email,
                subject: "New cars are out!",
                text: html
            };
    
            transporter.sendMail(mailOptions, function (error, info) {
                if (error) {
                    reject(error);
                } else {
                    resolve(true);
                }
            });
        })
    }
}

class MobileBG extends Mailer {
    notifyForNewCars(email, cars) {

    }
}

module.exports = {
    MobileBG: MobileBG,
};