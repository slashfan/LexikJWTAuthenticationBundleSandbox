(function () {

    'use strict';

    angular

        .module('demoApp', ['http-auth-interceptor', 'ui.bootstrap'])

        .factory('AuthenticationService', function ($rootScope, $http, authService, $httpBackend) {
            return {
                login:          function (credentials) {
                    $http
                        .post('/api/login_check', credentials, { ignoreAuthModule: true })
                        .success(function (data, status, headers, config) {
                            $http.defaults.headers.common.Authorization = 'Bearer ' + data.token;  // Step 1
                            authService.loginConfirmed(data, function (config) {  // Step 2 & 3
                                config.headers.Authorization = 'Bearer ' + data.token;
                                $rootScope.$broadcast('event:auth-login-complete');
                                return config;
                            });
                        })
                        .error(function (data, status, headers, config) {
                            $rootScope.$broadcast('event:auth-login-failed', status);
                        });
                },
                logout:         function (user) {
                    delete $http.defaults.headers.common.Authorization;
                    $rootScope.$broadcast('event:auth-logout-complete');
                }
            };
        })

        .controller('AppCtrl', function ($scope, $uibModal) {

            $scope.$on('event:auth-loginRequired', function () {
                $uibModal.open({
                    templateUrl: 'login.html',
                    controller:  'ModalInstanceCtrl',
                    backdrop:    'static'
                });
            });

        })

        .controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, AuthenticationService) {

            $scope.credentials = {
                username: 'user',
                password: 'password'
            };

            $scope.$on('event:auth-login-failed', function () {
                $scope.errorMessage = 'Bad credentials';
            });

            $scope.$on('event:auth-login-complete', function () {
                $uibModalInstance.close();
            });

            $scope.submit = function (credentials) {
                AuthenticationService.login(credentials);
            };

        })

        .controller('MainCtrl', function ($scope, $http) {
            $http
                .get('/api/pages')
                .then(function (response) {
                    $scope.pages = response.data;
                })
            ;
        })

    ;

})();
