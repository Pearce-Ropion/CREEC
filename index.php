<!DOCTYPE html>
<html>
    <head>
        <title>Carbon Sequestration | CREEC</title>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/head.php'); ?>
    </head>
    <body>
        <div id="page-wrapper">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/header.php'); ?>
            <?php
                $debug = false;
                $page = 'home';
                $species = array("Acer negundo", "Acer (other)", "Alnus rhombifolia", "Alnus (other)", "Aesculus californica", "Baccharis pilularis", "Baccharis salicifiolia", "Cephalanthus occidentalis", "Fraxinus latifolia", "Garrya elliptica", "Heteromeles arbutifolia", "Juglans (sp)", "Laurus nobilis", "Myrica californica", "Physocarpus capitatus", "Platanus racemosa", "Populus fremontii", "Populus (other)", "Quercus lobata", "Quercus agrifolia", "Quercus (other)", "Rosa californica",
                "Rubus (sp)", "Salix exigua", "Salix gooddingii", "Salix laevigata", "Salix lasiolepis", "Salix lucida", "Salix (other)", "Sambucus (sp)", "Symphoricarpos albus", "Toxicodendron diversilobum", "Vitis californicus", "Other canopy tree", "Other understory woody shrub");
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
                    <div id="creec">
                        <div id="down">
                            <div class="down-arrow"></div>
                        </div>
                    </div>
                    <div id="display-wrapper">
                        <form id="carbon-form" name="carbon-form" method="post" action="/portfolio/creec/carbon/">
                            <div id="basic-details">
                                <div class="bd-element">
                                    <label for="regen">Regeneration</label>
                                    <p>What type of restoration is this project?</p>
                                    <select id="regen" name="regen">
                                        <option value="0" disabled selected>Regeneration Type</option>
                                        <option value="1">Natural Regeneration</option>
                                        <option value="2">Planted Communities</option>
                                        <option value="3">Avoided Conversion</option>
                                    </select>
                                    <p id="regen-error" class="bd-error">You must select a regeneration type</p>
                                </div>
                                <div class="spacer"></div>
                                <div class="bd-element">
                                    <label for="region">Region</label>
                                    <p>Where is the project located?</p>
                                    <select id="region" name="region">
                                        <option value="0" disabled selected>Select a Location</option>
                                        <option value="1">Coast Ranges North/Central</option>
                                        <option value="2">Central Valley</option>
                                        <option value="3">Sierra Foothills (elev: < 3000 ft)</option>
                                        <option value="4">High Sierra (elev: > 3000 ft)</option>
                                        <option value="5">Southern California</option>
                                    </select>
                                    <p id="region-error" class="bd-error">You must select a region</p>
                                </div>
                                <div class="bd-extras-req">
                                    <div class="spacer"></div>
                                    <div class="bd-element">
                                        <label for="siteprep">Site Preparation</label>
                                        <p>What is the intensity of soil disturbance of the site?</p>
                                        <select id="siteprep" name="siteprep">
                                            <option value="0" disabled selected>Select a Site Prep</option>
                                            <option value="1">Low / Non-mechanical</option>
                                            <option value="2">High / Mechanical</option>
                                        </select>
                                        <p id="sp-error" class="bd-error">You must select a site preparation intensity</p>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="bd-element bd-element-unknown">
                                        <label for="landuse">Land Use</label>
                                        <p>How is the land used?</p>
                                        <div class="bd-unknown">
                                            Unknown
                                            <input id="landuse-x" name="landuse-x" type="checkbox" />
                                        </div>
                                        <select id="landuse" name="landuse">
                                            <option value="0" disabled selected>Select a Land Use</option>
                                            <option value="1">Crops</option>
                                            <option value="2">Grazing</option>
                                            <option value="3">Orchards</option>
                                            <option value="4">Degraded / Invaded</option>
                                        </select>
                                        <p id="lu-error" class="bd-error">You must select a land use</p>
                                    </div>
                                </div>
                            </div>
                            <div class="species-req">
                                <span class="clear"></span>
                                <div id="communities" class="communities c-accordion">
                                    <h3 class="comm-title">Planting Community 1</h3>
                                    <div id="community1" class="community">
                                        <div class="comm-section">
                                            <label for="acreage1">Planted Community Area (acres)</label>
                                            <input id="acreage1" name="acreage[]" type="number" min="0.1" step="0.1" pattern="/\d+/" title="Enter the acreage of your planting community"/>
                                        </div>
                                        <div class="comm-spacer"></div>
                                        <div id="comm-species1" class="comm-section">
                                            <p class="species-warning">Please enter woody species only</p>
                                            <div class="species-type">
                                                <label for="species1-type%" title="Use percentages to describe this community">Percentage</label>
                                                <input id="species1-type%" name="species1-type" type="radio" value="%" checked />
                                                <label for="species1-type#" title="Use plants/acre to describe this community"># of Plants</label>
                                                <input id="species1-type#" name="species1-type" type="radio" value="#" />
                                            </div>
                                            <?php
                                                for ($x = 1; $x <= 5; $x++) {
                                                    echo '<div id="comm-species1-'.$x.'" class="comm-species">';
                                                        echo '<select id="species1-'.$x.'" name="species1-'.$x.'">';
                                                            echo '<option value="0" disabled selected>Species '.$x.'</option>';
                                                            for ($z = 1; $z <= count($species); $z++) {
                                                                echo '<option value="'.$z.'">'.$species[$z-1].'</option>';
                                                            }
                                                        echo '</select>';
                                                        echo '<input id="species1-'.$x.'-type%" name="species1-'.$x.'-type%" type="number" min="0", max="100" class="textbox species-num" /><span> %</span>';
                                                        echo '<input id="species1-'.$x.'-type#" name="species1-'.$x.'-type#" type="number" min="0" class="textbox species-num" disabled />';
                                                        if ($x == 5) {
                                                          echo '<a class="species-remove" style="color: #cd0a0a;">X</a>';
                                                        }
                                                    echo '</div>';
                                                }
                                                echo '<input id="addspecies1" name="addspecies1" type="button" value="Add Species" class="c-button ui-button btn-add-species"/>';
                                                echo '<span id="comm1-error" class="comm-error">Temporary text</span>';
                                                echo '<input name="species1-count" value="5" type="hidden" />';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <button id="addCommunity" class="c-button"></button>
                            </div>
                            <input name="carbon-form-comms" value="" type="hidden" />
                            <input name="carbon-form-php" type="hidden" />
                            <button id="submit" type="submit" class="c-button">Submit</button>
                        </form>
                    </div>
                </div>
                <span class="clear"></span>
            </div>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/footer.php'); ?>
    </body>
</html>
