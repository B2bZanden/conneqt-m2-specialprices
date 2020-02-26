define(['jquery', 'uiComponent', 'mage/translate'], function ($, Component, $tr) {

    var self;
    return Component.extend({
        initialize: function () {
            $('*[data-role="priceBox"]').html('<span>' + $tr('Loading...') + '</span>');

            self = this;
            this._super();

            self.productIds = [];
            $('*[data-role="priceBox"]').each(function (index, priceBox) {
                self.productIds.push($(priceBox).data('product-id'));
            });

            $.ajax({
                url: self.url,
                data: { p: self.productIds },
                type: 'POST',
                success: function (result) {
                    $('*[data-role="priceBox"]').each(function (index, priceBox) {
                         $(priceBox).replaceWith(result.prices[$(priceBox).data('product-id')]);
                    });
                }
            })
        },
    });
});
