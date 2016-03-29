var config = require('../test/config');
var request = require('request');
var User = require('./mock/User');
var FUser = require('./fixtures/Users');
var assert = require('chai').assert;

describe('auth methods', function() {

    var token = '';

    it('auth Login', function(done){
        request.post(
            {
                url: config.serverUrl + 'auth',
                form: {
                    "phone": FUser.model.phone,
                    "email": FUser.model.email,
                    "password": FUser.model.password
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                User.getAuth(response);
                token = response.token;
                assert.equal(response.status, 201, 'Status not 201');
                done();
            }
        )
    });
    it('auth Register', function(done){
        var phone = '';
        for (var i=1; i<10; i++){
            phone = phone + (Math.random()*9);
        }
        request.post(
            {
                url: config.serverUrl + 'reg',
                form: {
                    "first_name":FUser.model2.first_name,
                    "last_name":FUser.model2.last_name,
                    "surname":FUser.model2.surname,
                    "role":FUser.model2.role,
                    "cover":FUser.model2.cover,
                    "phone": phone,
                    "email": (Math.random()*5) + FUser.model2.email,
                    "password": FUser.model2.password
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                User.getRegistration(response);
                done();
            }
        )
    });
    it('auth Sms Validation', function(done){
        request.post(
            {
                url: config.serverUrl + 'smsval',
                form: {
                    "phone": FUser.model.phone,
                    "code": "123" /*заглушка */
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                User.getActivation(response);
                token = response.token;
                done();
            }
        )
    });
    it('auth Restore password', function(done){
        request.post(
            {
                url: config.serverUrl + 'restore',
                form: {
                    "phone": FUser.model2.phone,
                    "code": "123" /*заглушка */
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                User.getNewPassword(response);
                token = response.token;
                done();
            }
        )
    });
})