$(document).ready(function(){
    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();
        var data = {
            products_id:    $(this).data('id'),
            title:          $(this).data('title'),
            quantity:       $(this).data('quantity') ? $(this).data('quantity') : $('#quantity').val(),
            size:           $('#size').length ? $('#size').val() : '',
            color:          $('#color').length ? $('#color').val() : '',
        };
        addToCart(data);
    });
});


function addToCart(data) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: '/cart',
        data: data,
        success: function(r) {
            alert(r.msg + ' Total products in your cart: ' + r.counter);
        }
    })
};