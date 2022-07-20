<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("location:index.php");
    return false;
    exit();
}
$type = '2';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tạo & Quản Lý Learning Zoom </title>
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
                                    <h2>Tạo Chủ Đề</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class='row'>
                                        <div class='col-md-12 col-sm-12'>
                                            <form id="category_form" method="POST" action="db_operations.php" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                <input type="hidden" id="add_category" name="add_category" required="" value="1" aria-required="true">
                                                <input type="hidden" name="type" value="<?= $type ?>" required>
                                                <?php if ($fn->is_language_mode_enabled()) { ?>
                                                    <div class="form-group row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <?php
                                                            $db->sql("SET NAMES 'utf8'");
                                                            $sql = "SELECT * FROM `languages` ORDER BY id DESC";
                                                            $db->sql($sql);
                                                            $languages = $db->getResult();
                                                            ?>
                                                            <label for="language">Ngôn Ngữ</label>
                                                            <select id="language_id" name="language_id" required class="form-control">
                                                                <option value="">Chọn Ngôn Ngữ</option>
                                                                <?php foreach ($languages as $language) { ?>
                                                                    <option value='<?= $language['id'] ?>'><?= $language['language'] ?></option>
                                                                <?php } ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <label for="name">Tên Chủ Đề</label>
                                                        <input type="text" id="name" name="name" required class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <label for="image">Ảnh</label>
                                                        <input type='file' name="image" id="image" class="form-control">
                                                    </div>

                                                </div>

                                                <div class="ln_solid"></div>
                                                <div id="result"></div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <button type="submit" id="submit_btn" class="btn btn-warning">Thêm Mới</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-md-12"><hr></div>
                                        </div>                                       
                                    </div>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <h2>Chủ Đề <small>Xem / Cập nhật / Xoá</small></h2>
                                            <?php if ($fn->is_language_mode_enabled()) { ?>
                                                <div class='col-md-4'>
                                                    <select id='filter_language' class='form-control' required>
                                                        <option value="">Chọn Ngôn Ngữ</option>
                                                        <?php foreach ($languages as $language) { ?>
                                                            <option value='<?= $language['id'] ?>'><?= $language['language'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <button class='btn btn-primary btn-block' id='filter_btn'>Lọc</button>
                                                </div>
                                            <?php } ?>
                                            <div class='col-md-12'><hr></div>
                                        </div>
                                        <div class='col-md-12 col-sm-12'>
                                            <?php
                                            $sql = "SELECT * FROM `languages` ORDER BY id DESC";
                                            $db->sql($sql);
                                            $languages = $db->getResult();
                                            ?>

                                            <div class='row'>
                                                <div id="toolbar">
                                                    <button class="btn btn-danger btn-sm" id="delete_multiple_categories" title="Delete Selected Categories"><em class='fa fa-trash'></em></button>
                                                </div> 

                                                <table aria-describedby="mydesc" class='table-striped' id='category_list'
                                                       data-toggle="table" data-url="get-list.php?table=category"
                                                       data-click-to-select="true" data-side-pagination="server"
                                                       data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                                       data-search="true" data-show-columns="true"
                                                       data-show-refresh="true" data-trim-on-search="false"
                                                       data-sort-name="row_order" data-sort-order="asc"
                                                       data-toolbar="#toolbar" data-mobile-responsive="true" data-maintain-selected="true"    
                                                       data-show-export="false" data-export-types='["txt","excel"]'
                                                       data-export-options='{
                                                       "fileName": "category-list-<?= date('d-m-y') ?>",
                                                       "ignoreColumn": ["state"]	
                                                       }'
                                                       data-query-params="queryParams">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" data-field="state" data-checkbox="true"></th>
                                                            <th scope="col" data-field="id" data-sortable="true">ID</th>
                                                            <?php if ($fn->is_language_mode_enabled()) { ?>
                                                                <th scope="col" data-field="language_id" data-sortable="true" data-visible="false">ID Ngôn Ngữ</th>
                                                                <th scope="col" data-field="language" data-sortable="true">Ngôn Ngữ</th>
                                                            <?php } ?>
                                                            <th scope="col" data-field="category_name" data-sortable="true">Tên Chủ Đề</th>
                                                            <th scope="col" data-field="image" data-sortable="false">Ảnh</th>
                                                            <th scope="col" data-field="operate" data-events="actionEvents">Thao tác</th>
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
            </div>
            <!-- /page content -->
            <div class="modal fade" id='editCategoryModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Chỉnh Sửa Chủ Đề</h4>
                        </div>
                        <div class="modal-body">
                            <form id="update_form"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                <input type='hidden' name="update_category" id="update_category" value='1'/>
                                <input type="hidden" name="type" value="<?= $type ?>" required>
                                <input type='hidden' name="category_id" id="category_id" value=''/>
                                <input type='hidden' name="image_url" id="image_url" value=''/>
                                <?php if ($fn->is_language_mode_enabled()) { ?>
                                    <div class="form-group">
                                        <label class="" for="name">Ngôn Ngữ</label>
                                        <select id="update_language_id" name="language_id" required class="form-control">
                                            <option value="">Chọn Ngôn Ngữ</option>
                                            <?php foreach ($languages as $language) { ?>
                                                <option value='<?= $language['id'] ?>'><?= $language['language'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="name">Tên Chủ Đề</label>
                                    <input type="text" name="name" id="update_name" placeholder="Category Name" class='form-control' required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Ảnh</label>
                                    <input type="file" name="image" id="update_image" class="form-control" aria-required="true">
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
                $('#category_list').bootstrapTable('refresh');
            });
            $('#delete_multiple_categories').on('click', function (e) {
                sec = 'category';
                is_image = 1;
                table = $('#category_list');
                delete_button = $('#delete_multiple_categories');
                selected = table.bootstrapTable('getAllSelections');

                ids = "";
                $.each(selected, function (i, e) {
                    ids += e.id + ",";
                });
                ids = ids.slice(0, -1); // removes last comma character

                if (ids == "") {
                    alert("Chọn một số chủ đề để xóa!!");
                } else {
                    if (confirm("Bạn có muốn xóa tất cả chủ đề được chọn?")) {
                        $.ajax({
                            type: 'GET',
                            url: "db_operations.php",
                            data: 'delete_multiple=1&ids=' + ids + '&sec=' + sec + '&is_image=' + is_image,
                            beforeSend: function () {
                                delete_button.html('<i class="fa fa-spinner fa-pulse"></i>');
                            },
                            success: function (result) {
                                if (result == 1) {
                                    alert("Xóa Thành Công.");
                                } else {
                                    alert("Không thể xóa. Hãy thử lại!");
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
            var $table = $('#category_list');
            $('#toolbar').find('select').change(function () {
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: $(this).val()
                });
            });
        </script>

        <script>
            window.actionEvents = {
                'click .edit-category': function (e, value, row, index) {
                    // alert('You click remove icon, row: ' + JSON.stringify(row));
                    var regex = /<img.*?src="(.*?)"/;
                    var src = regex.exec(row.image)[1];
<?php if ($fn->is_language_mode_enabled()) { ?>
                        $('#update_language_id').val(row.language_id);
<?php } ?>
                    $('#category_id').val(row.id);
                    $('#update_name').val(row.category_name);
                    $('#image_url').val(src);
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
                            $('#update_btn').html('Xin chờ...');
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            $('#update_result').html(result);
                            $('#update_result').show().delay(2000).fadeOut();
                            $('#update_btn').html('Cập Nhật');
                            $('#update_image').val('');
                            // $('#update_form')[0].reset();
                            $('#category_list').bootstrapTable('refresh');
                            setTimeout(function () {
                                $('#editCategoryModal').modal('hide');
                            }, 3000);
                        }
                    });
                }
            });
        </script>
        <script>
            function queryParams(p) {
                return {
                    "language": $('#filter_language').val(),
                    type:<?= $type ?>,
                    limit: p.limit,
                    sort: p.sort,
                    order: p.order,
                    offset: p.offset,
                    search: p.search
                };
            }
        </script>
        <script>
            $('#category_form').validate({
                rules: {
                    name: "required"
                }
            });
        </script>
        <script>
            $('#category_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($("#category_form").validate().form()) {
                    if (confirm('Bạn có muốn tạo chủ đề mới không?')) {
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: formData,
                            beforeSend: function () {
                                $('#submit_btn').html('Xin chờ...');
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (result) {
                                $('#result').html(result);
                                $('#result').show().delay(4000).fadeOut();
                                $('#submit_btn').html('Thêm Mới');
                                $('#category_form')[0].reset();
                                $('#category_list').bootstrapTable('refresh');
                            }
                        });
                    }
                }
            });
        </script>
        <script>
            $(document).on('click', '.delete-category', function () {
                if (confirm('Bạn muốn xóa chủ đề? Tất cả các dữ liệu liên quan cũng sẽ bị xóa.')) {
                    id = $(this).data("id");
                    image = $(this).data("image");
                    $.ajax({
                        url: 'db_operations.php',
                        type: "get",
                        data: 'id=' + id + '&image=' + image + '&delete_category=1',
                        success: function (result) {
                            if (result == 1) {
                                $('#category_list').bootstrapTable('refresh');
                            } else
                                alert('Lỗi!! Chưa thể xóa chủ đề.');
                        }
                    });
                }
            });
        </script>
    </body>
</html>