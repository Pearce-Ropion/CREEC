<!DOCTYPE html>
<html>
    <head>
        <title>Carbon Sequestration | CREEC</title>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/head.php'); ?>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/export.php'); ?>
    </head>
    <body>
        <div id="page-wrapper">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/header.php'); ?>
            <?php
                $debug = false;
                $page = 'carbon';
                $warning = false;
                $defSpecies = 5;
                $maxSpecies = 20;
                $maxCommunities = 4;
                $species = array("Acer negundo", "Acer (other)", "Alnus rhombifolia", "Alnus (other)", "Aesculus californica", "Baccharis pilularis", "Baccharis salicifiolia", "Cephalanthus occidentalis", "Fraxinus latifolia", "Garrya elliptica", "Heteromeles arbutifolia", "Juglans (sp)", "Laurus nobilis", "Myrica californica", "Physocarpus capitatus", "Platanus racemosa", "Populus fremontii", "Populus (other)", "Quercus lobata", "Quercus agrifolia", "Quercus (other)", "Rosa californica",
                "Rubus (sp)", "Salix exigua", "Salix gooddingii", "Salix laevigata", "Salix lasiolepis", "Salix lucida", "Salix (other)", "Sambucus (sp)", "Symphoricarpos albus", "Toxicodendron diversilobum", "Vitis californicus", "Other canopy tree", "Other understory woody shrub");
                $categories = array('Willow', 'Cottenwood', 'Oak', 'Shrub', 'AlWal', 'ABS', 'Other');
                $regens = array('Natural Regeneration', 'Planted Communities', 'Avoided Conversion');
                $regensX = array('NatRegen', 'Planted Communities', 'Avoided Conversion');
                $regions = array('Coast Ranges North/Central', 'Central Valley', 'Sierra Foothills', 'High Sierra', 'Southern California');
                $regionsX = array('Coast Ranges North/Central', 'Central Valley', 'Sierra Foothills', 'HighSierra', 'SoCal');
                $sitePreps = array('Low / Non-mechanical', 'High / Mechanical');
                $sitePrepsX = array('low/nonmechanical', 'high/mechanical');
                $landUses = array('Crops', 'Grazing', 'Orchards', 'Degraded / Invaded', 'Unknown');
                $landUsesX = array('crops', 'grazing', 'orchards', 'degraded/inv', 'unknown');
                $stockID = array();
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Check if form has been completed successfully
                    if (isset($_POST['carbon-form-php'])) {

                        // Receive constants
                        $regen = $_POST['regen'];
                        $region = $_POST['region'];
                        if (isset($_POST['siteprep'])) {
                            $sitePrep = $_POST['siteprep'];
                        } else {
                            $sitePrep = null;
                        }
                        if (isset($_POST['landuse-x'])) {
                            $landUse = 5;
                        } else if (isset($_POST['landuse'])) {
                            $landUse = $_POST['landuse'];
                        } else {
                            $landUse = null;
                        }
                        if ($regen == 2 || $regen == 3) {

                            // Initialize Community Arrays
                            $commTypes = array();
                            $numSpecies = array();
                            $commSpecies = array();
                            $commSpeciesCtg = array();
                            $commSpeciesAdjCtg = array();
                            $commValue = array();
                            $commAdjValue = array();
                            $commValueCtg = array();
                            $commValueLetter = array();
                            $commWord = array();
                            $commForestType = array();
                            // Receive community specific constants
                            if (isset($_POST['carbon-form-comms'])) {
                                $numCommunities = $_POST['carbon-form-comms'];
                            }
                            $acreage = array();
                            $commType = array();
                            foreach ($_POST['acreage'] as $acre) {
                                array_push($acreage, $acre);
                            }
                            for ($x = 1; $x <= $numCommunities; $x++) {
                                array_push($commType, $_POST['species'.$x.'-type']);
                                array_push($numSpecies, $_POST['species'.$x.'-count']);
                            }

                            // Receive and calculate all data
                            for ($x = 1; $x <= $numCommunities; $x++) {

                                // Initialize community arrays
                                $speciesSet = array();
                                $tempValue = array();
                                $speciesValue = array();
                                $speciesCtg = array();
                                $speciesAdjCtg = array();
                                $speciesAdjValue = array();
                                $categoryValue = array(null, null, null, null, null, null, null);
                                $categoryLetter = array();
                                $type = $commType[$x-1];
                                $totalPlants = 0;

                                // Push basic species info
                                for ($z = 1; $z <= $numSpecies[$x-1]; $z++) {
                                    if (isset($_POST['species'.$x.'-'.$z])) {

                                        // Push species name
                                        $selected = $_POST['species'.$x.'-'.$z];
                                        array_push($speciesSet, $selected);

                                        // Push species category from db
                                        $query = "SELECT * FROM categories WHERE id='$selected'";
                                        $result = $sql->query($query);
                                        while ($row = $result->fetchArray()) {
                                            array_push($speciesCtg, $row['category']);
                                        }

                                        // Push species value based on type
                                        if ($type == '%') {
                                            $value = $_POST['species'.$x.'-'.$z.'-type%'];
                                            array_push($speciesValue, $value);
                                        } else {
                                            $value = $_POST['species'.$x.'-'.$z.'-type#'];
                                            // $value *= $acreage[$x-1];
                                            $totalPlants += $value;
                                            array_push($tempValue, $value);
                                        }
                                    }
                                }
                                // Push plants/acre averages
                                if ($type == '#') {
                                    for ($z = 0; $z < $numSpecies[$x-1]; $z++) {
                                        $value = round(($tempValue[$z] / $totalPlants) * 100, 2);
                                        array_push($speciesValue, $value);
                                    }
                                }

                                //Adjust Total Percentages
                                if (in_array('Remove', $speciesCtg)) {
                                    $totalVal = 100;
                                    for ($z = 0; $z < $numSpecies[$x-1]; $z++) {
                                        if ($speciesCtg[$z] == 'Remove') {
                                            $totalVal -= $speciesValue[$z];
                                        }
                                    }
                                    for ($z = 0; $z < $numSpecies[$x-1]; $z++) {
                                        if ($speciesCtg[$z] != 'Remove') {
                                            $value = round(($speciesValue[$z] / $totalVal) * 100, 2);
                                            array_push($speciesAdjValue, $value);
                                            array_push($speciesAdjCtg, $speciesCtg[$z]);
                                        }
                                    }
                                } else {
                                    for ($z = 0; $z < $numSpecies[$x-1]; $z++) {
                                        array_push($speciesAdjValue, $speciesValue[$z]);
                                        array_push($speciesAdjCtg, $speciesCtg[$z]);
                                    }
                                }

                                // Push not-present categories
                                foreach ($categories as $i => $val) {
                                    if (!in_array($val, $speciesCtg)) {
                                        $categoryValue[$i] = 0;
                                    }
                                }

                                // Push present categories
                                $dupeCount = array_count_values($speciesCtg);
                                foreach ($dupeCount as $val => $count) {
                                    // If duplicate, find average, position and push
                                    if ($count > 1) {
                                        $total = 0;
                                        for ($z = 0; $z < count($speciesAdjValue); $z++) {
                                            if ($val == $speciesAdjCtg[$z]) {
                                                $total += $speciesAdjValue[$z];
                                            }
                                        }
                                        foreach ($categories as $i => $name) {
                                            if ($val == $name) {
                                                $categoryValue[$i] = $total;
                                            }
                                        }
                                    // Otherwise, find position and push
                                    // Theres probably a better way to do this one
                                    } else if ($count == 1) {
                                        for ($z = 0; $z < count($speciesAdjValue); $z++) {
                                            if ($val == $speciesAdjCtg[$z]) {
                                                foreach ($categories as $i => $name) {
                                                    if ($val == $name) {
                                                        $categoryValue[$i] = $speciesAdjValue[$z];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                // Create Letters
                                foreach ($categoryValue as $val) {
                                    if ($val >= 0 && $val <= 1) $letter = 'A';
                                    else if ($val >= 1 && $val <= 5) $letter = 'B';
                                    else if ($val >= 5 && $val <= 25) $letter = 'C';
                                    else if ($val >= 25 && $val <= 50) $letter = 'D';
                                    else if ($val >= 50 && $val <= 75) $letter = 'E';
                                    else if ($val >= 75 && $val <= 100) $letter = 'F';
                                    array_push($categoryLetter, $letter);
                                }

                                // Concatenate Letters into word
                                $word = implode('', $categoryLetter);

                                // Push species data into community arrays
                                array_push($commSpecies, $speciesSet);
                                array_push($commSpeciesCtg, $speciesCtg);
                                array_push($commValue, $speciesValue);
                                array_push($commSpeciesAdjCtg, $speciesAdjCtg);
                                array_push($commAdjValue, $speciesAdjValue);
                                array_push($commValueCtg, $categoryValue);
                                array_push($commValueLetter, $categoryLetter);
                                array_push($commWord, $word);
                            }

                            // Pull forest_type from db
                            for ($x = 0; $x < $numCommunities; $x++) {
                                $word = $commWord[$x];
                                $query = "SELECT * FROM permutations WHERE word='$word'";
                                $result = $sql->query($query);
                                while ($row = $result->fetchArray()) {
                                    array_push($commForestType, $row['forest_type']);
                                }
                            }
                        }

                        // Pull stock tables
                        $regenType = $regensX[$regen-1];
                        $regionType = $regionsX[$region-1];
                        $sitePrepType = ($sitePrep == null ? 'N/A' : $sitePrepsX[$sitePrep-1]);
                        $landUseType = ($landUse == null ? 'N/A' : $landUsesX[$landUse-1]);
                        $queries = array();
                        $regionOverride = false;
                        if ($regionType == 'HighSierra' || $regionType == 'SoCal') {
                            $regionOverride = true;
                            $query = "SELECT * FROM stock_match WHERE forest_type='$regionType' AND land_use='$landUseType' AND site_prep='$sitePrepType'";
                            array_push($queries, $query);
                        }
                        if ($regen == 1 && !$regionOverride) {
                            $query = "SELECT * FROM stock_match WHERE forest_type='$regenType' AND land_use='$landUseType' AND site_prep='$sitePrepType'";
                            array_push($queries, $query);
                        }
                        if (($regen == 2 || $regen == 3) && !$regionOverride) {
                            for ($x = 0; $x < $numCommunities; $x++) {
                                if ($commForestType[$x] == 'warning') {
                                    $warning = true;
                                    $forestType = 'otherMRF';
                                } else {
                                    $forestType = $commForestType[$x];
                                }
                                $query = "SELECT * FROM stock_match WHERE forest_type='$forestType' AND land_use='$landUseType' AND site_prep='$sitePrepType'";
                                array_push($queries, $query);
                            }
                        }
                        foreach ($queries as $query) {
                            $result = $sql->query($query);
                            while ($row = $result->fetchArray()) {
                                array_push($stockID, $row['stock_id']);
                            }
                        }


                        // Debug Output
                        if ($debug) {
                            print('Regeneration Type: '.$regens[$regen-1].'<br />');
                            print('Regeneration Num: '.$regen.'<br />');
                            print('RegenType: '.$regenType.'<br />');
                            print('Selected Location: '.$regions[$region-1].'<br />');
                            if (isset($_POST['siteprep'])) {
                                print('Soil Preparation : '.$sitePreps[$sitePrep-1].'<br />');
                            } else {
                                print('Soil Preparation : Unknown<br />');
                            }
                            if (isset($_POST['landuse'])) {
                                print('Land Usage: '.$landUses[$landUse-1].'<br />');
                            } else {
                                print('Land Usage : Unknown<br />');
                            }
                            if ($regen == 2 || $regen == 3) {

                                print('Acreages: ');
                                print_r($acreage);
                                print('<br />');
                                print('Community Types: ');
                                print_r($commType);
                                print('<br />');
                                print('Community Species: ');
                                print_r($commSpecies);
                                print('<br />');
                                print('Community Species Categories: ');
                                print_r($commSpeciesCtg);
                                print('<br />');
                                print('Community Values: ');
                                print_r($commValue);
                                print('<br />');
                                print('Adjusted Community Species Categories: ');
                                print_r($commSpeciesAdjCtg);
                                print('<br />');
                                print('Adjusted Community Values: ');
                                print_r($commAdjValue);
                                print('<br />');
                                print('Community Forest Categories: ');
                                print_r($commValueCtg);
                                print('<br />');
                                print('Community Forest Letter Codes: ');
                                print_r($commValueLetter);
                                print('<br />');
                                print('Community Words: ');
                                print_r($commWord);
                                print('<br />');
                                print('Community Forest Types: ');
                                print_r($commForestType);
                                print('<br />');
                                print('# Communities: '.$numCommunities.'<br />');
                            }
                            print('Stock Table IDs: ');
                            print_r($stockID);
                            print('<br />');
                            print('<br />'.$query.'<br />');
                        }
                    }
                }
            ?>
            <div id="content">
                <noscript>
                    <div class="fallback">
                        <div class="logo"></div>
                        <section>
                            <h1>CREEC</h1>
                            <h2>Carbon in Riparian Ecosystems Estimator<br />for California</h2>
                            <p>
                                For full functionality of this website it is necessary to <strong>enable JavaScript</strong>.<br />
                                Here are the <a href="http://www.enable-javascript.com" target="_blank" rel="noopener noreferrer">instructions how to enable JavaScript in your web browser</a>.
                            </p>
                        </section>
                    </div>
                </noscript>
                <div id="content-wrapper" class="jscontent" style="display: none;">
                    <div id="display-wrapper">
                        <div id="carbon">
                            <?php if ($warning): ?>
                                <div id="notice" class="n-box n-warning">
                                    <p><strong>Warning</strong>: The species information you have entered does not match with a riparian forest community represented by our database. Please check your inputs and interpret this result with caution. The stock table shown here is for a mixed riparian forest.</p>
                                    <a href="#" class="n-dismiss">X</a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['carbon-form-php'])): ?>
                                <section id="stock-details" class="ui-helper-reset ui-widget">
                                    <table>
                                        <tr>
                                            <th>Regeneration Type</th>
                                            <th>Region</th>
                                            <th>Site Preparation</th>
                                            <th>Land Use</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $regens[$regen-1]; ?></td>
                                            <td><?php echo $regions[$region-1]; ?></td>
                                            <td><?php echo $regen == 3 ? 'N / A' : $sitePreps[$sitePrep-1]; ?></td>
                                            <td><?php echo $regen == 3 ? 'N / A' : $landUses[$landUse-1]; ?></td>
                                        </tr>

                                    </table>
                                </section>
                                <section id="stock" class="c-accordion stock-accordian">
                                    <?php
                                        $count = count($stockID);
                                        for ($x = 0; $x < $count; $x++):
                                            echo '<h3 class="stock-title">Carbon Table '.($x+1).'</h3>';
                                    ?>
                                            <div id="stock-<?php echo $x+1 ?>" class="stock-panel">
                                                <?php if ($regen == 2 || $regen == 3): ?>
                                                    <div class="stock-acreage">
                                                        <p><strong>Acreage: </strong><?php echo $acreage[$x]; ?> acres</p>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="stock-buttons">
                                                    <button class="c-button ui-button print" style="font-weight: 400;">Print Table</button>
                                                    <select class="download">
                                                        <option value="0" disabled selected>Download Spreadsheet</option>
                                                        <option value="1">Excel (xlsx)</option>
                                                        <option value="2">PDF</option>
                                                        <option value="3">PNG</option>
                                                    </select>
                                                </div>
                                                <table id="stocktable-<?php echo $x+1 ?>" class="stock-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Age</th>
                                                            <th>Tree Carbon</th>
                                                            <th>Down Dead Carbon</th>
                                                            <th>Forest Floor Carbon</th>
                                                            <th>Understory Carbon</th>
                                                            <th>Non-Soil Carbon Accum</th>
                                                            <th>Soil Carbon Stock</th>
                                                            <th>Soil Carbon Accum</th>
                                                            <th>Total: Soil + Non-Soil Carbon Accum</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $id = $stockID[$x];
                                                            $query = "SELECT * FROM stock_tables WHERE stock_id='$id'";
                                                            $result = $sql->query($query);
                                                            while ($row = $result->fetchArray()):
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $row['age']; ?></td>
                                                                    <td><?php echo $row['all_trees']; ?></td>
                                                                    <td><?php echo $row['down_dead']; ?></td>
                                                                    <td><?php echo $row['forest_floor']; ?></td>
                                                                    <td><?php echo $row['understory']; ?></td>
                                                                    <td><?php echo $row['total_non-soil']; ?></td>
                                                                    <td><?php echo $row['total_soil']; ?></td>
                                                                    <td><?php echo $row['delta_soil']; ?></td>
                                                                    <td><?php echo $row['total']; ?></td>
                                                                </tr>
                                                        <?php endwhile; ?>
                                                   </tbody>
                                                </table>
                                            </div>
                                    <?php endfor; ?>
                                </section>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/footer.php'); ?>
    </body>
</html>
