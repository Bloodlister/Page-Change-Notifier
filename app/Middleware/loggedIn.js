function loggedIn(req, res, next) {
    if ((req.path !== '/login' && req.path !== '/register') && !req.session.email) {
        res.redirect('/login');
    } else if ((req.path === '/login' || req.path === '/register') && req.session.email) {
        res.redirect('/');
    } else if ((req.path ==='/login' || req.path === '/register') && !req.session.email) {
        next();
    } else {
        next();
    }
}

module.exports = {
    loggedIn: loggedIn,
};
