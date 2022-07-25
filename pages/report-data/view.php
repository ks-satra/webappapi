<?php
    $sql = "
        SELECT
        ( SELECT IFNULL(SUM(income1.cost), 0) AS cost FROM home INNER JOIN income1 ON home.home_id = income1.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income1.income), 0) AS income FROM home INNER JOIN income1 ON home.home_id = income1.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income2.cost), 0) AS cost FROM home INNER JOIN income2 ON home.home_id = income2.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income2.income), 0) AS income FROM home INNER JOIN income2 ON home.home_id = income2.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income3.cost), 0) AS cost FROM home INNER JOIN income3 ON home.home_id = income3.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income3.income), 0) AS income FROM home INNER JOIN income3 ON home.home_id = income3.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income4.cost), 0) AS cost FROM home INNER JOIN income4 ON home.home_id = income4.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income4.income), 0) AS income FROM home INNER JOIN income4 ON home.home_id = income4.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income5.cost), 0) AS cost FROM home INNER JOIN income5 ON home.home_id = income5.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income5.income), 0) AS income FROM home INNER JOIN income5 ON home.home_id = income5.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income6.cost), 0) AS cost FROM home INNER JOIN income6 ON home.home_id = income6.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income6.income), 0) AS income FROM home INNER JOIN income6 ON home.home_id = income6.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income7.cost), 0) AS cost FROM home INNER JOIN income7 ON home.home_id = income7.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income7.income), 0) AS income FROM home INNER JOIN income7 ON home.home_id = income7.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income8.cost), 0) AS cost FROM home INNER JOIN income8 ON home.home_id = income8.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income8.income), 0) AS income FROM home INNER JOIN income8 ON home.home_id = income8.home_id WHERE home.`status`='2' ) AS income
        UNION ALL
        SELECT
        ( SELECT IFNULL(SUM(income9.cost), 0) AS cost FROM home INNER JOIN income9 ON home.home_id = income9.home_id WHERE home.`status`='2' ) AS cost,
        ( SELECT IFNULL(SUM(income9.income), 0) AS income FROM home INNER JOIN income9 ON home.home_id = income9.home_id WHERE home.`status`='2' ) AS income
    ";
    $Income = $DATABASE->QueryObj($sql);

    $sql = "
        SELECT
            income_other_item.*,
            SUM(income_other.income) AS amount
        FROM income_other_item
            LEFT JOIN income_other ON income_other_item.income_other_item_id = income_other.income_other_item_id
            INNER JOIN home ON income_other.home_id = home.home_id AND home.`status`='2'
        GROUP BY income_other_item_id
        ORDER BY income_other_item_id
    ";
    $IncomeOther = $DATABASE->QueryObj($sql);

    $sql = "
        SELECT
            IFNULL(SUM(income_family.amount), 0) AS amount
        FROM home
            INNER JOIN income_family ON home.home_id = income_family.home_id
        WHERE home.`status`='2'
    ";
    $IncomeFamily = $DATABASE->QueryString($sql);
?>
<div id="content-title">
    รายงานสภาพเศรษฐกิจ
