gqAus.filter('rangefromyear', function () {
    return function (input, min) {
        min = parseInt(min);
        var datetime = new Date();
        var max = parseInt(datetime.getFullYear());
        for (var i = max; i >= min; i--)
            input.push(i);
        return input;
    };
});
gqAus.filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (angular.isArray(items)) {
      var keys = Object.keys(props);

      items.forEach(function(item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});