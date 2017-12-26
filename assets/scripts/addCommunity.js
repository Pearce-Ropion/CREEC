var maxCommunities = 4;
var maxSpecies = 20;
var defSpecies = 5;
$(document).ready(function() {
    if ($('#carbon-form') != null) {
        var species = ["Acer negundo", "Acer (other)", "Alnus rhombifolia", "Alnus (other)", "Aesculus californica", "Baccharis pilularis", "Baccharis salicifiolia", "Cephalanthus occidentalis", "Fraxinus latifolia", "Garrya elliptica", "Heteromeles arbutifolia", "Juglans (sp)", "Laurus nobilis", "Myrica californica", "Physocarpus capitatus", "Platanus racemosa", "Populus fremontii", "Populus (other)", "Quercus lobata",
        "Quercus agrifolia", "Quercus (other)", "Rosa californica", "Rubus (sp)", "Salix exigua", "Salix gooddingii", "Salix laevigata", "Salix lasiolepis", "Salix lucida", "Salix (other)", "Sambucus (sp)", "Symphoricarpos albus", "Toxicodendron diversilobum", "Vitis californicus", "Other canopy tree", "Other understory woody shrub"];
        var regenList = ['Add Planting Community', 'Add Vegetation Survey'];
        var titleList = ['Planting Community ', 'Vegetation Survey '];
        var acreList = ['Planted Community Area (acres)', 'Vegetation Survey Area (acres)'];
        var percentList = ['Percentage', 'Percent Cover'];
        var unitList = ['# of Plants', '# of Stems'];
        var cgStyleList = ['', '303px'];
        var regenBtn, acreText, tileText, percentText, unitText, cgStyleVal;
        $('#addCommunity').click(function(e) {
            e.preventDefault();
            var commIDname = $('div.community:last').attr('id');
            var commID = parseInt(commIDname.match(/\d+/)) + 1;
            var regenNum = $('#regen :selected').val();
            var textSet = regenNum - 2;
            titleText = titleList[textSet];
            acreText = acreList[textSet];
            percentText = percentList[textSet];
            unitText = unitList[textSet];
            cgStyleVal = cgStyleList[textSet];
            if (commID <= maxCommunities) {
                if (commID == maxCommunities) {
                    $(this).toggleClass('c-button-disabled');
                }
                $('#'+commIDname+' a.comm-remove').remove();
                var commTitle = $('<h3>', {
                    'class': 'comm-title',
                    text: titleText+commID
                });
                var newComm = $('<div>', {
                    id: 'community'+commID,
                    'class': 'community'
                });
                var remove = $('<a>', {
                    text: 'REMOVE',
                    'class': 'comm-remove',
                    style: 'color: #cd0a0a;'
                });
                var commSection1 = $('<div>', {
                    'class': 'comm-section'
                });
                var label1 = $('<label>', {
                    for: 'acreage'+commID,
                    text: acreText
                });
                var input1 = $('<input>', {
                    id: 'acreage'+commID,
                    name: 'acreage[]',
                    type: 'number',
                    pattern: '/\d+/',
                    min: '0.1',
                    step: '0.1',
                    title: 'Enter the acreage of your planting community'
                });
                var warning = $('<p>', {
                    'class': 'species-warning',
                    text: 'Please enter woody species only'
                });
                var speciestype = $('<div>', {
                    'class': 'species-type',
                    style: 'margin-left: '+cgStyleVal+';'
                });
                var label2 = $('<label>', {
                    for: 'species'+commID+'-type%',
                    text: percentText
                });
                var input2 = $('<input>', {
                    id: 'species'+commID+'-type%',
                    name: 'species'+commID+'-type',
                    type: 'radio',
                    value: '%',
                    checked: 'checked'
                });
                var label3 = $('<label>', {
                    for: 'species'+commID+'-type#',
                    text: unitText
                });
                var input3 = $('<input>', {
                    id: 'species'+commID+'-type#',
                    name: 'species'+commID+'-type',
                    type: 'radio',
                    value: '#'
                });
                var spacer = '<div class="comm-spacer"></div>';
                var speciesList = $('<div>', {
                    id: 'comm-species'+commID,
                    'class': 'comm-section'
                });
                var submit = $('<input>', {
                    id: 'addSpecies'+commID,
                    name: 'addspecies'+commID,
                    type: 'button',
                    value: 'Add Species',
                    'class': 'c-button ui-button btn-add-species'
                });
                var error = $('<span>', {
                    id: 'comm'+commID+'-error',
                    'class': 'comm-error'
                });
                var count = $('<input>', {
                    name: 'species'+commID+'-count',
                    value: 5,
                    type: 'hidden'
                });
                $('#communities').append(commTitle);
                $('#communities').append(newComm);
                $(remove).appendTo('#community'+commID);
                $(commSection1)
                    .appendTo('#community'+commID)
                    .append(label1)
                    .append(input1);
                $('#community'+commID).append(spacer);
                $(warning).appendTo('#community'+commID);
                $('#community'+commID).append(speciesList);
                $(speciestype)
                    .appendTo('#comm-species'+commID)
                    .append(label2)
                    .append(input2)
                    .append(label3)
                    .append(input3);
                for (var i = 1; i <= defSpecies; i++) {
                    addSpecies(i, commID, $('#comm-species'+commID));
                }
                $('#comm-species'+commID)
                    .append(submit)
                    .append(error)
                    .append(count);
                $("#communities").accordion('refresh');
                $("#communities").accordion('option', 'active', -1);
                $('.species-type').controlgroup();
                $('.species-type input').checkboxradio({
                    icon: false
                });

            }
        });
        $(document).on('click', '.comm-remove', function() {
            var commIDname = $('div.community:nth-last-of-type(2)').attr('id');
            var commID = parseInt(commIDname.match(/\d+/));
            var remove = $('<a>', {
                text: 'REMOVE',
                'class': 'comm-remove',
                style: 'color: #cd0a0a;'
            });
            if (commID != 1) {
                $(this).parent().prev().prev().prepend(remove);
            }
            if ($('#addCommunity').hasClass('c-button-disabled')) {
                $('#addCommunity').toggleClass('c-button-disabled');
            }
            $(this).parent().prev().remove();
            $(this).parent().remove()
            $("#communities").accordion('refresh');
            $("#communities").accordion('option', 'active', -1);
        });
    }
});

