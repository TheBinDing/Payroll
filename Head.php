<?php
  $sql = " SELECT Social_Number FROM [HRP].[dbo].[SocialSecurity] ";
  $query = mssql_query($sql);
  $row = mssql_fetch_array($query);
?>
<!-- <div class="bs-example" data-example-id="nav-pills-with-dropdown"> -->
   <ul class="nav nav-pills">
      <li role="presentation">
         <a href="News.php?page=1">
            <span>หน้าแรก</span>
         </a>
      </li>
      <li role="presentation" class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> จัดการข้อมูล <span class="caret"></span> </a>
         <ul class="dropdown-menu">
            <li><a href='Structure.php'><span>โครงการ</span></a></li>
            <li><a href='Position.php'><span>ตำแหน่ง</span></a></li>
            <li><a href='Dependency.php'><span>ชุด/สังกัด</span></a></li>
            <li><a href='Scan.php'><span>เครื่องสแกนนิ้วมือ</span></a></li>
         </ul>
      </li>
      <li role="presentation" class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> จัดการบุคคลากร <span class="caret"></span> </a>
         <ul class="dropdown-menu">
            <li><a href='Employee.php'><span>ข้อมูลพนักงาน</span></a></li>
            <!-- <li><a href='#'><span>ข้อมูลการลาพนักงาน</span></a></li>
            <li><a href='#'><span>ข้อมูล โยกย้าย/ปรับเปลี่ยน</span></a></li>
            <li><a href='#'><span>พนักงานเข้ากะ / พนักงานออก</span></a></li> -->
         </ul>
      </li>
      <li role="presentation" class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> จัดการแผนเวลาทำงาน <span class="caret"></span> </a>
         <ul class="dropdown-menu">
            <li><a href='Plan.php'><span>ตั้งค่าแผนเวลา</span></a></li>
            <li><a href='PlanPeople.php'><span>แผนเวลาบุคคล</span></a></li>
         </ul>
      </li>
      <li role="presentation" class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> จัดการเวลา <span class="caret"></span> </a>
         <ul class="dropdown-menu">
            <li><a href='Import_File.php'><span>นำเข้า ไฟล์เวลา</span></a></li>
            <li><a href='TimeCal.php'><span>คำนวณชั่วโมงทำงาน</span></a></li>
            <li><a href='TimePlan.php'><span>คำนวณค่าเวลาและ OT</span></a></li>
         </ul>
      </li>
      <li role="presentation" class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> จัดการเงิน <span class="caret"></span> </a>
         <ul class="dropdown-menu">
            <li>
               <a data-toggle="modal" data-target="#myModal4"><span>ประกันสังคม</span></a>
               <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content animated fadeIn">
                           <form name="frmMain" method="post" action="func/SocailUpdate.php" target="iframe_target">
                           <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                              <div class="modal-header">
                                <h2>ประกันสังคม</h2>
                              </div>
                              <div class="modal-body">
                                 <label class="control-label">แก้ไขประกันสังคม (%)</label>
                                 <input type="number" value="<?php echo $row['Social_Number']; ?>" id="So" name="So" required="required" class="form-control" style="text-align: center;height: 30px;">
                              </div>
                              <div class="modal-footer">
                                 <button class="btn btn-success Soc">บันทึก</button>
                              </div>
                           </form>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href='Expenses.php'><span>การเบิกอุปกรณ์หรือค่าใช้จ่ายอื่นๆ</span></a></li>
            <li><a href='CalcuMoney.php'><span>คำนวณเงิน</span></a></li>
         </ul>
      </li>
      <!-- <li role="presentation" class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> รายงาน <span class="caret"></span> </a>
         <ul class="dropdown-menu">
            <li><a href='Report.php'><span>รายงาน</span></a></li>
            <li><a href='#'><span>ใบ Support ปะหน้า</span></a></li>
            <li><a href='#'><span>ใบสลิปเงินเดือน</span></a></li>
            <li><a href='#'><span>ใบเวลาทำงานและOT</span></a></li>
            <li><a href='#'><span>ใบรายการหัก เบิก-จ่าย</span></a></li>
         </ul>
      </li> -->
      <li role="presentation">
         <a href='Report.php'>
            <span>รายงาน</span>
         </a>
      </li>
      <li role="presentation">
         <a href="#">
            <span>ติดต่อ</span>
         </a>
      </li>
   </ul>
<!-- </div> -->
