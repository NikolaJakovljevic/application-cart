<div class="container">
    <div class="row">
        <div class="col-md-6">
            @foreach($order->products as $product)
                <p>{{ $product->name }}</p>
            @endforeach
        </div>

    </div>
</div>
