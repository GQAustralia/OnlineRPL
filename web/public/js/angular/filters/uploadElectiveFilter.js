gqAus.filter('inArrayFilter', function(_) {
    return function(units, selectedUnits, matchKey) {
        return units.filter(function(unit) {
            var unitsToFind = {};
            
            if(matchKey === undefined){
                return _.contains(selectedUnits, unit);
                
            }else{
                unitsToFind[matchKey] = unit[matchKey];
                 return _.findWhere(selectedUnits, unitsToFind)
            }
           

        });
    };
});
gqAus.filter('bytesToSize', function () {
    return function (bytes,type) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0)
            return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        if(type === undefined)
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        if(type === 'size')
            return Math.round(bytes / Math.pow(1024, i), 2);
        if(type === 'measure')
            return sizes[i];
    };
});

gqAus.filter('getLength', function () {
    return function (objInstance) {
    	var keys = Object.keys(objInstance);
    	return len = keys.length;
    };
});

