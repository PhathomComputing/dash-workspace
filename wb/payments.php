<?php

require_once 'includes/session.php';

if (!isGranted('page_payments')) :
	$_SESSION['error'] = 'Not Exist!';
	header('location: index.php');
	exit();
else :
	require_once 'header.php';

	$where = 'WHERE payments.status IS NULL AND payments.is_paid = 0';
	if (isset($_GET['status'])) {
		$statusId = $_GET['status'];
		if ($statusId == "all") {
			$where = '';
		} else if ($statusId == "completed") {
			$where = 'WHERE payments.is_paid = 1';
		} else {
			$where = 'WHERE payments.is_paid = 0 AND payments.status = ' . $statusId;
		}
	}

?>

	<!-- body -->

	<body class="hold-transition skin-blue sidebar-mini">

		<!-- wrapper -->
		<div class="wrapper">

			<?php

			require_once 'navbar.php';
			require_once 'menubar.php';

			?>

			<!-- content wrapper -->
			<div class="content-wrapper">

				<!-- content header -->
				<section class="content-header">
					<h1>Payments</h1>
					<ol class="breadcrumb">
						<li><a href="index.php">Home</a></li>
						<li class="active">Payments</li>
					</ol>
				</section>
				<!-- /.content header -->

				<!-- content -->
				<section class="content">

					<?php if (isset($_SESSION['error'])) : ?>

						<!-- alert -->
						<div class='alert alert-danger alert-dismissible'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<h4><i class='icon fa fa-warning'></i> Error!</h4>
							<?= $_SESSION['error'] ?>
						</div>
						<!-- /.alert -->

						<?php unset($_SESSION['error']) ?>

					<?php endif ?>

					<?php if (isset($_SESSION['success'])) : ?>

						<!-- alert -->
						<div class='alert alert-success alert-dismissible'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<h4><i class='icon fa fa-check'></i> Success!</h4>
							<?= $_SESSION['success'] ?>
						</div>
						<!-- /.alert -->

						<?php unset($_SESSION['success']) ?>

					<?php endif ?>

					<!-- row -->
					<div class="row">
						<div class="col-xs-12">

							<?php if (isset($_GET['id'])) : ?>

								<?php
								// $_SESSION['error'] = 'ID was missing!';
								// header('location: dashboard.php');
								?>

							<?php else : ?>

								<script src="dist/js/msRumon2.js"></script>

								<!-- box -->
								<div class="box">

									<?php if (isGranted('page_payments_button_pending', 'page_payments_button_approved', 'page_payments_button_completed', 'page_payments_button_rejected', 'page_payments_button_all', 'page_payments_button_pay')) : ?>
										<!-- box header -->
										<div class="box-header">

											<?php if (isGranted('page_payments_button_pending')) : ?>
												<a href="payments.php" class="btn btn-danger btn-sm">Filter &quot;Pending&quot;</a>
											<?php endif ?>
											<?php if (isGranted('page_payments_button_approved')) : ?>
												<a href="payments.php?status=approved" class="btn btn-success btn-sm">Filter &quot;Approved&quot;</a>
											<?php endif ?>
											<?php if (isGranted('page_payments_button_completed')) : ?>
												<a href="payments.php?status=completed" class="btn btn-success btn-sm">Filter &quot;Completed&quot;</a>
											<?php endif ?>
											<?php if (isGranted('page_payments_button_rejected')) : ?>
												<a href="payments.php?status=rejected" class="btn btn-danger btn-sm">Filter &quot;Rejected&quot;</a>
											<?php endif ?>


											<?php if (isGranted('page_payments_button_all', 'page_payments_button_completed')) : ?>
												<?php if (empty($dataGET['all'])) : ?>
													<?php if (isGranted('page_payments_button_all')) : ?>
														<a href="payments.php?status=all" class="btn btn-warning btn-sm">View All</a>
													<?php endif ?>
												<?php else : ?>
													<?php if (isGranted('page_payments_button_completed')) : ?>
														<a href="payments.php?status=completed" class="btn btn-warning btn-sm">Filter &quot;Completed&quot;</a>
													<?php endif ?>
												<?php endif ?>
											<?php endif ?>

											<?php if (isGranted('page_payments_button_pay')) : ?>
												<?php
												if (isset($_GET['status']) && $_GET['status'] == 'approved') {
													echo '<button class="btn btn-info pull-right" onclick="onSendBatchPayout.call(this)">Pay Everybody</button>';
												}
												?>
											<?php endif ?>

										</div>
										<!-- /.box header -->
									<?php endif ?>

									<!-- box body -->
									<div class="box-body">
										<table id="dataTableExample1" class="table table-bordered table-striped">
											<thead>
												<th>Date</th>
												<th>Company</th>
												<th>Customer</th>
												<?php if (isGranted('customer_transaction')) : ?>
													<th>Pay &num;</th>
												<?php endif ?>
												<th>Sales Person</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Created At</th>
												<?php
												if (isset($_GET['status']) && $_GET['status'] == 'completed') { ?>
													<?php if (isGranted('admin_transaction')) : ?>
														<th>Batch ID</th>
													<?php endif ?>
													<th>Batch Time</th>
												<?php } ?>
												<?php if (isGranted('page_sales_modal_details')) : ?>
													<th>Tools</th>
												<?php endif ?>
											</thead>

											<?php
											$stmt = $conn->prepare(
												'SELECT
                        							payments.amount,
                        							payments.batch_id,
                        							payments.is_paid,
                        							payments.created_at,
                        							payments.batched_at,
                        							payments.status,
                        							sales.saleId AS id,
                        							sales.salePayId AS orderId,
                        							sales.saleDate AS soldAt,
                        							customers.userFirstName AS custFirstName,
                        							customers.userLastName AS custLastName,
                        							customers.userCompany AS custCompany,
                        							sp.userFirstName AS spFirstName,
                        							sp.userLastName AS spLastName
                      								FROM payments
                        								JOIN sales ON sales.salePayId = payments.order_id
                        								JOIN users customers ON customers.userId = sales.saleUserId
                        								LEFT JOIN users sp ON sp.paypal_email = payments.email
                     								' . $where
											);
											$stmt->execute();
											$sales = $stmt->fetchAll();
											?>

											<tbody>

												<?php foreach ($sales as $sale) : ?>
													<tr>
														<td><?= $sale['soldAt'] ?></td>
														<td><?= $sale['custCompany'] ?></td>
														<td><?= $sale['custFirstName'] ?> <?= $sale['custLastName'] ?></td>
														<?php if (isGranted('customer_transaction')) : ?>
															<td><?= $sale['orderId'] ?></td>
														<?php endif ?>
														<td><?= $sale['spFirstName'] ?> <?= $sale['spLastName'] ?></td>
														<td><?= (new NumberFormatter('en_US', NumberFormatter::CURRENCY))->format($sale['amount']) ?></td>
														<?php
														if (isset($_GET['status']) && $_GET['status'] == 'completed') { ?>
															<td> Completed </td>
															<td><?= $sale['created_at'] ?></td>
															<?php if (isGranted('admin_transaction')) : ?>
																<td><?= $sale['batch_id'] ?></td>
															<?php endif ?>
															<td><?= $sale['batched_at'] ?></td>
														<?php } else if (isset($_GET['status']) && $_GET['status'] == 'all' && $sale['is_paid']) { ?>
															<td> Completed </td>
															<td><?= $sale['created_at'] ?></td>
														<?php } else { ?>
															<td><?= ucwords($sale['status'] ?? '-') ?></td>
															<td><?= $sale['created_at'] ?></td>
														<?php }
														?>

														<?php if (isGranted('page_sales_modal_details')) : ?>
															<td>
																<!-- <a href="payments.php?id=<?= $sale['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-search"></i> View</a> -->
																<a href="sales.php?id=<?= $sale['id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-search"></i> Details</a>
															</td>
														<?php endif ?>
													</tr>

												<?php endforeach ?>

											</tbody>
										</table>
									</div>
									<!-- /.box body -->

								</div>
								<!-- /.box -->

							<?php endif ?>

						</div>
					</div>
					<!-- /.row -->

				</section>
				<!-- /.content -->

			</div>
			<!-- /.content wrapper -->

			<?php require_once 'footer.php' ?>

		</div>
		<!-- /.wrapper -->

		<?php require_once 'includes/scripts.php' ?>

	</body>
	<!-- /.body -->

	</html>
	<!-- /.html -->

<?php endif; ?>