<style>
    .cutoff-label{
        float: right;
        font-size: 15px;
    }
</style>
@if( isset( $items ) && !empty($items))

    @foreach ($items as $item)
        @php
        $product_items = $item->products;
        @endphp
        <h2>{{ $item->categories }}
            <span class="text-end text-muted cutoff-label"> Cuttoff Time : 
                {{ date('h:i A', strtotime($item->cutoff_start_time)) .' - '. date('h:i A', strtotime($item->cutoff_end_time)) }}</span>
        </h2>
        <div class="text-end">
            
        </div>
        @if (isset($product_items) && $product_items )
            @foreach ($product_items as $product)
       
            <div class="col-sm-6 col-lg-6 my-2">
                <label for="food_{{ $product->id }}" class="card border-0 rounded ">
                    <img class="w-100 rounded shadow-sm" src="{{ asset('products/'.$product->image) }}">
                    <div class="card-body w-100 px-2">
                        <div class="border-0">
                            <div>
                                <input type="checkbox" @if(isset(session()->get('order')['product_id']) && in_array($product->id, session()->get('order')['product_id']) ) checked @endif value="{{ $product->id }}" name="food[]" id="food_{{ $product->id }}" class="form-check-input me-2">
                                <strong class="food_name">{{ $product->name }}</strong>
                            </div>
                            <div class="food_price">RS. {{ $product->price }}</div>
                        </div>
                        <div class="food_content">{{ $product->description }}</div>
                    </div>
                </label>
            </div> 
            @endforeach
        @endif
    
    @endforeach
@endif
