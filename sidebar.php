        <?php
        include 'library/crud.php';
        include 'library/functions.php';
        $fn = new Functions();
        $config = $fn->get_configurations();
        $db = new Database();
        $db->connect();

        if (isset($config['system_timezone']) && !empty($config['system_timezone'])) {
            date_default_timezone_set($config['system_timezone']);
        } else {
            date_default_timezone_set('Asia/Kolkata');
        }

        if (isset($config['system_timezone_gmt']) && !empty($config['system_timezone_gmt'])) {
            $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
        } else {
            $db->sql("SET `time_zone` = '+07:00'");
        }

        function get_count($field, $table, $where = '') {
            if (!empty($where))
                $where = "where " . $where;

            $sql = "SELECT COUNT(" . $field . ") as total FROM " . $table . " " . $where;
            global $db;
            $db->sql($sql);
            $res = $db->getResult();
            foreach ($res as $row)
                return $row['total'];
        }

        $auth_username = $db->escapeString($_SESSION["username"]);

        function checkadmin($auth_username) {
            $db = new Database();
            $db->connect();
            $db->sql("SELECT `auth_username`,`role` FROM `authenticate` WHERE `auth_username`='$auth_username' LIMIT 1");
            $res = $db->getResult();
            if (!empty($res)) {
                if ($res[0]["role"] == "admin") {
                    return true;
                } else {
                    return false;
                }
            }
        }

        if (!checkadmin($auth_username)) {
            $pages = array('languages.php', 'users.php', 'monthly-leaderboard.php', 'send-notifications.php', 'user-accounts-rights.php', 'notification-settings.php', 'privacy-policy.php');
            foreach ($pages as $page) {
                if (basename($_SERVER['PHP_SELF']) == $page) {
                    exit("<center><h2 style='color:#fff;'><br><br><br><br><em style='color:#f7d701;' class='fas fa-exclamation-triangle fa-4x'></em><br><br>Access denied - You are not authorized to access this.</h2></center>");
                }
            }
        }
        if (basename($_SERVER['PHP_SELF']) == 'languages.php' && !$fn->is_language_mode_enabled()) {
            exit("<center><h2 style='color:#fff;'><br><br><br><br><em style='color:#f7d701;' class='fas fa-exclamation-triangle fa-4x'></em><br><br>Language mode is disabled - You are not allowed to access this page.</h2></center>");
        }
        ?>
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title text-center" style="border: 0;">
                    <img src="images/logo-460x114.png" alt="logo" width="230" class="md">
                    <img src="images/logo-half.png" alt="logo" width="56" class="sm">
                </div>
                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile clearfix text-center">                   
                    <div class="profile_info">
                        <h2> Admin Dashboard </h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">

                        <ul class="nav side-menu">
                            <li><a href ="home.php"><em class="fas fa-home"></em> Trang chủ</a></li>
                                <li><a href ="users.php"><em class="fas fa-users"></em> Người dùng</a></li>
                                <li>
                                    <a><em class="fas fa-th"></em> Bảng xếp hạng<span class="fas fa-caret-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="global-leaderboard.php">Tổng</a></li>
                                        <li><a href="monthly-leaderboard.php">Tháng</a></li>
                                        <li><a href="daily-leaderboard.php">Ngày</a></li>                                       
                                    </ul>
                                </li>                                   
                                <?php if ($fn->is_language_mode_enabled()) { ?>
                                    <li><a href="languages.php"><em class="fas fa-language"></em> Ngôn ngữ</a></li>
                                    <?php
                                }
                            ?>
                            <li>
                                <a><em class="fas fa-book"></em> Quiz Zone<span class="fas fa-caret-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="main-category.php">Danh Mục</a></li>
                                    <li><a href="sub-category.php">Danh Mục Con</a></li>
                                    <li><a href="questions.php">Câu Hỏi</a></li>
                                </ul>
                            </li>
                            <li><a href="daily-quiz.php"><em class="fas fa-question"></em> Daily Quiz</a></li>                          
                            <li>
                                <a><em class="fas fa-book"></em> Learning Zoom<span class="fas fa-caret-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="learning-category.php">Chủ Đề</a></li>
                                    <li><a href="learning.php"> Quản Lý</a></li>
                                </ul>
                            </li>
                            <li><a href="question-reports.php"><em class="far fa-question-circle"></em> Báo Cáo Về Câu Hỏi</a></li>
                            <li><a href="send-notifications.php"><em class="fas fa-bullhorn"></em> Gửi Thông Báo</a></li>
                            <li><a href="import-questions.php"><em class="fas fa-upload"></em> Nhập Câu Hỏi</a></li>
                           
                                <li>
                                    <a><em class="fas fa-cog"></em> Cài Đặt<span class="fas fa-caret-down"></span></a>
                                    <ul class="nav child_menu">
                                        <!-- <li><a href="system-configurations.php">Cấu Hình Hệ Thống</a></li> -->
                                        <li><a href="notification-settings.php">Cài Đặt Thông Báo</a></li>
                                        <li><a href="about-us.php">Giới Thiệu</a></li>
                                        <li><a href="privacy-policy.php">Chính Sách Bảo Mật</a></li>
                                        <li><a href="terms-conditions.php">Điều Khoản Dịch Vụ</a></li>                                       
                                    </ul>
                                </li>
                            
                        
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><em class="fa fa-bars"></em></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <?= ucwords($_SESSION['username']) ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="password.php"><em class="fa fa-key pull-right"></em> Đổi mật khẩu</a></li>
                                <li><a href="logout.php"><em class="fas fa-sign-out-alt pull-right"></em> Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->