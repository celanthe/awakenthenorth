// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Standard Ajax wrapper for Moodle. It calls the central Ajax script,
 * which can call any existing webservice using the current session.
 * In addition, it can batch multiple requests and return multiple responses.
 *
 * @module     core/ajax
 * @class      ajax
 * @package    core
 * @copyright  2015 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
define(['jquery', 'core/config', 'core/log', 'core/url'], function($, config, Log, URL) {

    // Keeps track of when the user leaves the page so we know not to show an error.
    var unloading = false;

    /**
     * Success handler. Called when the ajax call succeeds. Checks each response and
     * resolves or rejects the deferred from that request.
     *
     * @method requestSuccess
     * @private
     * @param {Object[]} responses Array of responses containing error, exception and data attributes.
     */
    var requestSuccess = function(responses) {
        // Call each of the success handlers.
        var requests = this,
            exception = null,
            i = 0,
            request,
            response,
            nosessionupdate;

        if (responses.error) {
            // There was an error with the request as a whole.
            // We need to reject each promise.
            // Unfortunately this may lead to duplicate dialogues, but each Promise must be rejected.
            for (; i < requests.length; i++) {
                request = requests[i];
                request.deferred.reject(responses);
            }

            return;
        }

        for (i = 0; i < requests.length; i++) {
            request = requests[i];

            response = responses[i];
            // We may not have responses for all the requests.
            if (typeof response !== "undefined") {
                if (response.error === false) {
                    // Call the done handler if it was provided.
                    request.deferred.resolve(response.data);
                } else {
                    exception = response.exception;
                    nosessionupdate = requests[i].nosessionupdate;
                    break;
                }
            } else {
                // This is not an expected case.
                exception = new Error('missing response');
                break;
            }
        }
        // Something failed, reject the remaining promises.
        if (exception !== null) {
            // Redirect to the login page.
            if (exception.errorcode === "servicerequireslogin" && !nosessionupdate) {
                window.location = URL.relativeUrl("/login/index.php");
            } else {
                requests.forEach(function(request) {
                    request.deferred.reject(exception);
                });
            }
        }
    };

    /**
     * Fail handler. Called when the ajax call fails. Rejects all deferreds.
     *
     * @method requestFail
     * @private
     * @param {jqXHR} jqXHR The ajax object.
     * @param {string} textStatus The status string.
     * @param {Error|Object} exception The error thrown.
     */
    var requestFail = function(jqXHR, textStatus, exception) {
        // Reject all the promises.
        var requests = this;

        var i = 0;
        for (i = 0; i < requests.length; i++) {
            var request = requests[i];

            if (unloading) {
                // No need to trigger an error because we are already navigating.
                Log.error("Page unloaded.");
                Log.error(exception);
            } else {
                request.deferred.reject(exception);
            }
        }
    };

    return /** @alias module:core/ajax */ {
        // Public variables and functions.
        /**
         * Make a series of ajax requests and return all the responses.
         *
         * @method call
         * @param {Object[]} requests Array of requests with each containing methodname and args properties.
         *                   done and fail callbacks can be set for each element in the array, or the
         *                   can be attached to the promises returned by this function.
         * @param {Boolean} async Optional, defaults to true.
         *                  If false - this function will not return until the promises are resolved.
         * @param {Boolean} loginrequired Optional, defaults to true.
         *                  If false - this function will call the faster nologin ajax script - but
         *                  will fail unless all functions have been marked as 'loginrequired' => false
         *                  in services.php
         * @param {Boolean} nosessionupdate Optional, defaults to false.
         *                  If true, the timemodified for the session will not be updated.
         * @param {Integer} timeout number of milliseconds to wait for a response. Defaults to no limit.
         * @param {Integer} cachekey This is used in order to identify the request. If this id changes then we
         *                  will be sending a different URL and any caching (eg. browser, proxy) knows that it
         *                  should perform another request and not use the cache. Note - this variable is only
         *                  used when we are calling 'service-nologin.php'. See MDL-65794.
         * @return {Promise[]} Array of promises that will be resolved when the ajax call returns.
         */
        call: function(requests, async, loginrequired, nosessionupdate, timeout, cachekey) {
            $(window).bind('beforeunload', function() {
                unloading = true;
            });
            var ajaxRequestData = [],
                i,
                promises = [],
                methodInfo = [],
                requestInfo = '';

            var maxUrlLength = 2000;

            if (typeof loginrequired === "undefined") {
                loginrequired = true;
            }
            if (typeof async === "undefined") {
                async = true;
            }
            if (typeof timeout === 'undefined') {
                timeout = 0;
            }
            if (typeof cachekey === 'undefined') {
                cachekey = null;
            } else {
                cachekey = parseInt(cachekey);
                if (cachekey <= 0) {
                    cachekey = null;
                } else if (!cachekey) {
                    cachekey = null;
                }
            }

            if (typeof nosessionupdate === "undefined") {
                nosessionupdate = false;
            }
            for (i = 0; i < requests.length; i++) {
                var request = requests[i];
                ajaxRequestData.push({
                    index: i,
                    methodname: request.methodname,
                    args: request.args
                });
                request.nosessionupdate = nosessionupdate;
                request.deferred = $.Deferred();
                promises.push(request.deferred.promise());
                // Allow setting done and fail handlers as arguments.
                // This is just a shortcut for the calling code.
                if (typeof request.done !== "undefined") {
                    request.deferred.done(request.done);
                }
                if (typeof request.fail !== "undefined") {
                    request.deferred.fail(request.fail);
                }
                request.index = i;
                methodInfo.push(request.methodname);
            }

            if (methodInfo.length <= 5) {
                requestInfo = methodInfo.sort().join();
            } else {
                requestInfo = methodInfo.length + '-method-calls';
            }

            ajaxRequestData = JSON.stringify(ajaxRequestData);
            var settings = {
                type: 'POST',
                context: requests,
                dataType: 'json',
                processData: false,
                async: async,
                contentType: "application/json",
                timeout: timeout
            };

            var script = 'service.php';
            var url = config.wwwroot + '/lib/ajax/';
            if (!loginrequired) {
                script = 'service-nologin.php';
                url += script + '?info=' + requestInfo;
                if (cachekey) {
                    url += '&cachekey=' + cachekey;
                    settings.type = 'GET';
                }
            } else {
                url += script + '?sesskey=' + config.sesskey + '&info=' + requestInfo;
            }

            if (nosessionupdate) {
                url += '&nosessionupdate=true';
            }

            if (settings.type === 'POST') {
                settings.data = ajaxRequestData;
            } else {
                var urlUseGet = url + '&args=' + encodeURIComponent(ajaxRequestData);

                if (urlUseGet.length > maxUrlLength) {
                    settings.type = 'POST';
                    settings.data = ajaxRequestData;
                } else {
                    url = urlUseGet;
                }
            }

            // Jquery deprecated done and fail with async=false so we need to do this 2 ways.
            if (async) {
                $.ajax(url, settings)
                    .done(requestSuccess)
                    .fail(requestFail);
            } else {
                settings.success = requestSuccess;
                settings.error = requestFail;
                $.ajax(url, settings);
            }

            return promises;
        }
    };
});
