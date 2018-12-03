const User = require('../MongooseModels/User.js');

class AuthController {
    static login(req, res) {
        let data = {};
        if (req.query) {
            data.err = req.query.err;
        }

        res.render('./../Views/login.ejs', data);
    }

    static register(req, res) {
        let data = {};
        if (req.query) {
            data.err = req.query.err;
        }

        res.render('./../Views/register.ejs');
    }

    static loginUser(req, res) {
        if(req.body.email && req.body.password) {
            User.authenticate(req.body.email, req.body.password, (err, user) => {
                if (err) {
                    res.redirect('/login?err=' + err.message);
                } else {
                    req.session.user_id = user._id;
                    req.session.email = user.email;
                    req.session.save();
                    res.redirect('/login?success=1');
                }
            })
        }
    }

    static registerUser(req, res) {
        if (req.body.app_password != "super_secret_password_123456") {
            return res.redirect('/register?err=Wrong app password');
        }
        if (req.body.email && req.body.username && req.body.password && req.body.passwordConf) {
            let userData = {
                email: req.body.email,
                username: req.body.username,
                password: req.body.password,
                passwordConf: req.body.passwordConf,
            };

            User.create(userData, (err, user) => {
                if(err) {
                    return res.redirect('/register?err=' + err.message);
                } else {
                    return res.redirect('/login');
                }
            });
        }
    }

    static logout(req, res) {
        req.session.destroy((err) => {});
        res.redirect('/login');
    }
}

module.exports = AuthController;