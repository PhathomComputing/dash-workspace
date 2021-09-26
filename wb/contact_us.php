<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'vendor/autoload.php';
require_once 'includes/session_customer.php';
require_once 'includes/header_customer.php';

?>

<!-- body -->

<body class="hold-transition skin-blue layout-top-nav">
	<script>
		let stateObj = {
			foo: "contact",
		}

		history.pushState(stateObj, "Contact Us", "contact_us"); 	
	</script>
	<!-- wrapper -->
	<div class="wrapper">

		<?php require_once 'includes/navbar_customer.php'; ?>

		<!-- content wrapper -->
		<div class="content-wrapper">
			<div class="container">
				<section class="content">
					<div class="row">
						<div class="col-sm-12">

							<!-- h1 -->
							<h1>
								Contact Us
							</h1>
							<!-- /.h1 -->

							<!-- row -->
							<div class="row">
								<div class="box box-solid">

									<!-- box header -->
									<div class="box-header with-border">
										<h3 class="box-title">
											<strong>
												Our Office
											</strong>
										</h3>
									</div>
									<!-- /.box header -->

									<!-- box body -->
									<div class="box-body">

										<!-- iframe -->
										<iframe src="<?= getVal('store_map_location') ?>" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen aria-hidden="false" tabindex="0"></iframe>
										<!-- /.iframe -->

										<!-- col sm 3 -->
										<div class="col-sm-3">
											<p>

												<!-- strong -->
												<strong>
													<?= getVal('store_name') ?>
												</strong>
												<!-- /.strong -->

												<br>

												<?= getVal('store_address') ?>

											</p>
										</div>
										<!-- /.col sm 3 -->

										<!-- col sm 3 -->
										<div class="col-sm-3">
											<p>

												<!-- strong -->
												<strong>
													Phone:
												</strong>
												<!-- /.strong -->

												<?php
												$numbers = explode(',', getVal('store_phones'));
												$number = null;
												foreach ($numbers as $number) { ?>

													<br>

													<?= $number ?>

												<?php } ?>

											</p>
										</div>
										<!-- /.col sm 3 -->

										<!-- col sm 3 -->
										<div class="col-sm-3">
											<p>

												<!-- strong -->
												<strong>
													Opening Hours:
												</strong>
												<!-- /.strong -->

												<br>

												<?= getVal('store_hours') ?>

											</p>
										</div>
										<!-- /.col sm 3 -->

										<!-- col sm 3 -->
										<div class="col-sm-3">
											<p>

												<!-- strong -->
												<strong>
													Notes:
												</strong>
												<!-- /.strong -->

												<br>

												<?= getVal('store_message') ?>

											</p>
										</div>
										<!-- /.col sm 3 -->

									</div>
									<!-- /.box body -->

									<!-- box header -->
									<div class="box-header with-border">
										<h3 class="box-title">
											<strong>
												Message
											</strong>
										</h3>
									</div>
									<!-- /.box header -->

									<!-- box body -->
									<div class="box-body">

										<?php if (isset($_POST['send'])) :
											//image process
											$error = '';
											if (!empty($_FILES['contactFile']['name'])) {
												$uploadDir = "/tmp/";
												$file = $uploadDir . basename($_FILES['contactFile']['name']);
												$uploadStat = 1;
												$fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

												$check = getimagesize($_FILES['contactFile']['tmp_name']);
												if ($check !== false) {
													if ($_FILES['contactFile']['size'] < 10000000) {
														if (
															$fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'png' || $fileType == 'pdf' || $fileType == 'docx' || $fileType == 'zip' || $fileType == 'gz' || $fileType == 'tar'
														) {

															//process upload
															if (move_uploaded_file($_FILES['contactFile']['tmp_name'], $file)) {
																$uploadStat = 1;
																$uploadFile = basename($_FILES['contactFile']['name']);
															} else {
																$uploadStat = 0;
																$error = '<strong>Server error uploading file.</strong>';
																// echo '
																// <div class="alert alert-error">
																// 	<strong>Error uploading file.</strong> Contact the web master.
																// </div>
																// ';
																//echo "Error uploading file. ".$file." | ".$uploadDir." | ".$_FILES['contactFile']['size'];
															}
														} else {
															$uploadStat = 0;
															//echo "Error file invalid format.";
															$error = '<strong>File improper format.</strong>';

															// echo '
															// 	<div class="alert alert-error">
															// 		<strong>Error file invalid format.</strong> Please select an image file.
															// 	</div>
															// ';
														}
													} else {
														$uploadStat = 0;
														$error = '<strong>File size too large.</strong>';

														// echo '
														// <div class="alert alert-error">
														// 	<strong>File size too large.</strong> Please check size and try again.
														// </div>
														// ';
														//echo "Error file too large. File: ".$file."|".$uploadDir."|".$_FILES['contactFile']['size'];
													}
												} else {
													$uploadStat = 0;
													$error = '<strong>File type not supported.</strong>';

													// echo '
													// 	<div class="alert alert-error">
													// 		<strong>Error file supplied is not image.</strong> Please select an image file.
													// 	</div>
													// 	';
													//echo "Error file supplied is not image.";
												}
											}

											$mail = new PHPMailer(true);
											$mail->isSMTP();
											$mail->SMTPAuth = true;
											$mail->Host = getVal('mail_host');
											$mail->Username = getVal('mail_username');
											$mail->Password = getVal('mail_password');
											$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
											$mail->Port = getVal('mail_server_port');

											$mail->setFrom(getVal('mail_from'));

											$mail->addAddress(getVal('mail_from'));
											$mail->addAddress($_POST['youremail']);
											$mail->addReplyTo(getVal('mail_from'));

											$mail->isHTML(true);
											$mail->Subject = 'Contact Query';
											$mail->Body = "
												Name : {$_POST['yourname']} |
												Email : {$_POST['youremail']} |
												Message : {$_POST['yourMessage']}
											";

											if (isset($uploadFile)) {
												$mail->addAttachment($uploadDir . $uploadFile);
											}
											try {
												$mail->send();

												if($error != ''){
													echo '<div class="alert alert-error">';
													echo $error." You can try to upload again, the message has been sent.</div>";
												}else{
													echo '
													<div class="alert alert-success">
														<strong>Query sent</strong> Our staff will contact you soon. A copy of the message has been automatically sent to you.
													</div>
													';

												}
												?>

												<!-- alert -->

												<!-- /.alert -->

											<?php } catch (Exception $e) {
												$_ = sprintf(
													'[%s] Error at line %s in %s: \'%s\'',
													(new DateTimeImmutable())->format(DateTimeImmutable::ATOM),
													$e->getLine(),
													$e->getFile(),
													$e->getMessage()
												);
												file_put_contents('logs', $_ . PHP_EOL, FILE_APPEND); ?>

												<!-- alert -->
												<div class="alert alert-danger">
													Something went wrong sending emails!
												</div>
												<!-- /.alert -->

										<?php }
										endif ?>

										<!-- form -->
										<form class="form-horizontal" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

											<!-- form group -->
											<div class="form-group">

												<!-- col sm 3 -->
												<label for="yourname" class="col-sm-3 control-label label--required">
													Name:
												</label>
												<!-- /.col sm 3 -->

												<!-- col sm 9 -->
												<div class="col-sm-9">
													<input type="text" class="form-control" id="yourname" name="yourname" required>
												</div>
												<!-- /.col sm 9 -->

											</div>
											<!-- /.form group -->

											<!-- form group -->
											<div class="form-group">

												<!-- col sm 3 -->
												<label for="youremail" class="col-sm-3 control-label label--required">
													Email:
												</label>
												<!-- /.col sm 3 -->

												<!-- col sm 9 -->
												<div class="col-sm-9">
													<input type="text" class="form-control" id="youremail" name="youremail" required>
												</div>
												<!-- /.col sm 9 -->

											</div>
											<!-- /.form group -->

											<!-- form group -->
											<div class="form-group">

												<!-- col sm 3 -->
												<label for="yourMessage" class="col-sm-3 control-label label--required">
													Message:
												</label>
												<!-- /.col sm 3 -->

												<!-- col sm 9 -->
												<div class="col-sm-9">
													<textarea class="form-control" id="yourMessage" name="yourMessage" rows="10" cols="80" required></textarea>
												</div>
												<!-- /.col sm 9 -->

											</div>
											<!-- /.form group -->

											<!-- form group -->
											<div class="form-group">

												<!-- col sm 3 -->
												<label for="contactFile" class="col-sm-3 control-label">
													Attachment:
												</label>
												<!-- /.col sm 3 -->

												<!-- col sm 9 -->
												<div class="col-sm-9">
													<input type="file" id="contactFile" name="contactFile">
												</div>
												<!-- /.col sm 9 -->

											</div>
											<!-- /.form group -->

											<!-- footer -->
											<div class="footer">
												<button type="submit" class="btn btn-primary pull-right" name="send">
													Send
												</button>
											</div>
											<!-- /.footer -->

										</form>
										<!-- /.form -->

									</div>
									<!-- /.box body -->

								</div>
							</div>
							<!-- /.row -->

						</div>
					</div>
				</section>
			</div>
		</div>
		<!-- /.content wrapper -->

	</div>
	<!-- /.wrapper -->

	<?php require_once 'includes/footer_customer.php'; ?>

	<?php require_once 'includes/scripts_customer.php'; ?>

	

</body>
<!-- /.body -->

</html>
<!-- /.html -->