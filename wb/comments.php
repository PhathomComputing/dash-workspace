<?php

require_once 'includes/session.php';

if (!isGranted('page_comments')) :
  $_SESSION['error'] = 'Not Exist!';
  header('location: index.php');
  exit();
else :
  require_once 'header.php';

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
          <h1>Comments</h1>
          <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Comments</li>
          </ol>
        </section>
        <!-- /.content header -->

        <!-- content -->
        <section class="content">
            
            <aside>
              <div class="modal fade" id="response-toggle-model">
                <div class="modal-dialog">
                  <div class="modal-content">

                    <!-- modal header -->
                    <div class="modal-header">
                      <button type="button" data-dismiss="modal" class="close">
                        <span>&times;</span>
                      </button>
                      <h4 class="modal-title"></h4>
                    </div>
                    <!-- /.modal header -->

                    <!-- modal body -->
                    <div class="modal-body">
                      <div name="response-info"></div>
                      <span class="pull-right"><button class="btn btn-primary hidecmt" onClick="location.reload()">Ok</button></span>
                      <!-- form -->
                    </div>


                        

                  </div>
                </div>
              </div>
            </aside>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">

                <!-- box header -->
                <div class="box-header with-border">
                  <div class="pull-right">
                  </div>
                </div>
                <!-- /.box header -->

                <!-- box body -->
                <script>
                  async function onHideComment() {
                    const form = new FormData();

                    form.append('action', 'hide');
                    form.append('cmtID', this.parent.value);
                    await fetch('includes/comments__CRUD.php', {
                      method: 'POST',
                      body: form
                    });

                    //alert('Comment Marked Hidden.');
                    document.querySelector('[name="response-info"]').innerHTML = `<h2>Comment Marked Hidden.</h2>`; 
                    
                  }

                  async function onShowComment() {
                    const form = new FormData();

                    form.append('action', 'show');
                    form.append('cmtID', this.value);

                    await fetch('includes/comments__CRUD.php', {
                      method: 'POST',
                      body: form
                    });

                    alert('Comment Marked Visible.');
                    location.reload();
                  }

                  async function onDeleteComment() {
                    const ans = confirm("Are you sure to delete this comment?");
                    if (ans) {
                      const form = new FormData();

                      form.append('action', 'delete');
                      form.append('cmtID', this.value);

                      await fetch('includes/comments__CRUD.php', {
                        method: 'POST',
                        body: form
                      });

                      alert('Comment removed.');
                      location.reload();
                    }
                  }
                </script>

                <div class="box-body">
                  <table id="dataTableExample1" class="table table-bordered table-striped">
                    <thead>
                      <th>Status</th>
                      <th>Product</th>
                      <th>Comment</th>
                      <th>Rating</th>
                      <th>User</th>
                      <th>Timestamp</th>
                      <?php if (isGranted('page_comments_modal_hide', 'page_comments_modal_show', 'page_comments_modal_delete')) : ?>
                        <th>Action</th>
                      <?php endif ?>
                    </thead>
                    <tbody>

                      <?php
                      try {
                        $stmt = $conn->prepare("SELECT product_comments.*,users.userEmail,products.productName FROM product_comments left join products on products.productId = product_comments.product_id left join users on users.userID = product_comments.user_id;");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                      ?>

                          <tr>
                            <td>
                              <?php if ($row['status'] == 1) : ?>
                                <p><span style='color:green'>Published</span></p>
                              <?php else : ?>
                                <p><strong>In-Active</strong></p>
                              <?php endif ?>
                            </td>

                            <td><?= $row['productName'] ?></td>
                            <td><?= $row['comment'] ?></td>
                            <td><?= ($row['rating'] > 1) ? $row['rating'] . ' Stars' : $row['rating'] . ' Star' ?></td>
                            <td><?= $row['userEmail'] ?></td>
                            <td><?= (new DateTimeImmutable($row['created_at'], new DateTimeZone($_COOKIE['tz'] ?? 'UTC')))->format('D, j M Y H:i:s') ?></td>
                            <?php if (isGranted('page_comments_modal_hide', 'page_comments_modal_show', 'page_comments_modal_delete')) : ?>
                              <td>


                                <?php if (isGranted('page_comments_modal_hide', 'page_comments_modal_show')) : ?>
                                  <?php if ($row['status'] == 1) : ?>
                                    <?php if (isGranted('page_comments_modal_hide')) : ?>
                                      <span class="pull-right"><button class="btn btn-primary hidecmt" value="" onclick="onHideComment.call(this)" data-toggle="modal" data-target="#response-toggle-model"><i class="fa fa-edit"></i> Hide M</button></span>

                                      <button class="btn btn-primary hidecmt" value="<?= $row['id'] ?>" onclick="onHideComment.call(this)">Hide</button>
                                    <?php endif ?>
                                  <?php else : ?>
                                    <?php if (isGranted('page_comments_modal_show')) : ?>
                                      <button class="btn btn-primary showcmt" value="<?= $row['id'] ?>" onclick="onShowComment.call(this)">Show</button>
                                    <?php endif ?>
                                  <?php endif ?>
                                <?php endif ?>

                                <?php if (isGranted('page_comments_modal_delete')) : ?>
                                  <button class='btn btn-danger delcmt' value="<?= $row['id'] ?>" onclick="onDeleteComment.call(this)">Delete</button>
                                <?php endif ?>

                              </td>
                            <?php endif ?>
                          </tr>

                      <?php
                        }
                      } catch (\PDOException $e) {
                        $_ = sprintf(
                          '[%s] Error at line %s in %s: \'%s\'',
                          (new DateTimeImmutable())->format(DateTimeImmutable::ATOM),
                          $e->getLine(),
                          $e->getFile(),
                          $e->getMessage()
                        );
                        file_put_contents('logs', $_ . PHP_EOL, FILE_APPEND);
                        echo 'Something went wrong!';
                      }
                      ?>

                    </tbody>
                  </table>
                </div>
                <!-- /.box body -->

              </div>
            </div>
          </div>
        </section>
        <!-- /.content -->

      </div>
      <!-- /.content wrapper -->

      <?php require_once 'footer.php'; ?>

    </div>
    <!-- /.wrapper -->

    <?php require_once 'includes/scripts.php'; ?>

    <!-- script -->
    <script>
      $(function() {
        //Date picker
        $('#datepicker_add').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        })
        $('#datepicker_edit').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        })

        //Timepicker
        $('.timepicker').timepicker({
          showInputs: false
        })

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          format: 'MM/DD/YYYY h:mm A'
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
          },
          function(start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        )

      });

      $(function() {
        $(document).on('click', '.transactionAdmin', function(e) {
          e.preventDefault();
          $('#adminTransaction').modal('show');
          var saleId = $(this).data('id');
          $.ajax({
            type: 'POST',
            url: 'user_transaction.php',
            data: {
              saleId: saleId
            },
            dataType: 'json',
            success: function(response) {
              $('#date').html(response.date);
              $('#transactionAdminId').html(response.adminTransaction);
              $('#detail').prepend(response.list);
              $('#total').html(response.total);
            }
          });
        });

        $("#adminTransaction").on("hidden.bs.modal", function() {
          $('.prepend_items').remove();
        });
      });
    </script>
    <!-- /.script -->

  </body>
  <!-- /.body -->

  </html>
  <!-- /.html -->

<?php endif ?>