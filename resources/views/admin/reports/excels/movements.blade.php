<table>
    <tr>
        <td><b>Store:</b></td>
        <td>{{@$store->name}}</td>
    </tr>
    <tr>
        <td><b>Address:</b></td>
        <td>{{@$store->address}}</td>
    </tr>
    <tr>
        <td><b>Phone:</b></td>
        <td>{{@$store->phone}}</td>
    </tr>
</table>
<br />
<table width="100%" border="1">
   <tr>
       <td>Date</td>
       <td>Sender Name</td>
       <td>Receiver Name</td>
       <td>Country</td>
       <td>Service</td>
       <td>Amount</td>
   </tr>
   <tbody>
       @foreach($data as $r)
            <tr>
                <td>{{date('m-d-Y',strtotime($r->shipment_date))}}</td>
                <td>{{$r->sender->full_name}}</td>
                <td>{{$r->receiver_person_id}}</td>
                <td>{{$r->country->name}}</td>
                <td>{{$r->service->name}}</td>
                <td>${{number_format($r->amount, 2, '.',',')}}</td>
            </tr>
       @endforeach
   </tbody>
</table>  