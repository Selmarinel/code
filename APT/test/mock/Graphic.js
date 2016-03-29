var expect = require('chai').expect;
var assert = require('chai').assert;

var Model = require('./Model');

var types;
types = {
    drug :[
        {'id': "number"},
        {'name': "string"},
        {'description': "string"},
        {'cover': "string"}
    ],
    drugs:[
        {'drug': "object"},
        {'count': "number"},
        {'times': "array"},
    ]
};

var method = {
    getDrugs : function(model){
        Model.Base.getAll(model,'drugs', method.drugs);
    },
    drugs : function(model){
        Model.Base.testDataByType(model,types.drugs)
        Model.Base.testDataByType(model.drug,types.drug)
    },
    drug : function(model){
        Model.Base.testDataByType(model,types.drug)
    }
}
module.exports = method;