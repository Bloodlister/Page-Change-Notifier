module.exports = function loggedIn(req, res, next) {
    console.log(req.session);
    if (req.session) {
        next();
    } else {
        res.redirect('/');
    }
};
