<h2 align="center">Welcome to Blog</h2>
<div>
    <h4>Welcome {{$data['name']}}</h4>
</div>
<div>
    <table border="1" cellpadding="10px">
        <tr>
            <td>Email ID:-</td>
            <td>
                {{$data['email']}}
            </td>
        </tr>
        <tr>
            <td>Mobile No:-</td>
            <td>
                {{$data['mobileno']}}
            </td>
        </tr>

        <tr>
            <td>subject:-</td>
            <td>
                {{$data['subject']}}
            </td>
        </tr>
        <tr>
            <td>Message:-</td>
            <td>{{$data['message']}}</td>
        </tr>
    </table>
{{--    <img src="{{$message-> embed($file[$i]->getRealPath())}}" width="100%" height="80%">--}}
</div>

<div align="center">
    Develop by Dholakiya Hardik
</div>