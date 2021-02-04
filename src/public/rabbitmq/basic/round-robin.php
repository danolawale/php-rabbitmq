<?php require __DIR__.'/../../../vendor/autoload.php'; ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $data = [
            'user' => [
                'firstname' => $_POST['firstname'] ?? '',
                'lastname' => $_POST['lastname'] ?? '',
                'username' => $_POST['email'],
                'email' => $_POST['email'],
                'password' => $_POST['password'] ?? '',
            ],
            'address' => [
                'address1' => $_POST['address1'] ?? '',
                'address2' => $_POST['address2'] ?? '',
                'city' => $_POST['city'] ?? '',
                'county' => $_POST['county'] ?? '',
                'post_code' => $_POST['post_code'] ?? '',
                'email' => $_POST['email']
            ]
        ];

        $rabbitConnection = Loader::getInstance(\Library\Tools\RabbitMq\AmqpStreamConnectionService::class);

        $registrationService = new \Library\Services\RabbitMq\Basic\RegistrationService(
            new \Library\Tools\RabbitMq\AmqpChannelService($rabbitConnection));

        if($registrationService->sendMultipleMessages($data))
        {
            echo "successfully sent messages\n";
        }
        else
        {
            echo "failure\n";
        }
    }

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RabbitMQ - Demo - Registration</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 950px;">
                <h4 class="card-title mt-3 text-center">Register</h4>

                <form method="POST" action="round-robin.php">
                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputFirstName">First Name</label>
                            <input type="text" class="form-control" id="inputFirstName" name="firstname" placeholder="First Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputLastName">Last Name</label>
                            <input type="text" class="form-control" id="inputLastName" name="lastname" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Password</label>
                            <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" name="address1" placeholder="1234 Main St">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputCity">City</label>
                            <input type="text" class="form-control" name="city" id="inputCity">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputState">County</label>
                            <input type="text" class="form-control" name="county" id="inputCounty">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Post Code</label>
                            <input type="text" class="form-control" name="post_code" id="inputZip">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Check me out
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Register</button>
                </form>
            </article>
        </div>

        
        <script src="" async defer></script>
    </body>
</html>