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
                            <li><a href ="home.php"><em class="fas fa-home"></em> Trang ch???</a></li>
                                <li><a href ="users.php"><em class="fas fa-users"></em> Ng?????i d??ng</a></li>
                                <li>
                                    <a><em class="fas fa-th"></em> B???ng x???p h???ng<span class="fas fa-caret-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="global-leaderboard.php">T???ng</a></li>
                                        <li><a href="monthly-leaderboard.php">Th??ng</a></li>
                                        <li><a href="daily-leaderboard.php">Ng??y</a></li>                                       
                                    </ul>
                                </li>                                   
                                <?php if ($fn->is_language_mode_enabled()) { ?>
                                    <li><a href="languages.php"><em class="fas fa-language"></em> Ng??n ng???</a></li>
                                    <?php
                                }
                            ?>
                            <li>
                                <a><em class="fas fa-book"></em> Quiz Zone<span class="fas fa-caret-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="main-category.php">Danh M???c</a></li>
                                    <li><a href="sub-category.php">Danh M???c Con</a></li>
                                    <li><a href="questions.php">C??u H???i</a></li>
                                </ul>
                            </li>
                            <li><a href="daily-quiz.php"><em class="fas fa-question"></em> Daily Quiz</a></li>                          
                            <li>
                                <a><em class="fas fa-book"></em> Learning Zoom<span class="fas fa-caret-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="learning-category.php">Ch??? ?????</a></li>
                                    <li><a href="learning.php"> Qu???n L??</a></li>
                                </ul>
                            </li>
                            <li><a href="question-reports.php"><em class="far fa-question-circle"></em> B??o C??o V??? C??u H???i</a></li>
                            <li><a href="send-notifications.php"><em class="fas fa-bullhorn"></em> G???i Th??ng B??o</a></li>
                            <li><a href="import-questions.php"><em class="fas fa-upload"></em> Nh???p C??u H???i</a></li>
                           
                                <li>
                                    <a><em class="fas fa-cog"></em> C??i ?????t<span class="fas fa-caret-down"></span></a>
                                    <ul class="nav child_menu">
                                        <!-- <li><a href="system-configurations.php">C???u H??nh H??? Th???ng</a></li> -->
                                        <li><a href="notification-settings.php">C??i ?????t Th??ng B??o</a></li>
                                        <li><a href="about-us.php">Gi???i Thi???u</a></li>
                                        <li><a href="privacy-policy.php">Ch??nh S??ch B???o M???t</a></li>
                                        <li><a href="terms-conditions.php">??i???u Kho???n D???ch V???</a></li>                                       
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
                                <li><a href="password.php"><em class="fa fa-key pull-right"></em> ?????i m???t kh???u</a></li>
                                <li><a href="logout.php"><em class="fas fa-sign-out-alt pull-right"></em> ????ng xu???t</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->