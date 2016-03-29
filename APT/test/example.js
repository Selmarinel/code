var config = require('../test/config');
var UserMock = require('./mock/User');
var expect = require('chai').expect;
var assert = require('chai').assert;
var request = require('request');

describe('Example methods', function(){

    var flag = '';

    it('test set flag', function(done){
        flag = 1;
        done();
    })
    it('test chk flag', function(done){
        assert.typeOf(flag, 'boolean');
        done();
    })
    it('test Auth', function(done){
        var response = {
            id: 1,
            token : 'token'
        }
        UserMock.getAuthEmail(response);
        done();
    })
});