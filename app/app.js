var app = angular.module('resourceTrackerApp', ['ngRoute', 'ngAnimate', 'toaster']);


///////////////////Services/////////////////////////////////////////////////////

//Customer Service--------------------------------------------------------------

app.factory("customerService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};
        obj.getCustomers = function() {
            return $http.get(serviceBase + 'customers');
        }
        obj.getCustomer = function(customerID) {
            return $http.get(serviceBase + 'customer?id=' + customerID);
        }

        obj.insertCustomer = function(customer) {
            return $http.post(serviceBase + 'insertCustomer', customer).then(function(results) {
                return results;
            });
        };

        obj.updateCustomer = function(id, customer) {
            return $http.post(serviceBase + 'updateCustomer', {id: id, customer: customer}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteCustomer = function(id) {
            return $http.delete(serviceBase + 'deleteCustomer?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//Currency Service--------------------------------------------------------------

app.factory("currencyService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getCurrencies = function() {
            return $http.get(serviceBase + 'currencies');
        }

        obj.getCurrency = function(currencyID) {
            return $http.get(serviceBase + 'currency?id=' + currencyID);
        }

        obj.insertCurrency = function(currency) {
            return $http.post(serviceBase + 'insertCurrency', currency).then(function(results) {
                return results;
            });
        };

        obj.updateCurrency = function(id, currency) {
            return $http.post(serviceBase + 'updateCurrency', {id: id, currency: currency}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteCurrency = function(id) {
            return $http.delete(serviceBase + 'deleteCurrency?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//Region Service--------------------------------------------------------------

app.factory("regionService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getRegions = function() {
            return $http.get(serviceBase + 'regions');
        }

        obj.getRegion = function(regionID) {
            return $http.get(serviceBase + 'region?id=' + regionID);
        }

        obj.insertRegion = function(region) {
            return $http.post(serviceBase + 'insertRegion', region).then(function(results) {
                return results;
            });
        };

        obj.updateRegion = function(id, region) {
            return $http.post(serviceBase + 'updateRegion', {id: id, region: region}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteRegion = function(id) {
            return $http.delete(serviceBase + 'deleteRegion?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//FinancialYear Service--------------------------------------------------------------

app.factory("financialYearService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getFinancialYears = function() {
            return $http.get(serviceBase + 'financialYears');
        }

        obj.getFinancialYear = function(financialYearID) {
            return $http.get(serviceBase + 'financialYear?id=' + financialYearID);
        }

        obj.insertFinancialYear = function(financialYear) {
            return $http.post(serviceBase + 'insertFinancialYear', financialYear).then(function(results) {
                return results;
            });
        };

        obj.updateFinancialYear = function(id, financialYear) {
            return $http.post(serviceBase + 'updateFinancialYear', {id: id, financial_year: financialYear}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteFinancialYear = function(id) {
            return $http.delete(serviceBase + 'deleteFinancialYear?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//OrganisationType Service--------------------------------------------------------------
app.factory("organisationTypeService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getOrganisationTypes = function() {
            return $http.get(serviceBase + 'organisationTypes');
        }

        obj.getOrganisationType = function(organisationTypeID) {
            return $http.get(serviceBase + 'organisationType?id=' + organisationTypeID);
        }

        obj.insertOrganisationType = function(organisationType) {
            return $http.post(serviceBase + 'insertOrganisationType', organisationType).then(function(results) {
                return results;
            });
        };

        obj.updateOrganisationType = function(id, organisationType) {
            return $http.post(serviceBase + 'updateOrganisationType', {id: id, organisation_type: organisationType}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteOrganisationType = function(id) {
            return $http.delete(serviceBase + 'deleteOrganisationType?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


//TypeOfSupport Service--------------------------------------------------------------
app.factory("typeOfSupportService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getTypeOfSupports = function() {
            return $http.get(serviceBase + 'typeOfSupports');
        }

        obj.getTypeOfSupport = function(typeOfSupportID) {
            return $http.get(serviceBase + 'typeOfSupport?id=' + typeOfSupportID);
        }

        obj.insertTypeOfSupport = function(typeOfSupport) {
            return $http.post(serviceBase + 'insertTypeOfSupport', typeOfSupport).then(function(results) {
                return results;
            });
        };

        obj.updateTypeOfSupport = function(id, typeOfSupport) {
            return $http.post(serviceBase + 'updateTypeOfSupport', {id: id, type_of_support: typeOfSupport}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteTypeOfSupport = function(id) {
            return $http.delete(serviceBase + 'deleteTypeOfSupport?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//PartnerType Service--------------------------------------------------------------
app.factory("partnerTypeService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getPartnerTypes = function() {
            return $http.get(serviceBase + 'partnerTypes');
        }

        obj.getPartnerType = function(partnerTypeID) {
            return $http.get(serviceBase + 'partnerType?id=' + partnerTypeID);
        }

        obj.insertPartnerType = function(partnerType) {
            return $http.post(serviceBase + 'insertPartnerType', partnerType).then(function(results) {
                return results;
            });
        };

        obj.updatePartnerType = function(id, partnerType) {
            return $http.post(serviceBase + 'updatePartnerType', {id: id, partner_type: partnerType}).then(function(status) {
                return status.data;
            });
        };

        obj.deletePartnerType = function(id) {
            return $http.delete(serviceBase + 'deletePartnerType?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


//Authority Service--------------------------------------------------------------
app.factory("authorityService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getAuthoritys = function() {
            return $http.get(serviceBase + 'authoritys');
        }

        obj.getAuthority = function(authorityID) {
            return $http.get(serviceBase + 'authority?id=' + authorityID);
        }

        obj.insertAuthority = function(authority) {
            return $http.post(serviceBase + 'insertAuthority', authority).then(function(results) {
                return results;
            });
        };

        obj.updateAuthority = function(id, authority) {
            return $http.post(serviceBase + 'updateAuthority', {id: id, authority: authority}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteAuthority = function(id) {
            return $http.delete(serviceBase + 'deleteAuthority?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//CostCategory Service--------------------------------------------------------------
app.factory("costCategoryService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getCostCategorys = function() {
            return $http.get(serviceBase + 'costCategorys');
        }

        obj.getCostCategory = function(costCategoryID) {
            return $http.get(serviceBase + 'costCategory?id=' + costCategoryID);
        }

        obj.insertCostCategory = function(costCategory) {
            return $http.post(serviceBase + 'insertCostCategory', costCategory).then(function(results) {
                return results;
            });
        };

        obj.updateCostCategory = function(id, costCategory) {
            return $http.post(serviceBase + 'updateCostCategory', {id: id, cost_category: costCategory}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteCostCategory = function(id) {
            return $http.delete(serviceBase + 'deleteCostCategory?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

////////////////Controllers/////////////////////////////////////////////////////

//Customer Controllers----------------------------------------------------------

app.controller('listCtrl', function($scope, customerService) {
    customerService.getCustomers().then(function(data) {
        $scope.customers = data.data;
    });
});

app.controller('editCtrl', function($scope, $rootScope, $location, $routeParams, customerService, customer) {
    var customerID = ($routeParams.customerID) ? parseInt($routeParams.customerID) : 0;
    $rootScope.title = (customerID > 0) ? 'Edit Customer' : 'Add Customer';
    $scope.buttonText = (customerID > 0) ? 'Update Customer' : 'Add New Customer';
    var original = customer.data;
    original._id = customerID;
    $scope.customer = angular.copy(original);
    $scope.customer._id = customerID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.customer);
    }

    $scope.deleteCustomer = function(customer) {
        $location.path('/');
        if (confirm("Are you sure to delete customer number: " + $scope.customer._id) == true)
            customerService.deleteCustomer(customer.customerNumber);
    };

    $scope.saveCustomer = function(customer) {
        $location.path('/');
        if (customerID <= 0) {
            customerService.insertCustomer(customer);
        }
        else {
            customerService.updateCustomer(customerID, customer);
        }
    };
});

//Currency Controllers----------------------------------------------------------
app.controller('CurrencyListCtrl', function($scope, currencyService) {
    currencyService.getCurrencies().then(function(data) {
        $scope.currencies = data.data;
    });
});


app.controller('CurrencyEditCtrl', function($scope, $rootScope, $location, $routeParams, currencyService, currency) {
    var currencyID = ($routeParams.currencyID) ? parseInt($routeParams.currencyID) : 0;
    $rootScope.title = (currencyID > 0) ? 'Edit Currency' : 'Add Currency';
    $scope.buttonText = (currencyID > 0) ? 'Update Currency' : 'Add New Currency';
    var original = currency.data;
    original._id = currencyID;
    $scope.currency = angular.copy(original);
    $scope.currency._id = currencyID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.currency);
    }

    $scope.deleteCurrency = function(currency) {
        $location.path('/');
        if (confirm("Are you sure to delete currency ID: " + $scope.currency._id) == true)
            currencyService.deleteCurrency(currency.currency_id);
        ///////////Navigate back to the list
    };

    $scope.saveCurrency = function(currency) {
        $location.path('/');
        if (currencyID <= 0) {
            currencyService.insertCurrency(currency);
        }
        else {
            currencyService.updateCurrency(currencyID, currency);
        }
    };
});

//Region Controllers----------------------------------------------------------
app.controller('RegionListCtrl', function($scope, regionService) {
    regionService.getRegions().then(function(data) {
        $scope.regions = data.data;
    });
});


app.controller('RegionEditCtrl', function($scope, $rootScope, $location, $routeParams, regionService, region) {
    var regionID = ($routeParams.regionID) ? parseInt($routeParams.regionID) : 0;
    $rootScope.title = (regionID > 0) ? 'Edit Region' : 'Add Region';
    $scope.buttonText = (regionID > 0) ? 'Update Region' : 'Add New Region';
    var original = region.data;
    original._id = regionID;
    $scope.region = angular.copy(original);
    $scope.region._id = regionID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.region);
    }

    $scope.deleteRegion = function(region) {
        $location.path('/');
        if (confirm("Are you sure to delete region ID: " + $scope.region._id) == true)
            regionService.deleteRegion(region.region_id);
        ///////////Navigate back to the list
    };

    $scope.saveRegion = function(region) {
        $location.path('/');
        if (regionID <= 0) {
            regionService.insertRegion(region);
        }
        else {
            regionService.updateRegion(regionID, region);
        }
    };
});


//FinancialYear Controllers----------------------------------------------------------
app.controller('FinancialYearListCtrl', function($scope, financialYearService) {
    financialYearService.getFinancialYears().then(function(data) {
        $scope.financialYears = data.data;
    });
});


app.controller('FinancialYearEditCtrl', function($scope, $rootScope, $location, $routeParams, financialYearService, financialYear) {
    var financialYearID = ($routeParams.financialYearID) ? parseInt($routeParams.financialYearID) : 0;
    $rootScope.title = (financialYearID > 0) ? 'Edit Financial Year' : 'Add Financial Year';
    $scope.buttonText = (financialYearID > 0) ? 'Update Financial Year' : 'Add New Financial Year';
    var original = financialYear.data;
    original._id = financialYearID;
    $scope.financialYear = angular.copy(original);
    $scope.financialYear._id = financialYearID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.financialYear);
    }

    $scope.deleteFinancialYear = function(financialYear) {
        $location.path('/');
        if (confirm("Are you sure to delete Financial Year ID: " + $scope.financialYear._id) == true)
            financialYearService.deleteFinancialYear(financialYear.financial_year_id);
        ///////////Navigate back to the list
    };

    $scope.saveFinancialYear = function(financialYear) {
        $location.path('/');
        if (financialYearID <= 0) {
            financialYearService.insertFinancialYear(financialYear);
        }
        else {
            financialYearService.updateFinancialYear(financialYearID, financialYear);
        }
    };
});


//OrganisationType Controllers----------------------------------------------------------
app.controller('OrganisationTypeListCtrl', function($scope, organisationTypeService) {
    organisationTypeService.getOrganisationTypes().then(function(data) {
        $scope.organisationTypes = data.data;
    });
});


app.controller('OrganisationTypeEditCtrl', function($scope, $rootScope, $location, $routeParams, organisationTypeService, organisationType) {
    var organisationTypeID = ($routeParams.organisationTypeID) ? parseInt($routeParams.organisationTypeID) : 0;
    $rootScope.title = (organisationTypeID > 0) ? 'Edit Organisation Type' : 'Add Organisation Type';
    $scope.buttonText = (organisationTypeID > 0) ? 'Update Organisation Type' : 'Add New Organisation Type';
    var original = organisationType.data;
    original._id = organisationTypeID;
    $scope.organisationType = angular.copy(original);
    $scope.organisationType._id = organisationTypeID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.organisationType);
    }

    $scope.deleteOrganisationType = function(organisationType) {
        $location.path('/');
        if (confirm("Are you sure to delete Organisation Type ID: " + $scope.organisationType._id) == true)
            organisationTypeService.deleteOrganisationType(organisationType.organisation_type_id);
        ///////////Navigate back to the list
    };

    $scope.saveOrganisationType = function(organisationType) {
        $location.path('/');
        if (organisationTypeID <= 0) {
            organisationTypeService.insertOrganisationType(organisationType);
        }
        else {
            organisationTypeService.updateOrganisationType(organisationTypeID, organisationType);
        }
    };
});

//TypeOfSupport Controllers----------------------------------------------------------
app.controller('TypeOfSupportListCtrl', function($scope, typeOfSupportService) {
    typeOfSupportService.getTypeOfSupports().then(function(data) {
        $scope.typeOfSupports = data.data;
    });
});


app.controller('TypeOfSupportEditCtrl', function($scope, $rootScope, $location, $routeParams, typeOfSupportService, typeOfSupport) {
    var typeOfSupportID = ($routeParams.typeOfSupportID) ? parseInt($routeParams.typeOfSupportID) : 0;
    $rootScope.title = (typeOfSupportID > 0) ? 'Edit Type Of Support' : 'Add Type Of Support';
    $scope.buttonText = (typeOfSupportID > 0) ? 'Update Type Of Support' : 'Add New Type Of Support';
    var original = typeOfSupport.data;
    original._id = typeOfSupportID;
    $scope.typeOfSupport = angular.copy(original);
    $scope.typeOfSupport._id = typeOfSupportID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.typeOfSupport);
    }

    $scope.deleteTypeOfSupport = function(typeOfSupport) {
        $location.path('/');
        if (confirm("Are you sure to delete Type Of Support ID: " + $scope.typeOfSupport._id) == true)
            typeOfSupportService.deleteTypeOfSupport(typeOfSupport.type_of_support_id);
        ///////////Navigate back to the list
    };

    $scope.saveTypeOfSupport = function(typeOfSupport) {
        $location.path('/');
        if (typeOfSupportID <= 0) {
            typeOfSupportService.insertTypeOfSupport(typeOfSupport);
        }
        else {
            typeOfSupportService.updateTypeOfSupport(typeOfSupportID, typeOfSupport);
        }
    };
});

//PartnerType Controllers----------------------------------------------------------
app.controller('PartnerTypeListCtrl', function($scope, partnerTypeService) {
    partnerTypeService.getPartnerTypes().then(function(data) {
        $scope.partnerTypes = data.data;
    });
});


app.controller('PartnerTypeEditCtrl', function($scope, $rootScope, $location, $routeParams, partnerTypeService, partnerType) {
    var partnerTypeID = ($routeParams.partnerTypeID) ? parseInt($routeParams.partnerTypeID) : 0;
    $rootScope.title = (partnerTypeID > 0) ? 'Edit Partner Type' : 'Add Partner Type';
    $scope.buttonText = (partnerTypeID > 0) ? 'Update Partner Type' : 'Add New Partner Type';
    var original = partnerType.data;
    original._id = partnerTypeID;
    $scope.partnerType = angular.copy(original);
    $scope.partnerType._id = partnerTypeID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.partnerType);
    }

    $scope.deletePartnerType = function(partnerType) {
        $location.path('/');
        if (confirm("Are you sure to delete Partner Type ID: " + $scope.partnerType._id) == true)
            partnerTypeService.deletePartnerType(partnerType.partner_type_id);
        ///////////Navigate back to the list
    };

    $scope.savePartnerType = function(partnerType) {
        $location.path('/');
        if (partnerTypeID <= 0) {
            partnerTypeService.insertPartnerType(partnerType);
        }
        else {
            partnerTypeService.updatePartnerType(partnerTypeID, partnerType);
        }
    };
});

//Authority Controllers----------------------------------------------------------
app.controller('AuthorityListCtrl', function($scope, authorityService) {
    authorityService.getAuthoritys().then(function(data) {
        $scope.authoritys = data.data;
    });
});


app.controller('AuthorityEditCtrl', function($scope, $rootScope, $location, $routeParams, authorityService, authority) {
    var authorityID = ($routeParams.authorityID) ? parseInt($routeParams.authorityID) : 0;
    $rootScope.title = (authorityID > 0) ? 'Edit Authority' : 'Add Authority';
    $scope.buttonText = (authorityID > 0) ? 'Update Authority' : 'Add New Authority';
    var original = authority.data;
    original._id = authorityID;
    $scope.authority = angular.copy(original);
    $scope.authority._id = authorityID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.authority);
    }

    $scope.deleteAuthority = function(authority) {
        $location.path('/');
        if (confirm("Are you sure to delete Authority ID: " + $scope.authority._id) == true)
            authorityService.deleteAuthority(authority.authority_id);
        ///////////Navigate back to the list
    };

    $scope.saveAuthority = function(authority) {
        $location.path('/');
        if (authorityID <= 0) {
            authorityService.insertAuthority(authority);
        }
        else {
            authorityService.updateAuthority(authorityID, authority);
        }
    };
});

//CostCategory Controllers----------------------------------------------------------
app.controller('CostCategoryListCtrl', function($scope, costCategoryService) {
    costCategoryService.getCostCategorys().then(function(data) {
        $scope.costCategorys = data.data;
    });
});


app.controller('CostCategoryEditCtrl', function($scope, $rootScope, $location, $routeParams, costCategoryService, costCategory) {
    var costCategoryID = ($routeParams.costCategoryID) ? parseInt($routeParams.costCategoryID) : 0;
    $rootScope.title = (costCategoryID > 0) ? 'Edit Cost Category' : 'Add Cost Category';
    $scope.buttonText = (costCategoryID > 0) ? 'Update Cost Category' : 'Add New Cost Category';
    var original = costCategory.data;
    original._id = costCategoryID;
    $scope.costCategory = angular.copy(original);
    $scope.costCategory._id = costCategoryID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.costCategory);
    }

    $scope.deleteCostCategory = function(costCategory) {
        $location.path('/');
        if (confirm("Are you sure to delete Cost Category ID: " + $scope.costCategory._id) == true)
            costCategoryService.deleteCostCategory(costCategory.cost_category_id);
        ///////////Navigate back to the list
    };

    $scope.saveCostCategory = function(costCategory) {
        $location.path('/');
        if (costCategoryID <= 0) {
            costCategoryService.insertCostCategory(costCategory);
        }
        else {
            costCategoryService.updateCostCategory(costCategoryID, costCategory);
        }
    };
});

//////////////////////////////Routes////////////////////////////////////////////

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
                ////////////////////Login Routes/////////////////////////
                when('/login', {
                    title: 'Login',
                    templateUrl: 'partials/login.html',
                    controller: 'authCtrl'
                })
                .when('/logout', {
                    title: 'Logout',
                    templateUrl: 'partials/login.html',
                    controller: 'logoutCtrl'
                })
                .when('/signup', {
                    title: 'Signup',
                    templateUrl: 'partials/signup.html',
                    controller: 'authCtrl'
                })
                .when('/dashboard', {
                    title: 'Dashboard',
                    templateUrl: 'partials/dashboard.html',
                    controller: 'authCtrl'
                })
                .when('/', {
                    title: 'Login',
                    templateUrl: 'partials/login.html',
                    controller: 'authCtrl',
                    role: '0'
                })

                /////////////////Customer Routes///////////////////////////
                .when('/customers', {
                    title: 'Customers',
                    templateUrl: 'partials/customer/customers.html',
                    controller: 'listCtrl'
                })
                .when('/edit-customer/:customerID', {
                    title: 'Edit Customers',
                    templateUrl: 'partials/customer/edit-customer.html',
                    controller: 'editCtrl',
                    resolve: {
                        customer: function(customerService, $route) {
                            var customerID = $route.current.params.customerID;
                            return customerService.getCustomer(customerID);
                        }
                    }
                })

                ////////////////////Currency Routes///////////////////////////
                .when('/currencies', {
                    title: 'Currencies',
                    templateUrl: 'partials/currency/currency-list.html',
                    controller: 'CurrencyListCtrl'
                })
                .when('/edit-currency/:currencyID', {
                    title: 'Edit Currencies',
                    templateUrl: 'partials/currency/edit-currency.html',
                    controller: 'CurrencyEditCtrl',
                    resolve: {
                        currency: function(currencyService, $route) {
                            var currencyID = $route.current.params.currencyID;
                            return currencyService.getCurrency(currencyID);
                        }
                    }
                })

                ////////////////////Region Routes///////////////////////////
                .when('/regions', {
                    title: 'Regions',
                    templateUrl: 'partials/region/region-list.html',
                    controller: 'RegionListCtrl'
                })
                .when('/edit-region/:regionID', {
                    title: 'Edit Regions',
                    templateUrl: 'partials/region/edit-region.html',
                    controller: 'RegionEditCtrl',
                    resolve: {
                        region: function(regionService, $route) {
                            var regionID = $route.current.params.regionID;
                            return regionService.getRegion(regionID);
                        }
                    }
                })

                ////////////////////Financial Year Routes///////////////////////////
                .when('/financialYears', {
                    title: 'Financial Year',
                    templateUrl: 'partials/financialYear/financialYear-list.html',
                    controller: 'FinancialYearListCtrl'
                })
                .when('/edit-financialYear/:financialYearID', {
                    title: 'Edit Financial Years',
                    templateUrl: 'partials/financialYear/edit-financialYear.html',
                    controller: 'FinancialYearEditCtrl',
                    resolve: {
                        financialYear: function(financialYearService, $route) {
                            var financialYearID = $route.current.params.financialYearID;
                            return financialYearService.getFinancialYear(financialYearID);
                        }
                    }
                })

                ////////////////////Organisation Type Routes///////////////////////////
                .when('/organisationTypes', {
                    title: 'Organisation Type',
                    templateUrl: 'partials/organisationType/organisationType-list.html',
                    controller: 'OrganisationTypeListCtrl'
                })
                .when('/edit-organisationType/:organisationTypeID', {
                    title: 'Edit Organisation Type',
                    templateUrl: 'partials/organisationType/edit-organisationType.html',
                    controller: 'OrganisationTypeEditCtrl',
                    resolve: {
                        organisationType: function(organisationTypeService, $route) {
                            var organisationTypeID = $route.current.params.organisationTypeID;
                            return organisationTypeService.getOrganisationType(organisationTypeID);
                        }
                    }
                })

                ////////////////////Type Of Support Routes///////////////////////////
                .when('/typeOfSupports', {
                    title: 'Type Of Support',
                    templateUrl: 'partials/typeOfSupport/typeOfSupport-list.html',
                    controller: 'TypeOfSupportListCtrl'
                })
                .when('/edit-typeOfSupport/:typeOfSupportID', {
                    title: 'Edit Type Of Support',
                    templateUrl: 'partials/typeOfSupport/edit-typeOfSupport.html',
                    controller: 'TypeOfSupportEditCtrl',
                    resolve: {
                        typeOfSupport: function(typeOfSupportService, $route) {
                            var typeOfSupportID = $route.current.params.typeOfSupportID;
                            return typeOfSupportService.getTypeOfSupport(typeOfSupportID);
                        }
                    }
                })

                ////////////////////Partner Type Routes///////////////////////////
                .when('/partnerTypes', {
                    title: 'Partner Type',
                    templateUrl: 'partials/partnerType/partnerType-list.html',
                    controller: 'PartnerTypeListCtrl'
                })
                .when('/edit-partnerType/:partnerTypeID', {
                    title: 'Edit Partner Type',
                    templateUrl: 'partials/partnerType/edit-partnerType.html',
                    controller: 'PartnerTypeEditCtrl',
                    resolve: {
                        partnerType: function(partnerTypeService, $route) {
                            var partnerTypeID = $route.current.params.partnerTypeID;
                            return partnerTypeService.getPartnerType(partnerTypeID);
                        }
                    }
                })
                
                ////////////////////Authority Routes///////////////////////////
                .when('/authoritys', {
                    title: 'Authority',
                    templateUrl: 'partials/authority/authority-list.html',
                    controller: 'AuthorityListCtrl'
                })
                .when('/edit-authority/:authorityID', {
                    title: 'Edit Authority',
                    templateUrl: 'partials/authority/edit-authority.html',
                    controller: 'AuthorityEditCtrl',
                    resolve: {
                        authority: function(authorityService, $route) {
                            var authorityID = $route.current.params.authorityID;
                            return authorityService.getAuthority(authorityID);
                        }
                    }
                })
                
                ////////////////////Cost Category Routes///////////////////////////
                .when('/costCategorys', {
                    title: 'Cost Category',
                    templateUrl: 'partials/costCategory/costCategory-list.html',
                    controller: 'CostCategoryListCtrl'
                })
                .when('/edit-costCategory/:costCategoryID', {
                    title: 'Edit Cost Category',
                    templateUrl: 'partials/costCategory/edit-costCategory.html',
                    controller: 'CostCategoryEditCtrl',
                    resolve: {
                        costCategory: function(costCategoryService, $route) {
                            var costCategoryID = $route.current.params.costCategoryID;
                            return costCategoryService.getCostCategory(costCategoryID);
                        }
                    }
                })

                .otherwise({
                    redirectTo: '/login'
                });
    }]);
//        .run(function($rootScope, $location, Data) {
//            $rootScope.$on("$routeChangeStart", function(event, next, current) {
//                $rootScope.authenticated = false;
//                Data.get('session').then(function(results) {
//                    if (results.uid) {
//                        $rootScope.authenticated = true;
//                        $rootScope.uid = results.uid;
//                        $rootScope.name = results.name;
//                        $rootScope.email = results.email;
//                    } else {
//                        var nextUrl = next.$$route.originalPath;
//                        if (nextUrl == '/signup' || nextUrl == '/login') {
//
//                        } else {
//                            $location.path("/login");
//                        }
//                    }
//                });
//            });
//        });