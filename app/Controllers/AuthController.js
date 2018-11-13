class AuthController {
    static login(req, res) {
        res.send('Login page');
    }

    static loginUser(req, res) {
        res.send('Login User');
    }

    static register(req, res) {
        res.send('Registration Page');
    }

    static registerUser(req, res) {
        res.send('Register User');
    }

    static logout(req, res) {
        req.session.destroy((err) => {
            console.log(err);
        });
        res.redirect('/login');
    }
}

module.exports = AuthController;