<div id="discount-modal" class="container">
    <div class="row discounts">
            @if(!$discounts->isEmpty())
            <div class="col-md-6 col-md-offset-4">
                <button data-id="null" type="button" class="{{ $order->discount_id == null ? 'selected-button' : '' }} btn btn-primary btn-lg discount-button">Bez popusta</button>
            </div>

                @foreach($discounts as $discount)
                    <div class="col-md-6 col-md-offset-4">
                        <button data-id="{{ $discount->id }}" type="button" class="{{ $order->discount_id == $discount->id ? 'selected-button' : ''}} btn btn-success btn-lg discount-button">
                            Popust {{ $discount->name }}
                        </button>
                    </div>
                @endforeach
            @endif
    </div>

    <div class="row">
        <div class="col-md-12">
                <button class="btn btn-danger btn-lg cancel-discount-button">OTKAŽI</button>
                <button class="btn btn-success btn-lg pull-right confirm-discount-button">POTVRDI</button>
        </div>
    </div>
</div>