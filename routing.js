
function setRouters(app) {
    let routers = [
        require('./app/Routers/Mailer.js'),
        require('./app/Routers/Auth.js'),
    ];

    routers.forEach((router) => {
        app.use(router.expressUrlPath, router);
    });
}

module.exports = setRouters;

