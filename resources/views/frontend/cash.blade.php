<div id="cash-modal-content" class="container">
    <div class="row">
        <div class="col-md-12 order-amount">
            <p> Iznos računa: <span class="pull-right">{{ number_format($order->getTotalPrice(), 2, ',', '.') }}</span></p>
            <input id="hidden-totla-price" type="hidden" value="{{ $order->getTotalPrice() }}">
        </div>

        <div class="col-md-12 order-paid">
            <p> Uplaćeno: <span id="order-paid" class="pull-right"><input type="text" name="order-paid" class="form-control" /></span></p>
        </div>

        <div class="col-md-12 order-change">
            <p> Kusur: <span class="pull-right"><input type="text" class="form-control" name="order-change" value="0,00"></span></p>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
                <button class="btn btn-danger btn-lg cancel-cash-button">OTKAŽI</button>
                <button class="btn btn-success btn-lg pull-right order-cash-pay" data-order-id="{{ $order->id }}" data-table-id="{{ $order->table_id }}">POTVRDI</button>
        </div>
    </div>
</div>