<!DOCTYPE html>
<html ng-app="resourceTrackerApp" ng-app lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>RMNCH Resource Tracker</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
    ul>li, a{cursor: pointer;}
    </style>
        <link href="css/custom.css" rel="stylesheet">
        <!--<link href="css/toaster.css" rel="stylesheet">-->

        <!--Custom sytles for navigation bar-->
        <link href="css/navbar.css" rel="stylesheet" type="text/css"/>
        <style>
            a {
                color: orange;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]><link href= "css/bootstrap-theme.css"rel= "stylesheet" >

<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body>

        <div class="container">

            <!-- Static navbar -->
            <div class="navbar navbar-inverse" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#/">Resource Tracker</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <!--<li class="active"><a href="#/customers">Customers</a></li>-->
                            <li><a href="#">Projects</a></li>
                            <!--<li><a href="#/customers">Customers</a></li>-->
                            <li><a href="#">Budget</a></li>
                            <li><a href="#">Organisationns</a></li>
                            <li><a href="#">Partners</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown">Setup<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">Lookups</li>
                                    <li><a href="#/currencies">Currency</a></li>
                                    <li><a href="#/regions">Region</a></li>
                                    <li><a href="#/districts">District</a></li>
                                    <li><a href="#/financialYears">Financial Year</a></li>
                                    <li><a href="#/organisationTypes">Organisation Type</a></li>
                                    <li><a href="#/typeOfSupports">Type of support</a></li>
                                    <li><a href="#/subCategoryOfSupports">Subcategory of support</a></li>
                                    <li><a href="#/partnerTypes">Partner Type</a></li>
                                    <li><a href="#/authoritys">Authority</a></li>
                                    <li><a href="#/costCategorys">Cost Category</a></li> 

                                    <li class="divider"></li>
                                    <li class="dropdown-header">User Management</li>
                                    <li><a href="#">Users</a></li>
                                    <!--<li><a href="#">User Roles</a></li>-->  
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown">Login<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#/login">Login</a></li>
                                    <li class="divider">
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </div>
            
            <div >
            <!--<div class="container" style="margin-top:20px;">-->

                <div ng-view="" id="ng-view"></div>

            <!--</div>-->
            </div>

            <!-- Main component for a primary marketing message or call to action -->
            <!--            <div class="jumbotron">
                            <h1>Welcome</h1>
                            <p>This is RMNCH Resource Tracking Tool. To get started, go to the menu and click on what you want. To logout, click on the name in the right top corner, or click on the Logout button below</p>
                            <p>
                                <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">Logout &raquo;</a>
                            </p>
                        </div>-->
        </div> <!-- /container -->

        



   

  <!--<toaster-container toaster-options="{'time-out': 3000}"></toaster-container>-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
    <script src="js/jquery.min.js"></script>
 
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Libs -->
    <script src="angular/angular.min.js" type="text/javascript"></script>
    <script src="angular/angular-route.min.js" type="text/javascript"></script>

    <script src="app/app.js"></script>
    <!--<script src="app/data.js"></script>-->
    <!--<script src="app/directives.js"></script>-->
    <!--<script src="app/authCtrl.js"></script>-->
    <script src="js/toaster.js" type="text/javascript"></script>
    <script src="js/angular-animate.min.js" type="text/javascript"></script>
    </body>
</html>

