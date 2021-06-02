const selectedColor = 'bg-success';

$("#datepickerFrom").datepicker({});
$("#datepickerTo").datepicker({});

$('#datepickerFrom').on("change", function () {
    let date = $('#datepickerFrom').val();
    if (date !== $('#origFromDate').val()) {
        let orderClass = $(".activeLink")[0].id;
        let urlFromDate = date.replaceAll('/', '-');
        let urlToDate = $('#datepickerTo').val().replaceAll('/', '-');
        window.location.href = window.location.origin + '/orders/get/' + orderClass + '/false/' + urlFromDate + '/' + urlToDate;
    }
});

$('#datepickerTo').on("change", function () {
    let date = $('#datepickerTo').val();
    if (date !== $('#origToDate').val()) {
        let orderClass = $(".activeLink")[0].id;
        let urlFromDate = $('#datepickerFrom').val().replaceAll('/', '-');
        let urlToDate = date.replaceAll('/', '-');
        window.location.href = window.location.origin + '/orders/get/' + orderClass + '/false/' + urlFromDate + '/' + urlToDate;
    }
});

$( "#search" ).keyup(function(e) {
    if (e.key === "Enter") search();
});

$(document).on("click", "#magnifyingGlass", function () {
    search();
});

function search()
{
    let params = $('#search').val();
    params = params.replace(/[,;]/g, ' ');
    params = params.trim();
    params = params.replace(/\s{2,}/g, ' ');
    if (params.length) {
        let orderClass = $(".activeLink")[0].id;
        params = encodeURIComponent(params);
        window.location.href = window.location.origin + '/orders/search/' + orderClass + '/' + params;
    }
}

$('#selectStore').on("change", function () {
    let orderClass = $(".activeLink")[0].id;
    let urlFromDate = $('#datepickerFrom').val().replaceAll('/', '-');
    let urlToDate = $('#datepickerTo').val().replaceAll('/', '-');
    let storefront = $('#selectStore').val();
    window.location.href = window.location.origin + '/orders/get/' + orderClass + '/false/' + urlFromDate + '/' + urlToDate + '/' + storefront;
});

$('.markSelected').on("click", function () {
    if ($(this).hasClass(selectedColor))
        $(this).removeClass('text-light ' + selectedColor);
    else
        $(this).addClass('text-light ' + selectedColor);

    let uid = $(this).data("uid");

    let orderNum = $('div[data-uid="' + uid + '"][data-field="on"]').text().trim();

    let allFields = $('.ms_' + uid);
    let selectedFields = Array();

    allFields.each(function (e, val) {
        if ($(val).hasClass(selectedColor)) selectedFields.push($(val).data("field"));
    });

    let fields = selectedFields.join('-');

    $.ajax({
        url: "/orders/selectFields",
        method: 'post',
        data: {orderNum: orderNum, fields: fields},
        dataType: 'json'
    });
});

$('.selectToggle').change(function () {
    if ($(this).prop('checked'))
        $('.selectOrder').prop('checked', true);
    else
        $('.selectOrder').prop('checked', false);
});

$('.collapsable').on('show.bs.collapse', function () {
    let id = $(this).attr('data-uid');
    $('#downArrow_' + id).css('display', 'none');
    $('#upArrow_' + id).css('display', 'inline-block');
});

$('#reset').on('click', function () {
    let orderClass = $(".activeLink")[0].id;
    window.location.href = window.location.origin + '/orders/get/' + orderClass + '/' + 'true';
});

$('#submit').on('click', function () {
    let orderClass = $('input[name=orderClass]:checked').val();
    let selectedOrderEls = $('.selectOrder:checkbox:checked');
    let selectedOrders = Array();

    if (selectedOrderEls[0]) {
        selectedOrderEls.each(function (e, val) {
            let arr = val.id.split('_');
            selectedOrders.push(arr[1]);
        });

        $.ajax({
            url: "/orders/changeOrderStatus",
            method: 'post',
            data: {orderClass: orderClass, selectedOrders: selectedOrders},
            dataType: 'json',
            success: function (res) {
                selectedOrderEls.each(function (e, val) {
                    $(val).prop('checked', false);
                    let arr = val.id.split('_');
                    let id = arr[1];
                    $('.order_' + id).css('display', 'none');
                });
            }
        });
    }
});