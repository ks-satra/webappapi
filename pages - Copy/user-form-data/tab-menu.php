<?php
    $sql = "SELECT * FROM form_step WHERE home_id='".$home["home_id"]."' ";
    $ObjFormStep = $DATABASE->QueryObj($sql);
    function GetFormStep($step) {
        global $ObjFormStep;
        foreach($ObjFormStep as $row) {
            if( $step==$row["step"] ) return true;
        }
        return false;
    }


    $menus = array(
        array("type"=>"section", "name"=>"หมวดที่ 1 ข้อมูลพื้นฐาน"),
        array("type"=>"link", "name"=>"<b>ตอนที่ 1</b> ข้อมูลพื้นฐานครัวเรือน", "tab"=>"1"),
        array("type"=>"link", "name"=>"<b>ตอนที่ 2</b> ผู้ให้ข้อมูล", "tab"=>"2"),
        array("type"=>"section", "name"=>"หมวดที่ 2 การรับประโยชน์"),
        array("type"=>"link", "name"=>"<b>ตอนที่ 3</b> การรับประโยชน์จากโครงการ", "tab"=>"3"),
        array("type"=>"section", "name"=>"หมวดที่ 3 สภาพครัวเรือน"),
        array("type"=>"link", "name"=>"<b>ตอนที่ 4</b> ที่อยู่อาศัย", "tab"=>"4"),
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
                if( GetFormStep($menu["tab"]) ) {
                    $icon = '<i class="fas fa-check text-success mr-1"></i>';
                } else {
                    $icon = '<i class="fas fa-exclamation-circle text-danger mr-1"></i>';
                }
                echo '
                    <a class="nav-link '.$active.'" href="./?page='.$PAGE.'&home_id='.$home_id.'&tab='.$menu["tab"].'">
                        '.$icon.' '.$menu["name"].'
                    </a>
                ';
            } else {
                echo '<div class="section-group">'.$menu["name"].'</div>';
            }
        }
    ?>
</nav>