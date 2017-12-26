$(document).ready(function() {
    if ($('#carbon-form') != null) {
        var species = ["Acer negundo", "Acer (other)", "Alnus rhombifolia", "Alnus (other)", "Aesculus californica", "Baccharis pilularis", "Baccharis salicifiolia", "Cephalanthus occidentalis", "Fraxinus latifolia", "Garrya elliptica", "Heteromeles arbutifolia", "Juglans (sp)", "Laurus nobilis", "Myrica californica", "Physocarpus capitatus", "Platanus racemosa", "Populus fremontii", "Populus (other)", "Quercus lobata",
        "Quercus agrifolia", "Quercus (other)", "Rosa californica", "Rubus (sp)", "Salix exigua", "Salix gooddingii", "Salix laevigata", "Salix lasiolepis", "Salix lucida", "Salix (other)", "Sambucus (sp)", "Symphoricarpos albus", "Toxicodendron diversilobum", "Vitis californicus", "Other canopy tree", "Other understory woody shrub"];
        var maxSpecies = 20;
        $(document).on('click', '.btn-add-species', function() {
            var commID = parseInt($(this).attr('id').match(/\d+/));
            var speciesIDname = $(this).prev().attr('id');
            var speciesID = parseInt(speciesIDname.match(/\d+(?=[^\d]*$)/)) + 1;
            var type = '%';
            $(this).siblings('.species-type').children('label').each(function() {
                if ($(this).hasClass('ui-checkboxradio-checked')) {
                    type = $(this).next().val();
                }
            });
            if (speciesID <= maxSpecies) {
                if (speciesID == maxSpecies) {
                    $(this).toggleClass('c-button-disabled');
                }
                $('#'+speciesIDname+' a').remove();
                var newSpecies = $('<div>', {
                    id: 'comm-species'+commID+'-'+speciesID,
                    'class': 'comm-species'
                });
                var speciesList = $('<select>', {
                    id: 'species'+commID+'-'+speciesID,
                    name: 'species'+commID+'-'+speciesID
                });
                if (type == '%') {
                    var speciesPer = $('<input>', {
                        id: 'species'+commID+'-'+speciesID+'-type%',
                        name: 'species'+commID+'-'+speciesID+'-type%',
                        type: 'number',
                        'class': 'textbox species-num',
                        min: '0',
                        max: '100'
                    });
                } else {
                    var speciesPer = $('<input>', {
                        id: 'species'+commID+'-'+speciesID+'-type%',
                        name: 'species'+commID+'-'+speciesID+'-type%',
                        type: 'number',
                        'class': 'textbox species-num',
                        disabled: 'disabled',
                        min: '0',
                        max: '100'
                    });
                }
                var symbol = $('<span>', {
                    text: ' %'
                });
                if (type == '#') {
                    var speciesNum = $('<input>', {
                        id: 'species'+commID+'-'+speciesID+'-type#',
                        name: 'species'+commID+'-'+speciesID+'-type#',
                        type: 'number',
                        'class': 'textbox species-num',
                        min: '0'
                    });
                } else {
                    var speciesNum = $('<input>', {
                        id: 'species'+commID+'-'+speciesID+'-type#',
                        name: 'species'+commID+'-'+speciesID+'-type#',
                        type: 'number',
                        'class': 'textbox species-num',
                        disabled: 'disabled',
                        min: '0'
                    });
                }
                var remove = $('<a>', {
                    text: 'X',
                    'class': 'species-remove',
                    style: 'color: #cd0a0a;'
                });
                $(newSpecies).insertBefore(this)
                    .append(speciesList)
                    .append(speciesPer)
                    .append(symbol)
                    .append(speciesNum)
                    .append(remove);
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

            } else {
                alert('You can\'t add any more species types');
            }
        });
        $(document).on('click', '.species-remove', function() {
        var speciesIDname = $(this).parent().prev().attr('id');
        var speciesID = parseInt(speciesIDname.match(/\d+(?=[^\d]*$)/));
            var remove = $('<a>', {
                text: 'X',
                'class': 'species-remove',
                style: 'color: #cd0a0a;'
            });
            if ($(this).parent().parent().children(':last-child').hasClass('c-button-disabled')) {
                $(this).parent().parent().children(':last-child').toggleClass('c-button-disabled');
            }
            if (speciesID != 1) {
                $(this).parent().prev().append(remove);
            }
            $(this).parent().remove();
        });
    }
});