</div>
<div id="content-body">
    <?php
        // for ($i='A'; $i<='Z'; $i++) {
        //     echo $i."<br>";
        // }
    ?>
    <div class="report-body">
        <!--<a href="pages/report-data/api/excel.php?t=<?php echo time(); ?>" class="btn btn-light border mr-2 mb-3">
            <i class="fas fa-file-excel mr-2"></i> ดาวน์โหลดข้อมูล Excel
        </a>
         <a href="pages/report-data/api/excel2.php?t=<?php echo time(); ?>" class="btn btn-light border mr-2 mb-3">
            <i class="fas fa-file-excel mr-2"></i> ดาวน์โหลดข้อมูลทั้งหมด Excel
        </a> -->
        <a href="Javascript:" id="btn-excel" class="btn btn-light border mr-2 mb-3">
            <i class="fas fa-file-excel mr-2"></i> ดาวน์โหลดข้อมูล Excel
        </a>
        <a href="Javascript:" id="btn-excel2" class="btn btn-light border mr-2 mb-3">
            <i class="fas fa-file-excel mr-2"></i> ดาวน์โหลดข้อมูลทั้งหมด Excel
        </a>
        <div class="form-number">
            จำนวนแบบสำรวจที่ได้ตรวจสอบทั้งหมด
            <?php
                $sql = "SELECT * FROM home WHERE `status`='2'";
                $obj = $DATABASE->QueryObj($sql);
                echo sizeof($obj);
            ?>
            ชุด
        </div>
        <table class="table table-bordered table-hover mb-5">
            <tr class="table-active">
                <th class="text-center">รายการ</th>
                <th class="text-center" style="width: 150px;">ต้นทุน (บาท)</th>
                <th class="text-center" style="width: 150px;">รายได้ (บาท)</th>
            </tr>
            <tbody>
                <tr class="level-1">
                    <td class="desc">รายการภาคการเกษตร</td>
                    <td class="amount">
                        <?php
                            $sum = $Income[0]["cost"]+$Income[1]["cost"]+$Income[2]["cost"]+$Income[3]["cost"]+$Income[4]["cost"]+$Income[5]["cost"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                    <td class="amount">
                        <?php
                            $sum = $Income[0]["income"]+$Income[1]["income"]+$Income[2]["income"]+$Income[3]["income"]+$Income[4]["income"]+$Income[5]["income"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                </tr>
                <tr class="level-2">
                    <td class="desc">พืช</td>
                    <td class="amount">
                        <?php
                            $sum = $Income[0]["cost"]+$Income[1]["cost"]+$Income[2]["cost"]+$Income[3]["cost"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                    <td class="amount">
                        <?php
                            $sum = $Income[0]["income"]+$Income[1]["income"]+$Income[2]["income"]+$Income[3]["income"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                </tr>
                <tr class="level-3">
                    <td class="desc">การปลูกข้าว</td>
                    <td class="amount"><?php echo number_format($Income[0]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[0]["income"], 2); ?></td>
                </tr>
                <tr class="level-3">
                    <td class="desc">การปลูกพืชผักสวนครัว/พืชอายุสั้น</td>
                    <td class="amount"><?php echo number_format($Income[1]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[1]["income"], 2); ?></td>
                </tr>
                <tr class="level-3">
                    <td class="desc">การปลูกพืชไร่</td>
                    <td class="amount"><?php echo number_format($Income[2]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[2]["income"], 2); ?></td>
                </tr>
                <tr class="level-3">
                    <td class="desc">การปลูกพืชสวน</td>
                    <td class="amount"><?php echo number_format($Income[3]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[3]["income"], 2); ?></td>
                </tr>
                <tr class="level-2">
                    <td class="desc">สัตว์</td>
                    <td class="amount">
                        <?php
                            $sum = $Income[4]["cost"]+$Income[5]["cost"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                    <td class="amount">
                        <?php
                            $sum = $Income[4]["income"]+$Income[5]["income"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                </tr>
                <tr class="level-3">
                    <td class="desc">ปศุสัตว์</td>
                    <td class="amount"><?php echo number_format($Income[4]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[4]["income"], 2); ?></td>
                </tr>
                <tr class="level-3">
                    <td class="desc">ประมง</td>
                    <td class="amount"><?php echo number_format($Income[5]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[5]["income"], 2); ?></td>
                </tr>
                <tr class="level-1">
                    <td class="desc">รายการนอกภาคการเกษตร</td>
                    <td class="amount">
                        <?php
                            $sum = $Income[6]["cost"]+$Income[7]["cost"]+$Income[8]["cost"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                    <td class="amount">
                        <?php
                            $sum = $Income[6]["income"]+$Income[7]["income"]+$Income[8]["cost"];
                            echo number_format($sum, 2);
                        ?>
                    </td>
                </tr>
                <tr class="level-2">
                    <td class="desc">หัตถกรรม</td>
                    <td class="amount"><?php echo number_format($Income[6]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[6]["income"], 2); ?></td>
                </tr>
                <tr class="level-2">
                    <td class="desc">การค้าขาย</td>
                    <td class="amount"><?php echo number_format($Income[7]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[7]["income"], 2); ?></td>
                </tr>
                <tr class="level-2">
                    <td class="desc">อาหารธรรมชาติ</td>
                    <td class="amount"><?php echo number_format($Income[8]["cost"], 2); ?></td>
                    <td class="amount"><?php echo number_format($Income[8]["income"], 2); ?></td>
                </tr>
                <tr class="level-2">
                    <td class="desc">รายได้อื่น ๆ</td>
                    <td class="amount">-</td>
                    <td class="amount">
                        <?php 
                            $sum = 0;
                            foreach($IncomeOther as $row) {
                                $sum += $row["amount"];
                            }
                            echo number_format($sum, 2); 
                        ?>
                    </td>
                </tr>
                <?php
                    foreach($IncomeOther as $key=>$row) {
                        echo '
                            <tr class="level-3">
                                <td class="desc">'.$row["income_other_item_name"].'</td>
                                <td class="amount">-</td>
                                <td class="amount">'.number_format($row["amount"], 2).'</td>   
                            </tr>
                        ';
                    }
                ?>
                <tr class="level-2">
                    <td class="desc">รายได้จากสมาชิกในครัวเรือน</td>
                    <td class="amount">-</td>
                    <td class="amount"><?php echo number_format($IncomeFamily, 2); ?></td>
                </tr>
            </tbody>
        </table>





        <table class="table table-bordered table-hover">
            <thead class="table-active">
                <th class="text-center">รายการอื่น ๆ</th>
                <th class="text-center" style="width: 150px;">ยอดเงิน (บาท)</th>
            </thead>
            <tbody>
                <tr class="level-1">
                    <td class="desc">เงินออม</td>
                    <td class="amount">
                        <?php
                            $sql = "
                                SELECT
                                    IFNULL(SUM(saving.amount), 0) AS amount
                                FROM home
                                    INNER JOIN saving ON home.home_id = saving.home_id
                                WHERE home.`status`='2'
                            ";
                            $amount = $DATABASE->QueryString($sql);
                            echo number_format($amount, 2);
                        ?>
                    </td>
                </tr>
                <?php
                    $sql = "
                        SELECT
                            saving_item.*,
                            IFNULL( SUM(saving.amount), 0) AS amount
                        FROM saving_item
                            LEFT JOIN (
                                SELECT
                                    saving.*
                                FROM saving
                                    INNER JOIN home ON saving.home_id = home.home_id AND home.`status`='2'
                            ) saving ON saving_item.saving_item_id = saving.saving_item_id
                        GROUP BY saving_item_id
                        ORDER BY saving_item_id
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    foreach($obj as $key=>$row) {
                        echo '
                            <tr class="level-2">
                                <td class="desc">'.$row["saving_item_name"].'</td>
                                <td class="amount">'.number_format($row["amount"], 2).'</td>  
                            </tr>
                        ';
                    }
                ?>
                <tr class="level-1">
                    <td class="desc">เงินช่วยเหลือ</td>
                    <td class="amount">
                        <?php
                            $sql = "
                                SELECT
                                    IFNULL(SUM(help.total_price), 0) AS amount
                                FROM home
                                    INNER JOIN help ON home.home_id = help.home_id
                                WHERE home.`status`='2'
                            ";
                            $amount = $DATABASE->QueryString($sql);
                            echo number_format($amount, 2);
                        ?>
                    </td>
                </tr>
                <?php
                    $sql = "
                        SELECT
                            help_item.*,
                            IFNULL( SUM(help.total_price), 0) AS amount
                        FROM help_item
                            LEFT JOIN (
                                SELECT
                                    help.*
                                FROM help
                                    INNER JOIN home ON help.home_id = home.home_id AND home.`status`='2'
                            ) help ON help_item.help_item_id = help.help_item_id
                        GROUP BY help_item_id
                        ORDER BY help_item_id
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    foreach($obj as $key=>$row) {
                        echo '
                            <tr class="level-2">
                                <td class="desc">'.$row["help_item_name"].'</td>
                                <td class="amount">'.number_format($row["amount"], 2).'</td>  
                            </tr>
                        ';
                    }
                ?>
                <?php
                    $sql = "
                        SELECT
                            expense_item.*,
                            IFNULL( SUM(expense.total_expense), 0) AS amount
                        FROM expense_item
                            LEFT JOIN (
                                SELECT
                                    expense.*
                                FROM expense
                                    INNER JOIN home ON expense.home_id = home.home_id AND home.`status`='2'
                            ) expense ON expense_item.expense_item_id = expense.expense_item_id
                        GROUP BY expense_item.expense_item_id
                        ORDER BY expense_item.expense_item_id
                    ";
                    $objExpense = $DATABASE->QueryObj($sql);
                    $expense = 0;
                    $expense1 = 0;
                    $expense2 = 0;
                    $expense3 = 0;
                    foreach($objExpense as $key=>$row) {
                        $expense += $row["amount"];
                        $expense1 += ( $row["expense_type_id"]=="1" ) ? $row["amount"] : 0;
                        $expense2 += ( $row["expense_type_id"]=="2" ) ? $row["amount"] : 0;
                        $expense3 += ( $row["expense_type_id"]=="3" ) ? $row["amount"] : 0;
                    }
                ?>
                <tr class="level-1">
                    <td class="desc">รายจ่าย</td>
                    <td class="amount"><?php echo number_format($expense, 2); ?></td>
                </tr>
                <tr class="level-2">
                    <td class="desc">ค่าใช้จ่ายเพื่อการบริโภค</td>
                    <td class="amount"><?php echo number_format($expense1, 2); ?></td>
                </tr>
                <?php
                    foreach($objExpense as $key=>$row) {
                        if( $row["expense_type_id"]=="1" ) {
                            echo '
                                <tr class="level-3">
                                    <td class="desc">'.$row["expense_item_name"].'</td>
                                    <td class="amount">'.number_format($row["amount"], 2).'</td>   
                                </tr>
                            ';
                        }
                    }
                ?>
                <tr class="level-2">
                    <td class="desc">ค่าใช้จ่ายเพื่อการอุปโภค</td>
                    <td class="amount"><?php echo number_format($expense2, 2); ?></td>
                </tr>
                <?php
                    foreach($objExpense as $key=>$row) {
                        if( $row["expense_type_id"]=="2" ) {
                            echo '
                                <tr class="level-3">
                                    <td class="desc">'.$row["expense_item_name"].'</td>
                                    <td class="amount">'.number_format($row["amount"], 2).'</td>   
                                </tr>
                            ';
                        }
                    }
                ?>
                <tr class="level-2">
                    <td class="desc">ค่าใช้จ่ายที่ไม่เกี่ยวกับการอุปโภคบริโภค</td>
                    <td class="amount"><?php echo number_format($expense3, 2); ?></td>
                </tr>
                <?php
                    foreach($objExpense as $key=>$row) {
                        if( $row["expense_type_id"]=="3" ) {
                            echo '
                                <tr class="level-3">
                                    <td class="desc">'.$row["expense_item_name"].'</td>
                                    <td class="amount">'.number_format($row["amount"], 2).'</td>   
                                </tr>
                            ';
                        }
                    }
                ?>
                <tr class="level-1">
                    <td class="desc">หนี้สิน</td>
                    <td class="amount">
                        <?php
                            $sql = "
                                SELECT
                                    IFNULL(SUM(debt.amount), 0) AS amount
                                FROM home
                                    INNER JOIN debt ON home.home_id = debt.home_id
                                WHERE home.`status`='2'
                            ";
                            $amount = $DATABASE->QueryString($sql);
                            echo number_format($amount, 2);
                        ?>
                    </td>
                </tr>
                <?php
                    $sql = "
                        SELECT
                            debt_item.*,
                            IFNULL( SUM(debt.amount), 0) AS amount
                        FROM debt_item
                            LEFT JOIN (
                                SELECT
                                    debt.*
                                FROM debt
                                    INNER JOIN home ON debt.home_id = home.home_id AND home.`status`='2'
                            ) debt ON debt_item.debt_item_id = debt.debt_item_id
                        GROUP BY debt_item_id
                        ORDER BY debt_item_id
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    foreach($obj as $key=>$row) {
                        echo '
                            <tr class="level-2">
                                <td class="desc">'.$row["debt_item_name"].'</td>
                                <td class="amount">'.number_format($row["amount"], 2).'</td>  
                            </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>