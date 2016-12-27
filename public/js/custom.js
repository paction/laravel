$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $('.remove-from-cart').on('click', function(e) {
        e.preventDefault();
        var data = {
            k:    $(this).data('k')
        };
        removeFromCart(data);
    });
});

function addToCart(data) {
    $.ajax({
        type: "POST",
        url: '/cart',
        data: data,
        success: function(r) {
            alert(r.msg + ' Total products in your cart: ' + r.counter);
        }
    })
};

function removeFromCart(data) {
    $.ajax({
        type: "DELETE",
        url: '/cart',
        data: data,
        success: function(r) {
            alert(r.msg);
            location.reload();
        }
    })
};