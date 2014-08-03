WSC_calc = {

    currentSum: 0,

    init: function() {
        jQuery('.WSC_section').click(WSC_calc.showSectionContent);
        jQuery('.WSC_sectionCategoryTitle').click(WSC_calc.toggleCategoryServices);
        jQuery('.WSC_serviceCheck').click(WSC_calc.checkServiceHandler);
        jQuery('.WSC_serviceCount').bind('change, keyup', WSC_calc.checkService).bind('change, keyup', WSC_calc.checkServiceHandler);
    },

    showSectionContent: function() {
        sectionID = jQuery(this).attr('data-id');

        jQuery('.WSC_sectionContent').addClass('hidden');
        jQuery('#WSC_sectionContent_' + sectionID).removeClass('hidden');
    },

    checkServiceHandler: function() {

        WSC_calc.currentSum = 0;

        jQuery('.WSC_serviceCheck:checked').each(function() {
            cost = parseInt(jQuery(this).parent('.wrap_checkbox').children('.WSC_serviceCostValue').val());
            many = parseInt(jQuery(this).parent('.wrap_checkbox').children('.WSC_serviceManyValue').val());

            if(many) {
                count = jQuery(this).parent('.wrap_checkbox').parent('.WSC_service').children('.wrap_many').children('.WSC_serviceCount').val();
                WSC_calc.currentSum += cost * count;
            } else {
                WSC_calc.currentSum += cost;
            }
        });

        jQuery('#WSC_sum').html(WSC_calc.currentSum);

        WSC_calc.refreshOrderInfo();
    },

    checkService: function() {
        jQuery(this).parent('.wrap_many').parent('.WSC_service').children('.wrap_checkbox').children('.WSC_serviceCheck').attr('checked', 'checked');
    },

    toggleCategoryServices: function() {
        jQuery(this).parent('.WSC_sectionCategory').toggleClass('WSC_sectionCategory_active').children('.WSC_sectionCategoryServices').slideToggle(300);
    },

    refreshOrderInfo: function() {
        var orderDescription = 'Выбрано услуг на сумму ' + WSC_calc.currentSum + ' рублей: \n\n';

        jQuery('.WSC_sectionContent').each(function(){
            var sectionName = jQuery(this).attr('data-name');
            jQuery('.WSC_sectionCategory', this).each(function(){
                var categoryName = jQuery(this).attr('data-name');
                jQuery('.WSC_serviceCheck:checked', this).each(function(){
                    var service = jQuery(this).parents('.WSC_service');
                    var serviceName = jQuery(service).attr('data-name');
                    var serviceCost = jQuery(service).attr('data-cost');

                    var count = parseInt(jQuery('.WSC_serviceCount', service).val());
                    var cost;
                    if(count > 0) {
                        cost = serviceCost + ' руб/шт * ' + count + ' шт = ' + serviceCost * count + 'руб';
                    } else {
                        cost = serviceCost + ' руб'
                    }

                    orderDescription += sectionName + ' >> ' + categoryName + ' >> ' + serviceName + ' - ' + cost + '\n';
                });
            });
        });

        jQuery('#WSC_orderDescription').html(orderDescription);
    },

    sendOrderForm: function() {
        var name = jQuery('#WSC_orderName').val();
        var phone = jQuery('#WSC_orderPhone').val();
        var comment = jQuery('#WSC_orderComment').val();

        if(name.length == 0) {
            alert('Введите Ваше имя');
            return;
        }

        if(phone.length == 0) {
            alert('Введите номер телефона');
            return;
        }

        jQuery.post(
            '/wp-admin/admin-ajax.php',
            {
                action: 'createOrder',
                name: name,
                phone: phone,
                comment: comment,
                description: jQuery('#WSC_orderDescription').html()
            },
            function() {
                jQuery('#WSC_order').addClass('hidden').dialog('close');

                jQuery('#WSC_orderName').val('');
                jQuery('#WSC_orderPhone').val('');
                jQuery('#WSC_orderComment').val('');
                jQuery('#WSC_orderDescription').html('');

                jQuery('.WSC_serviceCheck').removeAttr('checked');

                WSC_calc.checkServiceHandler();

                alert('Заказ принят, с Вами свяжутся по указанному телефону.');
            },
            'text'
        );
    },


    showOrderForm: function() {
        if(jQuery('.WSC_serviceCheck:checked').length == 0) {
            alert('Выберите услуги для заказа!');
            return false;
        }

        jQuery('#WSC_order').removeClass('hidden').dialog({
            modal: true,
            movable: false,
            resizable: false,
            width: 800,
            title: 'Оформление заказа'
        });
    }
};

jQuery(document).ready(WSC_calc.init);