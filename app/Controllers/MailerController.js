const nodemailer = require('nodemailer');

class MailerController {
    static testMail(req, res) {
        const transporter = nodemailer.createTransport({
            service: 'gmail',
            auth: {
                user: req.query.email,
                pass: req.query.password,
            },
        });

        const mailOptions = {
            from: req.query.email,
            to: 'AsenJ.Mihaylov@gmail.com',
            subject: 'Testrun',
            text: "This can't be this easy",
        };

        transporter.sendMail(mailOptions, (error, info) => {
            if (error) {
                console.log(error);
            } else {
                console.log(`Email sent: ${info.response}`);
            }
        });
    }
}

module.exports = MailerController;
