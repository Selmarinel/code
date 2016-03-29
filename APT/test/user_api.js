var config = require('../test/config');
var request = require('request');
var User = require('./mock/User');
var FUser = require('./fixtures/Users');
var assert = require('chai').assert;

describe('user_api methods', function() {

    var token = '';
    var id = 1;

    it('user_api show user', function(done){
        request.get(
            {
                url: config.serverUrl + 'users/'+id
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                User.getUser(response);
                done();
            }
        )
    });
    it('user_api show all user', function(done){
        request.get(
            {
                url: config.serverUrl + 'users'
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                User.getAllUsers(response);
                done();
            }
        )
    });
    // тест на добавление друга
    // тест на удаление друга
})