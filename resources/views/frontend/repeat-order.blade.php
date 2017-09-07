<div id="repeat-order-content" class="container">
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <ul class="list-group">
                @foreach($order->products as $product)
                    <li class="list-group-item product-repeat-item" data-id="{{ $product->id }}" data-repeat="0">
                        {{ $product->name }} <span class="badge">0</span>
                    </li>
                @endforeach

                <li class="list-group-item repeat-all">
                        Ponovi porudžbinu
                </li>

                <li class="list-group-item reset-order-button">
                    Resetuj
                </li>

            </ul>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-danger btn-lg cancel-repeat-button">OTKAŽI</button>
            <button class="btn btn-success btn-lg pull-right order-cash-pay">POTVRDI</button>
        </div>
    </div>
</div>