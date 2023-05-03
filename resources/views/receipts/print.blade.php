<div style="width: 700px;
margin-left: auto;
margin-right: auto; display: flex; margin-bottom: 5px;">
    <div>
        <img src="{{ asset('assets/images/logo.png') }}" />
    </div>
    <div>
      {{-- <table>
        <tbody style="padding: 0px; border: none;">
            <tr style="border: none;padding: 0px;">
                <td style="border: none;padding: 0px;" colspan="3">Invoice #12345ABC</td>
                <td style="border: none;padding: 0px;">09 March 2023</td>
            </tr><br>
            <tr style="border: none;padding: 5px;">
                <td style="border: none;padding: 0px;" colspan="3">Invoice #12345ABC</td>
                <td style="border: none;padding: 0px;">09 March 2023</td>
            </tr>
          </tbody>
      </table> --}}
    </div>
</div>

<table style="width: 700px;
margin-left: auto;
margin-right: auto;">
    <tr>
        <th colspan="4">Invoice #12345ABC</th>
        <th>09 March 2023</th>
    </tr>
    <tr>
        <td colspan="3">
            <strong>Pay To:</strong> <br> EFI Bike House <br>
            123 Willow Street <br>
            Colombo 10, LK 000010
        </td>
        <td colspan="3">
            <strong>Customer:</strong> <br>
            {{ $order->customer->username }} <br>
            {{ $order->customer->address }} <br>
            {{ $order->customer->phone }} <br>
            {{ $order->customer->mobile }} <br>

        </td>
    </tr>
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Sub Total</th>
    </tr>
    <tr>
        @foreach ($order->items as $item)
            <td>{{ $item->item->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price_user, 2) }}</td>
            <td>{{ number_format($item->discount, 2) }}</td>
            <td>{{ number_format($item->price_user * $item->quantity, 2) }}</td>
        @endforeach
    </tr>

    <tr>
        <th colspan="4">Grand Total</th>
        <td>{{ number_format($order->amount, 2) }}</td>
    </tr>
    <tr>
        <th colspan="4">Paid</th>
        <td>{{ number_format($order->amount, 2) }}</td>
    </tr>
</table>
