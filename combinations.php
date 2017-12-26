<!DOCTYPE html>
<html>
    <head>
        <title>Carbon Sequestration | CREEC</title>
        <link rel="stylesheet" href="/portfolio/creec/assets/styles/main.css" />
        <script src="/portfolio/creec/assets/scripts/jquery-3.2.1.min.js"></script>
        <meta charset="utf-8" />
        <meta content="" />
        <?php
            date_default_timezone_set('America/Los_Angeles');
            ini_set('display_errors',1);
            error_reporting(-1);
        ?>
        <script src="/portfolio/creec/assets/scripts/combinatorics.js"></script>
        <script>
            $(document).ready(function() {
                // No Script Override
                document.getElementById('content').style.display = 'block';

                var size = 7;
                var letters = ['a','b','c','d','e','f'];
                var minval = [0,1,5,25,50,75];
                var maxval = [1,5,25,50,75,100];
                var combos = [];
                var set = [];
                var min = 0, max = 0;
                var index = 0;
                var permutation = function(set, min, max) {
                    if (min + minval[index] <= 100) {
                        var setCopy = set;
                        var minCopy = min + minval[index];
                        var maxCopy = max + maxval[index];
                    } else {
                        index++;
                        if (index == size) {
                            return;
                        }
                    }
                    if (setCopy.length == size && max >= 100) {
                        combos.push(copySet);
                    } else if (copySet.length < size) {
                        permutation(setCopy, minCopy, maxCopy);
                    }
                }
                permutation(set, min, max);
                $.each(combos, function(index, value) {
                    $('#combs').append($('<p>', {
                        text: index+': '+value
                    }));
                });
            });
        </script>
    </head>
    <body>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/header.php'); ?>
        <?php

        ?>
        <div id="content" style="display: none;">
            <div id="combs">
            </div>
        <div class="clear"></div>
        <noscript>Javascript Must be enabled for this site to function</noscript>
    </body>
</html>
