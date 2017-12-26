var debug = true;
var numCommunities, numSpecies, commType;

$(document).ready(function() {

    // Initialize Variables

    var regens = ['Natural Regeneration', 'Planted Communities', 'Avoided Conversion'];
    var regions = ['Coast Ranges North/Central', 'Central Valley', 'Sierra Foothills (elev: < 3000 ft)', 'High Sierra (elev: > 3000 ft)', 'Southern California'];
    var sitepreps = ['Low / Non-mechanical', 'High / Mechanical'];
    var landuses = ['Crops', 'Grazing', 'Orchards', 'Degraded', 'Invaded'];

    // No Script Override
    $('.jscontent').css('display', 'block');

    //Debug Settings
    // $('.species-req').css('display', 'block');
    // $('#comm1-error').addClass('show-inline');

    $('.burger').click(function(e) {
        $('#navigation').toggleClass('open');
        $('.bar').toggleClass('bar-open');
    });

    // Check if form exists
    if ($('#carbon-form').length) {

        $('#estimator').children('a').addClass('scroll-link');
        $('#estimator').children('a').attr('href', '#');
        var creecBottom = $('#creec').outerHeight(true);
        $('#display-wrapper').css('margin-top', creecBottom+'px');

        $(document).on('click', '.scroll-link', function() {
    		$('html, body').animate({ scrollTop: $('#carbon-form').offset().top}, 1000);
            $('#navigation').toggleClass('open');
            $('.bar').toggleClass('bar-open');
        });
        $(document).on('click', '#down', function() {
    		$('html, body').animate({ scrollTop: $('#carbon-form').offset().top}, 1000);
        });
        $(document).scroll(function() {
            var y = $(this).scrollTop();
            if (y > creecBottom / 2) {
                $('#down').fadeOut();
            } else {
                $('#down').fadeIn();
            }
        });

        var regenList = ['Add Planting Community', 'Add Vegetation Survey'];
        var titleList = ['Planting Community ', 'Vegetation Survey '];
        var acreList = ['Planted Community Area (acres)', 'Vegetation Survey Area (acres)'];
        var percentList = ['Percentage', 'Percent Cover'];
        var unitList = ['# of Plants', '# of Stems'];
        var regenBtn, acreText, tileText;
        var globalValid = true;
        var bdErrorIDs = ['regen-error', 'region-error', 'sp-error', 'sc-error', 'lu-error'];
        var bdErrors = ['You must select a regeneration type', 'You must select a region', 'You must select a site preparation intensity', 'You must select a land use'];

        // Display Inputs based on Regeneration Type
        $(document).on('selectmenuclose', '#regen', function(event, ui) {
            var regenNum = $(this).val();
            var textSet = regenNum - 2;
            regenBtn = regenList[textSet];
            tileText = titleList[textSet];
            acreText = acreList[textSet];
            percentText = percentList[textSet];
            unitText = unitList[textSet];
            $('.bd-extras-req').removeAttr('style');
            if (regenNum > 0) {
                window.onbeforeunload = function () {
                    return 'Are you sure you want to leave the page?';
                };
            }
            if (regenNum == 2 || regenNum == 3) {
                $('.species-req').css('display', 'block');
            } else {
                $('.species-req').css('display', 'none');
            }
            if (regenNum == 2) {

            } else if (regenNum == 3) {
                $('.bd-extras-req').css('display', 'none');
            }
            $('.community').each(function() {
                $(this).children('.comm-section:first').children('label').html(acreText);
            });
            $('.comm-title').each(function(n) {
                $(this).html(tileText+(n+1));
            });
            $('.species-type').each(function(n) {
                $(this).children('label:first').html(percentText);
                $(this).children('label:last').html(unitText);
                if (regenNum == 3) {
                    $(this).controlgroup('widget').css('margin-left', '303px');
                } else if(regenNum == 2) {
                    $(this).controlgroup('widget').removeAttr('style');
                }

            });
            $('#addCommunity').html(regenBtn);
        });

        // Initiate JQuery UI Elements
        if (1) {
            $('.c-accordion').accordion({
                collapsible: true,
                heightStyle: 'content',
                autoHeight: false
            });
            $('.species-type').controlgroup();
            $('.species-type input').checkboxradio({
                icon: false
            });
            $('select').selectmenu();
            $('#basic-details select').each(function() { // Move basic detail select menus
                $(this).selectmenu('widget').addClass('bd-selectmenu');
            });
            $(document).tooltip();

            // Reset Form
            $('select').each(function() {
                $(this).val('0').prop('selected', true);
            });
            $('input[type=number]').each(function() {
                $(this).val('');
            });
            $('input[type=checkbox]').each(function() {
                $(this).prop('checked', false);
            });
            $('input[type=radio]:first').prop('checked', true);
        }


        // Disable inputs of unknown values
        $(document).on('change', '.bd-unknown input:checkbox', function() {
            if ($(this).is(':checked')) {
                $(this).parent().siblings('select').selectmenu('option', 'disabled', true);
                $(this).parent().siblings('select').selectmenu('refresh');
                if($(this).parent().siblings('select').selectmenu('widget').hasClass('bd-error-state')) {
                    $(this).parent().siblings('select').selectmenu('widget').removeClass('bd-error-state');
                    $(this).parent().siblings(':last').removeClass('show');
                }
            } else {
                $(this).parent().siblings('select').selectmenu('option', 'disabled', false);
                $(this).parent().siblings('select').selectmenu('refresh');
            }
        });

        // Disable Inputs based on type selection
        $(document).on('click', '.species-type label', function() {
            var type = $(this).attr('for').match(/.$/);
            var commIDname = $(this).parent().parent().parent().attr('id');
            var commID = parseInt(commIDname.match(/\d+/));
            if (type == '%') {
                $("input[name^='species"+commID+"']").filter("input[name$='#']").prop('disabled', true);
                $("input[name^='species"+commID+"']").filter("input[name$='%']").prop('disabled', false);
            } else if (type == '#' ) {
                $("input[name^='species"+commID+"']").filter("input[name$='%']").prop('disabled', true);
                $("input[name^='species"+commID+"']").filter("input[name$='#']").prop('disabled', false);
            }
        });

        //Disable submitting prematurely
        $(document).keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        //Disable non numeric input
        $(document).on('keypress', 'input[type=number]', function(e) {
            if (debug) console.log('Key Pressed: '+e.which);
            if ((e.which < 48 || e.which > 57) && e.which != 46) {
                e.preventDefault();
            }
            var input = $(this);
            setTimeout(function() {
                var value = parseInt(input.val());
                if (value == 0) {
                    input.addClass('bd-error-state');
                    globalValid = false;
                } else {
                    input.removeClass('bd-error-state');
                    globalValid = true;
                }
            }, 1500);
        });

        // Regen Error Validation
        $(document).on('selectmenuclose', '#regen', function(event, ui) {
            if ($('#regen :selected').val() == 0) {
                $('#regen').selectmenu('widget').addClass('bd-error-state');
                $('#regen-error').addClass('show');
                globalValid = false;
                if ($('#regen').selectmenu('widget').hasClass('bd-error-state')) {
                    $(document).on('selectmenuopen', '#regen', function(event, ui) {
                        $('#regen').selectmenu('widget').removeClass('bd-error-state');
                    });
                }
            } else {
                $('#regen-error').removeClass('show');
                $('#regen').selectmenu('widget').removeClass('bd-error-state');
                globalValid = true;
            }
        });

        // Region Error Validation
        $(document).on('selectmenuclose', '#region', function(event, ui) {
            if ($('#region :selected').val() == 0) {
                $('#region').selectmenu('widget').addClass('bd-error-state');
                $('#region-error').addClass('show');
                globalValid = false;
                if ($('#region').selectmenu('widget').hasClass('bd-error-state')) {
                    $(document).on('selectmenuopen', '#region', function(event, ui) {
                        $('#region').selectmenu('widget').removeClass('bd-error-state');
                    });
                }
            } else {
                $('#region-error').removeClass('show');
                $('#region').selectmenu('widget').removeClass('bd-error-state');
                globalValid = true;
            }
        });

        // Soil Prep Error Validation
        $(document).on('selectmenuclose', '#siteprep', function(event, ui) {
            if ($('#siteprep :selected').val() == 0) {
                $('#siteprep').selectmenu('widget').addClass('bd-error-state');
                $('#sp-error').addClass('show');
                globalValid = false;
                if ($('#siteprep').selectmenu('widget').hasClass('bd-error-state')) {
                    $(document).on('selectmenuopen', '#siteprep', function(event, ui) {
                        $('#siteprep').selectmenu('widget').removeClass('bd-error-state');
                    });
                }
            } else {
                $('#sp-error').removeClass('show');
                $('#siteprep').selectmenu('widget').removeClass('bd-error-state');
                globalValid = true;
            }
        });

        // Land Use Error Validation
        $(document).on('selectmenuclose', '#landuse', function(event, ui) {
            if ($('#landuse :selected').val() == 0) {
                $('#landuse').selectmenu('widget').addClass('bd-error-state');
                $('#lu-error').addClass('show');
                globalValid = false;
                if ($('#landuse').selectmenu('widget').hasClass('bd-error-state')) {
                    $(document).on('selectmenuopen', '#landuse', function(event, ui) {
                        $('#landuse').selectmenu('widget').removeClass('bd-error-state');
                    });
                }
            } else {
                $('#lu-error').removeClass('show');
                $('#landuse').selectmenu('widget').removeClass('bd-error-state');
                globalValid = true;
            }
        });

        // Reset error classes on click
        $(document).on('click', '.comm-title', function() {
            if ($(this).hasClass('ui-state-error')) {
                $(this).removeClass('ui-state-error');
            }
        });
        $(document).on('selectmenuopen', '.comm-species select', function() {
            if ($(this).selectmenu('widget').hasClass('ui-state-error')) {
                $(this).selectmenu('widget').removeClass('ui-state-error');
                $(this).parent().parent().parent().prev().removeClass('ui-state-error');
                $(this).parent().parent().children('.comm-species').children('select').each(function() {
                    if ($(this).selectmenu('widget').hasClass('ui-state-error')) {
                        $(this).selectmenu('widget').removeClass('ui-state-error');
                    }
                });
            }
        });
        $(document).on('click', '.comm-species input', function() {
            if ($(this).hasClass('ui-state-error')) {
                $(this).removeClass('ui-state-error');
                $(this).parent().parent().parent().prev().removeClass('ui-state-error');
            }
        });
        $(document).on('click', ".community input[name^='acreage']", function() {
            if ($(this).hasClass('ui-state-error')) {
                $(this).removeClass('ui-state-error');
                $(this).parent().parent().prev().removeClass('ui-state-error');
            }
        });

        // Disallow duplicates on input (passive)
        $(document).on('selectmenuclose', '.comm-species select', function() {
            var addedSpecies = [];
            var dupedSpecies = [];
            var commID = parseInt($(this).parent().parent().parent().attr('id').match(/\d+/));
            $('#comm'+commID+'-error').removeClass('show-inline');
            $('#comm'+commID+'-error').html('');
            $(this).parent().parent().children('.comm-species').children('select').each(function() {
                if ($(this).children('option:selected').val() != 0) {
                    addedSpecies.push($(this).children('option:selected').val());
                }
            });
            // Find duplicated species
            var sortAddedSpecies = addedSpecies.slice().sort();
            $(addedSpecies).each(function(z) {
                if (sortAddedSpecies[z + 1] == sortAddedSpecies[z]) {
                    dupedSpecies.push(sortAddedSpecies[z]);
                }
            });
            $(this).parent().parent().children('.comm-species').children('select').each(function() {
                for (var z = 0; z < dupedSpecies.length; z++) {
                    if ($(this).children('option:selected').val() == dupedSpecies[z]) {
                        $(this).selectmenu('widget').addClass('ui-state-error');
                        $('#comm'+commID+'-error').html('You cannot have any duplicate species.');
                        $('#comm'+commID+'-error').addClass('show-inline');
                        $(this).parent().parent().parent().prev().addClass('ui-state-error');
                        globalValidvalid = false;
                    }
                }
            });
        });

        // Submit button validation
        $(document).on('click', '#submit', function(e) {

            var valid = true, empty = false;
            numCommunities = 0;
            numSpecies = [];
            commType = [];
            var commError = -1;
            var regen = $('#regen :selected').val();

            if ($('input[type=number]').hasClass('ui-state-error')) {
                $('input[type=number]').removeClass('ui-state-error');
            }
            // Validate regeneration
            if (regen == 0) {
                $('#regen').selectmenu('widget').addClass('bd-error-state');
                $('#regen-error').addClass('show');
                valid = false;
            }
            // Validate location
            if ($('#region :selected').val() == 0) {
                $('#region').selectmenu('widget').addClass('bd-error-state');
                $('#region-error').addClass('show');
                valid = false;
            }
            // Validate siteprep and landuse
            if (regen != 3) {
                if ($('#siteprep :selected').val() == 0){
                    $('#siteprep').selectmenu('widget').addClass('bd-error-state');
                    $('#sp-error').addClass('show');
                    valid = false;
                }
                if ($('#landuse-x').is(':checked')) {
                    $('#lu-error').removeClass('show');
                    $('#landuse').selectmenu('widget').removeClass('bd-error-state');
                    valid = true;
                } else if ($('#landuse :selected').val() == 0){
                    $('#landuse').selectmenu('widget').addClass('bd-error-state');
                    $('#lu-error').addClass('show');
                    valid = false;
                }
            }
            // Check communities if needed
            if (regen == 2 || regen == 3) {
                $('.community').each(function(n) {
                    var addedSpecies = [];
                    var dupedSpecies = [];
                    numCommunities++;
                    numSpecies.push(0);
                    var commID = parseInt($(this).attr('id').match(/\d+/));
                    $('#comm'+commID+'-error').removeClass('show-inline');
                    var type = $(this).children('.comm-section:last').children('.species-type').children('input:checked').val();
                    commType[n] = type;
                    // Check acreage
                    if ($(this).children('.comm-section:first').children('#acreage'+commID).val() == ""|| parseInt($(this).children('#acreage'+commID).val()) == 0) {
                        valid = false;
                        $(this).children('.comm-section:first').children('#acreage'+commID).addClass('ui-state-error');
                        $(this).prev().addClass('ui-state-error');
                        // Set which community to show as the first error
                        if (commError == -1) {
                            commError = commID-1;
                        }
                    }
                    // Set total percentage
                    var total = 0;
                    // Iterate for each species added
                    $(this).children().children('.comm-species').each(function() {
                        if ($(this).children('select').selectmenu('widget').hasClass('ui-state-error')) {
                            $(this).children('select').selectmenu('widget').removeClass('ui-state-error');
                        }
                        // Add to species count
                        numSpecies[n]++;
                        // Check if species hasnt been added
                        if ($(this).children('select').children('option:selected').val() == 0) {
                            $(this).children('select').selectmenu('widget').addClass('ui-state-error');
                            $('#comm'+commID+'-error').html('You cannot have any empty species. You can remove species with the red <strong style="color: #CD0A0A;">X</strong>');
                            $('#comm'+commID+'-error').addClass('show-inline');
                            $(this).parent().parent().prev().addClass('ui-state-error');
                            valid = false;
                            empty = true;
                            // Remove this species
                            numSpecies[n]--;
                        // Check if species hasnt been added
                        } else if ($(this).children('select').children('option:selected').val() != 0){
                            // Compile list of added species
                            addedSpecies.push($(this).children('select').children('option:selected').val());
                            // Check if % or # has been added per species
                            if ($(this).children("input[name$='"+type+"']").val() == '' || parseInt($(this).children("input[name$='"+type+"']").val()) == 0) {
                                valid=false;
                                $(this).children("input[name$='"+type+"']").addClass('ui-state-error');
                                $(this).parent().parent().prev().addClass('ui-state-error');
                                $('#comm'+commID+'-error').html('You cannot have empty species values');
                                $('#comm'+commID+'-error').addClass('show-inline');
                                // Set which community to show as the first error
                                if (commError == -1) {
                                    commError = commID;
                                }
                            }
                            // Update total percentage
                            if (type == '%') {
                                total += parseInt($(this).children("input[name$='"+type+"']").val());
                            }
                        }
                    });
                    // Find duplicate species
                    if (!empty && valid) {
                        var sortAddedSpecies = addedSpecies.slice().sort();
                        $(addedSpecies).each(function(z) {
                            if (sortAddedSpecies[z + 1] == sortAddedSpecies[z]) {
                                dupedSpecies.push(sortAddedSpecies[z]);
                            }
                        });
                        // Show errors for each duplicate species
                        $(this).children().children('.comm-species').each(function() {
                            for (var z = 0; z < dupedSpecies.length; z++) {
                                if ($(this).children('select').children('option:selected').val() == dupedSpecies[z]) {
                                    $(this).children('select').selectmenu('widget').addClass('ui-state-error');
                                    $('#comm'+commID+'-error').html('You cannot have any duplicate species.');
                                    $('#comm'+commID+'-error').addClass('show-inline');
                                    $(this).parent().parent().prev().addClass('ui-state-error');
                                    valid = false;
                                }
                            }
                        });
                    }
                    // Show percentage error with some leeway
                    if ($("input[name$='"+type+"']").val() != '' && dupedSpecies.length == 0 && type == '%' && valid) {
                        if (total <= 99 || total >= 101) {
                            $('#comm'+commID+'-error').html('Your percentages must add up to 100%. <span style="color: #CD0A0A;">Current: '+total+'<span>');
                            $('#comm'+commID+'-error').addClass('show-inline');
                            $(this).prev().addClass('ui-state-error');
                            valid = false;
                        }
                    }
                    // Add species count to hidden value for PHP use
                    $(this).children(':last').children('input[type=hidden]').val(numSpecies[n]);
                    if (debug) console.log('Community '+commID+' Species Count: '+numSpecies[n]);
                });
                // Refresh community accordion with active errors
                $("#communities").accordion('refresh');
                $("#communities").accordion('option', 'active', commError);
                if (debug) console.log('Communities: '+numCommunities);
            }
            if (valid && globalValid) {
                // Override onbeforeunload function
                window.onbeforeunload = function () {}
                // Add community count to hidden value for PHP use
                $('input[name=carbon-form-comms]').val(numCommunities);
                $('#carbon-form').submit();
            } else {
                e.preventDefault();
            }
        });
    }
    if ($('#stock').length) {

        $(window).bind('beforeunload', function() {
            return 'Are you sure you want to leave this page?';
        });

        $('.c-accordion').accordion({
            collapsible: true,
            heightStyle: 'content',
            autoHeight: false
        });
        $('.download').selectmenu();
        $('.download').selectmenu('widget').addClass('borders');

        $('#stock-details').children('table').children('tbody').children('tr:last').addClass('last-row');
        $('.stock-panel').children('table').children('tbody').children('tr:last').addClass('last-row');

        $(document).on('selectmenuclose', '.download', function() {
            var stockIDname = $(this).parent().parent().attr('id');
            var stockID = parseInt(stockIDname.match(/\d+/));
            var value = $(this).children('option:selected').val();
            if (value == 1) {
                $('#stocktable-'+stockID).tableExport({
                    type:'xlsx',
                    fileName: 'Carbon Estimate'+stockID
                });
            } else if (value == 2) {
                $('#stocktable-'+stockID).tableExport({
                    type:'pdf',
                    fileName: 'Carbon Estimate '+stockID,
                    escape: false,
                    jspdf: {
                        orientation: 'l',
                        format: 'a4',
                        margins: {
                            left:10,
                            right:10,
                            top:20,
                            bottom:20
                        },
                        autotable: {
                            tableWidth: 'auto'
                        }
                    }
                });
            } else if (value == 3) {
                $('#stocktable-'+stockID).tableExport({
                    type:'png',
                    fileName: 'Carbon Estimate '+stockID
                });
            } else if (value != 0){
                alert('Unknown File Type!');
            }
        });
        $(document).on('click', '.print', function() {
            var stockIDname = $(this).parent().parent().attr('id');
            var stockID = parseInt(stockIDname.match(/\d+/));
            printJS({
                printable: 'stocktable-'+stockID,
                type: 'html',
                honorMarginPadding: false
            });
        });
    }
    if ($('#about').length) {
        var width;
        $('.circle').each(function() {
            width = $(this).width();
            $(this).height(width);
        });
        $(window).on('resize', function() {
            var width;
            $('.circle').each(function() {
                width = $(this).width();
                $(this).height(width);
            });
        });
    }
    if ($('#contact').length) {
        var submitted = false;
        var messages = ['You must enter your name.', 'You must enter your email address.', 'You must enter a valid email address.', 'You must enter a message.'];
        $(document).on('click, focus', 'input[type!=submit]', function() {
            $(this).siblings().each(function() {
                $(this).removeClass('active');
            });
            if ($(this).siblings('textarea').val() == '') {
                $(this).siblings('textarea').css('height', '40px');
            }
            $(this).addClass('active');
        });
        $(document).on('input', 'input[type!=submit]', function() {
            if (submitted) {
                if ($(this).attr('placeholder') == 'Name') {
                    var error, old = $('.error-display').html();
                    error = old.replace(messages[0]+'<br>', '');
                    $('.error-display').html(error);
                }
                if ($(this).attr('placeholder') == 'Email') {
                    var error, old = $('.error-display').html();
                    if (checkEmail($(this).val())) {
                        error = old.replace(messages[2]+'<br>', '');
                    } else {
                        error = old.replace(messages[1]+'<br>', '');
                    }
                    $('.error-display').html(error);
                }
                if ($('.error-display').html() == '') {
                    $('.contact-error-box p').fadeOut();
                }
            }
        });
        $(document).on('input', 'textarea', function() {
            if (submitted) {
                var error, old = $('.error-display').html();
                error = old.replace(messages[3]+'<br>', '');
                $('.error-display').html(error);
                if ($('.error-display').html() == '') {
                    $('.contact-error-box p').fadeOut();
                }
            }
        });
        $(document).on('click, focus', 'textarea', function() {
            $(this).siblings().each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            $(this).css('height', '200px');
        });
        $(document).on('click, focus', 'input[type!=submit], textarea', function() {
            if ($(this).hasClass('contact-error')) {
                $(this).removeClass('contact-error');
            }
        });
        if ($('#notice').length) {
            setTimeout(function() {
                $('#notice').fadeOut();
            }, 4000);
        }
        $(document).on('click', 'input[type=submit]', function(e) {
            var valid = true;
            var errors = [];
            submitted = true;
            $(this).siblings().each(function() {
                if ($(this).hasClass('contact-error')) {
                    $(this).removeClass('contact-error');
                }
            });
            var name = $(this).siblings('input:first-child').val();
            var email = $(this).siblings('input:nth-child(2)').val();
            var message = $(this).siblings('textarea').val();
            if (name == '') {
                valid = false;
                $(this).siblings('input:first-child').addClass('contact-error');
                errors.push(messages[0]);
            }
            if (email == '') {
                valid = false;
                $(this).siblings('input:nth-child(2)').addClass('contact-error');
                errors.push(messages[1]);
            } else if (!checkEmail(email)) {
                valid = false;
                $(this).siblings('input:nth-child(2)').addClass('contact-error');
                errors.push(messages[2]);
            }
            if (message == '') {
                valid = false;
                $(this).siblings('textarea').addClass('contact-error');
                errors.push(messages[3]);
            }
            if (valid) {
                $('#contact-form').submit();
            } else {
                e.preventDefault();
                var error = errors.join('<br />');
                $('.error-display').html(error+'<br />');
                $('.contact-error-box p').fadeIn();
            }
        });
    }
    if ($('#notice').length) {
        $(document).on('click', '#notice .n-dismiss', function() {
            $(this).parent().fadeOut();
        });
    }
});
function checkEmail(email) {
    var reg = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
    return reg.test(email);
}
