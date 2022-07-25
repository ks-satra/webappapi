<?php
    $sql = "
        SELECT 
            hm.*,
            ip.item_prefix_name,
            `is`.item_sex_name,
            ir.item_relation_name,
            ie.item_education_name,
            iw.item_work_name,
            io.item_occupation_name,
            ipl.item_place_name,
            id.item_disease_name
        FROM home_member hm
            INNER JOIN item_prefix ip ON ip.item_prefix_id=hm.item_prefix_id
            INNER JOIN item_sex `is` ON `is`.item_sex_id=hm.item_sex_id
            INNER JOIN item_relation ir ON ir.item_relation_id=hm.item_relation_id
            LEFT JOIN item_education ie ON ie.item_education_id=hm.item_education_id
            LEFT JOIN item_work iw ON iw.item_work_id=hm.item_work_id
            LEFT JOIN item_occupation io ON io.item_occupation_id=hm.item_occupation_id
            LEFT JOIN item_place ipl ON ipl.item_place_id=hm.item_place_id
            LEFT JOIN item_disease id ON id.item_disease_id=hm.item_disease_id
        WHERE hm.home_id='".$home['home_id']."' 
        ORDER BY hm.order_id
    ";
    $ObjHomeMember = $DATABASE->QueryObj($sql);
    $ExtBackHome = array(
        "1"=>"ไม่เคย",
        "2"=>"เคย"
    );
    $ExtLiveArea = array(
        "1"=>"ในพื้นที่",
        "2"=>"นอกพื้นที่"
    );
    $ExtInternet = array(
        "1"=>"เข้าถึง",
        "2"=>"เข้าไม่ถึง"
    );
