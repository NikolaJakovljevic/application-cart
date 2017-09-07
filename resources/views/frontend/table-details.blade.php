@extends('frontend.layouts.modal-layout')

@section('content')

 <div class="container-fluid">
     <div class="row">
         <div class="col-md-4">
             <div class="user-info">
                 <p>{{ Auth::user()->name }} </p>
                 <p>{{ date("d.m.Y.") }}</p>
                 <p>Broj stola: {{ $table->number }}</p>
             </div>

             {{--<hr>--}}

             <div>
                 <input type="hidden" id="table_hiiden_id" value="{{ $table->id }}" />
             </div>

             <div class="table-order">
                 <?php  $total = []; ?>
                 @if($table->order != null)
                     <div class="order-id">
                         <p id="order_id" data-id="{{ $table->order->id }}">Broj računa: {{ $table->order->id }}</p>
                     </div>
                     <div id="order-products">
                         @foreach($table->order->products as $product)
                             <?php $total[] = $product->quantity()->where('order_id', $table->order->id)->first()->product_quantity * $product->price; ?>
                             <div id="product-{{ $product->id }}">
                                 <p>
                                     <span class="product-quantity"> {{ $product->quantity()->where('order_id', $table->order->id)->first()->product_quantity }}x </span>
                                     <span class="product-name"> {{ $product->name }} </span>
                                     <span class="product-price pull-right">{{ number_format($product->quantity()->where('order_id', $table->order->id)->first()->product_quantity * $product->price, 2, ',', '.')  }} </span>
                                 </p>
                             </div>
                         @endforeach
                     </div>
                 @else
                     <div class="order-id">

                     </div>
                    <div id="order-products">

                    </div>
                 @endif

             </div>

             @if($table->order != null)
                 <div id="order-total">
                     <div id="total-price">
                         Ukupno: <span class="price pull-right">{{ number_format(array_sum($total), 2, ',', '.' ) }}</span>
                     </div>
                     @if($table->order->discount_id != null)
                         <div id="order-discount">
                             <p> Popust:  <span class="pull-right"> {{ number_format(array_sum($total) * $table->order->discount->value, 2, ',', '.')  }} </span> </p>
                         </div>
                         <div id="for-check">
                             <p> Za naplatu: <span class="pull-right"> {{ number_format(array_sum($total) -  array_sum($total) * $table->order->discount->value, 2, ',', '.') }} </span></p>
                         </div>
                     @else
                         <div id="order-discount">
                             <p>Popust: <span class="pull-right"> 0,00 </span></p>
                         </div>
                         <div id="for-check">
                             <p> Za naplatu: <span class="pull-right"> {{ number_format(array_sum($total), 2, ',', '.')  }} </span></p>
                         </div>
                     @endif
                 </div>
             @else
                 <div id="order-total">
                     <div id="total-price">
                         Ukupno: <span class="price pull-right"> 0,00</span>
                     </div>
                     <div id="order-discount">
                         <p>Popust: <span class="pull-right"> 0,00 </span></p>
                     </div>
                     <div id="for-check">
                         <p> Za naplatu: <span class="pull-right"> 0,00 </span></p>
                     </div>
                 </div>
             @endif

         </div>
         
         <div class="col-md-8">
             <div class="row">
             <div class="col-md-11" id="categories">
                 @foreach($categories as $category)
                        <div class="col-md-2">
                             <button type="button" data-id="{{ $category['id'] }}" class="btn btn-primary btn-lg category disabled">
                                 {{ $category['name'] }}
                             </button>
                        </div>
                 @endforeach
             </div>
             {{--<div class="row">--}}
                 <div class="col-md-11" id="subcategories" style="display: none;">
                 </div>
             {{--</div>--}}
             <div class="col-md-11" id="products">
                @if($featuredProducts)
                    @foreach($featuredProducts as $product)
                         <div class="col-md-2 products" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" align="center">
                             <button type="button"  class="btn btn-primary btn-lg">
                                 {{ $product->name }}
                             </button>
                         </div>
                    @endforeach
                @endif
             </div>
         </div>

     </div>

         <footer class="footer footer-table" style="position: fixed;">
             <div class="container-fluid">
                 <div class="col-md-6 footer-table-orders-action">
                     <div class="col-md-3 cancellation-items">
                         <p>Storno stavke</p>
                     </div>
                     <div class="col-md-3 change-items">
                         <p>Izmena stavke</p>
                     </div>
                     <div class="col-md-3 discount {{ $table->order == null ? 'action-disabled' : '' }}">
                         <p>Popust</p>
                     </div>
                     <div class="col-md-3">
                         <p>Storno porudžbine</p>
                     </div>
                     <div class="col-md-3 repeat-order">
                         <p>Ponovi porudžbinu</p>
                     </div>
                 </div>

                 <div class="col-md-3 footer-table-orders-payment">
                     <div class="col-md-5 cash">
                         <p>Gotovina</p>
                     </div>
                     <div class="col-md-5">
                         <p>Kreditna kartica</p>
                     </div>
                     <div class="col-md-5">
                         <p>Kombinovano</p>
                     </div>
                     <div class="col-md-5">
                         <p>Virman</p>
                     </div>
                 </div>

                 <div class="col-md-3 footer-table-orders-check">
                     <div class="col-md-5 col-md-push-2" id="made-check-button">
                         <p>Izdaj porudžbinu</p>
                     </div>
                     <div class="col-md-5 col-md-push-2 footer-back">
                         <p>Nazad</p>
                     </div>
                 </div>

             </div>
         </footer>
 </div>

@endsection

