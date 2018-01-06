require("dotenv").config();
var Echo = require("laravel-echo-server");

/**
 * The Laravel Echo Server options.
 */

var options = {
    "appKey": process.env.ECHO_KEY,
    "authHost": process.env.ECHO_AUTH_HOST,
    "authEndpoint": process.env.ECHO_AUTH_ENDPOINT,
    "database": process.env.ECHO_DATABASE,
    "databaseConfig": {
        "redis": {
            "port": 6379,
            "host": process.env.ECHO_REDIS_HOST
        },
        "sqlite": {
            "databasePath": process.env.ECHO_SQLITE_PATH
        }
    },
    "devMode": process.env.ECHO_DEV_MODE,
    "host": process.env.ECHO_HOST,
    "protocol": process.env.ECHO_PROTOCOL,
    "port": process.env.ECHO_PORT,
    "referrers": [],
    "socketio": {
        "port": 9090,
    },
    "sslCertPath": process.env.ECHO_SSL_CERT_PATH,
    "sslKeyPath": process.env.ECHO_SSL_KEY_PATH,
    "verifyAuthPath": true,
    "verifyAuthServer": true
};

/**
 * Run the Laravel Echo Server.
 */
Echo.run(options);