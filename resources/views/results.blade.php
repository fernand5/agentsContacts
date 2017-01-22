<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDldmqSxw6q72S0JT-HuhvbiAPhrVr-ac&v=3.23&libraries=places"></script>--}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>MULU</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Custom Fonts -->
        {{--<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">--}}
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDldmqSxw6q72S0JT-HuhvbiAPhrVr-ac&v=3.23&libraries=places"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="content">
                <a href="index" class="btn btn-info" role="button">Back</a>
                <table class="table">
                <thead>
                <th>AgentId</th>
                <th>Contact Name</th>
                <th>Contact Zip Code</th>

                </thead>
                <tbody>
                <?php $i = 0 ?>
                @foreach ($results as $value)
                    <?php $i++ ?>
                    <tr style="{!! ($agent1==$value["code"]||$agent2==$value["code"]) ? 'background:#980f0f;color:#FFF' : 'background:#FFF'!!}">
                        <td>{!! ($agent1==$value["code"]||$agent2==$value["code"]) ? '' : $value->agentId!!}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->code}}</td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
