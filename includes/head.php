<link rel="stylesheet" href="/portfolio/creec/assets/styles/jquery-ui.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato|Open+Sans">
<link rel="stylesheet" href="/portfolio/creec/assets/styles/main.css" />
<script type="text/javascript" src="/portfolio/creec/assets/scripts/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/portfolio/creec/assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="/portfolio/creec/assets/scripts/addSpecies.js"></script>
<script type="text/javascript" src="/portfolio/creec/assets/scripts/addCommunity.js"></script>
<script type="text/javascript" src="/portfolio/creec/assets/scripts/main.js"></script>
<meta charset="utf-8" />
<meta keywords="california, carbon estimator, riparian, forest, carbon calculator" />
<meta description="CREEC, the Carbon in Riparian Ecosystems Estimator for California, is a web-based tool that predicts carbon stocks in riparian forests at ages from 0-100 years." />
<?php
    class CarbonDB extends SQLite3 {
        function __construct() {
            $path = $_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/database/';
            $this->open($path.'carbon.db');
        }
    }
    $sql = new CarbonDB();
    if (!$sql) {
        die('Connection failed: '.$sql->lastErrorMsg());
    }
    date_default_timezone_set('America/Los_Angeles');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<noscript><link rel="stylesheet" href="/portfolio/creec/assets/styles/fallback.css" /></noscript>
