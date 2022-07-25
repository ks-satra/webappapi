<?php
    $sql = "
        SELECT
            province.province_id, 
            province.province_name_thai,
            area.province_code
        FROM area
            INNER JOIN user_area ON area.province_id = user_area.province_id
            INNER JOIN province ON user_area.province_id = province.province_id
        WHERE user_area.user_id='".$USER["user_id"]."'
    ";
    $UserArea = $DATABASE->QueryObj($sql);
?>
<div id="content-title">
    เพิ่มแบบสำรวจ
</div>
<div id="content-body">
    <?php
        // PrintData($YEAR_NAME);
    ?>
    <form id="formdata" class="mb-3" autocomplete="off">
        <div class="row">
            <div class="col-lg-6">
                <?php
                    $tab = "1";
                    $menus = array(
                        array("type"=>"section", "name"=>"หมวดที่ 1 ข้อมูลพื้นฐาน"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 1</b> ข้อมูลพื้นฐานครัวเรือน", "tab"=>"1", "icon"=>@$home["home_id"]),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 2</b> ผู้ให้ข้อมูล", "tab"=>"2", "icon"=>((@$home["informant_prefix_id"]=="0")?"":@$home["informant_prefix_id"])),
                        array("type"=>"section", "name"=>"หมวดที่ 2 การรับประโยชน์"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 3</b> การรับประโยชน์จากโครงการ", "tab"=>"3", "icon"=>((@$form["ch1"]=="0")?"":@$form["ch1"])),
                        array("type"=>"section", "name"=>"หมวดที่ 3 สภาพครัวเรือน"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 4</b> ที่อยู่อาศัย", "tab"=>"4", "icon"=>@$form["ch21"]),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 5</b> ไฟฟ่า", "tab"=>"5"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 6</b> น้ำ", "tab"=>"6"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 7</b> พื้นที่ทำกิน (ไม่รวมพื้นที่บ้าน)", "tab"=>"7"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 8</b> ความพออยู่พอกิน", "tab"=>"8"),
                        array("type"=>"section", "name"=>"หมวดที่ 4 สุขภาวะ"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 9</b> สุขภาวะด้านสุขภาพ", "tab"=>"9"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 10</b> สุขภาวะด้านสิ่งแวดล้อมในชุมชน", "tab"=>"10"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 11</b> สุขภาวะด้านสภาพทางสังคมของชุมชน", "tab"=>"11"),
                        array("type"=>"section", "name"=>"หมวดที่ 5 ข้อมูลสมาชิกในครัวเรือน"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 12</b> ข้อมูลสมาชิกที่อาศัยอยู่ในปัจจุบัน", "tab"=>"12"),
                        array("type"=>"section", "name"=>"หมวดที่ 6 สภาพทางเศรษฐกิจ"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 13</b> รายได้จากการปลูกข้าว", "tab"=>"13"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 14</b> รายได้จากการปลูกพืชผักสวนครัว/พืชอายุสั้น", "tab"=>"14"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 15</b> รายได้จากการปลูกพืชไร่", "tab"=>"15"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 16</b> รายได้จากการปลูกพืชสวน", "tab"=>"16"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 17</b> รายได้จากการปลูกไม้เศรษฐกิจ", "tab"=>"17"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 18</b> รายได้จากการทำปศุสัตว์", "tab"=>"18"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 19</b> รายได้จากการทำประมง", "tab"=>"19"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 20</b> รายได้จากผลิตภัณฑ์แปรรูป/ผลิตภัณฑ์ OTOP/ผลิตภัณฑ์ในชุมชน", "tab"=>"20"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 21</b> รายได้จากการทำงานหัตถกรรม", "tab"=>"21"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 22</b> รายได้จากการค้าขาย/ร้านค้า", "tab"=>"22"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 23</b> รายได้จากการหาอาหารธรรมชาติ (การลดรายจ่าย)", "tab"=>"23"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 24</b> รายได้จากแหล่งรายได้อื่น ๆ", "tab"=>"24"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 25</b> รายได้ประจำของสมาชิกในครัวเรือน", "tab"=>"25"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 26</b> เงินออม", "tab"=>"26"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 27</b> เงินช่วยเหลือ", "tab"=>"27"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 28</b> ค่าใช้จ่ายเพื่อการบริโภค", "tab"=>"28"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 29</b> ค่าใช้จ่ายเพื่อการอุปโภค", "tab"=>"29"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 30</b> ค่าใช้จ่ายที่ไม่เกี่ยวกับการอุปโภคบริโภค (ค่าใช้จ่ายอื่น ๆ)", "tab"=>"30"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 31</b> หนี้สิน", "tab"=>"31"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 32</b> ทรัพย์สินสำหรับการประกอบอาชีพ", "tab"=>"32"),
                        array("type"=>"section", "name"=>"หมวดที่ 7 ความสามารถในการจัดการชีวิตของครอบครัว"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 33</b> การจดบันทึกค่าใช้จ่าย", "tab"=>"33"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 34</b> การเป็นสมาชิกกลุ่ม", "tab"=>"34"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 35</b> โอกาสและการประกอบอาชีพ", "tab"=>"35"),
                        array("type"=>"section", "name"=>"หมวดที่ 8 สำหรับเจ้าหน้าที่"),
                        array("type"=>"link", "name"=>"<b>ตอนที่ 36</b> สำหรับเจ้าหน้าที่", "tab"=>"36"),
                    );
                ?>
                <nav class="nav flex-column section-menu">
                    <?php
                        foreach($menus as $menu) {
                            if( $menu["type"]=="link" ) {
                                $active = ($tab==$menu["tab"]) ? "active" : "";
                                $disabled = "disabled";
                                if( $tab==$menu["tab"] ) $disabled = "";
                                if( @$menu["icon"]=="" ) {
                                    $icon = '<i class="fas fa-exclamation-circle text-danger mr-1"></i>';
                                } else {
                                    $icon = '<i class="fas fa-check text-success mr-1"></i>';
                                }
                                echo '
                                    <a class="nav-link '.$active.' '.$disabled.'" href="./?page='.$PAGE.'">
                                        '.$icon.' '.$menu["name"].'
                                    </a>
                                ';
                            } else {
                                echo '<div class="section-group">'.$menu["name"].'</div>';
                            }
                        }
                    ?>
            </div>
            <div class="col-lg-6">
                <div class="informant">
                    <i class="fas fa-folder mr-2"></i> ข้อมูลแบบสำรวจ
                </div>
                <div class="form-group row">
                    <label for="area_province_id" class="col-md-5 col-form-label">พื้นที่ดูแล <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <select id="area_province_id" name="area_province_id" class="form-control" required>
                            <?php
                                foreach($UserArea as $row) {
                                    echo '<option value="'.$row["province_id"].'">['.$row["province_code"].'] จังหวัด'.$row["province_name_thai"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="area_province_id" class="col-md-5 col-form-label">หมายเลขแบบสำรวจ</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="form_code" name="form_code" value="" disabled>
                    </div>
                </div>
                <div class="informant">
                    <i class="fas fa-folder mr-2"></i> ข้อมูลพื้นฐานครัวเรือน
                </div>
                <div class="form-group row">
                    <label for="home_code" class="col-md-5 col-form-label">รหัสประจำบ้าน <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="home_code" name="home_code" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item_domination_id" class="col-md-5 col-form-label">เขตการปกครอง <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <select class="form-control" id="item_domination_id" name="item_domination_id">
                            <?php
                                $sql = "SELECT * FROM item_domination ORDER BY item_domination_id";
                                $obj = $DATABASE->QueryObj($sql);
                                foreach($obj as $row) {
                                    echo '<option value="'.$row["item_domination_id"].'">'.$row["item_domination_name"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="home_no" class="col-md-5 col-form-label">บ้านเลขที่ <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="home_no" name="home_no" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="moo" class="col-md-5 col-form-label">หมู่ที่</label>
                    <div class="col-md-7">
                        <select class="form-control" id="moo" name="moo">
                            <option value="">ไม่มี</option>
                            <?php
                                for($i=1; $i<=15; $i++) {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="village_name" class="col-md-5 col-form-label">ชื่อหมู่บ้าน <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="village_name" name="village_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tambol_id" class="col-md-5 col-form-label">
                        ค้นหาตำบล <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="tambol_id" data-toggle="tooltip"
                            title="โปรดพิมพ์ชื่อตำบล และเลือกจากรายการที่แสดงขึ้นมาเท่านั้น" required>
                        <small class="form-text text-muted">
                            <span class="fa fa-search form-control-feedback"></span> โปรดพิมพ์ชื่อตำบล
                            และเลือกจากรายการที่แสดงขึ้นมาเท่านั้น</small>
                        <input type="hidden" name="tambol_id">
                        <input type="hidden" name="amphur_id">
                        <input type="hidden" name="province_id" value="<?php echo $UserArea[0]["province_id"]; ?>">
                        <input type="hidden" name="zipcode">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amphur_id" class="col-md-5 col-form-label">อำเภอ <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="amphur_id" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amphur_id" class="col-md-5 col-form-label">จังหวัด <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="province_id"
                            value="<?php echo $UserArea[0]["province_name_thai"]; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="zipcode" class="col-md-5 col-form-label">รหัสไปรษณีย์ <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="zipcode" disabled>
                    </div>
                </div>
                <div class="informant">
                    <i class="fas fa-folder mr-2"></i> เจ้าของบ้านตามทะเบียนบ้าน
                </div>
                <div class="form-group row">
                    <label for="owner_prefix_id" class="col-md-5 col-form-label">คำนำหน้า <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <select id="owner_prefix_id" name="owner_prefix_id" class="form-control" required>
                            <option value="">-- กรุณาระบุคำนำหน้าชื่อ --</option>
                            <?php
                                $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                                $obj = $DATABASE->QueryObj($sql);
                                foreach($obj as $row) {
                                    echo '<option value="'.$row["item_prefix_id"].'">'.$row["item_prefix_name"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_name" class="col-md-5 col-form-label">ชื่อ <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="owner_name" name="owner_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_lname" class="col-md-5 col-form-label">นามสกุล <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="owner_lname" name="owner_lname" required>
                    </div>
                </div>
                <div class="informant">
                    <i class="fas fa-folder mr-2"></i> จำนวนสมาชิกทั้งหมดในครัวเรือน
                </div>
                <div class="form-group row">
                    <label class="col-md-5 col-form-label">จำนวนสมาชิก (คน) <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="0" disabled>
                        <small class="form-text text-muted">
                            ข้อมูลนี้ดึงมาจากตอนที่ 12
                            ข้อมูลสมาชิกที่อาศัยในปัจจุบัน</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="home_family_count" class="col-md-5 col-form-label">จำนวนครอบครัว (ครอบครัว) <span
                            class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <select class="form-control" id="home_family_count" name="home_family_count" required>
                            <?php
                                for($i=1; $i<=10; $i++) {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-success"><i class="fas fa-plus mr-2"></i>
                        ยืนยันการเพิ่มข้อมูล</button>
                </div>
            </div>
        </div>
    </form>
</div>