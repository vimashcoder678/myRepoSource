<?php
include 'config.php';
session_start();

if (empty($_SESSION['login'])) {
   header("Location:index.php");
}


if (isset($_POST['submit']) && empty($_POST['user_id'])) {
	
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$password')";

    $result = mysqli_query($connect, $sql);
    if ($result) {
    	header("Location: index.php");
    }
}

$getusers = "SELECT * FROM users"; // Correct table name syntax
$query_run = mysqli_query($connect, $getusers); // Use the query string as the second parameter
while ($row = mysqli_fetch_assoc($query_run)) {
    $userresult[] = $row;
}

if (!empty($_POST['user_id']) && isset($_POST['submit'])) {
	 $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET 
                name = '$name', 
                phone = '$phone', 
                email = '$email', 
                password = '$password' 
            WHERE id = $userId";

    // Execute the query
    if (mysqli_query($connect, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MyAjaxCrud</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
	<div class="container-xl">
		<div class="d-flex justify-content-between border m-2 p-2">

			<div class="heading">
				<h2 class="text-secondary">User</h2>
			</div>
			<div class="buttons">
			  <button class="btn btn-outline-secondary" id="create_user" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Create User</button>
			  <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Users</h1>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        <form action="index.php" method="post">
			        	<input type="number" name="user_id"  id="user_id" hidden> 
				      <div class="mb-3">
				        <label for="name" class="form-label">Name</label>
				        <input type="text" class="form-control" id="name"  name="name" placeholder="Enter your name" required>
				      </div>
				      <div class="mb-3">
				        <label for="phone" class="form-label">Phone</label>
				        <input type="tel" class="form-control" id="phone"  name="phone" placeholder="Enter your phone number" required>
				      </div>
				      <div class="mb-3">
				        <label for="email" class="form-label">Email address</label>
				        <input type="email" class="form-control" id="email"  name="email" placeholder="Enter your email" required>
				      </div>
				      <div class="mb-3">
				        <label for="password" class="form-label">Password</label>
				        <input type="password" class="form-control" id="password"  name="password" placeholder="Enter your password" required>
				      </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			        <button type="submit" name="submit" class="btn btn-primary">Create Account</button>
			      </div>
			      </form>
			    </div>
			  </div>
			</div>

		</div>

	</div>
	<div class="container-xl ">
		
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">name</th>
		      <th scope="col">phone</th>
		      <th scope="col">email</th>
		      <th colspan="2">Action</th>
		    </tr>
		  </thead>
		  <?php foreach($userresult as $user):?>
		  <tbody>
		    <tr>
		      <th scope="row"><?php echo $user['id']; ?></th>
		      <td><?php echo $user['name']; ?></td>
		      <td><?php echo $user['phone']; ?></td>
		      <td><?php echo $user['email']; ?></td>
		      <td colspan="2">
		       <button class="btn btn-outline-info" data-id="<?php echo $user['id']; ?>" onclick="editUser(this)">Edit</button>
		       <button class="btn btn-outline-dark">Delete</button>
		      </td>
		    </tr>
		  </tbody>
		<?php endforeach; ?>
		</table>
	
	</div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
			$(document).ready(function() {
		    $('#create_user').click(function() {
                // Your click event code here
                 $('#staticBackdropLabel').text('Create User');
            });
		   
		});
	 function editUser(button) {
    var userId = $(button).data('id');

       $.ajax({
                url:"fetch.php",
                method:"GET",
                data:{id:userId},
            success:function(data)
            {
            	var parsedData = JSON.parse(data);
            // Assuming there's only one object in the array, access the first element
                var userData = parsedData[0];
               $('#staticBackdropLabel').text('Update User');
	            $('#user_id').val(userData.id);
	            $('#name').val(userData.name);
	            $('#phone').val(userData.phone);
	            $('#email').val(userData.email);
	            $('#password').val(userData.password);
	            $('#staticBackdrop').modal('show');
        }
    });
}

</script>
</body>
</html>