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
        <title>Ngôn Ngữ </title>
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
                                    <h2>Tạo Ngôn Ngữ</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class='row'>
                                        <div class='col-md-6 col-sm-12 col-xs-12'>
                                            <form id="language_form" method="POST" action="db_operations.php" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                <input type="hidden" id="add_language" name="add_language" required="" value="1" aria-required="true">
                                                <div class="form-group">
                                                    <label for="name">Tên Ngôn Ngữ</label>
                                                    <input type="text" id="name" name="name" placeholder="Nhập Tên Ngôn Ngữ" required class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="ln_solid"></div>
                                                <div id="result"></div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <button type="submit" id="submit_btn" class="btn btn-warning">Thêm Mới</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='col-md-6 col-sm-12'>

                                        <div id="toolbar">
                                                <div class="col-md-3 col-sm-3">
                                                    <button class="btn btn-danger btn-sm" id="delete_multiple_languages" title="Xóa Ngôn Ngữ Được Chọn"><em class='fa fa-trash'></em></button>
                                                </div>                                                
                                            </div>
                                    

                                            <table aria-describedby="mydesc" class='table-striped' id='language_list'
                                                   data-toggle="table"
                                                   data-url="get-list.php?table=languages"
                                                   data-click-to-select="true"
                                                   data-side-pagination="server"
                                                   data-pagination="true"
                                                   data-page-list="[5, 10, 20, 50, 100, 200]"
                                                   data-search="true" data-show-columns="true"
                                                   data-show-refresh="true" data-trim-on-search="false"
                                                   data-sort-name="row_order" data-sort-order="asc"
                                                   data-mobile-responsive="true"
                                                   data-toolbar="#toolbar" data-show-export="false"
                                                   data-maintain-selected="true"
                                                   data-export-types='["txt","excel"]'
                                                   data-export-options='{
                                                   "fileName": "language-list-<?= date('d-m-y') ?>",
                                                   "ignoreColumn": ["state"]	
                                                   }'
                                                   data-query-params="queryParams">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" data-field="state" data-checkbox="true"></th>
                                                        <th scope="col" data-field="id" data-sortable="true">ID</th>
                                                        <th scope="col" data-field="language" data-sortable="true">Tên Ngôn Ngữ</th>
                                                        <th scope="col" data-field="status" data-sortable="true">Trạng Thái</th>
                                                        <th scope="col" data-field="operate" data-events="actionEvents">Thao Tác</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <div class="modal fade" id='editlanguageModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Chỉnh Sửa Ngôn Ngữ</h4>
                        </div>
                        <div class="modal-body">
                            <form id="update_form"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                <input type='hidden' name="update_language" id="update_language" value='1'/>
                                <input type='hidden' name="language_id" id="language_id" value=''/>
                                <div class="form-group">
                                    <label>Tên Ngôn Ngữ</label>
                                    <input type="text" name="name" id="update_name" placeholder="Tên Ngôn Ngữ" class='form-control' required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Trạng Thái</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div id="status" class="btn-group">
                                            <label class="btn btn-default">
                                                <input type="radio" name="status" value="1"> Active
                                            </label>
                                            <label class="btn btn-warning">
                                                <input type="radio" name="status" value="0"> Deactive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <button type="submit" id="update_btn" class="btn btn-success">Cập Nhật</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result"></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer content -->
            <?php include 'footer.php'; ?>
            <!-- /footer content -->
        </div>
        <!-- jQuery -->
        <script>
            $('#filter_btn').on('click', function (e) {
                $('#language_list').bootstrapTable('refresh');
            });
            $('#delete_multiple_languages').on('click', function (e) {
                sec = 'languages';
                is_image = 0;
                table = $('#language_list');
                delete_button = $('#delete_multiple_languages');
                selected = table.bootstrapTable('getAllSelections');
                // alert(selected[0].id);
                ids = "";
                $.each(selected, function (i, e) {
                    ids += e.id + ",";
                });
                ids = ids.slice(0, -1); // removes last comma character
                if (ids == "") {
                    alert("Hãy chọn một số ngôn ngữ để xóa!");
                } else {
                    if (confirm("Bạn có muốn xóa tất cả các ngôn ngữ được chọn?")) {
                        $.ajax({
                            type: 'GET',
                            url: "db_operations.php",
                            data: 'delete_multiple=1&ids=' + ids + '&sec=' + sec + '&is_image=' + is_image,
                            beforeSend: function () {
                                delete_button.html('<i class="fa fa-spinner fa-pulse"></i>');
                            },
                            success: function (result) {
                                if (result == 1) {
                                    alert("Thành công.");
                                } else {

                                    alert("Có lỗi xảy ra. Hãy thử lại!");
                                }
                                delete_button.html('<i class="fa fa-trash"></i>');
                                table.bootstrapTable('refresh');
                            }
                        });
                    }
                }
            });
        </script>
        <script>
            var $table = $('#language_list');
            $('#toolbar').find('select').change(function () {
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: $(this).val()
                });
            });
        </script>
        <script>
            window.actionEvents = {
                'click .edit-language': function (e, value, row, index) {
                    // alert('You click remove icon, row: ' + JSON.stringify(row));
                    $("input[name=status][value=1]").prop('checked', true);
                    if ($(row.status).text() == 'Disabled')
                        $("input[name=status][value=0]").prop('checked', true);
                    $('#language_id').val(row.id);
                    $('#update_name').val(row.language);
                    $('#status').val(row.status);
                }
            };
        </script>
        <script>
            $('#update_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($("#update_form").validate().form()) {
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        beforeSend: function () {
                            $('#update_btn').html('Xin Chờ..');
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            $('#update_result').html(result);
                            $('#update_result').show().delay(1000).fadeOut();
                            $('#update_btn').html('Cập Nhật');
                            $('#update_form')[0].reset();
                            $('#language_list').bootstrapTable('refresh');
                            setTimeout(function () {
                                $('#editlanguageModal').modal('hide');
                            }, 2000);
                        }
                    });
                }
            });
        </script>
        <script>
            function queryParams(p) {
                return {
                    limit: p.limit,
                    sort: p.sort,
                    order: p.order,
                    offset: p.offset,
                    search: p.search
                };
            }
        </script>
        <script>
            $('#language_form').validate({
                rules: {
                    name: "required"
                }
            });
        </script>
        <script>
            $('#language_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($("#language_form").validate().form()) {
                    if (confirm('Bạn muốn tạo ngôn ngữ mới không?')) {
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: formData,
                            beforeSend: function () {
                                $('#submit_btn').html('Xin Chờ..');
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (result) {
                                $('#result').html(result);
                                $('#result').show().delay(6000).fadeOut();
                                $('#submit_btn').html('Thêm Mới');
                                $('#language_form')[0].reset();
                                $('#language_list').bootstrapTable('refresh');
                            }
                        });
                    }
                }
            });
        </script>
        <script>
            $(document).on('click', '.delete-language', function () {
                if (confirm('Bạn muốn xóa ngôn ngữ này không?')) {
                    var id = $(this).data("id");
                    $.ajax({
                        url: 'db_operations.php',
                        type: "get",
                        data: 'id=' + id + '&delete_language=1',
                        success: function (result) {
                            if (result == 1) {
                                $('#language_list').bootstrapTable('refresh');
                            } else
                                alert('Lỗi! Ngôn ngữ này chưa được xóa.');
                        }
                    });
                }
            });
        </script>
    </body>
</html>