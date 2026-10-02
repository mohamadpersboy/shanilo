<div class="close_btn"><i class="i-cancel"></i></div>
<div class="title_style7"><span class="title">کیف پول {{$wallet->shop->title}}</span></div>
<div class="text_style1">تراکنش های کیف پول</div>
<div class="table_style1">
    <table>
        <thead>
        <tr>
            <th>شماره تراکنش</th>
            <th>شماره سفارش</th>
            <th>مبدا</th>
            <th>مقصد</th>
            <th>مبلغ تراکنش</th>
            <th>تاریخ تراکنش</th>
        </tr>
        </thead>
        <tbody>
        @foreach($walletTransactions as $index=>$walletTransaction)
            <tr>
                <td>{{$walletTransaction->id}}</td>
                <td>{{$walletTransaction->order_id}}</td>
                <td>{{$walletTransaction->source}}</td>
                <td>{{$walletTransaction->destination}}</td>
                <td><span class="price {{$walletTransaction->type}}">{{showPrice($walletTransaction->order->total,null,null)}}</span></td>
                <td>{{show_persian_with_month($walletTransaction->created_at)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


