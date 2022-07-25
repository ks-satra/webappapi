<nav id="navbar" class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="./">
        <img src="images/yru.png" alt="Logo">
        <span class="d-none d-lg-inline">Web Application</span>
        <span class="d-inline d-lg-none">Web Application</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php //if($USER["level"]["area-user"]=="Y") { ?>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    แบบสำรวจ
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="./?page=user-form-add">เพิ่มแบบสำรวจ</a>
                    <a class="dropdown-item" href="./?page=user-form">แบบสำรวจของฉัน</a>
                </div>
            </li> -->
            <?php //} ?>



            <?php //if($USER["level"]["report-all"]=="Y" || $USER["level"]["area-admin"]=="Y") { ?>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    รายงาน
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="./?page=report-form">แบบสำรวจทั้งหมด</a> -->
                    <!-- <a class="dropdown-item" href="./?page=report-data">รายงานสภาพเศรษฐกิจ</a>
                    <a class="dropdown-item" href="./?page=report-users">จำนวนผู้บันทึกแบบสำรวจทั้งหมด</a>
                    <a class="dropdown-item" href="./?page=export-excel">Export Excel</a> -->
                <!-- </div>
            </li> -->
            <?php // }?>


            <?php 
                // if($USER["level"]["area-admin"]=="Y") { 

                //     $sql = "
                //         SELECT
                //             user_tmp.*
                //         FROM user_tmp
                //         WHERE user_tmp.area_province_id IN (
                //             SELECT province_id FROM user_area WHERE user_id='".$USER["user_id"]."'
                //         )
                //     ";
                //     $badge2 = sizeof( $DATABASE->QueryObj($sql) );
            ?>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    แอดมินพื้นที่ -->
                    <?php
                        // if( $badge2>0 ) echo '<span class="badge badge-danger">'.($badge2).'</span>';
                    ?>
                </a>
                <!-- <div class="dropdown-menu"> -->
                    <!-- <a class="dropdown-item" href="./?page=aduser-form">
                        แบบสำรวจรอตรวจ
                        <?php
                           // if( $badge1>0 ) echo '<span class="badge badge-danger">'.$badge1.'</span>';
                        ?>
                    </a> -->
                    <!-- <a class="dropdown-item" href="./?page=aduser-user-approve">
                        อนุมัติผู้ใช้งานใหม่
                        <?php
                            //if( $badge2>0 ) echo '<span class="badge badge-danger">'.$badge2.'</span>';
                        ?>
                    </a>
                    <a class="dropdown-item" href="./?page=aduser-user">ข้อมูลผู้ใช้งาน</a> -->
                    <!-- <a class="dropdown-item" href="./?page=aduser-report-users">จำนวนผู้บันทึกแบบสำรวจ</a> -->
                <!-- </div>
            </li> -->
            <?php //} ?>


            <?php if($USER["level"]["admin"]=="Y") { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    ข้อมูลผู้ใช้งาน
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="./?page=admin-user">ข้อมูลผู้ใช้งานทั้งหมด</a>
                    <!-- <a class="dropdown-item" href="./?page=admin-area">ข้อมูลพื้นที่เก็บแบบสำรวจ</a>
                    <a class="dropdown-item" href="./?page=admin-year">ข้อมูลปีงบประมาณ</a>
                    <a class="dropdown-item" href="./?page=admin-prefix">ตั้งค่าข้อมูลพื้นฐานอื่น ๆ</a>
                    <a class="dropdown-item" href="./?page=admin-update-excel">อัพเดตรายการใน Excel</a>
                    <a class="dropdown-item" href="./?page=admin-online-user">ผู้ใช้งานขณะนี้</a> -->
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    โครงการ
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="./?page=project">ข้อมูลโครงการทั้งหมด</a>
                    <!-- <a class="dropdown-item" href="./?page=admin-area">ข้อมูลพื้นที่เก็บแบบสำรวจ</a>
                    <a class="dropdown-item" href="./?page=admin-year">ข้อมูลปีงบประมาณ</a>
                    <a class="dropdown-item" href="./?page=admin-prefix">ตั้งค่าข้อมูลพื้นฐานอื่น ๆ</a>
                    <a class="dropdown-item" href="./?page=admin-update-excel">อัพเดตรายการใน Excel</a>
                    <a class="dropdown-item" href="./?page=admin-online-user">ผู้ใช้งานขณะนี้</a> -->
                </div>
            </li>
            <?php } ?>



        </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <!-- <li class="nav-item">
                <span class="navbar-text">
                    ปีงบประมาณ <?php //echo $YEAR_NAME; ?>
                </span>
            </li> -->
            <li class="nav-item dropdown">
                <a class="profile-name nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="profile-image" src="./files/user/<?php echo $USER["image"]; ?>"
                        onerror="ImageError(this, './files/user/default.png')">
                    <?php echo $USER['user_name']; ?>
                    <?php echo $USER['user_lname']; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="./?page=all-profile">
                        <i class="fas fa-user mr-2"></i> โปรไฟล์ของฉัน
                    </a>
                    <a class="dropdown-item" href="./?page=all-changepass">
                        <i class="fas fa-key mr-2"></i> เปลี่ยนรหัสผ่าน
                    </a>
                    <a class="dropdown-item" href="./?page=all-login">
                        <i class="fas fa-history mr-2"></i> ประวัติการล็อกอิน
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item btn-logout" href="Javascript:">
                        <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php include("online-staff.php"); ?>