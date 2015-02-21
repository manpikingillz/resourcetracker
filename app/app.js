
// init jquery functions and plugins
$(document).ready(function() {
    $.getScript('//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.min.js', function() {

        $("#mySel").select2({
        });
    });//script

});


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

//District Service--------------------------------------------------------------
app.factory("districtService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getDistricts = function() {
            return $http.get(serviceBase + 'districts');
        }

        obj.getDistrict = function(districtID) {
            return $http.get(serviceBase + 'district?id=' + districtID);
        }

        obj.insertDistrict = function(district) {
            return $http.post(serviceBase + 'insertDistrict', district).then(function(results) {
                return results;
            });
        };

        obj.updateDistrict = function(id, district) {
            return $http.post(serviceBase + 'updateDistrict', {id: id, district: district}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteDistrict = function(id) {
            return $http.delete(serviceBase + 'deleteDistrict?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


//SubCategoryOfSupport Service--------------------------------------------------------------
app.factory("subCategoryOfSupportService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getSubCategoryOfSupports = function() {
            return $http.get(serviceBase + 'subCategoryOfSupports');
        }

        obj.getSubCategoryOfSupport = function(subCategoryOfSupportID) {
            return $http.get(serviceBase + 'subCategoryOfSupport?id=' + subCategoryOfSupportID);
        }

        obj.insertSubCategoryOfSupport = function(subCategoryOfSupport) {
            return $http.post(serviceBase + 'insertSubCategoryOfSupport', subCategoryOfSupport).then(function(results) {
                return results;
            });
        };

        obj.updateSubCategoryOfSupport = function(id, subCategoryOfSupport) {
            return $http.post(serviceBase + 'updateSubCategoryOfSupport', {id: id, sub_category_of_support: subCategoryOfSupport}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteSubCategoryOfSupport = function(id) {
            return $http.delete(serviceBase + 'deleteSubCategoryOfSupport?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//Organisation Service--------------------------------------------------------------
app.factory("organisationService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getOrganisations = function() {
            return $http.get(serviceBase + 'organisations');
        }

        obj.getOrganisation = function(organisationID) {
            return $http.get(serviceBase + 'organisation?id=' + organisationID);
        }

        obj.insertOrganisation = function(organisation) {
            return $http.post(serviceBase + 'insertOrganisation', organisation).then(function(results) {
                return results;
            });
        };

        obj.updateOrganisation = function(id, organisation) {
            return $http.post(serviceBase + 'updateOrganisation', {id: id, organisation: organisation}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteOrganisation = function(id) {
            return $http.delete(serviceBase + 'deleteOrganisation?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


//Project Service--------------------------------------------------------------
app.factory("projectService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getProjects = function() {
            return $http.get(serviceBase + 'projects');
        }

        obj.getProject = function(projectID) {
            return $http.get(serviceBase + 'project?id=' + projectID);
        }

        obj.insertProject = function(project) {
            return $http.post(serviceBase + 'insertProject', project).then(function(results) {
                return results;
            });
        };

        obj.updateProject = function(id, project) {
            return $http.post(serviceBase + 'updateProject', {id: id, project: project}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteProject = function(id) {
            return $http.delete(serviceBase + 'deleteProject?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

    //Partner Service--------------------------------------------------------------
app.factory("partnerService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getPartners = function() {
            return $http.get(serviceBase + 'partners');
        }

        obj.getPartner = function(partnerID) {
            return $http.get(serviceBase + 'partner?id=' + partnerID);
        }

        obj.insertPartner = function(partner) {
            return $http.post(serviceBase + 'insertPartner', partner).then(function(results) {
                return results;
            });
        };

        obj.updatePartner = function(id, partner) {
            return $http.post(serviceBase + 'updatePartner', {id: id, partner: partner}).then(function(status) {
                return status.data;
            });
        };

        obj.deletePartner = function(id) {
            return $http.delete(serviceBase + 'deletePartner?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

    //Budget Service--------------------------------------------------------------
app.factory("budgetService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getBudgets = function() {
            return $http.get(serviceBase + 'budgets');
        }

        obj.getBudget = function(budgetID) {
            return $http.get(serviceBase + 'budget?id=' + budgetID);
        }

        obj.insertBudget = function(budget) {
            return $http.post(serviceBase + 'insertBudget', budget).then(function(results) {
                return results;
            });
        };

        obj.updateBudget = function(id, budget) {
            return $http.post(serviceBase + 'updateBudget', {id: id, budget: budget}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteBudget = function(id) {
            return $http.delete(serviceBase + 'deleteBudget?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


//TypeOfSupportBudget Service--------------------------------------------------------------
app.factory("typeOfSupportBudgetService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getTypeOfSupportBudgets = function() {
            return $http.get(serviceBase + 'typeOfSupportBudgets');
        }

        obj.getTypeOfSupportBudget = function(typeOfSupportBudgetID) {
            return $http.get(serviceBase + 'typeOfSupportBudget?id=' + typeOfSupportBudgetID);
        }

        obj.insertTypeOfSupportBudget = function(typeOfSupportBudget) {
            return $http.post(serviceBase + 'insertTypeOfSupportBudget', typeOfSupportBudget).then(function(results) {
                return results;
            });
        };

        obj.updateTypeOfSupportBudget = function(id, typeOfSupportBudget) {
            return $http.post(serviceBase + 'updateTypeOfSupportBudget', {id: id, type_of_support_budget: typeOfSupportBudget}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteTypeOfSupportBudget = function(id) {
            return $http.delete(serviceBase + 'deleteTypeOfSupportBudget?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


    //ProjectSubCategoryOfSupportBudget Service--------------------------------------------------------------
app.factory("projectSubCategoryOfSupportBudgetService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getProjectSubCategoryOfSupportBudgets = function() {
            return $http.get(serviceBase + 'projectSubCategoryOfSupportBudgets');
        }

        obj.getProjectSubCategoryOfSupportBudget = function(projectSubCategoryOfSupportBudgetID) {
            return $http.get(serviceBase + 'projectSubCategoryOfSupportBudget?id=' + projectSubCategoryOfSupportBudgetID);
        }

        obj.insertProjectSubCategoryOfSupportBudget = function(projectSubCategoryOfSupportBudget) {
            return $http.post(serviceBase + 'insertProjectSubCategoryOfSupportBudget', projectSubCategoryOfSupportBudget).then(function(results) {
                return results;
            });
        };

        obj.updateProjectSubCategoryOfSupportBudget = function(id, projectSubCategoryOfSupportBudget) {
            return $http.post(serviceBase + 'updateProjectSubCategoryOfSupportBudget', {id: id, project_sub_category_of_support_budget: projectSubCategoryOfSupportBudget}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteProjectSubCategoryOfSupportBudget = function(id) {
            return $http.delete(serviceBase + 'deleteProjectSubCategoryOfSupportBudget?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);


//NationalBudget Service--------------------------------------------------------------
app.factory("nationalBudgetService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getNationalBudgets = function() {
            return $http.get(serviceBase + 'nationalBudgets');
        }

        obj.getNationalBudget = function(nationalBudgetID) {
            return $http.get(serviceBase + 'nationalBudget?id=' + nationalBudgetID);
        }

        obj.insertNationalBudget = function(nationalBudget) {
            return $http.post(serviceBase + 'insertNationalBudget', nationalBudget).then(function(results) {
                return results;
            });
        };

        obj.updateNationalBudget = function(id, nationalBudget) {
            return $http.post(serviceBase + 'updateNationalBudget', {id: id, national_budget: nationalBudget}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteNationalBudget = function(id) {
            return $http.delete(serviceBase + 'deleteNationalBudget?id=' + id).then(function(status) {
                return status.data;
            });
        };

        return obj;
    }]);

//NationalBudgetCostCategory Service--------------------------------------------------------------
app.factory("nationalBudgetCostCategoryService", ['$http', function($http) {
        var serviceBase = 'php-backend/services/';
        var obj = {};

        obj.getNationalBudgetCostCategorys = function() {
            return $http.get(serviceBase + 'nationalBudgetCostCategorys');
        }

        obj.getNationalBudgetCostCategory = function(nationalBudgetCostCategoryID) {
            return $http.get(serviceBase + 'nationalBudgetCostCategory?id=' + nationalBudgetCostCategoryID);
        }

        obj.insertNationalBudgetCostCategory = function(nationalBudgetCostCategory) {
            return $http.post(serviceBase + 'insertNationalBudgetCostCategory', nationalBudgetCostCategory).then(function(results) {
                return results;
            });
        };

        obj.updateNationalBudgetCostCategory = function(id, nationalBudgetCostCategory) {
            return $http.post(serviceBase + 'updateNationalBudgetCostCategory', {id: id, national_budget_cost_category: nationalBudgetCostCategory}).then(function(status) {
                return status.data;
            });
        };

        obj.deleteNationalBudgetCostCategory = function(id) {
            return $http.delete(serviceBase + 'deleteNationalBudgetCostCategory?id=' + id).then(function(status) {
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
        $location.path('/customers');
        if (confirm("Are you sure to delete customer number: " + $scope.customer._id) == true)
            customerService.deleteCustomer(customer.customerNumber);
    };

    $scope.saveCustomer = function(customer) {
        $location.path('/customers');
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
        $location.path('/currencies');
        if (confirm("Are you sure to delete currency ID: " + $scope.currency._id) == true)
            currencyService.deleteCurrency(currency.currency_id);
        ///////////Navigate back to the list
    };

    $scope.saveCurrency = function(currency) {
        $location.path('/currencies');
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
        $location.path('/regions');
        if (confirm("Are you sure to delete region ID: " + $scope.region._id) == true)
            regionService.deleteRegion(region.region_id);
        ///////////Navigate back to the list
    };

    $scope.saveRegion = function(region) {
        $location.path('/regions');
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
        $location.path('/financialYears');
        if (confirm("Are you sure to delete Financial Year ID: " + $scope.financialYear._id) == true)
            financialYearService.deleteFinancialYear(financialYear.financial_year_id);
        ///////////Navigate back to the list
    };

    $scope.saveFinancialYear = function(financialYear) {
        $location.path('/financialYears');
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
        $location.path('/organisationTypes');
        if (confirm("Are you sure to delete Organisation Type ID: " + $scope.organisationType._id) == true)
            organisationTypeService.deleteOrganisationType(organisationType.organisation_type_id);
        ///////////Navigate back to the list
    };

    $scope.saveOrganisationType = function(organisationType) {
        $location.path('/organisationTypes');
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
        $location.path('/typeOfSupports');
        if (confirm("Are you sure to delete Type Of Support ID: " + $scope.typeOfSupport._id) == true)
            typeOfSupportService.deleteTypeOfSupport(typeOfSupport.type_of_support_id);
        ///////////Navigate back to the list
    };

    $scope.saveTypeOfSupport = function(typeOfSupport) {
        $location.path('/typeOfSupports');
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
        $location.path('/partnerTypes');
        if (confirm("Are you sure to delete Partner Type ID: " + $scope.partnerType._id) == true)
            partnerTypeService.deletePartnerType(partnerType.partner_type_id);
        ///////////Navigate back to the list
    };

    $scope.savePartnerType = function(partnerType) {
        $location.path('/partnerTypes');
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
        $location.path('/authoritys');
        if (confirm("Are you sure to delete Authority ID: " + $scope.authority._id) == true)
            authorityService.deleteAuthority(authority.authority_id);
        ///////////Navigate back to the list
         
    };

    $scope.saveAuthority = function(authority) {
        $location.path('/authoritys');
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
        $location.path('/costCategorys');
        if (confirm("Are you sure to delete Cost Category ID: " + $scope.costCategory._id) == true)
            costCategoryService.deleteCostCategory(costCategory.cost_category_id);
        ///////////Navigate back to the list
    };

    $scope.saveCostCategory = function(costCategory) {
        $location.path('/costCategorys');
        if (costCategoryID <= 0) {
            costCategoryService.insertCostCategory(costCategory);
        }
        else {
            costCategoryService.updateCostCategory(costCategoryID, costCategory);
        }
    };
});


//District Controllers----------------------------------------------------------
app.controller('DistrictListCtrl', function($scope, districtService) {
    districtService.getDistricts().then(function(data) {
        $scope.districts = data.data;
    });
});


app.controller('DistrictEditCtrl', function($scope, $rootScope, $location, $routeParams, districtService, regionService, district) {
    var districtID = ($routeParams.districtID) ? parseInt($routeParams.districtID) : 0;
    $rootScope.title = (districtID > 0) ? 'Edit District' : 'Add District';
    $scope.buttonText = (districtID > 0) ? 'Update District' : 'Add New District';
    var original = district.data;
    original._id = districtID;
    $scope.district = angular.copy(original);
    $scope.district._id = districtID;

    ////////////regions//////////
    regionService.getRegions().then(function(data) {
        $scope.regions = data.data;
    });

    $scope.isClean = function() {
        return angular.equals(original, $scope.district);
    }

    $scope.deleteDistrict = function(district) {
        $location.path('/districts');
        if (confirm("Are you sure to delete District ID: " + $scope.district._id) == true)
            districtService.deleteDistrict(district.district_id);
        ///////////Navigate back to the list
    };

    $scope.saveDistrict = function(district) {
        $location.path('/districts');
        if (districtID <= 0) {
            districtService.insertDistrict(district);
        }
        else {
            districtService.updateDistrict(districtID, district);
        }
    };

});


//SubCategoryOfSupport Controllers----------------------------------------------------------
app.controller('SubCategoryOfSupportListCtrl', function($scope, subCategoryOfSupportService) {
    subCategoryOfSupportService.getSubCategoryOfSupports().then(function(data) {
        $scope.subCategoryOfSupports = data.data;
    });
});


app.controller('SubCategoryOfSupportEditCtrl', function($scope, $rootScope, $location, $routeParams, subCategoryOfSupportService, typeOfSupportService, subCategoryOfSupport) {
    var subCategoryOfSupportID = ($routeParams.subCategoryOfSupportID) ? parseInt($routeParams.subCategoryOfSupportID) : 0;
    $rootScope.title = (subCategoryOfSupportID > 0) ? 'Edit SubCategory Of Support' : 'Add SubCategory Of Support';
    $scope.buttonText = (subCategoryOfSupportID > 0) ? 'Update SubCategory Of Support' : 'Add New SubCategory Of Support';
    var original = subCategoryOfSupport.data;
    original._id = subCategoryOfSupportID;
    $scope.subCategoryOfSupport = angular.copy(original);
    $scope.subCategoryOfSupport._id = subCategoryOfSupportID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.subCategoryOfSupport);
    }

    //type of support
    typeOfSupportService.getTypeOfSupports().then(function(data) {
        $scope.typeOfSupports = data.data;
    });

    $scope.deleteSubCategoryOfSupport = function(subCategoryOfSupport) {
        $location.path('/subCategoryOfSupports');
        if (confirm("Are you sure to delete SubCategory Of Support ID: " + $scope.subCategoryOfSupport._id) == true)
            subCategoryOfSupportService.deleteSubCategoryOfSupport(subCategoryOfSupport.sub_category_of_support_id);
        ///////////Navigate back to the list
    };

    $scope.saveSubCategoryOfSupport = function(subCategoryOfSupport) {
        $location.path('/subCategoryOfSupports');
        if (subCategoryOfSupportID <= 0) {
            subCategoryOfSupportService.insertSubCategoryOfSupport(subCategoryOfSupport);
        }
        else {
            subCategoryOfSupportService.updateSubCategoryOfSupport(subCategoryOfSupportID, subCategoryOfSupport);
        }
    };
});

//Organisation Controllers----------------------------------------------------------
app.controller('OrganisationListCtrl', function($scope, organisationService) {
    organisationService.getOrganisations().then(function(data) {
        $scope.organisations = data.data;
    });

});


app.controller('OrganisationEditCtrl', function($scope, $rootScope, $location, $routeParams, organisationService, organisationTypeService, authorityService, organisation) {
    var organisationID = ($routeParams.organisationID) ? parseInt($routeParams.organisationID) : 0;
    $rootScope.title = (organisationID > 0) ? 'Edit Organisation' : 'Add Organisation';
    $scope.buttonText = (organisationID > 0) ? 'Update Organisation' : 'Add New Organisation';
    var original = organisation.data;
    original._id = organisationID;
    $scope.organisation = angular.copy(original);
    $scope.organisation._id = organisationID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.organisation);
    }

    //Organisation Types
    organisationTypeService.getOrganisationTypes().then(function(data) {
        $scope.organisationTypes = data.data;
    });

    //Authorities
    authorityService.getAuthoritys().then(function(data) {
        $scope.authoritys = data.data;
    });

    $scope.deleteOrganisation = function(organisation) {
        $location.path('/organisations');
        if (confirm("Are you sure to delete organisation ID: " + $scope.organisation._id) == true)
            organisationService.deleteOrganisation(organisation.organisation_id);
        ///////////Navigate back to the list
    };

    $scope.saveOrganisation = function(organisation) {
        $location.path('/organisations');
        if (organisationID <= 0) {
            organisationService.insertOrganisation(organisation);
        }
        else {
            organisationService.updateOrganisation(organisationID, organisation);
        }
    };
});


//Project Controllers----------------------------------------------------------
app.controller('ProjectListCtrl', function($scope, projectService) {
    projectService.getProjects().then(function(data) {
        $scope.projects = data.data;
    });

});


app.controller('ProjectEditCtrl', function($scope, $rootScope, $location, $routeParams, projectService, organisationService, project) {
    var projectID = ($routeParams.projectID) ? parseInt($routeParams.projectID) : 0;
    $rootScope.title = (projectID > 0) ? 'Edit Project' : 'Add Project';
    $scope.buttonText = (projectID > 0) ? 'Update Project' : 'Add New Project';
    var original = project.data;
    original._id = projectID;
    $scope.project = angular.copy(original);
    $scope.project._id = projectID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.project);
    }
    
    //Organisations list
        organisationService.getOrganisations().then(function(data) {
        $scope.organisations = data.data;
    });
    

    $scope.deleteProject = function(project) {
        $location.path('/projects');
        if (confirm("Are you sure to delete project ID: " + $scope.project._id) == true)
            projectService.deleteProject(project.project_id);
        ///////////Navigate back to the list
    };

    $scope.saveProject = function(project) {
        $location.path('/projects');
        if (projectID <= 0) {
            projectService.insertProject(project);
        }
        else {
            projectService.updateProject(projectID, project);
        }
    };
});

//Partner Controllers----------------------------------------------------------
app.controller('PartnerListCtrl', function($scope, partnerService) {
    partnerService.getPartners().then(function(data) {
        $scope.partners = data.data;
    });

});

app.controller('PartnerEditCtrl', function($scope, $rootScope, $location, $routeParams, partnerService, partnerTypeService, partner) {
    var partnerID = ($routeParams.partnerID) ? parseInt($routeParams.partnerID) : 0;
    $rootScope.title = (partnerID > 0) ? 'Edit Partner' : 'Add Partner';
    $scope.buttonText = (partnerID > 0) ? 'Update Partner' : 'Add New Partner';
    var original = partner.data;
    original._id = partnerID;
    $scope.partner = angular.copy(original);
    $scope.partner._id = partnerID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.partner);
    }
    
    //Partner Types list
        partnerTypeService.getPartnerTypes().then(function(data) {
        $scope.partnerTypes = data.data;
    });
    

    $scope.deletePartner = function(partner) {
        $location.path('/partners');
        if (confirm("Are you sure to delete partner ID: " + $scope.partner._id) == true)
            partnerService.deletePartner(partner.partner_id);
        ///////////Navigate back to the list
    };

    $scope.savePartner = function(partner) {
        $location.path('/partners');
        if (partnerID <= 0) {
            partnerService.insertPartner(partner);
        }
        else {
            partnerService.updatePartner(partnerID, partner);
        }
    };
});


//Budget Controllers----------------------------------------------------------
app.controller('BudgetListCtrl', function($scope, budgetService) {
    budgetService.getBudgets().then(function(data) {
        $scope.budgets = data.data;
    });

});

app.controller('BudgetEditCtrl', function($scope, $rootScope, $location, $routeParams, budgetService, currencyService, financialYearService, projectService, budget) {
    var budgetID = ($routeParams.budgetID) ? parseInt($routeParams.budgetID) : 0;
    $rootScope.title = (budgetID > 0) ? 'Edit Budget' : 'Add Budget';
    $scope.buttonText = (budgetID > 0) ? 'Update Budget' : 'Add New Budget';
    var original = budget.data;
    original._id = budgetID;
    $scope.budget = angular.copy(original);
    $scope.budget._id = budgetID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.budget);
    }
    
    //Currency list
        currencyService.getCurrencies().then(function(data) {
        $scope.currencies = data.data;
    });
    
    //Financial Year List
    financialYearService.getFinancialYears().then(function(data) {
        $scope.financialYears = data.data;
    });
    
    //Project List
    projectService.getProjects().then(function(data) {
        $scope.projects = data.data;
    });

    $scope.deleteBudget = function(budget) {
        $location.path('/budgets');
        if (confirm("Are you sure to delete budget ID: " + $scope.budget._id) == true)
            budgetService.deleteBudget(budget.budget_id);
        ///////////Navigate back to the list
    };

    $scope.saveBudget = function(budget) {
        $location.path('/budgets');
        if (budgetID <= 0) {
            budgetService.insertBudget(budget);
        }
        else {
            budgetService.updateBudget(budgetID, budget);
        }
    };
});


//TypeOfSupportBudget Controllers----------------------------------------------------------
app.controller('TypeOfSupportBudgetListCtrl', function($scope, typeOfSupportBudgetService) {
    typeOfSupportBudgetService.getTypeOfSupportBudgets().then(function(data) {
        $scope.typeOfSupportBudgets = data.data;
    });
});


app.controller('TypeOfSupportBudgetEditCtrl', function($scope, $rootScope, $location, $routeParams, typeOfSupportBudgetService,typeOfSupportService, budgetService, typeOfSupportBudget) {
    var typeOfSupportBudgetID = ($routeParams.typeOfSupportBudgetID) ? parseInt($routeParams.typeOfSupportBudgetID) : 0;
    $rootScope.title = (typeOfSupportBudgetID > 0) ? 'Edit Type Of Support Budget' : 'Add Type Of Support Budget';
    $scope.buttonText = (typeOfSupportBudgetID > 0) ? 'Update Type Of Support Budget' : 'Add New Type Of Support Budget';
    var original = typeOfSupportBudget.data;
    original._id = typeOfSupportBudgetID;
    $scope.typeOfSupportBudget = angular.copy(original);
    $scope.typeOfSupportBudget._id = typeOfSupportBudgetID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.typeOfSupportBudget);
    }

    //Type of support list
    typeOfSupportService.getTypeOfSupports().then(function(data) {
        $scope.typeOfSupports = data.data;
    });
    
    //Budget List
    budgetService.getBudgets().then(function(data) {
        $scope.budgets = data.data;
    });
    

    $scope.deleteTypeOfSupportBudget = function(typeOfSupportBudget) {
        $location.path('/typeOfSupportBudgets');
        if (confirm("Are you sure to delete Type Of Support Budget ID: " + $scope.typeOfSupportBudget._id) == true)
            typeOfSupportBudgetService.deleteTypeOfSupportBudget(typeOfSupportBudget.type_of_support_budget_id);
        ///////////Navigate back to the list
    };

    $scope.saveTypeOfSupportBudget = function(typeOfSupportBudget) {
        $location.path('/typeOfSupportBudgets');
        if (typeOfSupportBudgetID <= 0) {
            typeOfSupportBudgetService.insertTypeOfSupportBudget(typeOfSupportBudget);
        }
        else {
            typeOfSupportBudgetService.updateTypeOfSupportBudget(typeOfSupportBudgetID, typeOfSupportBudget);
        }
    };
});

//ProjectSubCategoryOfSupportBudget Controllers----------------------------------------------------------
app.controller('ProjectSubCategoryOfSupportBudgetListCtrl', function($scope, projectSubCategoryOfSupportBudgetService) {
    projectSubCategoryOfSupportBudgetService.getProjectSubCategoryOfSupportBudgets().then(function(data) {
        $scope.projectSubCategoryOfSupportBudgets = data.data;
    });
});


app.controller('ProjectSubCategoryOfSupportBudgetEditCtrl', function($scope, $rootScope, $location, $routeParams, projectSubCategoryOfSupportBudgetService,typeOfSupportBudgetService, subCategoryOfSupportService, projectSubCategoryOfSupportBudget) {
    var projectSubCategoryOfSupportBudgetID = ($routeParams.projectSubCategoryOfSupportBudgetID) ? parseInt($routeParams.projectSubCategoryOfSupportBudgetID) : 0;
    $rootScope.title = (projectSubCategoryOfSupportBudgetID > 0) ? 'Edit Project SubCategory Of Support Budget' : 'Add Project SubCategory Of Support Budget';
    $scope.buttonText = (projectSubCategoryOfSupportBudgetID > 0) ? 'Update Project SubCategory Of Support Budget' : 'Add New Project SubCategory Of Support Budget';
    var original = projectSubCategoryOfSupportBudget.data;
    original._id = projectSubCategoryOfSupportBudgetID;
    $scope.projectSubCategoryOfSupportBudget = angular.copy(original);
    $scope.projectSubCategoryOfSupportBudget._id = projectSubCategoryOfSupportBudgetID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.projectSubCategoryOfSupportBudget);
    }

    //Type of support Budget list
    typeOfSupportBudgetService.getTypeOfSupportBudgets().then(function(data) {
        $scope.typeOfSupportBudgets = data.data;
    });
    
    //SubCategory of support list
    subCategoryOfSupportService.getSubCategoryOfSupports().then(function(data) {
        $scope.subCategoryOfSupports = data.data;
    });
    

    $scope.deleteProjectSubCategoryOfSupportBudget = function(projectSubCategoryOfSupportBudget) {
        $location.path('/projectSubCategoryOfSupportBudgets');
        if (confirm("Are you sure to delete Project SubCategory Of Support Budget ID: " + $scope.projectSubCategoryOfSupportBudget._id) == true)
            projectSubCategoryOfSupportBudgetService.deleteProjectSubCategoryOfSupportBudget(projectSubCategoryOfSupportBudget.project_sub_category_of_support_budget_id);
        ///////////Navigate back to the list
    };

    $scope.saveProjectSubCategoryOfSupportBudget = function(projectSubCategoryOfSupportBudget) {
        $location.path('/projectSubCategoryOfSupportBudgets');
        if (projectSubCategoryOfSupportBudgetID <= 0) {
            projectSubCategoryOfSupportBudgetService.insertProjectSubCategoryOfSupportBudget(projectSubCategoryOfSupportBudget);
        }
        else {
            projectSubCategoryOfSupportBudgetService.updateProjectSubCategoryOfSupportBudget(projectSubCategoryOfSupportBudgetID, projectSubCategoryOfSupportBudget);
        }
    };
});


//NationalBudget Controllers----------------------------------------------------------
app.controller('NationalBudgetListCtrl', function($scope, nationalBudgetService) {
    nationalBudgetService.getNationalBudgets().then(function(data) {
        $scope.nationalBudgets = data.data;
    });
});


app.controller('NationalBudgetEditCtrl', function($scope, $rootScope, $location, $routeParams, nationalBudgetService,typeOfSupportService, budgetService, nationalBudget) {
    var nationalBudgetID = ($routeParams.nationalBudgetID) ? parseInt($routeParams.nationalBudgetID) : 0;
    $rootScope.title = (nationalBudgetID > 0) ? 'Edit National Budget' : 'Add National Budget';
    $scope.buttonText = (nationalBudgetID > 0) ? 'Update National Budget' : 'Add New National Budget';
    var original = nationalBudget.data;
    original._id = nationalBudgetID;
    $scope.nationalBudget = angular.copy(original);
    $scope.nationalBudget._id = nationalBudgetID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.nationalBudget);
    }
    
    //Budget List
    budgetService.getBudgets().then(function(data) {
        $scope.budgets = data.data;
    });
    

    $scope.deleteNationalBudget = function(nationalBudget) {
        $location.path('/nationalBudgets');
        if (confirm("Are you sure to delete National Budget ID: " + $scope.nationalBudget._id) == true)
            nationalBudgetService.deleteNationalBudget(nationalBudget.national_budget_id);
        ///////////Navigate back to the list
    };

    $scope.saveNationalBudget = function(nationalBudget) {
        $location.path('/nationalBudgets');
        if (nationalBudgetID <= 0) {
            nationalBudgetService.insertNationalBudget(nationalBudget);
        }
        else {
            nationalBudgetService.updateNationalBudget(nationalBudgetID, nationalBudget);
        }
    };
});

//NationalBudgetCostCategory Controllers----------------------------------------------------------
app.controller('NationalBudgetCostCategoryListCtrl', function($scope, nationalBudgetCostCategoryService) {
    nationalBudgetCostCategoryService.getNationalBudgetCostCategorys().then(function(data) {
        $scope.nationalBudgetCostCategorys = data.data;
    });
});


app.controller('NationalBudgetCostCategoryEditCtrl', function($scope, $rootScope, $location, $routeParams, nationalBudgetCostCategoryService,projectService,nationalBudgetService, costCategoryService, nationalBudgetCostCategory) {
    var nationalBudgetCostCategoryID = ($routeParams.nationalBudgetCostCategoryID) ? parseInt($routeParams.nationalBudgetCostCategoryID) : 0;
    $rootScope.title = (nationalBudgetCostCategoryID > 0) ? 'Edit National Budget Cost Category' : 'Add National Budget Cost Category';
    $scope.buttonText = (nationalBudgetCostCategoryID > 0) ? 'Update National Budget Cost Category' : 'Add New National Budget Cost Category';
    var original = nationalBudgetCostCategory.data;
    original._id = nationalBudgetCostCategoryID;
    $scope.nationalBudgetCostCategory = angular.copy(original);
    $scope.nationalBudgetCostCategory._id = nationalBudgetCostCategoryID;

    $scope.isClean = function() {
        return angular.equals(original, $scope.nationalBudgetCostCategory);
    }
    
    //National Budget List
    nationalBudgetService.getNationalBudgets().then(function(data) {
        $scope.nationalBudgets = data.data;
    });
    
    projectService.getProjects().then(function(data) {
        $scope.projects = data.data;
    });
    
    //Cost Category List
    costCategoryService.getCostCategorys().then(function(data) {
        $scope.costCategorys = data.data;
    });
    

    $scope.deleteNationalBudgetCostCategory = function(nationalBudgetCostCategory) {
        $location.path('/nationalBudgetCostCategorys');
        if (confirm("Are you sure to delete National Budget Cost Category ID: " + $scope.nationalBudgetCostCategory._id) == true)
            nationalBudgetCostCategoryService.deleteNationalBudgetCostCategory(nationalBudgetCostCategory.national_budget_cost_category_cost_category_id);
        ///////////Navigate back to the list
    };

    $scope.saveNationalBudgetCostCategory = function(nationalBudgetCostCategory) {
        $location.path('/nationalBudgetCostCategorys');
        if (nationalBudgetCostCategoryID <= 0) {
            nationalBudgetCostCategoryService.insertNationalBudgetCostCategory(nationalBudgetCostCategory);
        }
        else {
            nationalBudgetCostCategoryService.updateNationalBudgetCostCategory(nationalBudgetCostCategoryID, nationalBudgetCostCategory);
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
                    templateUrl: 'partials/home.html',
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

                .when('/districts', {
                    title: 'District',
                    templateUrl: 'partials/district/district-list.html',
                    controller: 'DistrictListCtrl'
                })
                .when('/edit-district/:districtID', {
                    title: 'Edit District',
                    templateUrl: 'partials/district/edit-district.html',
                    controller: 'DistrictEditCtrl',
                    resolve: {
                        district: function(districtService, $route) {
                            var districtID = $route.current.params.districtID;
                            return districtService.getDistrict(districtID);
                        }
                    }
                })

                ////////////////////SubCategory Of Support Routes///////////////////////////
                .when('/subCategoryOfSupports', {
                    title: 'SubCategory Of Support',
                    templateUrl: 'partials/subCategoryOfSupport/subCategoryOfSupport-list.html',
                    controller: 'SubCategoryOfSupportListCtrl'
                })
                .when('/edit-subCategoryOfSupport/:subCategoryOfSupportID', {
                    title: 'Edit SubCategory Of Support',
                    templateUrl: 'partials/subCategoryOfSupport/edit-subCategoryOfSupport.html',
                    controller: 'SubCategoryOfSupportEditCtrl',
                    resolve: {
                        subCategoryOfSupport: function(subCategoryOfSupportService, $route) {
                            var subCategoryOfSupportID = $route.current.params.subCategoryOfSupportID;
                            return subCategoryOfSupportService.getSubCategoryOfSupport(subCategoryOfSupportID);
                        }
                    }
                })

                ////////////////////Organisation Routes///////////////////////////
                .when('/organisations', {
                    title: 'Organisations',
                    templateUrl: 'partials/organisation/organisation-list.html',
                    controller: 'OrganisationListCtrl'
                })
                .when('/edit-organisation/:organisationID', {
                    title: 'Edit Organisations',
                    templateUrl: 'partials/organisation/edit-organisation.html',
                    controller: 'OrganisationEditCtrl',
                    resolve: {
                        organisation: function(organisationService, $route) {
                            var organisationID = $route.current.params.organisationID;
                            return organisationService.getOrganisation(organisationID);
                        }
                    }
                })


                ////////////////////Project Routes///////////////////////////
                .when('/projects', {
                    title: 'Projects',
                    templateUrl: 'partials/project/project-list.html',
                    controller: 'ProjectListCtrl'
                })
                .when('/edit-project/:projectID', {
                    title: 'Edit Projects',
                    templateUrl: 'partials/project/edit-project.html',
                    controller: 'ProjectEditCtrl',
                    resolve: {
                        project: function(projectService, $route) {
                            var projectID = $route.current.params.projectID;
                            return projectService.getProject(projectID);
                        }
                    }
                })
                
                 ////////////////////Partner Routes///////////////////////////
                .when('/partners', {
                    title: 'Partners',
                    templateUrl: 'partials/partner/partner-list.html',
                    controller: 'PartnerListCtrl'
                })
                .when('/edit-partner/:partnerID', {
                    title: 'Edit Partners',
                    templateUrl: 'partials/partner/edit-partner.html',
                    controller: 'PartnerEditCtrl',
                    resolve: {
                        partner: function(partnerService, $route) {
                            var partnerID = $route.current.params.partnerID;
                            return partnerService.getPartner(partnerID);
                        }
                    }
                })
                
                 ////////////////////Budget Routes///////////////////////////
                .when('/budgets', {
                    title: 'Budgets',
                    templateUrl: 'partials/budget/budget-list.html',
                    controller: 'BudgetListCtrl'
                })
                .when('/edit-budget/:budgetID', {
                    title: 'Edit Budgets',
                    templateUrl: 'partials/budget/edit-budget.html',
                    controller: 'BudgetEditCtrl',
                    resolve: {
                        budget: function(budgetService, $route) {
                            var budgetID = $route.current.params.budgetID;
                            return budgetService.getBudget(budgetID);
                        }
                    }
                })
                
                ////////////////////Type Of Support Budget Routes///////////////////////////
                .when('/typeOfSupportBudgets', {
                    title: 'Type Of Support Budget',
                    templateUrl: 'partials/typeOfSupportBudget/typeOfSupportBudget-list.html',
                    controller: 'TypeOfSupportBudgetListCtrl'
                })
                .when('/edit-typeOfSupportBudget/:typeOfSupportBudgetID', {
                    title: 'Edit Type Of Support Budget',
                    templateUrl: 'partials/typeOfSupportBudget/edit-typeOfSupportBudget.html',
                    controller: 'TypeOfSupportBudgetEditCtrl',
                    resolve: {
                        typeOfSupportBudget: function(typeOfSupportBudgetService, $route) {
                            var typeOfSupportBudgetID = $route.current.params.typeOfSupportBudgetID;
                            return typeOfSupportBudgetService.getTypeOfSupportBudget(typeOfSupportBudgetID);
                        }
                    }
                })

                ////////////////////Project SubCategory Of Support Budget Routes///////////////////////////
                .when('/projectSubCategoryOfSupportBudgets', {
                    title: 'Project SubCategory Of Support Budget',
                    templateUrl: 'partials/projectSubCategoryOfSupportBudget/projectSubCategoryOfSupportBudget-list.html',
                    controller: 'ProjectSubCategoryOfSupportBudgetListCtrl'
                })
                .when('/edit-projectSubCategoryOfSupportBudget/:projectSubCategoryOfSupportBudgetID', {
                    title: 'Edit Project SubCategory Of Support Budget',
                    templateUrl: 'partials/projectSubCategoryOfSupportBudget/edit-projectSubCategoryOfSupportBudget.html',
                    controller: 'ProjectSubCategoryOfSupportBudgetEditCtrl',
                    resolve: {
                        projectSubCategoryOfSupportBudget: function(projectSubCategoryOfSupportBudgetService, $route) {
                            var projectSubCategoryOfSupportBudgetID = $route.current.params.projectSubCategoryOfSupportBudgetID;
                            return projectSubCategoryOfSupportBudgetService.getProjectSubCategoryOfSupportBudget(projectSubCategoryOfSupportBudgetID);
                        }
                    }
                })
                
                ////////////////////National Budget Routes///////////////////////////
                .when('/nationalBudgets', {
                    title: 'National Budget',
                    templateUrl: 'partials/nationalBudget/nationalBudget-list.html',
                    controller: 'NationalBudgetListCtrl'
                })
                .when('/edit-nationalBudget/:nationalBudgetID', {
                    title: 'Edit National Budget',
                    templateUrl: 'partials/nationalBudget/edit-nationalBudget.html',
                    controller: 'NationalBudgetEditCtrl',
                    resolve: {
                        nationalBudget: function(nationalBudgetService, $route) {
                            var nationalBudgetID = $route.current.params.nationalBudgetID;
                            return nationalBudgetService.getNationalBudget(nationalBudgetID);
                        }
                    }
                })
                
                ////////////////////National Budget Cost Category Routes///////////////////////////
                .when('/nationalBudgetCostCategorys', {
                    title: 'National Budget Cost Category',
                    templateUrl: 'partials/nationalBudgetCostCategory/nationalBudgetCostCategory-list.html',
                    controller: 'NationalBudgetCostCategoryListCtrl'
                })
                .when('/edit-nationalBudgetCostCategory/:nationalBudgetCostCategoryID', {
                    title: 'Edit National Budget Cost Category',
                    templateUrl: 'partials/nationalBudgetCostCategory/edit-nationalBudgetCostCategory.html',
                    controller: 'NationalBudgetCostCategoryEditCtrl',
                    resolve: {
                        nationalBudgetCostCategory: function(nationalBudgetCostCategoryService, $route) {
                            var nationalBudgetCostCategoryID = $route.current.params.nationalBudgetCostCategoryID;
                            return nationalBudgetCostCategoryService.getNationalBudgetCostCategory(nationalBudgetCostCategoryID);
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