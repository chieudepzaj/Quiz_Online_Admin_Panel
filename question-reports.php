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
        <title>Báo Cáo Về Câu Hỏi </title>
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
                                    <h2>Báo Cáo Câu Hỏi Của Người Dùng</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <div class="row" id="toolbar">
                                                <div class="col-md-3">
                                                    <button class="btn btn-danger btn-sm" id="delete_multiple_question_reports" title="Xóa Báo Cáo Câu Hỏi Đã Chọn"><em class='fa fa-trash'></em></button>
                                                </div>
                                            </div>
                                            <table aria-describedby="mydesc" class='table-striped' id='report_list'
                                                   data-toggle="table"
                                                   data-url="get-list.php?table=question_reports"
                                                   data-click-to-select="true"
                                                   data-side-pagination="server"
                                                   data-pagination="true"
                                                   data-page-list="[5, 10, 20, 50, 100, 200]"
                                                   data-search="true" data-show-columns="true"
                                                   data-show-refresh="true" data-trim-on-search="false"
                                                   data-sort-name="id" data-sort-order="desc"
                                                   data-mobile-responsive="true"
                                                   data-toolbar="#toolbar" 
                                                   data-maintain-selected="true"
                                                   data-show-export="false" data-export-types='["txt","excel"]'
                                                   data-export-options='{
                                                   "fileName": "users-list-<?= date('d-m-y') ?>",
                                                   "ignoreColumn": ["state"]	
                                                   }'
                                                   data-query-params="queryParams_1"
                                                   >
                                                <thead>
                                                    <tr>
                                                        <th scope="col" data-field="state" data-checkbox="true"></th>
                                                        <th scope="col" data-field="id" data-sortable="true">ID</th>
                                                        <th scope="col" data-field="user_id" data-sortable="true">ID Người Dùng</th>
                                                        <th scope="col" data-field="name" data-sortable="true" data-visible='false'>Tên Người Dùng</th>
                                                        <th scope="col" data-field="question_id" data-sortable="true" data-visible='false'>ID Câu Hỏi</th>
                                                        <th scope="col" data-field="question" data-sortable="true">Câu Hỏi</th>
                                                        <th scope="col" data-field="message" data-sortable="true">Nội Dung Báo Cáo</th>
                                                        <th scope="col" data-field="date" data-sortable="true">Ngày</th>
                                                        <th scope="col" data-field="operate">Thao Tác</th>
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
            <!-- footer content -->
            <?php include 'footer.php'; ?>
            <!-- /footer content -->
        </div>

        <script>
            function queryParams_1(p) {
                return {
                    limit: p.limit,
                    sort: p.sort,
                    order: p.order,
                    offset: p.offset,
                    search: p.search
                };
            }
            $('#delete_multiple_question_reports').on('click', function (e) {
                sec = 'question_reports';
                is_image = 0;
                table = $('#report_list');
                delete_button = $('#delete_multiple_question_reports');
                selected = table.bootstrapTable('getAllSelections');
                // alert(selected[0].id);
                ids = "";
                $.each(selected, function (i, e) {
                    ids += e.id + ",";
                });
                ids = ids.slice(0, -1); // removes last comma character
                if (ids == "") {
                    alert("Hãy chọn một số trường để xóa!!");
                } else {
                    if (confirm("Bạn có muốn xóa tất cả các trường được chọn?")) {
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
        <!-- jQuery -->
        <script>
            $(document).on('click', '.delete-report', function () {
                if (confirm('Bạn muốn xóa báo cáo này không?')) {
                    id = $(this).data("id");
                    $.ajax({
                        url: 'db_operations.php',
                        type: "get",
                        data: 'id=' + id + '&delete_question_report=1',
                        success: function (result) {
                            if (result == 1) {
                                $('#report_list').bootstrapTable('refresh');
                            } else
                                alert('Lỗi! Báo cáo này chưa được xóa.');
                        }
                    });
                }
            });
        </script>
    </body>
</html>