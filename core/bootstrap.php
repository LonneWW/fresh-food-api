<?php

require 'database/QueryBuilder.php';
require 'Router.php';
require 'Request.php';
require 'App.php';


App::bind('database', new QueryBuilder);
