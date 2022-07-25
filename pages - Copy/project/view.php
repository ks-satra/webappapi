<?php
    $tab = isset( $_GET["tab"] ) ? $_GET["tab"] : "1";
?>
<div id="content-title">
    ข้อมูลโครงการทั้งหมด
</div>
<div id="content-body">

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="1") echo "active"; ?>" href="./?page=project">โครงการทั้งหมด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="2") echo "active"; ?>" href="./?page=project&tab=2">กิจกรรมทั้งหมด</a>
                </li>
            </ul>
        </div>
        <div class="card-body mb-3">
            <?php
                echo '
                    <link href="pages/'.$PAGE.'/tab'.$tab.'/view.css?version='.$VERSION.'" rel="stylesheet">
                    <script src="pages/'.$PAGE.'/tab'.$tab.'/view.js?version='.$VERSION.'"></script>
                ';
                include_once('pages/'.$PAGE.'/tab'.$tab.'/view.php');
            ?>
        </div>
    </div>
</div>