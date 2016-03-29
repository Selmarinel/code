var config = require('../test/config');
var request = require('request');
var Drug = require('./mock/Drugs');
var assert = require('chai').assert;

describe('drugs methods', function() {

    var take = 10;
    var skip = 0;
    var name = '"';
    var id = 1;

    it('drugs Get All goods', function(done){
        request.get(
            {
                url: config.serverUrl + 'drugs?take='+take+'&skip='+skip+'&name='+name
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Drug.getDrugs(response);
                done();
            }
        )
    });

    it('drugs Get one', function(done){
        request.get(
            {
                url: config.serverUrl + 'drugs/'+id,
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                Drug.oneDrug(response);
                done();
            }
        )
    });
})