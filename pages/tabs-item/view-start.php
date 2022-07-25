<style>
.nav-link.active {
    background-color: #e1e1e1;
}
</style>
<div class="row">
    <div class="col-lg-4">
        <nav class="nav flex-column">
            <!-- ตอนที่ 1 -->
            <a class="nav-link <?php if($PAGE=="admin-prefix") echo "active"; ?>"
                href="./?page=admin-prefix">ข้อมูลคำนำหน้า</a>

            <!-- ตอนที่ 7.5 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-area-utilization") echo "active"; ?>"
                href="./?page=admin-area-utilization">ข้อมูลการใช้ประโยชน์พื้นที่ <b class="text-success">(7.5)</b></a> -->
            <!-- ตอนที่ 7.8 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-area-water") echo "active"; ?>"
                href="./?page=admin-area-water">ข้อมูลแหล่งน้ำที่ใช้ในแปลง <b class="text-success">(7.8)</b></a> -->
            <!-- ตอนที่ 7.9 -->
            <a class="nav-link <?php if($PAGE=="admin-area-status") echo "active"; ?>"
                href="./?page=admin-area-status">ข้อมูลสถานะพื้นที่ทำกิน <b class="text-success">(7.9)</b></a>
            <!-- ตอนที่ 9.2 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-behavior") echo "active"; ?>"
                href="./?page=admin-behavior">ข้อมูลการปฏิบัติตัวเริ่มต้น <b class="text-success">(9.2)</b></a> -->
            <!-- ตอนที่ 9.4 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-contagious") echo "active"; ?>"
                href="./?page=admin-contagious">ข้อมูลโรคติดต่อที่เคยเจ็บป่วย <b class="text-success">(9.4)</b></a> -->
            <!-- ตอนที่ 9.6 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-disability") echo "active"; ?>"
                href="./?page=admin-disability">ข้อมูลความพิการของสมาชิก <b class="text-success">(9.6)</b></a> -->
            <!-- ตอนที่ 10 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-society") echo "active"; ?>"
                href="./?page=admin-society">ข้อมูลสุขภาวะด้านสภาพทางสังคมของชุมชน <b class="text-success">(10)</b></a> -->
            <!-- ตอนที่ 11 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-environment") echo "active"; ?>"
                href="./?page=admin-environment">ข้อมูลสุขภาวะด้านสภาพสิ่งแวดล้อมในชุมชน <b class="text-success">(11)</b></a> -->
            <!-- ตอนที่ 12.8 -->
            <a class="nav-link <?php if($PAGE=="admin-education") echo "active"; ?>"
                href="./?page=admin-education">ข้อมูลระดับการศึกษาสูงสุด <b class="text-success">(12.8)</b></a>
            <!-- ตอนที่ 12.9 -->
            <a class="nav-link <?php if($PAGE=="admin-work") echo "active"; ?>"
                href="./?page=admin-work">ข้อมูลสถานะการทำงาน <b class="text-success">(12.9)</b></a>
            <!-- ตอนที่ 12.10 -->
            <a class="nav-link <?php if($PAGE=="admin-occupation") echo "active"; ?>"
                href="./?page=admin-occupation">ข้อมูลอาชีพ <b class="text-success">(12.10)</b></a>
            <!-- ตอนที่ 12.11 -->
            <a class="nav-link <?php if($PAGE=="admin-place") echo "active"; ?>"
                href="./?page=admin-place">ข้อมูลสถานที่ทำงาน/เรียน <b class="text-success">(12.11)</b></a>
            <!-- ตอนที่ 12.14 -->
            <a class="nav-link <?php if($PAGE=="admin-disease") echo "active"; ?>"
                href="./?page=admin-disease">ข้อมูลโรคเรื้อรัง <b class="text-success">(12.14)</b></a>
            <!-- ตอนที่ 13.1 -->
            <a class="nav-link <?php if($PAGE=="admin-rice") echo "active"; ?>"
                href="./?page=admin-rice">ข้อมูลชนิดของข้าว <b class="text-success">(13.1)</b></a>
            <!-- ตอนที่ 13.11 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-market") echo "active"; ?>"
                href="./?page=admin-market">ข้อมูลลักษณะการขาย <b class="text-success">(13.11)</b></a> -->
            <!-- ตอนที่ 14.1 -->
            <a class="nav-link <?php if($PAGE=="admin-vegetable") echo "active"; ?>"
                href="./?page=admin-vegetable">ข้อมูลชนิดของพืชผักสวนครัว/พืชอายุสั้น <b
                    class="text-success">(14.1)</b></a>
            <!-- ตอนที่ 15.1 -->
            <a class="nav-link <?php if($PAGE=="admin-farm") echo "active"; ?>"
                href="./?page=admin-farm">ข้อมูลชนิดของพืชไร่ <b class="text-success">(15.1)</b></a>
            <!-- ตอนที่ 16.1 -->
            <a class="nav-link <?php if($PAGE=="admin-horticulture") echo "active"; ?>"
                href="./?page=admin-horticulture">ข้อมูลชนิดของพืชสวน <b class="text-success">(16.1)</b></a>
            <!-- ตอนที่ 17.1 -->
            <a class="nav-link <?php if($PAGE=="admin-wood") echo "active"; ?>"
                href="./?page=admin-wood">ข้อมูลชนิดของไม้เศรษฐกิจ <b class="text-success">(17.1)</b></a>
            <!-- ตอนที่ 18.1 -->
            <a class="nav-link <?php if($PAGE=="admin-animal-land") echo "active"; ?>"
                href="./?page=admin-animal-land">ข้อมูลชนิดสัตว์บก <b class="text-success">(18.1)</b></a>
            <!-- ตอนที่ 19.1 -->
            <a class="nav-link <?php if($PAGE=="admin-animal-water") echo "active"; ?>"
                href="./?page=admin-animal-water">ข้อมูลชนิดสัตว์ในน้ำ <b class="text-success">(19.1)</b></a>
            <!-- ตอนที่ 19.2 -->
            <a class="nav-link <?php if($PAGE=="admin-product-water") echo "active"; ?>"
                href="./?page=admin-product-water">ข้อมูลผลิตภัณฑ์การทำประมง <b class="text-success">(19.2)</b></a>
            <!-- ตอนที่ 24 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-income-other") echo "active"; ?>"
                href="./?page=admin-income-other">ข้อมูลแหล่งรายได้ <b class="text-success">(24)</b></a> -->
            <!-- ตอนที่ 26 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-saving") echo "active"; ?>"
                href="./?page=admin-saving">ข้อมูลประเภทเงินออม <b class="text-success">(26)</b></a> -->
            <!-- ตอนที่ 27 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-help") echo "active"; ?>"
                href="./?page=admin-help">ข้อมูลแหล่งเงินช่วยเหลือ <b class="text-success">(27)</b></a> -->
            <!-- ตอนที่ 28 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-expense1") echo "active"; ?>"
                href="./?page=admin-expense1">ข้อมูลค่าใช้จ่ายเพื่อการบริโภค <b class="text-success">(28)</b></a> -->
            <!-- ตอนที่ 29 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-expense2") echo "active"; ?>"
                href="./?page=admin-expense2">ข้อมูลค่าใช้จ่ายเพื่อการอุปโภค <b class="text-success">(29)</b></a> -->
            <!-- ตอนที่ 30 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-expense3") echo "active"; ?>"
                href="./?page=admin-expense3">ข้อมูลค่าใช้จ่ายที่ไม่เกี่ยวกับการอุปโภคบริโภค (ค่าใช้จ่ายอื่นๆ) <b class="text-success">(30)</b></a> -->
            <!-- ตอนที่ 31 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-debt-purpose") echo "active"; ?>"
                href="./?page=admin-debt-purpose">ข้อมูลวัตถุประสงค์ในการกู้ <b class="text-success">(31)</b></a> -->
            <!-- ตอนที่ 31 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-debt-borrow") echo "active"; ?>"
                href="./?page=admin-debt-borrow">ตัวเลือกแหล่งกู้ยืม <b class="text-success">(31)</b></a> -->
            <!-- ตอนที่ 32 -->
            <!-- <a class="nav-link <?php if($PAGE=="admin-asset") echo "active"; ?>"
                href="./?page=admin-asset">รายการทรัพย์สิน <b class="text-success">(32)</b></a> -->


        </nav>
    </div>
    <div class="col-lg-8">