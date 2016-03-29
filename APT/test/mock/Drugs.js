var expect = require('chai').expect;
var assert = require('chai').assert;

var Model = require('./Model');

var types;
types = {
    drug :[
        {'id': "number"},
        {'name': "string"},
        {'vendor': "object"},
        {'description': "string"},
        {'cover': "string"},
        {'unit': "string"},
        {'type': "string"},
    ],
    vendor:[
        {'id': "number"},
        {'name': "string"},
        {'phone': "string"},
        {'address': "string"},
        {'cover': "string"}
    ],
        category:[
        {'id':"number"},
        {'name':"string"}
    ]


};

var method = {
    getDrugs : function(model){
        Model.Base.getAll(model,'drugs', method.drug);
    },
    drug : function(model){
        Model.Base.testDataByType(model,types.drug);
        method.vendor(model.vendor);
    },
    vendor : function(model){
        Model.Base.testDataByType(model,types.vendor);
    },
    oneDrug : function(model){
        method.vendor(model.vendor);
    }
}
module.exports = method;