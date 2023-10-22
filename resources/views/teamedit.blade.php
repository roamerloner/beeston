<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-6 m-auto">
                <div class="card">
                  <div class="card-header">
                     Edit Team Member ({{ $team->name }})
                  </div>
                    <div class="card-body">

                            <form action="{{url('team/edit/post')}}/{{ $team->id }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Team Member Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $team->name }}">
                                </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Team Member Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" value="{{ $team->phone_number }}">
                            </div>
                            <button type="submit" class="btn btn-primary bg-gradient">Edit</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>

