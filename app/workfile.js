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