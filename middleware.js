let middleware = [];

function setMiddleware(app) {
    middleware.forEach((middleware) => {
        middleware(middleware.route, app);
    });
}

module.exports = setMiddleware;