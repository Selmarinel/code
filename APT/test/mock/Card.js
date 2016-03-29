var expect = require('chai').expect;
var assert = require('chai').assert;

var Model = require('./Model');

var types;
types = {
    note :[
        {'id': "number"},
        {'complaints': "string"},
        {'notes': "string"},
        {'symptoms': "array"},
        {'inferences': "array"},
        {'diagnosises': "array"},
        {'drugs': "array"},
        {'photos': "array"},
        {'created_at': "Object"}
    ],
    symptom:[
        {'symptom': "string"}
    ],
    inference:[
        {'inference':"string"},
        {'recommendations':"string"},
        {'time':"Object"}
    ],
    time:[
        {'doctor':"Object"},
        {'time':"string"}
    ],
    doctor:[
        {'id':"number"},
        {'name':"string"},
        {'phone':"string"},
        {'cover':"string"},
        {'specialozation':"Object"}
    ],
    specialozation:[
        {'id':"number"},
        {'name':"string"}
    ],
    diagnosis:[
        {'diagnosis': "string"}
    ],
    drug:[
        {'drug':"Object"},
        {'recipe':"string"}
    ],
    oneDrug :[
        {'id': "number"},
        {'name': "string"},
        {'description': "string"},
        {'cover': "string"}
    ],
    photo :[
        {'id': "number"},
        {'photo_url': "string"},
        {'name': "string"},
        {'description': "string"}
    ],
    created_at:[
        {'date':"string"},
        {'timezone_type':"number"},
        {'timezone':"string"}
    ],
    success:[
        {'message':"string"},
        {'status':"number"}
    ],
    photoCheck:[
        {'photo':"Object"},
        {'status':"number"}
    ],
    drugCheck:[
        {'drug':"Object"},
        {'status':"number"}
    ],
    times:[
        {'time':"string"}
    ],
    doctorCheck:[
        {'doctor':"Object"},
        {'status':"number"}
    ],
    OneDoctor:[
        {'time':"Object"},
        {'inference':"string"},
        {'recommendations':"string"}
    ],
    oneTime:[
        {'doctor':"Object"},
        {'time':"string"}
    ]
};

var method = {
    getCard : function(model){
        Model.Base.getAll(model,'note', method.note);
    },
    note : function(model){
        Model.Base.testDataByType(model,types.note);
        Model.Base.getAllSimple(model,'symptoms',method.symptom);
        Model.Base.getAllSimple(model,'inferences',method.inference);
        Model.Base.getAllSimple(model,'diagnosises',method.diagnosis);
        Model.Base.getAllSimple(model,'drugs',method.drug);
        Model.Base.getAllSimple(model,'photos',method.photo);
    },
    symptom : function(model){
        Model.Base.testDataByType(model,types.symptom);
    },
    diagnosis : function(model){
        Model.Base.testDataByType(model,types.diagnosis);
    },
    inference : function(model){
        Model.Base.testDataByType(model,types.inference);
        method.time(model.time);
    },
    created_at : function(model){
        Model.Base.testDataByType(model,types.created_at);
    },
    drug : function(model){
        Model.Base.testDataByType(model,types.drug);
        method.oneDrug(model.drug);
    },
    oneDrug : function(model){
        Model.Base.testDataByType(model,types.oneDrug);
    },
    photo : function(model){
        Model.Base.testDataByType(model,types.photo);
    },
    doctor : function(model){
        Model.Base.testDataByType(model,types.doctor);
        method.specialization(model.specialozation);
    },
    time : function(model){
        Model.Base.testDataByType(model,types.time);
        method.doctor(model.doctor);
    },
    specialization : function(model){
        Model.Base.testDataByType(model,types.specialozation)
    },
    success : function(model){
        Model.Base.testDataByType(model,types.success)
    },
    photoCheck : function(model){
        Model.Base.testDataByType(model,types.photoCheck);
        method.photo(model.photo);
    },
    drugCheck : function(model){
        Model.Base.testDataByType(model,types.drugCheck);
        method.drug(model.drug);
    },
    timesCheck : function(model){
        Model.Base.getAll(model,'times',method.times);
    },
    times : function(model){
        Model.Base.testDataByType(model,types.times);
    },
    doctorCheck : function(model){
        Model.Base.testDataByType(model,types.doctorCheck);
        method.oneDoctorCheck(model.doctor);
    },
    oneDoctorCheck : function(model){
        Model.Base.testDataByType(model,types.OneDoctor);
        method.oneTimeCheck(model.time);
    },
    oneTimeCheck : function(model){
        Model.Base.testDataByType(model,types.oneTime);
        method.doctor(model.doctor);
    }
}
module.exports = method;