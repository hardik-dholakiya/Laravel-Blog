<h2 align="center">Welcome to Blog</h2>
<div>
   <h4>
       Welcome {{$user['name']}}
   </h4>
</div>
<div>
    <table border="1" cellpadding="10px">
        <tr>
            <td>Email ID</td>
            <td>{{$user['email']}}</td>
        </tr>
        <tr>
            <td>Account Password</td>
            <td>{{$password}}</td>
        </tr>
        <tr>
            <td>Account created at</td>
            <td> {{$user['created_at']}}</td>
        </tr>

    </table>
</div>

<div align="center">
    Develop by Dholakiya Hardik
</div>