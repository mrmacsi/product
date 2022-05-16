<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($errors->any())
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        </div>
                    </div>
                @endif
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="salesForm" method="POST" action="{{route('store.sales')}}">
                    @csrf
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <table style="width: 60%;">
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Cost(£)</th>
                                <th style="width: 100px;">Selling Price</th>
                                <th></th>
                                <tr>
                                    <td>
                                        <select name="product_id" id="product_id">
                                            @foreach ($products as $product)
                                                <option value="{{$product->id}}">{{$product->label}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required>
                                    </td>
                                    <td>
                                    <input type="text" name="unit_cost" id="unit_cost" class="form-control" placeholder="Unit Cost (£)" required>
                                    </td>
                                    <td style="width: 100px;">
                                        <div id='selling_price'></div>
                                    </td>
                                    <td>
                                        <button type="submit" style="border: 1px solid black; padding:5px; margin-left:10px; width: 100px;" class="border-gray-200">Record Sale</button>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <span class="pb-2">Previous Sales</span>
                        <div>
                            <table style="width: 60%;">
                                <th style="border: 1px solid black">Quantity</th>
                                <th style="border: 1px solid black">Unit Cost</th>
                                <th style="border: 1px solid black">Selling Price</th>
                                <th style="border: 1px solid black">Sold at</th>
                                @foreach ($sales as $sale)
                                <tr>
                                    <td style="border: 1px solid black">{{$sale->quantity}}</td>
                                    <td style="border: 1px solid black">{{$sale->unit_cost}}</td>
                                    <td style="border: 1px solid black">{{$sale->selling_price}}</td>
                                    <td style="border: 1px solid black">{{\Carbon\Carbon::parse($sale->sold_at)->format('Y-m-d H:i');}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
document.getElementById('unit_cost').addEventListener('keyup', function(e){
    calculate ();
});  
document.getElementById('quantity').addEventListener('keyup', function(e){
    calculate ();
});  
document.getElementById('product_id').addEventListener('change', function(e){
    calculate ();
});  
function calculate () { 
    var unit_cost = document.getElementById('unit_cost').value;
    var quantity = document.getElementById('quantity').value;
    var product_id = document.getElementById('product_id').value;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if(!unit_cost || !quantity || !product_id) return;
    $.post('/calculate',
    {
        '_token': $('meta[name=csrf-token]').attr('content'),
        unit_cost: unit_cost,
        quantity: quantity,
        product_id: product_id,
    })
    .error(
     )
    .success(
       function(data) {
        document.getElementById('selling_price').innerText =  data.selling_price;
       }
    );
}
</script>
