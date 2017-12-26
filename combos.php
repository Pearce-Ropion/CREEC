<!DOCTYPE html>
<html>
    <head>
        <title>Carbon Sequestration | CREEC</title>
        <link rel="stylesheet" href="/portfolio/creec/assets/styles/main.css" />
        <script src="/portfolio/creec/assets/scripts/jquery-3.2.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/alasql/0.3/alasql.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.12/xlsx.core.min.js"></script>
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

                var letters = ['A', 'B', 'C', 'D', 'E', 'F']
                var minvals = [0, 1, 5, 25, 50, 75];
                var maxvals = [1, 5, 25, 50, 75, 100];
                var size = 7;
                var combos = [];
                var data = [];

                function rangeSet(size, letters, minval, maxval) {
                    addLetter([], 0, 0);

                    function addLetter(set, min, max) {
                        for (var lt = 0; lt < letters.length; lt++) {
                            if (min + minval[lt] < 100) {
                                var set_copy = set.concat([letters[lt]]);
                                var min_copy = min + minval[lt];
                                var max_copy = max + maxval[lt];
                                if (set_copy.length == size) {
                                    if (max_copy >= 100) {
                						combos.push(set_copy);
                                    }
                                }
                                else addLetter(set_copy, min_copy, max_copy);
                            }
                        }
                    }
                }

                rangeSet(size, letters, minvals, maxvals);

            	$('#log').html('# of Possible Combinations: ' + combos.length);
                $(document).on('click', '#excel', function() {
                    alasql('SELECT * INTO XLSX('+path+') FROM ?', [data]);
                });
                $.each(combos, function(index, set) {
                    var row = $('<tr>', {
                        'class': 'data-row'
                    });
                    var cell0 = $('<td>', {
                        text: index
                    });
                    var cell1 = $('<td>', {
                        text: set[0]
                    });
                    var cell2 = $('<td>', {
                        text: set[1]
                    });
                    var cell3 = $('<td>', {
                        text: set[2]
                    });
                    var cell4 = $('<td>', {
                        text: set[3]
                    });
                    var cell5 = $('<td>', {
                        text: set[4]
                    });
                    var cell6 = $('<td>', {
                        text: set[5]
                    });
                    var cell7 = $('<td>', {
                        text: set[6]
                    });
                    $(row)
                        .appendTo('#combos tbody')
                        .append(cell0)
                        .append(cell1)
                        .append(cell2)
                        .append(cell3)
                        .append(cell4)
                        .append(cell5)
                        .append(cell6)
                        .append(cell7);
                });
                window.exportExcel = function exportExcel() {
                    alasql('SELECT * INTO XLSX("Permutations.xlsx",{headers:true}) FROM HTML("#combos",{headers:true})');
                }
            });
        </script>
        <style>
            table {
                border-collapse: collapse;
                margin: auto;
            }
            tr {
                border-bottom: 1px solid black;
                border-top: 1px solid black;
            }
            td, th {
                border-right: 1px solid black;
                border-left: 1px solid black;
                padding: 10px 20px;
            }
        </style>
    </head>
    <body>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/header.php'); ?>
        <?php

        ?>
        <div id="content" style="display: none;">
            <button id="excel" onclick="window.exportExcel()">Download Excel</button>
            <br />
            <br />
            <p id="log"></p>
            <br />
            <table id="combos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Willow</th>
                        <th>Cottonwood</th>
                        <th>Oak</th>
                        <th>Shrub</th>
                        <th>Alwal</th>
                        <th>ABS</th>
                        <th>Other</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        <div class="clear"></div>
        <noscript>Javascript Must be enabled for this site to function</noscript>
    </body>
</html>