function addSpecies(speciesID, commID, location) {
    var species = ["Acer negundo", "Acer (other)", "Alnus rhombifolia", "Alnus (other)", "Aesculus californica", "Baccharis pilularis", "Baccharis salicifiolia", "Cephalanthus occidentalis", "Fraxinus latifolia", "Juglans (sp)", "Laurus nobilis", "Physocarpus capitatus", "Platanus racemosa", "Populus fremontii", "Populus (other)", "Quercus lobata", "Quercus agrifolia", "Quercus (other)", "Rosa californica", "Rubus (sp)", "Salix exigua", "Salix gooddingii", "Salix laevigata",
    "Salix lasiolepis", "Salix lucida", "Salix (other)", "Sambucus mexicana", "Sambucus nigra", "Symphoricarpos albus", "Toxicodendron diversilobum", "Vitis californicus", "Other canopy tree", "Other understory woody shrub"];
    var newSpecies = $('<div>', {
        id: 'comm-species'+commID+'-'+speciesID,
        'class': 'comm-species'
    });
    var speciesList = $('<select>', {
        id: 'species'+commID+'-'+speciesID,
        name: 'species'+commID+'-'+speciesID
    });
    var speciesPer = $('<input>', {
        id: 'species'+commID+'-'+speciesID+'-type%',
        name: 'species'+commID+'-'+speciesID+'-type%',
        type: 'number',
        'class': 'textbox species-num',
        min: '0',
        max: '100'
    });
    var symbol = $('<span>', {
        text: ' %'
    });
    var speciesNum = $('<input>', {
        id: 'species'+commID+'-'+speciesID+'-type#',
        name: 'species'+commID+'-'+speciesID+'-type#',
        type: 'number',
        'class': 'textbox species-num',
        disabled: 'disabled',
        min: '0'
    });
    var remove = $('<a>', {
        text: 'X',
        'class': 'species-remove',
        style: 'color: #cd0a0a;'
    });
    if (speciesID != defSpecies) {
        $(newSpecies)
            .appendTo(location)
            .append(speciesList)
            .append(speciesPer)
            .append(symbol)
            .append(speciesNum);
    } else {
        $(newSpecies)
            .appendTo(location)
            .append(speciesList)
            .append(speciesPer)
            .append(symbol)
            .append(speciesNum)
            .append(remove);
    }
    $('#species'+commID+'-'+speciesID).append($('<option>', {
        value: 0,
        disabled: 'disabled',
        selected: 'selected',
        text: 'Species '+speciesID
    }));
    $.each(species, function(index, value) {
        $('#species'+commID+'-'+speciesID).append($('<option>', {
            value: index+1,
            text: value
        }));
    });
    $('#species'+commID+'-'+speciesID).selectmenu();
}
