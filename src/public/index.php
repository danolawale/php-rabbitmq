<?php require __DIR__.'/../vendor/autoload.php'; ?>


<?php
    $usersRepo = \Library\Model\Entity\UserAccount::getRepository();

    $users = $usersRepo::fetchAllUsers(\Library\Model\Entity\UserAccount::class);
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
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
        
        <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Id</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Date Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <th scope="row"><?= $user->id ?></th>
                        <td><?= $user->firstname ?></td>
                        <td><?= $user->lastname ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->date_created ?></td>
                        <td><?= $user->date_updated ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
		<script src="" async defer></script>
	</body>
</html>