<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("location:index.php");
    return false;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Điều Khoản Dịch Vụ </title>
        <?php include 'include-css.php'; ?>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php include 'sidebar.php'; ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <br />
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Điều Khoản Dịch Vụ <small> Cập nhật / Thay đổi</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <?php
                                    $db->sql("SET NAMES 'utf8'");
                                    $sql = "select * from `settings` where type='update_terms'";
                                    $db->sql($sql);
                                    $res = $db->getResult();
                                    $data1 = $res[0];
                                    ?>
                                    <div class="col-md-12"><hr style="margin-top: 5px;"></div>
                                    <form id="terms_form"  method="POST" action ="db_operations.php"data-parsley-validate class="form-horizontal form-label-left">
                                        <input type="hidden" id="update_terms" name="update_terms" required value='1'/>
                                        <div class="form-group">
                                            <label class="control-label col-md-2" for="message">Điều Khoản Dịch Vụ</label>
                                            <div class="col-md-9">
                                                <textarea name='message' id='terms' class='form-control' ><?= $data1['message']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" id="submit_privacy_btn" class="btn btn-success">Cập Nhật</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div  class="col-md-offset-3 col-md-4" style ="display:none;" id="privacy_result">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                <?php include 'footer.php'; ?>
                <!-- /footer content -->
            </div>
        </div>
        <!-- jQuery -->
        <script>
            tinymce.init({
                selector: '#terms',
                height: 400,
                menubar: true,
                plugins: [
                    'advlist autolink lists link charmap print preview anchor textcolor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime table contextmenu paste code help wordcount'
                ],
                toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                setup: function (editor) {
                    editor.on("change keyup", function (e) {
                        //tinyMCE.triggerSave(); // updates all instances
                        editor.save(); // updates this instance's textarea
                        $(editor.getElement()).trigger('change'); // for garlic to detect change
                    });
                }
            });
        </script>
        <script>
            $('#terms_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($("#terms_form").validate().form()) {
                    if (confirm('Bạn muốn cập nhật Điều Khoản Dịch Vụ không ? Điều này sẽ thay đổi trực tiếp lên ứng dụng người dùng.')) {
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: formData,
                            beforeSend: function () {
                                $('#submit_privacy_btn').html('Đang cập nhật..');
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (result) {
                                $('#privacy_result').html(result);
                                $('#privacy_result').show().delay(3000).fadeOut();
                                $('#submit_privacy_btn').html('Cập Nhật');
                                // $('#register_form')[0].reset();
                            }
                        });
                    }
                }
            });
        </script>
    </body>
</html>