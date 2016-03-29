var Config = require('../config');
var log = require('../libs/log')(module);

var config = {
    status : {
        error : Config.get("apiCode").error,
        ok : Config.get("apiCode").success
    },
    serverUrl : 'http://apt.loc/api/'
}

module.exports = config;