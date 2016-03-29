var expect = require('chai').expect;
var assert = require('chai').assert;

var Model = require('../../test/mock/Model');

var types;
types = {
    auth: [
        {'token' : "string"},
        {'status' : "number"},
    ],
    registration: [
        {'sms' : 'number'},
        {'status' : 'number'}
    ],
    sms_validation: [
        {'user' : "object"},
        {'status':"number"}
    ],
    user :[
        {'id':"number"},
        {'email': "string"},
        {'first_name': "string"},
        {'last_name': "string"},
        {'surname': "string"},
        {'cover': "string"},
        {'address':"string"},
        {'phone': "string"},
        {'role':"number"},
        {'created_at':"string"},
        {'updated_at':"string"}
    ],
    password: [
        {'password': "string"},
        {'status': "number"}
    ],
    shortUser:[
        {'name'   : "string"},
        {'phone'  : "string"},
        {'cover'  : "string"},
        {'snils'  : "string"},
    ],
    userWithFriends:[
        {'name'   : "string"},
        {'phone'  : "string"},
        {'cover'  : "string"},
        {'snils'  : "string"},
        {'friend' : "array"},
        {'status' : "number"}
    ]
};
var phone = null;

var method = {

    getAuth : function(model) {
        Model.Base.testDataByType(model,types.auth);
    },
    getRegistration : function(model) {
        Model.Base.testDataByType(model,types.registration);
    },
    getNewPassword : function(model) {
        Model.Base.testDataByType(model,types.password);
    },
    getActivation : function(model){
        Model.Base.testDataByType(model,types.sms_validation);
    },
    getFriends : function(model){
        Model.Base.testDataByType(model,types.shortUser);
    },
    getUser : function(model){
        Model.Base.testDataByType(model,types.userWithFriends);
        Model.Base.getAllSimple(model, 'friend', method.scopeUser);
    },
    scopeUser : function(model){
        Model.Base.testDataByType(model,types.shortUser);
    },
    getAllUsers : function(model){
        Model.Base.getAll(model,'users', method.scopeUser);
    }
}
module.exports = method;