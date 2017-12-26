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
                $page = 'about';
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
                        <div id="about">
                            <section class="sec-def">
                                <div class="two-thirds left">
                                    <h1>About CREEC</h1>
                                    <p class="paragraph">CREEC, the <strong>C</strong>arbon in <strong>R</strong>iparian <strong>E</strong>cosystems <strong>E</strong>stimator for <strong>C</strong>alifornia, is a web-based tool that predicts carbon stocks in riparian forests at ages from 0-100 years. CREEC is intended to be used in conjunction with the California Air Resources Board’s Quantification Methodology for riparian forest restoration and conservation projects to be funded by the California Climate Investments program.</p>
                                    <p class="paragraph">CREEC receives user inputs on the geographic location, previous land-use, intended forest community, and type of restoration approach for proposed riparian projects. It returns carbon stocks in biomass and soil for 5 or 10 year intervals, which in turn become inputs to Equations 1 and 4 of the Quantification Methodology. </p>
                                </div>
                                <div class="one-third right">
                                    <figure class="circle" style="background-image: url('/portfolio/creec/assets/media/images/about1.jpg');"></figure>
                                </div>
                            </section>
                            <section class="sec-def">
                                <div class="one-third left">
                                    <figure class="circle" style="background-image: url('/portfolio/creec/assets/media/images/about2.jpg'); margin-top: 15%;"></figure>
                                </div>
                                <div class="two-thirds right">
                                    <p class="paragraph">
                                        Carbon stocks in CREEC are modeled from statistical relationships between age and live tree biomass in a large database of riparian forest measurements in California. The database consists of 632 riparian forest plots in which all trees and woody shrubs above 2.5 cm diameter at breast height were measured and identified to species. These diameter measurements were converted to biomass using the Chojnacky allometric equations (Chojnacky et al. 2013), assigned on the basis of taxonomic grouping and/or wood density. To construct stock tables for 100-year predictions, the relationship between biomass and age was assumed to follow a Chapman-Richards growth function, and non-linear regression was used to estimate the parameters of this function for different species assemblages represented in the database. The tables produced by CREEC therefore represent expected values, not actual data. The carbon stocks in the tables are reported in Mg C/ha (metric tons of carbon per hectare), with biomass assumed to be 50% carbon.
                                    </p>
                                    <p class="paragraph">
                                        Other forest vegetation carbon pools (understory, forest floor, downed dead) are estimated from live tree biomass and/or from forest age according to standard methods used by the National Greenhouse Gas Inventory (Smith et al. 2013). Soil carbon accumulation is modeled as recovery from depletion to an expected mean value for the forest type, with the initial depletion dependent on previous land-use and on the degree of soil disturbance associated with site preparation.
                                    </p>
                                </div>
                            </section>
                            <section class="sec-def">
                                <div class="two-thirds left">
                                    <p class="paragraph">The web tool is not itself a model and does not perform the statistical calculations directly; instead, an algorithm matches user inputs to the most similar scenario in the CREEC database represented by a look-up table.</p>
                                    <p class="paragraph">
                                        CREEC was developed by Santa Clara University under contract #3015-304 from the California Department of Conservation to Virginia Matzek (principal investigator). Pearce Ropion designed the web interface. Thanks are due to all the researchers who generously shared data to parameterize CREEC, especially John Stella (SUNY-ESF), David Lewis (UC Cooperative Extension), and the late Dave Wood (CSU Chico). Questions about CREEC can be directed to Virginia Matzek at vmatzek@scu.edu.
                                    </p>
                                    <p class="small"><strong>Chojnacky</strong>, D.C., Heath, L.S. and Jenkins, J.C., 2013. Updated generalized biomass equations for North American tree species. <em>Forestry</em>, 87(1), pp.129-151.</p>
                                    <p class="small"><strong>Smith</strong>, J.E., Heath, L.S. and Hoover, C.M., 2013. Carbon factors and models for forest carbon estimates for the 2005–2011 National Greenhouse Gas Inventories of the United States. <em>Forest Ecology and Management</em>, 307, pp.7-19.</p>
                                </div>
                                <div class="one-third right">
                                    <figure class="circle" style="background-image: url('/portfolio/creec/assets/media/images/about3.jpg');"></figure>
                                </div>
                            </section>
                        </section>
                    </div>
                </div>
                <span class="clear"></span>
            </div>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/footer.php'); ?>
    </body>
</html>
