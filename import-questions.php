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
        <title>Nhập Câu Hỏi </title>
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
                                    <h2>Nhập Câu Hỏi <small>Tải lên bằng tệp CSV</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form id="register_form"  method="POST" action ="db_operations.php"data-parsley-validate class="form-horizontal form-label-left">
                                        <input type="hidden" id="import_questions" name="import_questions" required value='1'/>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="questions_file">Tệp Câu Hỏi CSV</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="file" name="questions_file" id="questions_file" required class="form-control col-md-7 col-xs-12" accept=".csv" />
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" id="submit_btn" class="btn btn-success">Tải Lên Tệp CSV</button>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <a class='btn btn-warning' href='library/data-format.csv' target="_blank"> <em class='fas fa-download'></em> Tải Xuống Tệp Mẫu Tại Đây</a>
                                            </div>
                                        </div>
                                    </form>                                 
                                </div>
                                <div class="row">
                                    <div  class="col-md-offset-3 col-md-4" style ="display:none;" id="result">
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 class="text-danger">Cách Điền File Câu Hỏi Từ Mẫu Tải Xuống</h2>
                                    <div class="clearfix"></div>
                                </div>                                
                                <p>1. Cột A: ID Danh mục.<p>
                                <p>2. Cột B: ID Danh mục con.</p>
                                <p>3. Cột C: ID Ngôn Ngữ.</p>
                                <p>4. Cột D: Loại câu hỏi <b>( 1:Câu hỏi nhiều lựa chọn, 2: Dạng đúng sai )</b>.</p>
                                <p>5. Cột E: Câu hỏi.</p>
                                <p>6. Cột F->J: Các phương án để chọn<b>( Nếu dạng câu hỏi đúng sai thì bỏ trống cột H->J)</b></p>
                                <p>7. Cột K: Đáp án</p>
                                <p>8. Cột L: Level câu hỏi (không bắt buộc)</p>
                                <p>9. Cột M: Ghi chú < nếu có ></p>
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

        <!-- jQuery -->
        <script>
            $('#register_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
//                if ($("#register_form").validate().form()) {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    beforeSend: function () {
                        $('#submit_btn').html('Đang tải lên..');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        $('#result').html(result);
                        $('#result').show().delay(6000).fadeOut();
                        $('#submit_btn').html('Tải Lên Tệp CSV');
                        $('#questions_file').val('');
                    }
                });
//                }
            });
        </script>
    </body>
</html>