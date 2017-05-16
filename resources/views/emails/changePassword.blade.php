<h2 align="center">Welcome to Blog</h2>
<div>
    <h4>Welcome {{$user->name}}</h4>
</div>
<div>
    <table border="1" cellpadding="10px">
        <tr>
            <td>Email ID:-</td>
            <td>
                {{$user->email}}
            </td>
        </tr>
        <tr>
            <td>Role Type:-</td>
            <td>
                @if($user->role==1)
                    Admin
                @else
                    User
                @endif
            </td>
        </tr>
        <tr>
            <td>Your password :-</td>
            <td>{{$password}}</td>
        </tr>
        <tr>
            <td>account created at :-</td>
            <td>{{$user->created_at}}</td>
        </tr>
        <tr>
            <td>account Last update at :-</td>
            <td>{{$user->updated_at}}</td>
        </tr>

    </table>

</div>

<div align="center">
    Develop by Dholakiya Hardik
</div>