define(['jquery', 'uiComponent', 'mage/translate'], function ($, Component, $tr) {

    var self;
    return Component.extend({
        initialize: function () {

            self = this;
            this._super();

            self.loadSpecialPrices()

            $(document).on('amshopby:ajax_filter_applied', function() {
                self.loadSpecialPrices();
            })
        },
        loadSpecialPrices: function () {
            $('*[data-role="priceBox"]').html('<span class="loading">' + $tr('Loading...') + '</span>');

            self.productIds = [];
            $('*[data-role="priceBox"]').each(function (index, priceBox) {
                self.productIds.push($(priceBox).data('product-id'));
            });

            $.ajax({
                url: self.url,
                data: { p: self.productIds },
                type: 'GET',
                success: function (result) {
                    $('*[data-role="priceBox"]').each(function (index, priceBox) {
                        $(priceBox).replaceWith(result.prices[$(priceBox).data('product-id')]);
                    });

                    $('.product-add-form').after(result.updater);
                    $('.product-info-main').trigger('contentUpdated');
                }
            })
        }
    });
});
