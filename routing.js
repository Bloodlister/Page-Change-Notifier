
function setRouters(app) {
    let routers = [
        require('./app/Routers/Base.js'),
        require('./app/Routers/Mailer.js'),
        require('./app/Routers/Auth.js'),
        require('./app/Routers/Listenings.js'),
    ];

    routers.forEach((router) => {
        app.use(router.expressUrlPath, router);
    });
}

module.exports = setRouters;

