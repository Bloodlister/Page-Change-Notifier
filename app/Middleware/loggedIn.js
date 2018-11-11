function loggedIn(req, res, next) {
    if ((req.path === '/login' || req.path === '/register') && !req.session.email) {
        next();
    } else {
        res.redirect('/login');
    }
}

module.exports = {
    loggedIn: loggedIn,
};
