var config = require('../test/config');
var request = require('request');
var Graphic = require('./mock/Graphic');
var assert = require('chai').assert;

describe('graphic methods', function() {

    var take = 10;
    var skip = 0;
    var name = '';
    var id   = 1;
    var id1  = 1;
    var id2 = 7;
    var id3 = 3;
    var time = "2015-12-16 08:06:21";
    var count = 1.2;

    it('graphic Get All grafics', function(done){
        request.get(
            {
                url: config.serverUrl + 'graphic/'+id+'?take='+take+'&skip='+skip+'&name='+name
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Graphic.getDrugs(response);
                done();
            }
        )
    });

    it('graphic addTime', function(done){
        request.post(
            {
                url: config.serverUrl + 'graphic/add_time',
                form: {
                    "graphic_id": id1,
                    "times_and_dates" : time
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                done();
            }
        )
    });

    it('graphic deleteTime', function(done){
        request.get(
            {
                url: config.serverUrl + 'graphic/delete_time/'+id2
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                done();
            }
        )
    });

    it('graphic addDrug', function(done){
        request.post(
            {
                url: config.serverUrl + 'graphic/add',
                form: {
                    "user_id": id,
                    "drug_id" : id1,
                    "count" : count
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                done();
            }
        )
    });

    it('graphic deleteDrug', function(done){
        request.get(
            {
                url: config.serverUrl + 'graphic/delete/'+id3
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                done();
            }
        )
    });
})