?>
<form id="formdata" class="mb-3" autocomplete="off">
    <input type="hidden" name="home_id" value="<?php echo $home["home_id"]; ?>">
    <div class="row">
        <div class="col-lg-6">
            <?php include_once('pages/'.$PAGE.'/tab-menu.php');?>
        </div>
        <div class="col-lg-6">
            <div class="informant" id="first-scroll">
                <i class="fas fa-folder mr-2"></i> ข้อมูลสมาชิกที่อาศัยอยู่ในปัจจุบัน
            </div>
            <div class="form-group row">
                <label for="area_num" class="col-md-5 col-form-label">จำนวนสมาชิกในครัวเรือน (คน)</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="area_num" value="<?php echo sizeof($ObjHomeMember); ?>"
                        disabled>
                </div>
            </div>

            <div>
                <?php
                    foreach($ObjHomeMember as $key=>$row) {
                ?>
                <table class="table table-bordered table-sm"
                    data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <tbody>
                        <tr class="bg-light">
                            <th scope="col" style="width: 150px;">ลำดับที่</th>
                            <th scope="col"><?php echo $key+1; ?></th>
                        </tr>
                        <tr>
                            <th scope="col">ชื่อ - นามสกุล</th>
                            <td scope="col">
                                <?php echo $row["item_prefix_name"]; ?><?php echo $row["name"]; ?>
                                <?php echo $row["lname"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">เพศ</th>
                            <td scope="col">
                                <?php echo $row["item_sex_id"]; ?>.
                                <?php echo $row["item_sex_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">ปี พ.ศ. เกิด</th>
                            <td scope="col"><?php echo $row["year_bdate"]+543; ?></td>
                        </tr>
                        <tr>
                            <th scope="col">อายุ</th>
                            <td scope="col"><?php echo $row["age"]; ?> ปี</td>
                        </tr>
                        <tr>
                            <th scope="col">ความสัมพันธ์</th>
                            <td scope="col">
                                <?php echo $row["item_relation_id"]; ?>.
                                <?php echo $row["item_relation_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">ระดับการศึกษาสูงสุด</th>
                            <td scope="col">
                                <?php 
                                    if( $row["item_education_id"]=="999" ) echo "999. อื่นๆ (".$row["education_assign"].")";
                                    else echo $row["item_education_id"].". ".$row["item_education_name"]; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">สถานะการทำงาน</th>
                            <td scope="col">
                                <?php 
                                    if( $row["item_work_id"]=="999" ) echo "999. อื่นๆ (".$row["work_assign"].")";
                                    else echo $row["item_work_id"].". ".$row["item_work_name"]; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">อาชีพ</th>
                            <td scope="col">
                                <?php 
                                    if( $row["item_occupation_id"]=="999" ) echo "999. อื่นๆ (".$row["occupation_assign"].")";
                                    else echo $row["item_occupation_id"].". ".$row["item_occupation_name"]; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">สถานที่ทำงาน/เรียน</th>
                            <td scope="col">
                                <?php echo $row["item_place_id"]; ?>.
                                <?php echo $row["item_place_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">กลับหมู่บ้าน</th>
                            <td scope="col">
                                <?php echo $row["back_home_id"]; ?>.
                                <?php echo $ExtBackHome[$row["back_home_id"]]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">อาศัยอยู่ในพื้นที่</th>
                            <td scope="col">
                                <?php echo $row["live_area_id"]; ?>.
                                <?php echo $ExtLiveArea[$row["live_area_id"]]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">โรคเรื้อรัง</th>
                            <td scope="col">
                                <?php echo $row["item_disease_id"]; ?>.
                                <?php echo $row["item_disease_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">เครือข่ายอินเทอร์เน็ต</th>
                            <td scope="col">
                                <?php echo $row["internet_id"]; ?>.
                                <?php echo $ExtInternet[$row["internet_id"]]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">จัดการ</th>
                            <td scope="col">
                                <a href="Javascript:" class="text-warning mr-3 btn-edit"><i class="fas fa-edit"></i>
                                    แก้ไข</a>
                                <a href="Javascript:" class="text-danger btn-del"><i class="fas fa-trash"></i> ลบ</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } ?>
            </div>


            <div class="text-center p-5 border">
                <a id="btn-add" href="Javascript:" class="text-center text-success">
                    <i class="fas fa-plus mb-2" style="font-size: 30px;"></i><br>
                    เพิ่มสมาชิกในครัวเรือนใหม่
                </a>
            </div>


            <div class="mt-5">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-2"></i>
                    บันทึกและถัดไป
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</form>



<div id="template" class="d-none">
    <form autocomplete="off">
        <input type="hidden" name="home_id" value="<?php echo $home['home_id']; ?>">
        <input type="hidden" name="order_id" value="">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="item_prefix_id">คำนำหน้า</label>
                <select class="form-control" id="item_prefix_id" name="item_prefix_id" required>
                    <option value="">-- ระบุคำนำหน้า --</option>
                    <?php
                        $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_prefix_id"].'">'.$row["item_prefix_id"].'. '.$row["item_prefix_name"].' </option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="name">ชื่อ</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group col-md-4">
                <label for="name">นามสกุล</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            <div class="form-group col-md-4">
                <label for="item_sex_id">เพศ</label>
                <select class="form-control" id="item_sex_id" name="item_sex_id" required>
                    <option value="">-- ระบุเพศ --</option>
                    <?php
                        $sql = "SELECT * FROM `item_sex` ORDER BY item_sex_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_sex_id"].'">'.$row["item_sex_id"].'. '.$row["item_sex_name"].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="year_bdate">ปี พ.ศ.เกิด</label>
                <select class="form-control" id="year_bdate" name="year_bdate" required>
                    <option value="">-- ระบุปีเกิด --</option>
                    <?php
                        for($i=date("Y")-100; $i<=date("Y"); $i++) {
                            echo '<option value="'.$i.'">'.($i+543).'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="item_relation_id">ความสัมพันธ์</label>
                <select class="form-control" id="item_relation_id" name="item_relation_id" required>
                    <option value="">-- ระบุความสัมพันธ์ --</option>
                    <?php
                        $sql = "SELECT * FROM item_relation ORDER BY item_relation_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_relation_id"].'">'.$row["item_relation_id"].'. '.$row["item_relation_name"].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="item_education_id">ระดับการศึกษาสูงสุด</label>
                <select class="form-control" id="item_education_id" name="item_education_id" required>
                    <option value="">-- ระบุระดับการศึกษาสูงสุด --</option>
                    <?php
                        $sql = "SELECT * FROM `item_education` ORDER BY item_education_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_education_id"].'">'.$row["item_education_id"].'. '.$row["item_education_name"].'</option>';
                        }
                    ?>
                    <option value="999">999. อื่นๆ ระบุ</option>
                </select>
            </div>
            <div class="form-group col-md-8">
                <label for="education_assign">ระบุ</label>
                <input type="text" class="form-control" id="education_assign" name="education_assign"
                    placeholder="ระบุระดับการศึกษาสูงสุดอื่นๆ..." required disabled>
            </div>
            <div class="form-group col-md-4">
                <label for="item_work_id">สถานะการทำงาน</label>
                <select class="form-control" id="item_work_id" name="item_work_id" required>
                    <option value="">-- ระบุสถานะการทำงาน --</option>
                    <?php
                        $sql = "SELECT * FROM `item_work` ORDER BY item_work_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_work_id"].'">'.$row["item_work_id"].'. '.$row["item_work_name"].'</option>';
                        }
                    ?>
                    <option value="999">999. อื่นๆ ระบุ</option>
                </select>
            </div>
            <div class="form-group col-md-8">
                <label for="work_assign">ระบุ</label>
                <input type="text" class="form-control" id="work_assign" name="work_assign"
                    placeholder="ระบุสถานะการทำงานอื่นๆ..." required disabled>
            </div>
            <div class="form-group col-md-4">
                <label for="item_occupation_id">อาชีพ</label>
                <select class="form-control" id="item_occupation_id" name="item_occupation_id" required>
                    <option value="">-- ระบุอาชีพ --</option>
                    <?php
                        $sql = "SELECT * FROM `item_occupation` ORDER BY item_occupation_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_occupation_id"].'">'.$row["item_occupation_id"].'. '.$row["item_occupation_name"].'</option>';
                        }
                    ?>
                    <option value="999">999. อื่นๆ ระบุ</option>
                </select>
            </div>
            <div class="form-group col-md-8">
                <label for="occupation_assign">ระบุ</label>
                <input type="text" class="form-control" id="occupation_assign" name="occupation_assign"
                    placeholder="ระบุอาชีพอื่นๆ..." required disabled>
            </div>
            <div class="form-group col-md-4">
                <label for="item_place_id">สถานที่ทำงาน/เรียน</label>
                <select class="form-control" id="item_place_id" name="item_place_id" required>
                    <option value="">-- ระบุสถานที่ทำงาน/เรียน --</option>
                    <?php
                        $sql = "SELECT * FROM `item_place` ORDER BY item_place_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_place_id"].'">'.$row["item_place_id"].'. '.$row["item_place_name"].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="back_home_id">กลับหมู่บ้าน</label>
                <select class="form-control" id="back_home_id" name="back_home_id" required>
                    <option value="">-- ระบุกลับหมู่บ้าน --</option>
                    <?php
                        foreach($ExtBackHome as $key=>$row) {
                            echo '<option value="'.$key.'">'.$key.'. '.$row.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="live_area_id">อาศัยอยู่ในพื้นที่</label>
                <select class="form-control" id="live_area_id" name="live_area_id" required>
                    <option value="">-- ระบุอาศัยอยู่ในพื้นที่ --</option>
                    <?php
                        foreach($ExtLiveArea as $key=>$row) {
                            echo '<option value="'.$key.'">'.$key.'. '.$row.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-8">
                <label for="item_disease_id">โรคเรื้อรัง</label>
                <select class="form-control" id="item_disease_id" name="item_disease_id" required>
                    <option value="">-- ระบุโรคเรื้อรัง --</option>
                    <?php
                        $sql = "SELECT * FROM `item_disease` ORDER BY item_disease_id";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            echo '<option value="'.$row["item_disease_id"].'">'.$row["item_disease_id"].'. '.$row["item_disease_name"].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="internet_id">เครือข่ายอินเทอร์เน็ต</label>
                <select class="form-control" id="internet_id" name="internet_id" required>
                    <option value="">-- ระบุเครือข่ายอินเทอร์เน็ต --</option>
                    <?php
                        foreach($ExtInternet as $key=>$row) {
                            echo '<option value="'.$key.'">'.$key.'. '.$row.'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <input type="submit" class="submit d-none">
    </form>
</div>