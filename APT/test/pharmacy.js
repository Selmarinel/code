var config = require('../test/config');
var request = require('request');
var Pharmacy = require('./mock/Pharmacy');
var assert = require('chai').assert;

describe('pharmacy methods', function() {

    var take = 10;
    var skip = 0;
    var name = '';
    var id   = 1;
    var id1  = 2;
    var spId = 13;

    it('pharmacy Get All pharmacy', function(done){
        request.get(
            {
                url: config.serverUrl + 'pharmacy?take='+take+'&skip='+skip+'&name='+name
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Pharmacy.getPharmacy(response);
                done();
            }
        )
    });

    it('pharmacy Get one', function(done){
        request.get(
            {
                url: config.serverUrl + 'pharmacy/'+id,
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response)
                Pharmacy.one(response);
                done();
            }
        )
    });

    it('pharmacy Get all drug from one pharmacy', function(done){
        request.get(
            {
                url: config.serverUrl + 'pharmacy/'+id+'/drugs/',
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response)
                Pharmacy.allDrugs(response);
                done();
            }
        )
    });

    it('pharmacy Get All hospitals', function(done){
        request.get(
            {
                url: config.serverUrl + 'hospitals?take='+take+'&skip='+skip+'&name='+name,
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response)
                Pharmacy.getHospitals(response);
                done();
            }
        )
    });

    it('pharmacy Get One hospital', function(done){
        request.get(
            {
                url: config.serverUrl + 'hospitals/'+id1,
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response)
                Pharmacy.oneHospitals(response);
                done();
            }
        )
    });

    it('pharmacy get doctors of hospital by specialization', function(done){
        request.get(
            {
                url: config.serverUrl + 'hospitals/'+id1+'/spec/'+spId,
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response)
                Pharmacy.getDoctorsBySpecialization(response);
                done();
            }
        )
    });

})