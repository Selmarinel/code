var expect = require('chai').expect;
var assert = require('chai').assert;

var Model = require('./Model');

var types;
types = {
    onePharmacy:[
        {'pharmacy':"object"},
        {'status':"number"}
    ],
    oneHospital:[
        {'hospital':"object"},
        {'status':"number"}
    ],
    pharmacy :[
        {'id': "number"},
        {'phone': "string"},
        {'cover': "string"},
        {'name': "string"},
        {'url': "string"},
        {'address': "string"},
        {'description': "string"},
        {'time': "string"},
        {'payment': "array"},
        {'users': "array"},
    ],
    users:[
        {'id':"number"},
        {'name':"string"}
    ],
    user:[
        {'name':"string"},
        {'phone':"string"},
        {'cover':"string"},
        {'snils':"string"}
    ],
    drug:[
        {'id': "number"},
        {'name': "string"},
        {'description': "string"},
        {'cover': "string"}
    ],
    drugs:[
        {'drugs':"array"},
        {'status':"number"}
    ],
    hospitals :[
        {'id': "number"},
        {'phone': "string"},
        {'cover': "string"},
        {'name': "string"},
        {'address': "string"},
        {'description': "string"},
        {'time': "string"},
        //{'doctors': "array"},
        {'specializations': "array"}
    ],
    doctors:[
        {'doctors':"array"},
        {'status':"number"}
    ],
    doctor:[
        {'id':"number"},
        {'name':"string"},
        {'phone':"string"},
        {'cover':"string"}
        /*{'specialization':"object"}*/
    ],
    specialization:[
        {'id':"number"},
        {'name':"string"}
    ]
};

var method = {
    getPharmacy : function(model){
        Model.Base.getAll(model,'pharmacy', method.onePharmacy);
    },
    one : function(model){
        Model.Base.testDataByType(model,types.onePharmacy);
    },
    onePharmacy : function(model){
        Model.Base.testDataByType(model,types.pharmacy);
        Model.Base.getAllSimple(model, 'users', method.user);
    },
    user : function(model){
        Model.Base.testDataByType(model,types.user);
    },
    allDrugs : function(model){
        Model.Base.testDataByType(model,types.drugs);
        Model.Base.getAllSimple(model, 'drugs', method.drug);
    },
    drug : function(model){
        Model.Base.testDataByType(model,types.drug);
    },
    getHospitals : function(model){
        Model.Base.getAll(model,'hospitals', method.oneHospital);
    },
    oneHospital : function(model){
        Model.Base.testDataByType(model,types.hospitals);
        Model.Base.getAllSimple(model, 'specializations', method.specialization);
    },
    doctor : function(model){
        Model.Base.testDataByType(model,types.doctor);
        //Model.Base.testDataByType(model.specialization,types.specialization);
    },
    specialization : function(model){
        Model.Base.testDataByType(model,types.specialization);
    },
    oneHospitals : function(model){
        Model.Base.testDataByType(model,types.oneHospital);
        Model.Base.testDataByType(model.hospital,types.hospitals);
        //Model.Base.getAllSimple(model.hospital, 'doctors', method.doctor);
        Model.Base.getAllSimple(model.hospital, 'specializations', method.specialization);
    },
    getDoctorsBySpecialization:function(model){
        Model.Base.testDataByType(model,types.doctors);
        Model.Base.getAllSimple(model, 'doctors', method.doctor);
    },
    drugs: function(model){
    }// Я ЕБУ((
}
module.exports = method;