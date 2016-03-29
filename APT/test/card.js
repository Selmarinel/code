var config = require('../test/config');
var request = require('request');
var Card = require('./mock/Card');
var assert = require('chai').assert;

describe('card methods', function() {

    var take = 10;
    var skip = 0;
    var name = '"';
    var id = 1;
    var id1 = 4;
    var id2 = 1;
    var pName = "test";
    var pDescription = "test";
    var pUrl = "http://url.com"; //Я не знаю как сюда передать изображение((
    var dId = 1;
    var dRecipe = "test";
    var time = "12.12.12 12:12:12";
    var docId = 1;
    var docI = "test";
    var docR = "test";

    it('Card Get All goods', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'?take='+take+'&skip='+skip+'&name='+name
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.getCard(response);
                done();
            }
        )
    });
    it('Card Add symptom to card', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/symptom/'+id1+'+/add'
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Delete symptom to card', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/symptom/'+id1+'+/del'
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Add diagnosis to card', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/diagnosis/'+id1+'+/add'
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Delete diagnosis to card', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/diagnosis/'+id1+'+/del'
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });

    it('Card Add photo', function(done){
        request.post(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/photo/add',
                form: {
                    "url": pUrl,
                    "name" : pName,
                    "description": pDescription
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Show photo', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/photo/'+id
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.photoCheck(response);
                done();
            }
        )
    });
    it('Card Edit photo', function(done){
        request.post(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/photo/edit/'+id,
                form: {
                    "url": pUrl,
                    "name" : pName,
                    "description": pDescription
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Delete photo', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/photo/del/'+id
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });

    it('Card Add drug', function(done){
        request.post(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/drug/add',
                form: {
                    "drug_id": dId,
                    "recipe" : dRecipe
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Show drug', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/drug/'+id
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.drugCheck(response);
                done();
            }
        )
    });
    it('Card Edit drug', function(done) {
        request.post(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/drug/edit/'+id,
                form: {
                    "drug_id": dId,
                    "recipe" : dRecipe
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Delete drug', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/drug/del/'+id
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });

    it('Card DOCTOR Add Time', function(done){
        request.post(
            {
                url: config.serverUrl + 'doctor/'+id+'/add_time',
                form: {
                    "fTime": time
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card DOCTOR Times', function(done){
        request.get(
            {
                url: config.serverUrl + 'doctor/'+id+'/times'
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.timesCheck(response);
                done();
            }
        )
    });
    it('Card TIME change status', function(done){
        request.get(
            {
                url: config.serverUrl + 'time/'+id
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });

    it('Card Add doctors', function(done){
        request.post(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/doctors/add',
                form: {
                    "inference": docI,
                    "recommendations" : docR,
                    "doctor_times_id": docId
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Edit doctors', function(done){
        request.post(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/doctors/edit'+id1,
                form: {
                    "inference": docI,
                    "recommendations" : docR,
                    "doctor_times_id": docId
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });
    it('Card Show doctors', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/doctors/'+id2
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.doctorCheck(response);
                done();
            }
        )
    });
    it('Card Delete doctors', function(done){
        request.get(
            {
                url: config.serverUrl + 'medical_card/card/'+id+'/doctors/del/'+id1
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(response);
                Card.success(response);
                done();
            }
        )
    });

})