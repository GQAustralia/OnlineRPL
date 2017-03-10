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
// here we define our unique filter
gqAus.filter('unique', function() {
   return function(collection, keyname) {
      var output = [], 
          keys = [];
      angular.forEach(collection, function(item) {
          // we check to see whether our object exists
          var key = item[keyname];
          // if it's not already part of our keys array
          if(keys.indexOf(key) === -1) {
              // add it to our keys array
              keys.push(key); 
              // push this item to our final output array
              output.push(item);
          }
      });
      return output;
   };
});
// Count Word
gqAus.filter('countWord', function () {
    return function (text) {
        var s = text ? text.split(/\s+/) : 0; // it splits the text on space/tab/enter
        return s ? s.length : '';
    };
});

// Encode URI
gqAus.filter('encodeURI', function () {
    return function (text) {
        var s = text ? encodeURI(text) : ''; 
        return s;
    };
});

