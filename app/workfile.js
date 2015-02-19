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


