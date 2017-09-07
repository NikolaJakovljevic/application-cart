@extends('frontend.layouts.app')

@section('content')
    <div class="container-fluid tables-background">
        <div class="row">
            <div class="col-md-12">
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Dashboard</div>--}}
                    <div class="container-fluid">
                        <div class="panel-body">
                            <div class="row">
                                <?php  $total = []; ?>
                                @foreach($tables as $table)
                                    @if($table->order != null)
                                        @foreach($table->order->products as $item)
                                            <?php $total[] = $item->quantity()->where('order_id', $table->order->id)->first()->product_quantity * $item->price; ?>
                                        @endforeach

                                        <div id="table-{{ $table->id }}" class="table-bench col-md-2 col-sm-12 {{ $table->order->waiter->id !== Auth::user()->id ? 'table-disabled' : 'self-table' }}" data-id="{{ $table->id }}" >
                                            @if($table->order->discount_id != null)
                                                <div style="border: 2px solid {{ $table->order->waiter->color }};">
                                                    <p>{{ $table->number }} {{ $table->order->waiter->name }}</p>
                                                    <span class="table-price">{{ number_format(array_sum($total) - array_sum($total) * $table->order->discount->value, 2, ',', '.')  }}</span>  RSD
                                                </div>
                                            @else
                                                <div style="border: 2px solid {{ $table->order->waiter->color }};">
                                                    <p>{{ $table->number }} {{ $table->order->waiter->name }}</p>
                                                    <span class="table-price">{{ number_format(array_sum($total), 2, ',', '.') }}</span>  RSD
                                                </div>
                                            @endif
                                        </div>
                                        <?php $total = []; ?>
                                    @else
                                        <div id="table-{{ $table->id }}" class="table-bench table-free col-md-2 col-sm-12" data-id="{{ $table->id }}" >
                                            <div>{{ $table->number }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                {{--</div>--}}
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="col-md-6">
                <div class="footer-menu-button col-md-3">
                    <p>Pregled kase</p>
                </div>
                <div class="footer-menu-button col-md-3">
                    <p>Računi konabara</p>
                </div>
                <div class="footer-menu-button col-md-3">
                    <p>Transfer zaduženja</p>
                </div>
                <div class="footer-menu-button col-md-3">
                    <p>Računi za fakturisanje</p>
                </div>
                <div class="footer-menu-button col-md-3">
                    <p>Ostalo poslovanje</p>
                </div>
            </div>

            <div class="date-time col-md-2">
                <p>Radni dan</p>
                <p id="current-date-time"></p>
                <p> Korisnik: </p>
                <p> {{ Auth::user()->name }} </p>
            </div>

            <div class="col-md-4">
                <div class="footer-menu-button col-md-push-4 col-md-4">
                    <p>Brza porudžbina</p>
                </div>
                <div class="col-md-4 col-md-push-4 footer-log-out">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                    <a href=""
                       onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                        <p>Nazad</p>
                    </a>
                </div>
            </div>

        </div>
    </footer>

    {{-- Div for iziModal--}}
    <div id="moda-wrapper">
        <div id="modal">
            <div class="iziModal-content">

            </div>
        </div>
    </div>
    {{--Div for iziModal END--}}

    {{-- Div for iziModal--}}
    <div id="moda-wrapper">
        <div id="oreder-items-modal">
            <div class="iziModal-content">

            </div>
        </div>
    </div>
    {{--Div for iziModal END--}}

    {{-- Div for iziModal--}}
    <div id="moda-wrapper">
        <div id="oreder-discount-modal">
            <div class="iziModal-content">

            </div>
        </div>
    </div>
    {{--Div for iziModal END--}}

    {{-- Div for iziModal--}}
    <div id="moda-wrapper">
        <div id="cancellation-items">
            <div class="iziModal-content">

            </div>
        </div>
    </div>
    {{--Div for iziModal END--}}

    {{-- Div for iziModal--}}
    <div id="moda-wrapper">
        <div id="cash-modal">
            <div class="iziModal-content">

            </div>
        </div>
    </div>
    {{--Div for iziModal END--}}

    {{-- Div for iziModal--}}
    <div id="moda-wrapper">
        <div id="repeat-order-modal">
            <div class="iziModal-content">

            </div>
        </div>
    </div>
    {{--Div for iziModal END--}}
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            setInterval(function () {
                var dt = new Date();
                var date = dt.getDate() < 10 ? "0"+dt.getDate() : dt.getDate();
                var month = dt.getMonth() < 10 ? parseInt(dt.getMonth()) + parseInt(1) : dt.getMonth();
                var hours = dt.getHours() < 10 ? "0"+dt.getHours() : dt.getHours();
                var minutes = dt.getMinutes() < 10 ? "0"+dt.getMinutes() : dt.getMinutes();
                var seconds = dt.getSeconds() < 10 ? "0"+dt.getSeconds() : dt.getSeconds();

                var time = date +"."+ month +"."+ dt.getFullYear() +". "+hours + ":" + minutes + ":" + seconds;
                $('#current-date-time').html(time);
            }, 1000);

            // open iziModal click on element with class .table
            $("body").on('click', '.table-bench',function () {
                var table_id = $(this).data('id');

                // Settings for iziModal
                $("#modal").iziModal({
                    fullscreen: true,
                    openFullscreen: true,
                    closeButton: false,
                    closeOnEscape: false,
                    transitionIn: 'fadeInDown',
                    transitionOut: 'fadeOutDown',
                    onOpening: function (modal) {
                        modal.startLoading();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '/tableDetails',
                            type: 'POST',
                            data: {
                                'table_id' : table_id
                            },
                            success: function(data){
                                $("#modal .iziModal-content").html(data);
                                modal.stopLoading();
                            }
                        });
                    },
                    onOpened: function(){

                        //open modal for chaneges order items
                        $('.change-items').click(function(){

                            $('#oreder-items-modal').iziModal({
                                title: 'Izmena stavke',
                                subtitle: '',
                                headerColor: '#88A0B9',
                                width: 1000,
                                closeOnEscape: false,
                                closeButton: false,
                                transitionIn: 'fadeInDown',
                                transitionOut: 'fadeOutDown',
                                top: '7%',
                                onOpening: function (modal) {
                                    modal.startLoading();

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        url: '/changeItems',
                                        type: 'POST',
                                        data: {
                                            'order_id' : $('#order_id').data('id')
                                        },
                                        success: function(data){
                                            $("#oreder-items-modal .iziModal-content").html(data);
                                            modal.stopLoading();
                                        }
                                    });
                                },
                                onOpened: function(){
                                    disableButtons();
                                },
                                onClosed: function(modal){
                                    enableButtons();
                                    $('#oreder-items-modal').iziModal('destroy');
                                }
                            });

                            $("#oreder-items-modal").iziModal('open');
                        });

                        //open iziModal when click on repeat-order
                        $('body').on('click', '.repeat-order', function(){

                            $("#repeat-order-modal").iziModal({
                                title: 'PONOVI PORUDŽBINU',
                                subtitle: '',
                                headerColor: '#2980b9',
                                borderBottom: true,
                                width: 600,
                                closeOnEscape: false,
                                closeButton: false,
                                history: false,
                                restoreDefaultContent: true,
                                transitionIn: 'fadeInDown',
                                transitionOut: 'fadeOutDown',
                                overlayColor: 'rgb(35, 37, 37)',
                                timeoutProgressbarColor: 'rgb(60, 63, 65)',
                                top: '7%',
                                bottom: null,
                                onOpening: function (modal) {
                                    modal.startLoading();

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        url: '/repeatOrder',
                                        type: 'POST',
                                        data: {
                                            'order_id' : $('#order_id').data('id')
                                        },
                                        success: function(data){
                                            $("#repeat-order-modal .iziModal-content").html(data);
                                            modal.stopLoading();
                                        }
                                    });
                                },
                                onOpened: function(modal) {
                                    disableButtons();
                                    $('body').on('click', '.product-repeat-item', function(e){
                                        $(this).addClass('selected-button');
                                        var repeat = parseInt($(this).attr('data-repeat')) + 1;
                                        $(this).children().html(repeat);
                                        $(this).attr('data-repeat', repeat);
                                    });

                                    $('body').on('click', '.repeat-all', function(e){
                                        var products = $('.list-group > .product-repeat-item');

                                        $( products ).each( function( index, el ) {
                                            var repeat = parseInt($( el ).attr('data-repeat')) + 1;
                                            console.log(repeat);
                                            $( el ).attr('data-repeat', repeat);
                                            $( el ).addClass('selected-button');
                                            $( el ).children().html(repeat);
                                        });

                                    });

                                    $('body').on('click', '.reset-order-button', function(e){
                                        var products = $('.list-group > .product-repeat-item');
                                        products.removeClass('selected-button');
                                        products.attr('data-repeat', 0);
                                        products.children().html(0);
                                    });

                                    $('body').on('click', '.cancel-repeat-button', function(){
                                        enableButtons();
                                        var products = $('.list-group > .product-repeat-item');
                                        $( products ).each( function( index, el ) {
                                            $( el ).attr('data-repeat', 0);
                                            $( el ).removeAttr('data-repeat');
                                        });

                                        $('.list-group').remove();
                                        $('#repeat-order-content').remove();
                                        $('#repeat-order-modal').iziModal('destroy');
                                    });


                                },
                                onClosing: function(modal){
                                },

                            });

                            $("#repeat-order-modal").iziModal('open');

                        });

                        //open iziModal when click on discount
                        $('body').on('click', '.discount', function(){
                            disableButtons();
                            // Settings for iziModal
                            $("#oreder-discount-modal").iziModal({
                                title: 'POPUST',
                                subtitle: '',
                                headerColor: '#2980b9',
                                borderBottom: true,
                                width: 600,
                                closeOnEscape: false,
                                closeButton: false,
                                transitionIn: 'fadeInDown',
                                transitionOut: 'fadeOutDown',
                                overlayColor: 'rgb(35, 37, 37)',
                                timeoutProgressbarColor: 'rgb(60, 63, 65)',
                                top: '7%',
                                bottom: null,
                                onOpening: function (modal) {
                                    modal.startLoading();

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        url: '/discount',
                                        type: 'POST',
                                        data: {
                                            'order_id' : $('#order_id').data('id')
                                        },
                                        success: function(data){
                                            $("#oreder-discount-modal .iziModal-content").html(data);
                                            modal.stopLoading();
                                        }
                                    });
                                },
                                onOpened: function(modal){
                                    console.log(modal);
                                    console.log(table_id);
                                    var order_id = $('#order_id').data('id');

                                    $('body').on('click', '.discount-button', function(e){
                                        $('.discount-button').removeClass('selected-button');
                                        $(this).addClass('selected-button');
                                    });

                                    $('body').on('click', '.cancel-discount-button', function(e){
                                        enableButtons();
                                        $('#oreder-discount-modal').iziModal('close');
                                    });

                                    $('#discount-modal').on('click', '.confirm-discount-button', function(e){
                                        e.preventDefault();
                                        var discount_id = $('button.selected-button').data('id');
                                        var order_id = $('#order_id').data('id');

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: '/calculateDiscount',
                                            type: 'POST',
                                            data: {
                                                'order_id' : order_id,
                                                'discount_id' : discount_id
                                            },
                                            success: function(data){
                                                if(data.isDiscount == true){
                                                    $('#order-discount span').html(data.discountPrice);
                                                    $('#for-check span').html(data.priceWithDiscount);
                                                    $('#table-'+table_id+' > div > .table-price').html(data.priceWithDiscount);
                                                }

                                                if(data.isDiscount == false){
                                                    $('#order-discount span').html('0,00');
                                                    $('#for-check span').html(data.total_price);
                                                    $('#table-'+table_id+' > div > .table-price').html(data.total_price);
                                                }
                                                enableButtons();
                                                $('#oreder-discount-modal').iziModal('close');
                                            }
                                        });

                                    });

                                },
                            });

                            $("#oreder-discount-modal").iziModal('open');
                        });

                        //storno items
                        $('body').on('click', '.cancellation-items', function(){
                                // Settings for iziModal
                                $("#cancellation-items").iziModal({
                                    title: 'STORNO STAVKE',
                                    subtitle: '',
                                    headerColor: '#2980b9',
                                    borderBottom: true,
                                    width: 600,
                                    closeOnEscape: false,
                                    closeButton: false,
                                    transitionIn: 'fadeInDown',
                                    transitionOut: 'fadeOutDown',
                                    overlayColor: 'rgb(35, 37, 37)',
                                    timeoutProgressbarColor: 'rgb(60, 63, 65)',
                                    top: '7%',
                                    bottom: null,
                                    onOpening: function (modal) {
                                        modal.startLoading();

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: '/cancellationItems',
                                            type: 'POST',
                                            data: {
                                                'order_id' : $('#order_id').data('id')
                                            },
                                            success: function(data){
                                                $("#cancellation-items .iziModal-content").html(data);
                                                modal.stopLoading();
                                            }
                                        });
                                    },
                                    onOpened : function(){
                                        disableButtons();
                                        $('#cancellation-reason').keyboard({
                                            lockInput: false, // prevent manual keyboard entry
                                        }).addTyping();

                                        $('.keyboard-open').on('click', function(){
                                            $('#cancellation-reason').getkeyboard().reveal();
                                            return false;
                                        });
                                    }
                                });

                            $('#cancellation-items').iziModal('open');

                            $('body').on('click', '.cancel-storno-button', function(e){
                                enableButtons();
                                $('#cancellation-items').iziModal('destroy');
                            });
                        });

                        //when click on cash
                        $('body').on('click', '.cash', function () {
                            $('#cash-modal').iziModal({
                                title: 'GOTOVINA',
                                subtitle: '',
                                headerColor: '#2980b9',
                                borderBottom: true,
                                width: 600,
                                closeOnEscape: false,
                                closeButton: false,
                                transitionIn: 'fadeInDown',
                                transitionOut: 'fadeOutDown',
                                overlayColor: 'rgb(35, 37, 37)',
                                timeoutProgressbarColor: 'rgb(60, 63, 65)',
                                top: '7%',
                                bottom: null,
                                onOpening: function (modal) {
                                    modal.startLoading();

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        url: '/cash',
                                        type: 'POST',
                                        data: {
                                            'order_id' : $('#order_id').data('id')
                                        },
                                        success: function(data){
                                            $("#cash-modal .iziModal-content").html(data);
                                            modal.stopLoading();
                                        }
                                    });
                                },
                                onOpened : function(){
                                    disableButtons();
                                    $('#order-paid input').number( true, 2, ',', '.' );
                                    $('body').on('keyup', '#order-paid input', function () {
                                       var paid_price = parseInt($(this).val());
                                       var total_price = parseInt($('#hidden-totla-price').val());
                                       var order_cahnge = paid_price - total_price;

                                       $('.order-change > p > span > input').val($.number( order_cahnge, 2, ',', '.' ));
                                    });

                                    $('body').on('click', '.order-cash-pay', function () {
                                        var order_id = $(this).data('order-id');
                                        //var table_id = $(this).data('table-id');

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: '/payment',
                                            type: 'POST',
                                            data: {
                                                'order_id' : order_id,
                                            },
                                            success: function(data){
                                                if(data){
                                                    var table = $('#table-'+data.table_id);
                                                    table.removeClass('self-table').addClass('table-free');
                                                    table.html('<div>'+ data.table_number +'</div>');
                                                    enableButtons();
                                                    $('#cash-modal').iziModal('close');
                                                    $('#modal').iziModal('close');
                                                }
                                            }
                                        });

                                    });
                                }
                            });

                            $('#cash-modal').iziModal('open');

                            $('body').on('click', '.cancel-cash-button', function(){
                                enableButtons();
                                $('#cash-modal').iziModal('close');
                            });
                        });


                        $('.footer-back').click(function(){
                            $('#modal').iziModal('close');
                        });

                        $('.category ').removeClass('disabled');
                        //when click on button with class category
                        $('#categories').on('click', '.category', function(){

                            $('#subcategories').html('');
                            $('#subcategories').empty();
                            $('#products').hide();
                            $('#products').empty();

                            $('#categories > div > button').css('border-color', '#2980b9');
                            $(this).css('border-color', '#FFF');

                            var category_id = $(this).data('id');
                            console.log(category_id);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: '/getSubcategories',
                                type: 'POST',
                                data: {
                                    'category_id' : category_id
                                },
                                success: function(data){
                                    $('#subcategories').show();
                                    $.each(data, function( index, value ) {
                                        $('#subcategories').append('<div class="col-md-2"><button data-id="'+value.id+'" class="btn btn-success subcategory-products">'+value.name+'</button></div>');
                                    });
                                }
                            });
                        });

                        //when click on button with class subcategory
                        $('#subcategories').on('click', '.subcategory-products', function(e){
                            e.stopPropagation();
                            e.preventDefault();

                            $('#products').empty();

                            $('#subcategories > div > button').css('border-color', 'green');
                            $(this).css('border-color', '#FFF');


                            var subcategory_id = $(this).data('id');
                            console.log(subcategory_id);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            var content = '';

                            $.ajax({
                                url: '/getProducts',
                                type: 'POST',
                                data: {
                                    'subcategory_id' : subcategory_id
                                },
                                success: function(data){
                                    $('#products').show();
                                    if($.isArray(data) && data.length > 0 ){
                                        $.each(data, function( index, value ) {
                                            console.log(value);
                                            content+="<div class='col-md-2 products' data-id='"+value.id+"' data-name='"+value.name+"' data-price='"+value.price+"' align='center'>";
                                            if(value.image !== null) {
                                                content+= "<img src='" + value.image + "' class'img-rounded img-responsive add-to-order' width='150'/>";
                                            }else{
                                                content+="<button type='button'  class='btn btn-primary btn-lg'>"+value.name+"</button>"
                                            }
                                            content+="</div>";
                                        });
                                    }else{
                                        content+="<div class='alert alert-danger'>";
                                        content+="Nema traženih proizvoda. :(";
                                        content+="</div>";
                                    }

                                    $('#products').html(content);
                                }
                            });
                        });

                        //when click on product to add to order
                        $('#products').on('click', '.products', function(e){
                            e.stopPropagation();
                            var product_id = $(this).data('id');
                            var product_name = $(this).data('name');
                            var product_price = $(this).data('price');
                            var order_id = $('#order_id').data('id');
                            var table_id = $('#table_hiiden_id').val();

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            var content = '';

                            $.ajax({
                                url: '/addProductOrder',
                                type: 'POST',
                                data: {
                                    'product_id' : product_id,
                                    'order_id' : order_id,
                                    'table_id' : table_id
                                },
                                success: function(data){

                                    var table_id = 'table-'+data.table_id;

                                    if(data.first == false){
                                        $('#product-'+data.product_id+ '> p > .product-quantity').html(data.product_quantity+'x');
                                        $('#order-total > #total-price > .price').html(data.total_price);
                                        $('#for-check span').html(data.total_price);
                                        $('#'+table_id+' > div > .table-price').html(data.total_price);
                                        $('#product-'+data.product_id+' > p > .product-price').html(data.price);

                                        if(data.isDiscount == true){
                                            $('#order-discount span').html(data.discount);
                                            $('#for-check span').html(data.priceWithDiscount);
                                            $('#'+table_id+' > div > .table-price').html(data.priceWithDiscount);
                                        }
                                    }

                                    var content = '';

                                    if(data.first == true){
                                        var id = 'product-'+data.id;
                                        $('.discount ').removeClass('action-disabled');

                                        $('.order-id').html('<p id="order_id" data-id="'+data.order_id+'">Broj računa: '+data.order_id+'</p>');

                                        content+="<div id='"+id+"'>";
                                        content+='<p>'
                                        content+='<span class="product-quantity">1x</span>';
                                        content+='<span class="product-name"> '+data.name+' </span>';
                                        content+='<span class="product-price pull-right">'+data.price+' </span>';
                                        content+='</p>';
                                        content+='</div>';

                                        $('.table-order > #order-products').append(content);

                                        var oldTotalPrice = parseInt($('.table-order > #total-price > .price').text());
                                        var newTotalPrice = oldTotalPrice + data.price;
                                        var table = $('#'+table_id);

                                        var table_content = '';

                                        table_content+='<div style="border: 2px solid '+data.waiter_color+'">';
                                            table_content+= '<p>'+data.table_number +' '+ data.waiter+'</p>';
                                            table_content+='<span class="table-price">'+data.price+'</span>  RSD';
                                        table_content+='</div>';

                                        $('#order-total > #total-price > .price').html(data.total_price);
                                        table.removeClass('table-free');
                                        table.addClass('self-table');
                                        table.html(table_content);
                                        $('#'+table_id+' > div > .table-price').html(data.total_price);
                                        $('#for-check span').html(data.total_price);

                                        if(data.isDiscount == true){
                                            $('#order-discount span').html(data.discount);
                                            $('#for-check span').html(data.priceWithDiscount);
                                            $('#'+table_id+' > div > .table-price').html(data.priceWithDiscount);
                                        }
                                    }
                                }
                            });

                        });
                    },
                    onClosing: function(modal){

                    },
                    onClosed: function(modal){
                        $('#modal').iziModal('destroy');
                        $('#oreder-items-modal').iziModal('destroy');
                    }
                });

                $('#modal').iziModal('open');
            });

            $('.dropdown-toggle').click(function(){
               $('.dropdown-menu').css('display', 'block');
            });
        });
    </script>
@endsection