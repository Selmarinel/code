var config = require('../test/config');
var expect = require('chai').expect;
var assert = require('chai').assert;
var request = require('request');
var md5 = require('md5');

describe('Taxi methods', function(){

    var token = '';
    var token2 = '';
    var EventId = 23723;
    var TrainId = 3040;
    var isCheckin = false;
    var ride_id = '';

    it('TAXI registration by email', function(done){
        request.post(
            {
                url: config.serverUrl + 'v3/user/email',
                form: {
                    "secret": md5("2event" + User.model.email + md5(User.model.password)), //md5(“2event” + email + md5(password))
                    "first_name": User.model.first_name,
                    "last_name": User.model.last_name,
                    "avatar": User.model.avatar, // url
                    "city": User.model.city, // city id from city autocomplete method
                    "email": User.model.email,
                    "password": md5(User.model.password)
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                userMock.getAuthEmail(response);
                token = response.token;
                console.log(token);
                done();
            }
        )
    })
    it('TAXI registration by email to User2', function(done){
        request.post(
            {
                url: config.serverUrl + 'v3/user/email',
                form: {
                    "secret": md5("2event" + User.model2.email + md5(User.model2.password)), //md5(“2event” + email + md5(password))
                    "first_name": User.model2.first_name,
                    "last_name": User.model2.last_name,
                    "avatar": User.model2.avatar, // url
                    "city": User.model2.city, // city id from city autocomplete method
                    "email": User.model2.email,
                    "password": md5(User.model2.password)
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                userMock.getAuthEmail(response);
                token2 = response.token;
                console.log(token2);
                done();
            }
        )
    })
    //it('TAXI train checkin to Train', function(done){
    //    request.post(
    //        {
    //            url: config.serverUrl + 'v3/train/checkin/',
    //            headers: {
    //                'USER-AUTH': token
    //            },
    //            form: {
    //                "full_number": "23",  // номер поїзда
    //                "carriage": "5", // вагон
    //                "seat": "2", // місце
    //                "depart_time" : "1441199734", // час відбуття зі станції пасажира
    //                "depart_station": "KIEV",  // станція відправлення пасажира
    //                "from": "Kiev",  // optional, початкова станція поїзда
    //                "arrive_time" : 1441199734, // час прибуття на станція пасажира
    //                "arrive_station": "End"
    //            }
    //        },
    //        function(err,httpResponse,body){
    //            console.log(body, token);
    //            //var response = JSON.parse(body);
    //            done();
    //        }
    //    )
    //})
    it('TAXI get EVENTS', function(done){
        request.post(
            {
                url: config.serverUrl + 'v3/newsapp/events/',
                headers: {
                    'USER-AUTH': token
                }
            },
            function(err,httpResponse,body){
                console.log(body);
                var response = JSON.parse(body);
                expect(response[0]).to.have.property('event_id');
                assert.isNumber(response[0].event_id);
                EventId = response[0].event_id;
                done();
            }
        )
    })
    it('TAXI get my checkIn EVENTs', function(done){
        request.get(
            {
                url: config.serverUrl + 'v3/events/',
                headers: {
                    'USER-AUTH': token
                }
            },
            function(err,httpResponse,body){
                console.log(body);
                var response = JSON.parse(body);

                isCheckin = (response.length);
                console.log(response);
                done();
            }
        )
    })
    it('TAXI get EVENT INFO', function(done){
        request.get(
            {
                url: config.serverUrl + 'v3/events/',
                headers: {
                    'USER-AUTH': token
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                expect(response[0]).to.have.property('event_id');
                assert.isNumber(response[0].event_id);
                event_id = response[0].event_id;
                console.log(response);
                done();
            }
        )
    })
    it('TAXI create EVENT checkIN', function(done){
        if(isCheckin) {
            return done();
        }
        request.post(
            {
                url: config.serverUrl + '/v3/events/add/',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    "event_id": EventId,
                    "message": "My First CHECKIN"
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                //expect(response[0]).to.have.property('event_id');
                //assert.isNumber(response[0].event_id);
                event_id = response[0].event_id;
                console.log(response);
                done();
            }
        )
    })
    it('TAXI create group Taxi', function(done){
        request.post(
            {
                url: config.serverUrl + 'v3/taxi/order/',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    "obj_type": 1,
                    "obj_id": EventId,
                    "before_obj": 0,
                    "ride_from_address": "ул. Замковая, 515",
                    "ride_to_address": "ул. Драгоманова, Украина",
                    "from_lat": "50.474613",
                    "from_lng": "30.506389",
                    "to_lat": "50.377615",
                    "to_lng": "30.468195",
                    "cost": "20",
                    "date_of_ride": "2015-09-04T16:14:06.072+03:00",
                    "time_of_ride": "08:14:00",
                    "passenger_count": 1,
                    "phone_number": "02"
                }
            },
            function(err,httpResponse,body) {
                var response = JSON.parse(body);
                ride_id = response.id;
                console.log(response, body);
                done();
            }
        )
    })
    it('TAXI get one group Taxi', function(done){
        console.log(ride_id);
        request.get(
            {
                url: config.serverUrl + 'v3/taxi/get/' + ride_id,
                headers: {
                    'USER-AUTH': token2
                }
            },
            function(err,httpResponse,body){
                console.log(body, token2, ride_id);
                var response = JSON.parse(body);
                Mock.getGroup(response);
                console.log(response);
                done();
            }
        )
    })
    it('TAXI getAll groups Taxi', function(done) {
        request.get(
            {
                url: config.serverUrl + 'v3/taxi/all/',
                headers: {
                    'USER-AUTH': token2
                }
            },
            function(err,httpResponse,body){
                console.log(123, body, token2, ride_id);
                var response = JSON.parse(body);
                Mock.getGroups(response);
                console.log(response, ride_id);
                done();
            }
        )
    })
    it('TAXI getAll groups Taxi by city', function(done) {
        request.get(
            {
                url: config.serverUrl + 'v3/taxi/all/',
                headers: {
                    'USER-AUTH': token2
                }
            },
            function(err,httpResponse,body){
                console.log(123, body, token2, ride_id);
                var response = JSON.parse(body);
                Mock.getGroups(response);
                console.log(response, ride_id);
                done();
            }
        )
    })
    it('TAXI SetInfo group Taxi', function(done){
        var car_identifier = 'car_identifier';
        var taxi_service_name = 'taxi_service_name';
        request.post(
            {
                url: config.serverUrl + 'v3/taxi/ride_info/',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    'ride_id' : ride_id,
                    'taxi_service_name' : taxi_service_name,
                    'car_identifier' : car_identifier
                }
            },
            function(err,httpResponse,body){
                console.log(body);
                var response = JSON.parse(body);
                console.log(response);
                expect(response).to.not.include.keys('error');
                request.get(
                    {
                        url: config.serverUrl + 'v3/taxi/get/' + ride_id,
                        headers: {
                            'USER-AUTH': token2
                        }
                    },
                    function(err,httpResponse,body){
                        console.log(body, token2, ride_id);
                        var response = JSON.parse(body);
                        Mock.getGroup(response);
                        assert(response.car_identifier == car_identifier, 'car_identifier not save');
                        assert(response.taxi_service_name == taxi_service_name, 'taxi_service_name don\'t save');
                        console.log(response);
                        done();
                    }
                )
            }
        )
    })
    it('TAXI delete group Taxi', function(done){
        console.log(ride_id);
        request.post(
            {
                url: config.serverUrl + 'v3/taxi/cancel/',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    'id' : ride_id
                }
            },
            function(err,httpResponse,body){
                done();
            }
        )
    })
    it('TAXI get TRAIN INFO', function(done){
        request.get(
            {
                url: config.serverUrl + 'v3/train/checkin',
                headers: {
                    'USER-AUTH': token
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(body, response.length)
                TrainId = response[0].full_number;
                isCheckin = (response.length);
                done();
            }
        )
    })
    it('TAXI create TRAIN checkIN', function(done){
        if(isCheckin) {
            return done();
        }
        request.post(
            {
                url: config.serverUrl + '/v3/train/checkin',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    "full_number" : "12",  // номер поїзда
                    "carriage" : "12", // вагон
                    "seat" : "123", // місце
                    "depart_time" : "1355956320",// час відбуття зі станції пасажира
                    "depart_station": "1",  // станція відправлення пасажира
                    "from": "1",  // optional, початкова станція поїзда
                    "arrive_time" : "1355990880", // час прибуття на станція пасажира
                    "arrive_station": "2" //станція прибуття пасажира
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
                console.log(body, response)
                expect(response[0]).to.have.property('checkin_id');
                assert.isNumber(response[0].checkin_id);
                TrainId = response[0].checkin_id;
                done();
            }
        )
    })
    it('TAXI create group Taxi to Train', function(done){
        request.post(
            {
                url: config.serverUrl + 'v3/taxi/order/',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    "obj_type": 2,
                    "obj_id": TrainId,
                    "before_obj": 0,
                    "ride_from_address": "ул. Вечевая, 1,Львов,Украина",
                    "ride_to_address": "Пустомытовский район,null,Украина",
                    "from_lat": "50.474613",
                    "from_lng": "30.506389",
                    "to_lat": "50.377615",
                    "to_lng": "30.468195",
                    "cost": "116",
                    "date_of_ride": "2015-09-07T12:04:49.900+03:00",
                    "time_of_ride": "00:04:00",
                    "passenger_count": 1,
                    "phone_number": "02"
                }
            },
            function(err,httpResponse,body){
                var response = JSON.parse(body);
//                ride_id = response.id;
                console.log(response, body);
                done();
            }
        )
    })
    it('TAXI join group Taxi', function(done){
        request.post(
            {
                url: config.serverUrl + 'v3/taxi/join/',
                headers: {
                    'USER-AUTH': token2
                },
                form: {
                    'id' : ride_id,
                    'phone_number' : "234234234",
                    "comment" : "It's my comment",
                    "from_address" : "from_address"
                }
            },
            function(err,httpResponse,body){
                console.log(body, token2, ride_id);
                //var response = JSON.parse(body);
                done();
            }
        )
    })
    it('TAXI delete group Taxi', function(done){
        console.log(ride_id);
        request.post(
            {
                url: config.serverUrl + 'v3/taxi/cancel/',
                headers: {
                    'USER-AUTH': token
                },
                form: {
                    'id' : ride_id
                }
            },
            function(err,httpResponse,body){
                done();
            }
        )
    })
});