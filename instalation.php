<?php
// set session
session_start();
ob_start(); 
if (is_null($_SESSION['instalation'])) {
	header("Location: index");
}elseif($_GET['step'] !== $_SESSION['instalation']){
	header("Location: index");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dipolling Instalation (<?php echo $_SESSION['instalation']; ?>)</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/dipolling.css">
	<link rel="icon" href="assets/img/mg/dipolling.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
	<div class="d-flex justify-content-center align-items-center">
		<div class="dip-instalation p-4 mt-3 mb-3">
			<div class="dip-brand text-secondary fs-1 text-center mb-4">
				Dipolling
			</div>
			<div class="card p-5 w-100">
			<!-- (kondisi pertama) -->
			<?php if (isset($_GET['step'])): ?>
				<!-- start Step (kondisi kedua)-->
				<?php
				//cek session dan get step database
				if ($_SESSION['instalation'] === 'database' && $_GET['step'] === 'database'): ?>
					<?php
						if (isset($_POST['submit_database'])) {
							$host = $_POST['host_name'];
							$database_name = $_POST['database_name'];
							$database_username = $_POST['database_username'];
							$database_password = $_POST['database_password'];
							$myfile = fopen("core/config.php", "w");
$txt = "<?php
$"."db_host_name = '$host';
$"."db_username = '$database_username';
$"."db_password = '$database_password';
$"."db_name = '$database_name';
?>";
							fwrite($myfile, $txt);
							fclose($myfile);
							require 'core/server.php';
							$conn = mysqli_connect($db_host_name, $db_username, $db_password, $db_name);

							// Buat tabel: list_table
							$query_list_table = 'CREATE TABLE list_table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(150), polvote INT, polling_active INT(5))';

							mysqli_query($conn, $query_list_table);

							// Buat tabel: dipolling_users
							$query_dipolling_users = 'CREATE TABLE dipolling_users (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(150), name VARCHAR(255), username VARCHAR(255), password VARCHAR(355))';

							mysqli_query($conn, $query_dipolling_users);

							// Buat tabel: dipolling_settings
							$query_dipolling_settings = 'CREATE TABLE dipolling_settings (settings_profile VARCHAR(255) PRIMARY KEY, site_name VARCHAR(255), site_icon VARCHAR(255), site_smtp VARCHAR(255), site_poll_icon VARCHAR(355), site_hide_login INT(5), site_maintenance INT(5))';
							session_start();
							mysqli_query($conn, $query_dipolling_settings);
							$_SESSION['instalation'] = 'account';
							header("Location: instalation?step=account");
						}
					?>
					<!-- Database Account -->
					<h2 class="text-center">Welcome!</h2>
					<p class="text-secondary mb-5 text-center">This is Dipolling instalation</p>
					<form action="" method="post">

						<!-- Host Name -->
						<label for="#hostName" class="control-label mb-2">Host Name <small class="text-secondary">default: localhost</small></label>
						<input type="text" name="host_name" class="form-control mb-3" placeholder="Database Name" id="hostName" value="localhost" required>

						<!-- Database name -->
						<label for="#databaseName" class="control-label mb-2">Database Name</label>
						<input type="text" name="database_name" class="form-control mb-3" placeholder="Database Name" id="databaseName" required>

						<!-- Database Account -->
						<label for="#databaseAccount" class="control-label">Database Account</label>
						<div class="input-group" id="databaseAccount">
							<input type="text" name="database_username" class="form-control mb-3" placeholder="Database Username" required>
							<input type="password" name="database_password" class="form-control mb-3" placeholder="Database Password">
						</div>
						<small class="text-center text-secondary d-block">Jika menggunakan xampp default password <br>adalah kosong (kolom password tidak perlu di isi)</small>

						<!-- Submit Database -->
						<button type="submit" name="submit_database" class="btn btn-primary w-100 mt-4">Connect Database</button>
					</form>
				<?php
				//cek session dan get step account
				elseif( $_SESSION['instalation'] === 'account' && $_GET['step'] === 'account'): ?>
					<?php if(isset($_POST['submit_account'])){
							require 'core/server.php';
							if (is_null($dipolling->addUserInstall($_POST))) {
								session_start();
								$_SESSION['instalation'] = 'settings';
								header("Location: instalation?step=settings");
							}else{
								echo $notify->showNotify(false, "Tambah akun gagal");
							}
					} ?>

					<!-- Account -->
					<h2 class="text-center">Set your Account!</h2>
					<p class="text-secondary mb-4 text-center">This account used for login to Dipolling dashboard</p>
					<form action="" method="post">

						<!-- Name Account -->
						<label for="#name" class="control-label mb-2">Name</label>
						<input type="text" name="name_account" class="form-control mb-3" placeholder="Name Account" id="name">

						<!-- Email Account -->
						<label for="#email" class="control-label mb-2">Email</label>
						<input type="text" name="email_account" class="form-control mb-3" placeholder="Email address" id="email">

						<!-- Basic Account -->
						<label for="#basic_account" class="control-label mb-2">Username & Password</label>
						<div class="input-group" id="basic_account">
							<input type="text" name="username_account" class="form-control mb-3" placeholder=" Username">
							<input type="password" name="password_account" class="form-control mb-3" placeholder="Password">
						</div>

						<!-- Submit Account -->
						<button type="submit" name="submit_account" class="btn btn-primary w-100">Create Account</button>
					</form>
				<?php
				//cek session dan get step account
				elseif( $_SESSION['instalation'] === 'settings' && $_GET['step'] === 'settings'): ?>
					<?php if(isset($_POST['submit_settings'])){
						require 'core/server.php';
						$dipMediaFotoExtension = ['jpg', 'png', 'jpeg'];

						$media = new dipollingMedia($_FILES, 'assets/img/', $dipMediaFotoExtension, 5000000);

						if ($img = $media->addMedia('img')) {
							if (is_null($dipolling->addSettings($_POST, $img))) {
								$instalation_success = true;
							}else{
								echo $notify->showNotify(false, "Tambah settings gagal");
							}
						}
					} ?>
					<?php if (isset($instalation_success)): ?>
					<div class="text-center">
						<i class="bi bi-check-circle fw-bold fs-1 text-success"></i>
						<span class="fs-4 fw-bold d-block mt-2">Instalation Successful!</span>
						<small class="text-secondary mb-4 d-block">
							Thank you for using Dipolling
						</small>
						<a href="login" class="btn btn-primary w-100">Let's Make Some Polling</a>
					</div>
					<?php else: ?>
					<!-- Site Settings -->
					<h2 class="text-center">Site Settings</h2>
					<p class="text-secondary mb-4 text-center">This settings can be changed on dashboard</p>
					<form action="" method="post" enctype="multipart/form-data">

						<!-- Site Name -->
						<label for="#siteName" class="control-label mb-2">Site Name</label>
						<input type="text" name="site_name" class="form-control mb-3" placeholder="Site Name" id="siteName">
						
						<!-- Site Icon -->
						<label for="#siteIcon" class="control-label mb-2">Site Icon</label>
						<input type="file" name="polimg" class="form-control mb-3" placeholder="Site Icon" id="siteIcon">

						<!-- API SMTP -->
						<label for="#apiSMTP" class="control-label mb-2">API SMTP</label>
						<input type="text" name="site_smtp" class="form-control" placeholder="API SMTP (Dalam pengembangan)" id="apiSMTP" disabled>
						<small>
							<i class="text-secondary">
								<span class="text-danger">*</span>
								Fitur ini belum tersedia
							</i>
						</small>

						<!-- Submit Settings -->
						<button type="submit" name="submit_settings" class="btn btn-primary w-100 mt-3">Install</button>
					</form>
					<?php endif; ?>
				<?php
				// Ketika semua kondisi false maka diasumsikan koneksi database error
				elseif($_SESSION['instalation'] == 'error' && $_GET['step'] == 'error'): ?>
					<h3 class="fw-bold">Error Database Connection</h3>
					<p class="text-secondary">Please check your database configuration</p>
					<?php 
			        $_SESSION = [];
			        session_unset();
			        session_destroy();
					?>
				<!-- End step (kondisi kedua)-->
				<?php endif; ?>

			<?php
			// cek kondisi (kondisi pertama) get step apakah terdaftar atau tidak
			elseif($_GET['step'] !== 'database' || $_GET['step'] !== 'account' || $_GET['step'] !== 'settings' || $_GET['step'] !== 'error'): ?>
				<?php if (isset($_SESSION['instalation'])): ?>
					<?php header("Location: instalation?step=" . $_SESSION['instalation']); ?>
				<?php else: ?>
					<?php header("Location: index"); ?>
				<?php endif; ?>

			<?php else: ?>
				<?php header("Location: index"); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>

<!-- Internal Javascript -->
<script src="../assets/js/dipolling.js"></script>

<?php ob_flush(); ?>
</body>
</html>