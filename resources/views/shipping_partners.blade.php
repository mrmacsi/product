<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Set new shipment cost 🚚') }}
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
                    <form id="salesForm" method="POST" action="{{route('store.shipment')}}">
                    @csrf
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="p-2"> New cost of shipment</div>
                            <div class="p-2">
                                <input type="text" name="cost" id="cost" class="p-2" placeholder="Cost" required>
                            </div>
                            <div class="p-2">
                                <button type="submit" style="border: 1px solid black; padding:5px" class="border-gray-200">Set New Price</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <span class="pb-2" style="font-size: 30px;">Log of shipment costs</span>
                        <div>
                            <table style="width: 60%;">
                                <th style="border: 1px solid black">Shipment Cost</th>
                                <th style="border: 1px solid black">Active</th>
                                <th style="border: 1px solid black">Set at</th>
                                <th style="border: 1px solid black">Number of sales</th>
                                @foreach ($shipment_costs as $shipment_cost)
                                    <tr>
                                        <td style="border: 1px solid black">{{$shipment_cost->cost}}</td>
                                        <td style="border: 1px solid black">{{$shipment_cost->active?'Yes':'No'}}</td>
                                        <td style="border: 1px solid black">{{\Carbon\Carbon::parse($shipment_cost->created_at)->format('Y-m-d H:i');}}</td>
                                        <td style="border: 1px solid black">123</td>
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
