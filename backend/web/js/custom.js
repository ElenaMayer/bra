$(document).ready(function() {

    sizesForm($('#product-size'));

    $(document.body).on('click', '.image_remove', function () {
        removeImage($(this));
        return false;
    });

    $(document.body).on('click', '.add-item-link', function () {
        $('.add-item-link').addClass('hide');
        $('.add-item-form').removeClass('hide');
    });

    $(document.body).on('click', '.update_qty' ,function(){
        var qty = $(this).parent().children('input.cartitem_qty_value').val();
        var id = $(this).parent().children('input.cartitem_id').val();
        if(!$(this).hasClass('disable') && qty > 0){
            $(this).addClass('disable').prop('readonly', true);
            window.location.replace('/order/update_order_item?id=' + id + '&field=quantity&value=' + qty);
        }
    });

    $(document.body).on('click', '#product-size' ,function(){
        sizesForm($(this));
    });

    $(document.body).on('change', '#order-shipping_method' ,function(){
        $('.shipping_method_field').each(function(){
            $(this).hide();
        });
        method = $(this).children("option:selected").val();

        if(method == 'courier'){
            $('.method_courier').show();
        } else if(method == 'rp'){
            $('.method_rp').show();
        } else if(method == 'tk'){
            $('.method_tk').show();
        }
    });

});

function sizesForm(e) {
    if(e.is(':checked')){
        $('.size-and-count').show();
        $('.size-without-count').hide();
    } else {
        $('.size-and-count').hide();
        $('.size-without-count').show();
    }
}

function removeImage(e) {
    $.ajax({
        method: 'get',
        url: e.attr('href'),
        dataType: 'json',
    }).done(function( data ) {
        if(data) {
            e.parent('.product-image').remove();
        }
    });
}