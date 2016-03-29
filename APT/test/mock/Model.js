var expect = require('chai').expect;
var types = {
}

var methods = {
    getAll : function(data, categoryName, methodTest){
        var getAlltypes = [
            {'take'             : "number"},
            {'skip'             : "number"},
            {'count'            : "number"},
            {'status'           : "number"}
        ];
        var objName = {};
        objName[categoryName] = 'array';
        getAlltypes.push(objName);
        methods.testDataByType(data, getAlltypes);
        expect(data).to.have.property(categoryName);
        data[categoryName].forEach(function(model) {
            console.log(model)
            methodTest(model);
        })
    },
    getAllSimple: function(data, categoryName, methodTest){
        expect(data).to.have.property(categoryName);
        data[categoryName].forEach(function(model) {
            methodTest(model);
        })
    },
    getFildsByType: function(types){
        var results = [];
        types.forEach(function(obj) {
            results.push(Object.keys( obj )[0]);
        })
        return results;
    },
    testDataByType: function(data, types){
        expect(data).to.have.all.keys(this.getFildsByType(types));
        types.forEach(function(type){
            expect(data[Object.keys(type)[0]]).to.be.a(type[Object.keys(type)[0]]);
        });
    }
}
module.exports = types;
module.exports.Base = methods;