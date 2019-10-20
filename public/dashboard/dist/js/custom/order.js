$(document).ready(function () {

    /*
    * add product btn
    * */
    $('.add-product-btn').click(function (e) {

        e.preventDefault();

        let name = $(this).data('name');
        let id = $(this).data('id');
        let price = accounting.formatNumber( $(this).data('price'), 2);

        $(this).removeClass('btn-success').addClass('btn-default disabled');

        let html =
            `<tr>
                <td>${name}</td>
                <input type="hidden" name="products_ids[]" value="${id}">
                <td> <input type="number" data-price="${price}" name="quantities[]" min="1" value="1" class="form-control input-sm product-quantity"> </td>
                <td>${price}</td>
                <td class="product-price">${price}</td>
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"> <i class="fa fa-trash"></i> </button> </td>
            </tr>`;

        $('.order-list').append(html)

        // to calculate total price
        calculateTotal();



    }); //end of product btn

    //change product quantity
    $('body').on('keyup change', '.product-quantity', function () {

        let quantity = parseInt( $(this).val() );
        let unitPrice = parseFloat( $(this).data('price').replace(/,/g,'') );

        let totalPrice =  accounting.formatNumber(unitPrice * quantity, 2) ;

         $(this).closest('tr').find('.product-price').html(totalPrice);

         calculateTotal();

    });//end of product quantity

    // remover product btn
    $('body').on('click', '.remove-product-btn', function () {

        let id = $(this).data('id');

        $('#product-'+id).removeClass('btn-default disabled').addClass('btn-success');

        $(this).closest('tr').remove();

        // to calculate total price
        calculateTotal();

    });//end of remove product btn

    // prevent default
    $('body').on('click', '.disabled', function (e) {
        e.preventDefault();
    });


    // show order products with ajax
    $('.order-products').click(function (e) {

        e.preventDefault();

        let url = $(this).data('url');
        let method = $(this).data('method');

        $('.btn-default').removeClass('btn-default').addClass('btn-primary');

        $(this).removeClass('btn-primary').addClass('btn-default');

        $.ajax({

            url: url,
            method: method,
            success: function (data) {
                $('#order-product-list').empty();
                $('#order-product-list').append(data);
            }

        });

    });//end show order products with ajax

    //print order
    $(document).on('click', '.print-btn', function () {
        $('#print-area').printThis();
    });


});//end of document ready

// calculate
function calculateTotal() {

    let price = 0;

    $('.order-list .product-price').each(function (index) {

        price += parseFloat($(this).html().replace(/,/g,''));

    });//end product price

    $('.total-price').html( accounting.formatNumber(price, 2, ".", ",") );


    //check if price > 0

    if (price > 0)
    {
        $('#add-order-form-btn').removeClass('disabled');
    } else {
        $('#add-order-form-btn').addClass('disabled');
    }

}//end of calculate total












