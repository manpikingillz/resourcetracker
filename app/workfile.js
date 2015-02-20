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