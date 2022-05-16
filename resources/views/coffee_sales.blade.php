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
                            <select name="product_id">
                                @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->label}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required>
                            <input type="text" name="unit_cost" id="unit_cost" class="form-control" placeholder="Unit Cost (£)" required>
                            <span class="p-6">Selling Price</span>
                            <button type="submit" style="border: 1px solid black; padding:5px" class="border-gray-200">Record Sale</button>
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
                                @foreach ($sales as $sale)
                                <tr>
                                    <td style="border: 1px solid black">{{$sale->quantity}}</td>
                                    <td style="border: 1px solid black">{{$sale->unit_cost}}</td>
                                    <td style="border: 1px solid black">{{$sale->selling_price}}</td>
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
