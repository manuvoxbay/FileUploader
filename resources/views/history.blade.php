<!DOCTYPE html>
<html lang="en">
    <head>
        <title>History</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{url('/')}}">Home</a>
                </div>
                <div class="col-md-8">
                    <h2>History</h2>
                    <table border=1 class="table">
                        <thead>
                            <th>SI.No</th>
                            <th>File Name</th>
                            <th>Type</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach($files as $key=>$file)
                                <tr>
                                    <td>{{$loop->count}}</td>
                                    <td> 
                                         {{$file->file}}
                                    </td>
                                    <td>
                                        @if($file->type == 1)
                                            Uploaded
                                        @else
                                            Deleted
                                        @endif
                                    </td>
                                    <td>
                                       {{$file->created_at}}
                                    </td>
                                </tr>
                            @endforeach
                            @if(empty($files[0]))
                            <tr><td colspan="3" align="center"'>No data found</td></tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $files->render() !!}
                </div>
            <div class="col-md-2"></div>
        </div>
    </body>
</html>
