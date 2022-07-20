<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("location:index.php");
    return false;
    exit();
}
$type = 1;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quản Lý Câu Hỏi </title>
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
                                    <h2>Quản Lý Câu Hỏi <small>Tạo Câu Hỏi</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <form id="register_form" method="POST" action="db_operations.php" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="novalidate">
                                            <h4 class="col-md-offset-1"><strong>Tạo Câu Hỏi Mới</strong></h4>
                                            <input type="hidden" id="add_question" name="add_question" required="" value="1" aria-required="true">
                                            <?php
                                            $db->sql("SET NAMES 'utf8'");
                                            if ($fn->is_language_mode_enabled()) {
                                                ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="category">Ngôn Ngữ</label>
                                                    <div class="col-md-10 col-sm-6 col-xs-12">
                                                        <?php
                                                        $sql = "SELECT * FROM `languages` ORDER BY id DESC";
                                                        $db->sql($sql);
                                                        $languages = $db->getResult();
                                                        ?>
                                                        <select id="language_id" name="language_id" required class="form-control">
                                                            <option value="">Chọn Ngôn Ngữ</option>
                                                            <?php foreach ($languages as $language) { ?>
                                                                <option value='<?= $language['id'] ?>'><?= $language['language'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="category">Danh Mục</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <?php
                                                    $sql = "SELECT id, category_name FROM category WHERE type=" . $type . " ORDER BY id DESC";
                                                    $db->sql($sql);
                                                    $categories = $db->getResult();
                                                    ?>
                                                    <select name='category' id='category' class='form-control' required>
                                                        <option value=''>Chọn Danh Mục</option>
                                                        <?php foreach ($categories as $row) { ?>
                                                            <option value='<?= $row['id'] ?>'><?= $row['category_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="subcategory">Danh Mục Con</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <select name='subcategory' id='subcategory' class='form-control' >
                                                        <option value=''>Chọn Danh Mục Con</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="question">Câu Hỏi</label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">
                                                    <textarea id="question" name="question" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="image">Ảnh <small>( nếu có )</small></label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">
                                                    <input type="file" id="image" name="image" class="form-control" aria-required="true">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="answer type">Loại Câu Hỏi</label>
                                                <div class="col-md-8 col-sm-6 col-xs-12">                                                     
                                                    <div id="status" class="btn-group">
                                                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                            <input type="radio" name="question_type" value="1" checked=""> Lựa Chọn 
                                                        </label>
                                                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                            <input type="radio" name="question_type" value="2"> True / False
                                                        </label>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="a">Phương Án</label>
                                                <div class="col-md-8 col-sm-6 col-xs-12"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="a" class="control-label col-md-1 col-sm-3 col-xs-12">A</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input id="a" class="form-control" type="text" value="" name="a">
                                                </div>
                                                <label for="b" class="control-label col-md-1 col-sm-3 col-xs-12">B</label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input id="b" class="form-control" type="text" name="b">
                                                </div>
                                            </div>
                                            <div id="tf">
                                                <div class="form-group" >
                                                    <label for="c" class="control-label col-md-1 col-sm-3 col-xs-12">C</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input id="c" class="form-control" type="text" name="c">
                                                    </div>
                                                    <label for="d" class="control-label col-md-1 col-sm-3 col-xs-12">D</label>
                                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                                        <input id="d" class="form-control" type="text" name="d">
                                                    </div>
                                                </div>
                                                <?php if ($fn->is_option_e_mode_enabled()) { ?>
                                                    <div class="form-group">
                                                        <label for="e" class="control-label col-md-1 col-sm-3 col-xs-12">E </label>
                                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                                            <input id="e" class="form-control" type="text" name="e">
                                                        </div>
                                                        <label for="d" class="control-label col-md-1 col-sm-3 col-xs-12"></label>
                                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="level">Level</label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">
                                                    <input type='text' name='level' id='level' class='form-control' required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="answer">Đáp Án</label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">
                                                    <select name='answer' id='answer' class='form-control'>
                                                        <option value=''>Chọn Đáp Án</option>
                                                        <option value='a'>A</option>
                                                        <option value='b'>B</option>
                                                        <option class='ntf' value='c'>C</option>
                                                        <option class='ntf' value='d'>D</option>
                                                        <?php if ($fn->is_option_e_mode_enabled()) { ?>
                                                            <option class='ntf' value='e'>E</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="note">Ghi chú</label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">
                                                    <textarea name='note' id='note' class='form-control'></textarea>
                                                </div>
                                            </div>

                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
                                                    <button type="submit" id="submit_btn" class="btn btn-success">Tạo Câu Hỏi</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div  class="col-md-offset-3 col-md-4" style ="display:none;" id="result">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-md-12"><hr></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <h2>Danh Sách Câu Hỏi <small>Xem / Cập Nhật / Xóa</small></h2>
                                        </div>
                                        <div class='col-md-12'>
                                            <?php if ($fn->is_language_mode_enabled()) { ?>
                                                <div class='col-md-3'>
                                                    <select id='filter_language' class='form-control' required>
                                                        <option value="">Chọn Ngôn Ngữ</option>
                                                        <?php foreach ($languages as $language) { ?>
                                                            <option value='<?= $language['id'] ?>'><?= $language['language'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-3'>
                                                    <select id='filter_category' class='form-control' required>
                                                        <option value=''>Chọn Danh Mục</option>
                                                    </select>
                                                </div>
                                            <?php } else { ?>
                                                <div class='col-md-3'>
                                                    <select id='filter_category' class='form-control' required>
                                                        <option value=''>Chọn Danh Mục Con</option>
                                                        <?php foreach ($categories as $row) { ?>
                                                            <option value='<?= $row['id'] ?>'><?= $row['category_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class='col-md-3'>
                                                <select id='filter_subcategory' class='form-control' required>
                                                    <option value=''>Chọn Danh Mục Con</option>
                                                </select>
                                            </div>

                                            <div class='col-md-3'>
                                                <button class='btn btn-primary btn-block' id='filter_btn'>Lọc</button>
                                            </div>
                                        </div>
                                        <div class='col-md-12'><hr></div>
                                    </div>
                                    <div id="toolbar">
                                        <div class="col-md-3">
                                            <button class="btn btn-danger btn-sm" id="delete_multiple_questions" title="Delete Selected Questions"><em class='fa fa-trash'></em></button>
                                        </div>
                                    </div>
                                    <table aria-describedby="mydesc" class='table-striped' id='questions'
                                           data-toggle="table" data-url="get-list.php?table=question"
                                           data-sort-name="id" data-sort-order="desc"
                                           data-click-to-select="true" data-side-pagination="server"                                           
                                           data-search="true" data-show-columns="true"
                                           data-show-refresh="true" data-trim-on-search="false"                                                    
                                           data-toolbar="#toolbar" data-mobile-responsive="true" data-maintain-selected="true"  
                                           data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"  
                                           data-show-export="false" data-export-types='["txt","excel"]'
                                           data-export-options='{
                                           "fileName": "questions-list-<?= date('d-m-y') ?>",
                                           "ignoreColumn": ["state"]	
                                           }'
                                           data-query-params="queryParams_1"
                                           >
                                        <thead>
                                            <tr>
                                                <th scope="col" data-field="state" data-checkbox="true"></th>
                                                <th scope="col" data-field="id" data-sortable="true">ID</th>
                                                <th scope="col" data-field="category" data-sortable="true" data-visible='false'>Danh Mục</th>
                                                <th scope="col" data-field="subcategory" data-sortable="true" data-visible='false'>Danh Mục Con</th>
                                                <?php if ($fn->is_language_mode_enabled()) { ?>
                                                    <th scope="col" data-field="language_id" data-sortable="true" data-visible='false'>ID Ngôn Ngữ</th>
                                                    <th scope="col" data-field="language" data-sortable="true" data-visible='true'>Ngôn Ngữ</th>
                                                <?php } ?>
                                                <th scope="col" data-field="image" data-sortable="false">Ảnh</th>
                                                <th scope="col" data-field="question" data-sortable="true">Câu Hỏi</th>
                                                <th scope="col" data-field="question_type" data-sortable="true" data-visible='false'>Loại Câu Hỏi</th>
                                                <th scope="col" data-field="optiona" data-sortable="true">Lựa chọn A</th>
                                                <th scope="col" data-field="optionb" data-sortable="true">Lựa chọn B</th>
                                                <th scope="col" data-field="optionc" data-sortable="true">Lựa chọn C</th>
                                                <th scope="col" data-field="optiond" data-sortable="true">Lựa chọn D</th>
                                                <?php if ($fn->is_option_e_mode_enabled()) { ?>
                                                    <th scope="col" data-field="optione" data-sortable="true" data-visible='false'>Lựa chọn E</th>
                                                <?php } ?>
                                                <th scope="col" data-field="answer" data-sortable="true" data-visible='false'>Đáp Án</th>
                                                <th scope="col" data-field="level" data-sortable="true">Level</th>
                                                <th scope="col" data-field="note" data-sortable="true" data-visible='false'>Ghi chú</th>
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
            <!-- /page content -->
            <div class="modal fade" id='editQuestionModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Chỉnh sửa Câu Hỏi</h4>
                        </div>
                        <div class="modal-body">
                            <form id="update_form"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                <input type='hidden' name="question_id" id="question_id" value=''/>
                                <input type='hidden' name="update_question" id="update_question" value='1'/>
                                <input type='hidden' name="image_url" id="image_url" value=''/>
                                <?php
                                $db->sql("SET NAMES 'utf8'");
                                if ($fn->is_language_mode_enabled()) {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="category">Ngôn Ngữ</label>
                                        <div class="col-md-10 col-sm-6 col-xs-12">
                                            <?php
                                            $sql = "SELECT * FROM `languages` ORDER BY id DESC";
                                            $db->sql($sql);
                                            $languages = $db->getResult();
                                            ?>
                                            <select id="update_language_id" name="language_id" required class="form-control col-md-7 col-xs-12">
                                                <option value="">Chọn Ngôn Ngữ</option>
                                                <?php foreach ($languages as $language) { ?>
                                                    <option value='<?= $language['id'] ?>'><?= $language['language'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="category">Danh Mục</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <select name='category' id='edit_category' class='form-control' required>
                                            <option value=''>Chọn Danh Mục</option>
                                            <?php foreach ($categories as $row) { ?>
                                                <option value='<?= $row['id'] ?>'><?= $row['category_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="subcategory">Danh Mục Con</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <select name="subcategory" id="edit_subcategory" class="form-control" >
                                            <option value="">Chọn Danh Mục Con</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 col-sm-3 col-xs-12" for="image">Ảnh Câu Hỏi</label>
                                    <div class="col-md-10 col-md-offset-1 col-sm-6 col-xs-12">
                                        <input type="file" id="edit_image" name="image" class="form-control col-md-7 col-xs-12" aria-required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="question">Câu Hỏi</label>
                                    <div class="col-md-10 col-sm-6 col-xs-12">
                                        <textarea type="text" id="edit_question" name="question" required="required" class="form-control col-md-7 col-xs-12" aria-required="true"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="answer type">Loại Câu Hỏi</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">                                                     
                                        <div id="status" class="btn-group">
                                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="edit_question_type" value="1" checked=""> Lựa Chọn 
                                            </label>
                                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="edit_question_type" value="2"> True / False
                                            </label>                                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="a">Phương Án</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12"></div>
                                </div>
                                <div class="form-group">
                                    <label for="a" class="control-label col-md-1 col-sm-3 col-xs-12">A</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <input id="edit_a" class="form-control col-md-7 col-xs-12" type="text" name="a">
                                    </div>
                                    <label for="b" class="control-label col-md-1 col-sm-3 col-xs-12">B</label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input id="edit_b" class="form-control col-md-7 col-xs-12" type="text" name="b">
                                    </div>
                                </div>
                                <div id="edit_tf">
                                    <div class="form-group" >
                                        <label for="c" class="control-label col-md-1 col-sm-3 col-xs-12">C</label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <input id="edit_c" class="form-control col-md-7 col-xs-12" type="text" name="c">
                                        </div>
                                        <label for="d" class="control-label col-md-1 col-sm-3 col-xs-12">D</label>
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <input id="edit_d" class="form-control col-md-7 col-xs-12" type="text" name="d">
                                        </div>
                                    </div>
                                    <?php if ($fn->is_option_e_mode_enabled()) { ?>
                                        <div class="form-group">
                                            <label for="e" class="control-label col-md-1 col-sm-3 col-xs-12">E</label>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <input id="edit_e" class="form-control col-md-7 col-xs-12" type="text" name="e">
                                            </div>
                                            <label class="control-label col-md-1 col-sm-3 col-xs-12"></label>
                                            <div class="col-md-5 col-sm-6 col-xs-12"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="level">Level</label>
                                    <div class="col-md-10 col-sm-6 col-xs-12">
                                        <input type="text" id="edit_level" name="level" required="required" class="form-control col-md-7 col-xs-12" aria-required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="answer">Đáp Án</label>
                                    <div class="col-md-10 col-sm-6 col-xs-12">
                                        <select name="answer" id="edit_answer" class="form-control" required>
                                            <option value="">Chọn Đáp Án</option>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option class='edit_ntf' value="c">C</option>
                                            <option class='edit_ntf' value="d">D</option>
                                            <?php if ($fn->is_option_e_mode_enabled()) { ?>
                                                <option class='edit_ntf' value='e'>E</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="note">Ghi chú</label>
                                    <div class="col-md-10 col-sm-6 col-xs-12">
                                        <textarea name="note" id="edit_note" class="form-control"></textarea>
                                    </div>
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
            var type =<?= $type ?>;
<?php if ($fn->is_language_mode_enabled()) { ?>
                $('#language_id').on('change', function (e) {
                    var language_id = $('#language_id').val();
                    $.ajax({
                        type: 'POST',
                        url: "db_operations.php",
                        data: 'get_categories_of_language=1&language_id=' + language_id + '&type=' + type,
                        beforeSend: function () {
                            $('#category').html('Xin chờ...');
                        },
                        success: function (result) {
                            $('#category').html(result);
                        }
                    });
                });
                $('#update_language_id').on('change', function (e, row_language_id, row_category, row_subcategory) {
                    var language_id = $('#update_language_id').val();
                    $.ajax({
                        type: 'POST',
                        url: "db_operations.php",
                        data: 'get_categories_of_language=1&language_id=' + language_id + '&type=' + type,
                        beforeSend: function () {
                            $('#edit_category').html('Xin chờ...');
                        },
                        success: function (result) {
                            $('#edit_category').html(result).trigger("change");
                            if (language_id == row_language_id && row_category != 0)
                                $('#edit_category').val(row_category).trigger("change", [row_category, row_subcategory]);
                        }
                    });
                });
                $('#filter_language').on('change', function (e) {
                    var language_id = $('#filter_language').val();
                    $.ajax({
                        type: 'POST',
                        url: "db_operations.php",
                        data: 'get_categories_of_language=1&language_id=' + language_id + '&type=' + type,
                        beforeSend: function () {
                            $('#filter_category').html('<option>Xin Chờ...</option>');
                        },
                        success: function (result) {
                            $('#filter_category').html(result);
                            $('#filter_subcategory').html('<option>Chọn Danh Mục Con</option>');
                        }
                    });
                });
                category_options = '';
    <?php
    $category_options = "<option value=''>Select Options</option>";
    foreach ($categories as $category) {
        $category_options .= "<option value='" . $category['id'] . "'>" . $category['category_name'] . "</option>";
    }
    ?>
                category_options = "<?= $category_options; ?>";

<?php } ?>
        </script>
        <script>
            $('#category').on('change', function (e) {
                var category_id = $('#category').val();
                $.ajax({
                    type: 'POST',
                    url: "db_operations.php",
                    data: 'get_subcategories_of_category=1&category_id=' + category_id,
                    beforeSend: function () {
                        $('#subcategory').html('Xin chờ..');
                    },
                    success: function (result) {
                        $('#subcategory').html(result);
                    }
                });
            });
            $('#edit_category').on('change', function (e, row_category, row_subcategroy) {
                var category_id = $('#edit_category').val();
                $.ajax({
                    type: 'POST',
                    url: "db_operations.php",
                    data: 'get_subcategories_of_category=1&category_id=' + category_id,
                    beforeSend: function () {
                        $('#edit_subcategory').html('Xin chờ..');
                    },
                    success: function (result) {
                        $('#edit_subcategory').html(result);
                        if (category_id == row_category && row_subcategroy != 0)
                            $('#edit_subcategory').val(row_subcategroy);
                    }
                });
            });

            $('#filter_category').on('change', function (e) {
                var category_id = $('#filter_category').val();
                $.ajax({
                    type: 'POST',
                    url: "db_operations.php",
                    data: 'get_subcategories_of_category=1&category_id=' + category_id,
                    beforeSend: function () {
                        $('#filter_subcategory').html('<option>Xin chờ..</option>');
                    },
                    success: function (result) {
                        $('#filter_subcategory').html(result);
                    }
                });
            });
        </script>

        <script>
            window.actionEvents = {
                'click .edit-question': function (e, value, row, index) {
                    if (row.image != 'No image') {
                        var regex = /<img.*?src="(.*?)"/;
                        var src = regex.exec(row.image)[1];
                        $('#image_url').val(src);
                    } else {
                        $('#image_url').val('');
                    }
                    $('#question_id').val(row.id);
                    $('#edit_question').val(row.question);
<?php if ($fn->is_language_mode_enabled()) { ?>
                        if (row.language_id == 0) {
                            $('#update_language_id').val(row.language_id);
                            $('#edit_category').html(category_options);
                            $('#edit_category').val(row.category).trigger("change", [row.category, row.subcategory]);
                        } else {
                            $('#update_language_id').val(row.language_id).trigger("change", [row.language_id, row.category, row.subcategory]);
                        }

<?php } else { ?>
                        $('#edit_category').val(row.category).trigger("change", [row.category, row.subcategory]);
<?php } ?>
                    var question_type = row.question_type;
                    if (question_type == "2") {
                        $("input[name=edit_question_type][value=2]").prop('checked', true);
                        $('#edit_tf').hide('fast');
                        $('#edit_a').val(row.optiona);
                        $('#edit_b').val(row.optionb);
                        $('.edit_ntf').hide('fast');
                    } else {
                        $("input[name=edit_question_type][value=1]").prop('checked', true);
                        $('#edit_a').val(row.optiona);
                        $('#edit_b').val(row.optionb);
                        $('#edit_c').val(row.optionc);
                        $('#edit_d').val(row.optiond);
<?php if ($fn->is_option_e_mode_enabled()) { ?>
                            $('#edit_e').val(row.optione);
<?php } ?>
                        $('#edit_tf').show('fast');
                        $('.edit_ntf').show('fast');
                    }

                    $('#edit_a').val(row.optiona);
                    $('#edit_b').val(row.optionb);
                    $('#edit_c').val(row.optionc);
                    $('#edit_d').val(row.optiond);
<?php if ($fn->is_option_e_mode_enabled()) { ?>
                        $('#edit_e').val(row.optione);
<?php } ?>
                    $('#edit_answer').val(row.answer.toLowerCase());
                    $('#edit_level').val(row.level);
                    $('#edit_note').val(row.note);
                    $('#edit_subcategory').val(row.subcategory);
                }
            };
        </script>
        <script>
            $(document).on('click', '.delete-question', function () {
                if (confirm('Bạn có muốn xóa câu hỏi không?')) {
                    id = $(this).data("id");
                    image = $(this).data("image");
                    $.ajax({
                        url: 'db_operations.php',
                        type: "get",
                        data: 'id=' + id + '&image=' + image + '&delete_question=1',
                        success: function (result) {
                            if (result == 1) {
                                $('#questions').bootstrapTable('refresh');
                            } else
                                alert('Lỗi!!!');
                        }
                    });
                }
            });
        </script>    
        <script>
            function queryParams_1(p) {
                return {
                    "language": $('#filter_language').val(),
                    "category": $('#filter_category').val(),
                    "subcategory": $('#filter_subcategory').val(),
                    limit: p.limit,
                    sort: p.sort,
                    order: p.order,
                    offset: p.offset,
                    search: p.search
                };
            }
        </script>
        <script>
            var $table = $('#questions');
            $('#toolbar').find('select').change(function () {
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: $(this).val()
                });
            });
        </script>        

        <script>
            $('#register_form').validate({
                rules: {
                    question: "required",
                    category: "required",
                    a: "required",
                    b: "required",
                    c: "required",
                    d: "required",
                    level: "required",
                    answer: "required"
                }
            });
        </script>
        <script>
            $('#register_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($("#register_form").validate().form()) {
<?php if ($fn->is_language_mode_enabled()) { ?>
                        var language = $('#language_id').val();
<?php } ?>
                    var category = $('#category').val();
                    var subcategory = $('#subcategory').val();
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        beforeSend: function () {
                            $('#submit_btn').html('Xin chờ..');
                            $('#submit_btn').prop('disabled', true);
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            $('#submit_btn').html('Tạo Câu Hỏi');
                            $('#result').html(result);
                            $('#result').show().delay(2000).fadeOut();
                            $('#register_form')[0].reset();
                            $('#category').val(category);
                            $('#subcategory').val(subcategory);
<?php if ($fn->is_language_mode_enabled()) { ?>
                                $('#language_id').val(language);
<?php } ?>
                            $('#tf').show('fast');
                            $('.ntf').show('fast');
                            $('#submit_btn').prop('disabled', false);
                            $('#questions').bootstrapTable('refresh');
                        }
                    });
                }
            });
        </script>

        <script>
            $('#update_form').validate({
                rules: {
                    edit_question: "required",
                    update_quiz_id: "required",
                    update_a: "required",
                    update_b: "required",
                    update_c: "required",
                    update_d: "required",
                    edit_answer: "required"
                }
            });
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
                            $('#update_btn').html('Please wait..');
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            $('#update_result').html(result);
                            $('#update_result').show().delay(1000).fadeOut();
                            $('#update_btn').html('Cập Nhật');
                            $('#edit_image').val('');
                            $('#questions').bootstrapTable('refresh');
                            setTimeout(function () {
                                $('#editQuestionModal').modal('hide');
                            }, 2000);
                        }
                    });
                }
            });
        </script>
        <script>
            $('#filter_btn').on('click', function (e) {
                $('#questions').bootstrapTable('refresh');
            });
            $('#delete_multiple_questions').on('click', function (e) {
                sec = 'question';
                is_image = 1;
                table = $('#questions');
                delete_button = $('#delete_multiple_questions');
                selected = table.bootstrapTable('getAllSelections');
                ids = "";
                $.each(selected, function (i, e) {
                    ids += e.id + ",";
                });
                ids = ids.slice(0, -1); // removes last comma character
                if (ids == "") {
                    alert("Vui lòng chọn một số câu hỏi để xóa!");
                } else {
                    if (confirm("Bạn có muốn xóa tất cả các câu hỏi đã chọn?")) {
                        $.ajax({
                            type: 'GET',
                            url: "db_operations.php",
                            data: 'delete_multiple=1&ids=' + ids + '&sec=' + sec + '&is_image=' + is_image,
                            beforeSend: function () {
                                delete_button.html('<i class="fa fa-spinner fa-pulse"></i>');
                            },
                            success: function (result) {
                                if (result == 1) {
                                    alert("Câu hỏi đã xóa thành công.");
                                } else {
                                    ("Không thể xóa câu hỏi. Thử lại!");
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
            $('input[name="question_type"]').on("click", function (e) {
                var question_type = $(this).val();
                if (question_type == "2") {
                    $('#tf').hide('fast');
                    $('#a').val("<?php echo $config['true_value'] ?>");
                    $('#b').val("<?php echo $config['false_value'] ?>");
                    $('.ntf').hide('fast');
                } else {
                    $('#a').val('');
                    $('#b').val('');
                    $('#tf').show('fast');
                    $('.ntf').show('fast');
                }
            });
            $('input[name="edit_question_type"]').on("click", function (e) {
                var edit_question_type = $(this).val();
                if (edit_question_type == "2") {
                    $('#edit_tf').hide('fast');
                    $('#edit_a').val("<?php echo $config['true_value'] ?>");
                    $('#edit_b').val("<?php echo $config['false_value'] ?>");
                    $('.edit_ntf').hide('fast');
                    $('#edit_answer').val('');
                } else {
                    $('#edit_tf').show('fast');
                    $('.edit_ntf').show('fast');
                }
            });
        </script>

    </body>
</html>