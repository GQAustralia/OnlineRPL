gqAus.service(
    "AjaxService",
    function($http, $q, $window) {
        var headers = {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS, PUT',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };

        return ({
            ajaxHttp: ajaxHttp,
            apiCall: apiCall
        });


        /**
         * ajaxHttp calls to API
         *
         * @param (string) url
         *
         * @param (object) data
         *
         * @param (object) headers
         *
         * @param (string) method
         *
         */
        function ajaxHttp(url, data, header, method) {
            var ajaxheaders = header || headers;
            var ajaxMethod = method || 'post';

            var httpData = data;
            var request = $http({
                method: ajaxMethod,
                headers: ajaxheaders,
                url: url,
                data: httpData
            });

            return (request.then(handleSuccess, handleError));
        }

        function apiCall(url, data, header, method) {
            url = $window.base_url + url;
            return ajaxHttp(url, data, header, method);
        }

        /*
         * PRIVATE METHODS.
         *
         * I transform the error response, unwrapping the application dta from
         * the API response payload.
         *
         */
        function handleError(response) {
            /*
             *
             * The API response from the server should be returned in a
             * nomralized format. However, if the request was not handled by the
             * server (or what not handles properly - ex. server error), then we
             * may have to normalize it on our end, as best we can.
             *
             */
            if (!angular.isObject(response.data) || !response.data.message) {
                return ($q.reject(response));
            }
            // Otherwise, use expected error message.
            return ($q.reject(response.data.message));
        }

        /*
         * I transform the successful response, unwrapping the application data
         * from the API response payload.
         */
        function handleSuccess(response) {
            return (response.data);
        }
    }
);
