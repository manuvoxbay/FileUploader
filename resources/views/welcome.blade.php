<!DOCTYPE html>
<html lang="en">
    <head>
        <title>File Handler</title>
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
                <div class="col-md-12">
                    <main class="py-4">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('warning'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                    </main>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <a href="{{url('/history')}}">history</a>
                </div>
                <div class="col-md-4">
                    <h2>Upload File</h2>
                    <p>
                        <form method="post" action="{{route('save.file')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Upload File</label>
                                <input type="file" name="image" id="image" class="form-control" placeholder="Choose File"/>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Upload" name="add" id="add" class="btn btn-primary"/>
                            </div>
                        </form>
                    </p>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form method="get" action="{{route('load.index')}}" enctype="multipart/form-data">
                    <input type="text" name="search" class="form-control" id="search" placeholder="Enter your  keyword"/>
                    <input type="submit" name="submit" class="btn btn-info" value="Load"/>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <h2>File List</h2>
                <table border=1 class="table">
                    <thead>
                        <th>SI.No</th>
                        <th>File Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <form method="post" action="{{route('delete.file')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @if ($errors->has('file_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file_id') }}</strong>
                                </span>
                            @endif
                            @foreach($files as $key=>$file)
                                <tr>
                                    <td>{{$loop->count}}</td>
                                    <td>  
                                        <a href="{{asset('storage/files/'.$file->file)}}" target="blank" download>
                                            {{$file->file}}
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" name="file_id" value="{{$file->id}}" id="file_id"/>
                                        <button type="submit" name="delete" id="delete" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            @if(empty($files[0]))
                            <tr><td colspan="3" align="center"'>No files found</td></tr>
                            @endif
                        </form>
                    </tbody>
                </table>
                {!! $files->render() !!}
            </div>
            <div class="col-md-2"></div>
        </div>
    </body>
</html>
