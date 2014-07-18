WSC_calc = {

    currentSum: 0,

    init: function() {
        jQuery('.WSC_section').click(WSC_calc.showSectionContent);
        jQuery('.WSC_sectionCategoryTitle').click(WSC_calc.toggleCategoryServices);
        jQuery('.WSC_serviceCheck').click(WSC_calc.checkServiceHandler);
        jQuery('.WSC_serviceCount').bind('change, keyup', WSC_calc.checkService);
        jQuery('.WSC_serviceCount').bind('change, keyup', WSC_calc.checkServiceHandler);
    },

    showSectionContent: function() {
        sectionID = jQuery(this).attr('data-id');

        jQuery('.WSC_sectionContent').addClass('hidden');
        jQuery('#WSC_sectionContent_' + sectionID).removeClass('hidden');
    },

    checkServiceHandler: function() {

        WSC_calc.currentSum = 0;

        jQuery('.WSC_serviceCheck:checked').each(function() {
            cost = parseInt(jQuery(this).parent('.WSC_service').children('.WSC_serviceCostValue').val());
            many = parseInt(jQuery(this).parent('.WSC_service').children('.WSC_serviceManyValue').val());

            if(many) {
                count = jQuery(this).parent('.WSC_service').children('.WSC_serviceCount').val();
                WSC_calc.currentSum += cost * count;
            } else {
                WSC_calc.currentSum += cost;
            }
        });

        jQuery('#WSC_sum').html(WSC_calc.currentSum);
    },

    checkService: function() {
        jQuery(this).parent('.WSC_service').children('.WSC_serviceCheck').attr('checked', 'checked');
    },

    toggleCategoryServices: function() {
        jQuery(this).parent('.WSC_sectionCategory').children('.WSC_sectionCategoryServices').slideToggle(300);
    },

    binds: function() {

    }
};

jQuery(document).ready(WSC_calc.init);