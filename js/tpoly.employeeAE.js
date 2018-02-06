var tpoly = {
    employeeAE: new Object()
};

(function ( $ ) {
    tpoly.popup = function(value) {
        if(value == 'loading'){
            $('#block').css('display','block');
            $('#loading').fadeIn();
            $('html').css('overflow','hidden');
            $('body').css('overflow','hidden');
        }
        else if(value == 'close'){
            $('#block').css('display','none');
            $('#loading').css('display','none');
            $('html').css('overflow','auto');
            $('body').css('overflow','auto');
        }
    }

    tpoly.employeeAE.Excels = function() {
        var i =  $('#EmployeeIDs').val();
        if(i == 'W' || i == '' || i == ' ') {
            window.open("excel/ExportToExcel.php?Status=W");
        }
        if(i == 'O') {
            window.open("excel/ExportToExcel.php?Status="+ i);
        }
        if(i == 'B') {
            window.open("excel/ExportToExcel.php?Status="+ i);
        }
    }

    tpoly.employeeAE.swap = function() {
        CodeIDs = $('#Em_IDs').val();

        window.location = "EmployeeDetail.php?Em_ID="+ CodeIDs +"&page=Edit";
    }

    tpoly.employeeAE.age = function(dob, today) {
        var today = today || new Date(),
            result = {
              years: 0,
              months: 0,
              days: 0,
              toString: function() {
                return (this.years ? this.years + '-' : 0 + '-')
                  + (this.months ? this.months + '-' : 0 + '-')
                  + (this.days ? this.days : 0);
              }
            };
        result.months =
          ((today.getFullYear() * 12) + (today.getMonth() + 1))
          - ((dob.getFullYear() * 12) + (dob.getMonth() + 1));
        if (0 > (result.days = today.getDate() - dob.getDate())) {
            var y = today.getFullYear(), m = today.getMonth();
            m = (--m < 0) ? 11 : m;
            result.days +=
              [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m]
                + (((1 == m) && ((y % 4) == 0) && (((y % 100) > 0) || ((y % 400) == 0))) 
                    ? 1 : 0);
            --result.months;
        }
        result.years = (result.months - (result.months % 12)) / 12;
        result.months = (result.months % 12);
        return result;
    }

    tpoly.employeeAE.formatDate = function(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }

    tpoly.employeeAE.formatDateSeach = function(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    tpoly.employeeAE.page = function() {
        p = $('#employeePage').val();

        id1 = $("#tab1").attr("class");
        id2 = $("#tab2").attr("class");
        id3 = $("#tab3").attr("class");

        if(id1 == 'active'){
            status = 'W';
        }
        if(id2 == 'active'){
            status = 'O';
        }
        if(id3 == 'active'){
            status = 'B';
        }

        tpoly.employeeAE.loadEmployee('', p, status);
    }

    tpoly.employeeAE.setStatus = function(status) {
        if(status == 'W') {
            $('#employeePage').val(10);
            $('#EmployeeIDs').val('W');
        }
        if(status == 'O') {
            $('#employeePage').val(10);
            $('#EmployeeIDs').val('O');
        }
        if(status == 'B') {
            $('#employeePage').val(10);
            $('#EmployeeIDs').val('B');
        }

        tpoly.employeeAE.loadEmployee('', 10, status);
    }

    tpoly.employeeAE.setSearch = function(obj) {
        vv = $(obj).val();

        p = $('#employeePage').val();

        id1 = $("#tab1").attr("class");
        id2 = $("#tab2").attr("class");
        id3 = $("#tab3").attr("class");

        if(id1 == 'active'){
            status = 'W';
        }
        if(id2 == 'active'){
            status = 'O';
        }
        if(id3 == 'active'){
            status = 'B';
        }

        tpoly.employeeAE.loadEmployee(vv, p, status);
    }

    tpoly.employeeAE.setPageSline = function(value) {

        p = $('#employeePage').val();

        id1 = $("#tab1").attr("class");
        id2 = $("#tab2").attr("class");
        id3 = $("#tab3").attr("class");

        if(id1 == 'active'){
            status = 'W';
        }
        if(id2 == 'active'){
            status = 'O';
        }
        if(id3 == 'active'){
            status = 'B';
        }

        tpoly.employeeAE.loadEmployee('', p, status, value);
    }

    tpoly.employeeAE.loadEmployee = function(obj, page, status, value) {
        // console.log(obj+'--'+page+'--'+status+'--'+value);
        vv = obj;
        tpoly.employeeAE.Criteria['name'] = '';
        tpoly.employeeAE.Criteria['id'] = '';

        if(status == undefined) {
            status = 'W';
        }

        if(page == undefined || page == '') {
            page = $('#employeePage').val();
        }

        if(vv != undefined || vv != '') {
            if(isNaN(vv)) {
                tpoly.employeeAE.Criteria['name'] = vv;
            } else {
                tpoly.employeeAE.Criteria['id'] = vv;
            }

        }

        tpoly.employeeAE.Criteria['mode'] = 'load_employee';
        tpoly.employeeAE.Criteria['page'] = page;
        tpoly.employeeAE.Criteria['status'] = status;
        tpoly.employeeAE.Criteria['num'] = value;

        var ajax_config = {
            url: "func/AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: tpoly.employeeAE.Criteria,
            beforeSend: function() {
                tpoly.popup('loading');
            }
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            // console.log(response);
            tpoly.employee = response;
            var EmployeeList = $('#EmployeeList');
            resultSearch = tpoly.employee;
            var html = '';
            html += '<table class="table table-striped table-bordered table-hover">';
            html += '<thead>';
            html += '<tr>';
            html += '<th style="text-align: center;">#</th>';
            html += '<th style="text-align: center;">รหัสพนักงาน</th>';
            html += '<th style="text-align: center;">ชื่อ/นามสกุล</th>';
            html += '<th style="text-align: center;">โครงการ</th>';
            html += '<th style="text-align: center;">ตำแหน่ง</th>';
            html += '<th style="text-align: center;width: 10em;">ชุด/สังกัด</th>';
            html += '<th style="text-align: center;width: 10em;">ดูข้อมูล</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for(var i in resultSearch) {
                s = parseInt(i);
                m = (s+1);
                html += '<tr>';
                html += '<td style="text-align: center;">'+ m +'</td>';
                html += '<td style="text-align: center;">'+resultSearch[i]['Em_ID']+'</td>';
                html += '<td style="">'+resultSearch[i]['Fullname']+' '+resultSearch[i]['Lastname']+'</td>';
                html += '<td style="">'+resultSearch[i]['Site_Name']+'</td>';
                html += '<td style="">'+resultSearch[i]['Pos_Name']+'</td>';
                html += '<td style="">'+resultSearch[i]['Group_Name']+'</td>';
                html += '<td style="text-align: center;">';
                html += '<a data-toggle="modal" data-target="#myModals01" class="open-sendname btn-white btn btn-xs" data-id="'+resultSearch[i]['Em_ID']+'" onclick="tpoly.employeeAE.CheckNumberEmployee('+resultSearch[i]['Em_ID']+');">ดูข้อมูล</a>';
                html += '</td>';
                html += '</tr>';
            }
            if(resultSearch == '') {
                html += '<tr>';
                html += '<td colspan="6" style="text-align: center;">Data Not Found</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';

            EmployeeList.html(html);
            tpoly.employeeAE.numEmployee();
        });

        tpoly.employeeAE.numEmployee = function() {
            tpoly.employeeAE.Criteria['mode'] = 'load_num_employee';

            var ajax_config = {
                url: "func/AjaxSearch.php",
                dataType: "json",
                type: "POST",
                data: tpoly.employeeAE.Criteria,
                beforeSend: function() {
                    tpoly.popup('loading');
                }
            };

            var get_ajax = $.ajax(ajax_config);
            get_ajax.done(function(response) {
                tpoly.num = response;
                resultNum = tpoly.num;

                num = tpoly.employeeAE.Criteria['num'];
                limitP = tpoly.employeeAE.Criteria['page'];

                start = (num > 1) ? (((num - 1) * limitP) + 1) : 1;
                if(resultNum < 10) {
                    end = resultNum;
                } else {
                    end = (num > 1) ? (limitP * num) : limitP;
                }

                var ListPage = $('#ListPage');
                var p = 1;
                var s = 1;

                totalPage = Math.ceil(resultNum / limitP);

                if(num == undefined) {
                    num = 1;
                }

                var html = '';
                html += '<br>';
                html += '<span>ข้อมูลจาก '+ start +' ถึง '+ end +' จากทั้งหมด '+ resultNum +' รายการ</span>';
                html += '<div class="dataTables_paginate paging_simple_numbers">';
                html += '<ul class="pagination">';
                if(totalPage <= 10) {
                    if(num > 1) {
                        html += '<li id="employsearch-page-pre" class="paginate_button previous" onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                    } else {
                        html += '<li id="employsearch-page-pre" class="paginate_button previous disabled" onClick="tpoly.employeeAE.setPageSline();">';
                    }
                    html += '<a href="#">Previous</a>';
                    html += '</li>';
                    for(p;p<=totalPage;p++){
                        if(p == num) {
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+p+');">';
                        } else {
                            html += '<li class="paginate_button" onClick="tpoly.employeeAE.setPageSline('+p+');">';
                        }
                        html += '<a href="#">'+ p +'</a>';
                        html += '</li>';
                    }
                    if(num < (p-1)) {
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                    } else {
                        html += '<li id="employsearch-page-next" class="paginate_button next disabled">';
                    }
                    html += '<a href="#">Next</a>';
                    html += '</li>';
                } else {
                    if(num > 1) {
                        html += '<li id="employsearch-page-pre" class="paginate_button previous" onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                    } else {
                        html += '<li id="employsearch-page-pre" class="paginate_button previous disabled">';
                    }
                    html += '<a href="#">Previous</a>';
                    html += '</li>';
                    if(num < 5) {
                        for(s;s<=5;s++) {
                            if(s == num) {
                                html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+s+');">';
                            } else {
                                html += '<li class="paginate_button" onClick="tpoly.employeeAE.setPageSline('+s+');">';
                            }
                            html += '<a href="#">'+ s +'</a>';
                            html += '</li>';
                        }
                        html += '<li class="paginate_button disabled">';
                        html += '<a href="#">...</a>';
                        html += '</li>';
                        html += '<li class="paginate_button" onClick="tpoly.employeeAE.setPageSline('+totalPage+');">';
                        html += '<a href="#">'+totalPage+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num >= 5 && num <= (totalPage - 5)) {
                        html += '<li class="paginate_button" onClick="tpoly.employeeAE.setPageSline(1);">';
                        html += '<a href="#">1</a>';
                        html += '</li>';
                        html += '<li class="paginate_button disabled" onClick="tpoly.employeeAE.setPageSline('+s+');">';
                        html += '<a href="#">...</a>';
                        html += '</li>';

                        html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                        html += '<a href="#">'+(num-1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+(num)+');">';
                        html += '<a href="#">'+(num)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                        html += '<a href="#">'+(num+1)+'</a>';
                        html += '</li>';

                        html += '<li class="paginate_button disabled" onClick="tpoly.employeeAE.setPageSline('+s+');">';
                        html += '<a href="#">...</a>';
                        html += '</li>';
                        html += '<li class="paginate_button" onClick="tpoly.employeeAE.setPageSline('+totalPage+');">';
                        html += '<a href="#">'+totalPage+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num > (totalPage - 5)) {
                        html += '<li class="paginate_button" onClick="tpoly.employeeAE.setPageSline(1);">';
                        html += '<a href="#">1</a>';
                        html += '</li>';
                        html += '<li class="paginate_button disabled" onClick="tpoly.employeeAE.setPageSline('+s+');">';
                        html += '<a href="#">...</a>';
                        html += '</li>';
                        if(num == (totalPage - 5)) {
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+num+');">';
                            html += '<a href="#">'+num+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">'+(num+1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+2)+');">';
                            html += '<a href="#">'+(num+2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+3)+');">';
                            html += '<a href="#">'+(num+3)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+4)+');">';
                            html += '<a href="#">'+(num+4)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+5)+');">';
                            html += '<a href="#">'+(num+5)+'</a>';
                            html += '</li>';
                            html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">Next</a>';
                            html += '</li>';
                        }
                        if(num == (totalPage - 4)) {
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                            html += '<a href="#">'+(num-1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+num+');">';
                            html += '<a href="#">'+num+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">'+(num+1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+2)+');">';
                            html += '<a href="#">'+(num+2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+3)+');">';
                            html += '<a href="#">'+(num+3)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+4)+');">';
                            html += '<a href="#">'+(num+4)+'</a>';
                            html += '</li>';
                            html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">Next</a>';
                            html += '</li>';
                        }
                        if(num == (totalPage - 3)) {
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-2)+');">';
                            html += '<a href="#">'+(num-2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                            html += '<a href="#">'+(num-1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+num+');">';
                            html += '<a href="#">'+num+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">'+(num+1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+2)+');">';
                            html += '<a href="#">'+(num+2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+3)+');">';
                            html += '<a href="#">'+(num+3)+'</a>';
                            html += '</li>';
                            html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">Next</a>';
                            html += '</li>';
                        }
                        if(num == (totalPage - 2)) {
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-3)+');">';
                            html += '<a href="#">'+(num-3)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-2)+');">';
                            html += '<a href="#">'+(num-2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                            html += '<a href="#">'+(num-1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+num+');">';
                            html += '<a href="#">'+num+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">'+(num+1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+2)+');">';
                            html += '<a href="#">'+(num+2)+'</a>';
                            html += '</li>';
                            html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">Next</a>';
                            html += '</li>';
                        }
                        if(num == (totalPage - 1)) {
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-4)+');">';
                            html += '<a href="#">'+(num-4)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-3)+');">';
                            html += '<a href="#">'+(num-3)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-2)+');">';
                            html += '<a href="#">'+(num-2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                            html += '<a href="#">'+(num-1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+num+');">';
                            html += '<a href="#">'+num+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">'+(num+1)+'</a>';
                            html += '</li>';
                            html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employeeAE.setPageSline('+(num+1)+');">';
                            html += '<a href="#">Next</a>';
                            html += '</li>';
                        }
                        if(num == totalPage) {
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-5)+');">';
                            html += '<a href="#">'+(num-5)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-4)+');">';
                            html += '<a href="#">'+(num-4)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-3)+');">';
                            html += '<a href="#">'+(num-3)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-2)+');">';
                            html += '<a href="#">'+(num-2)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button " onClick="tpoly.employeeAE.setPageSline('+(num-1)+');">';
                            html += '<a href="#">'+(num-1)+'</a>';
                            html += '</li>';
                            html += '<li class="paginate_button active" onClick="tpoly.employeeAE.setPageSline('+num+');">';
                            html += '<a href="#">'+num+'</a>';
                            html += '</li>';
                            html += '<li id="employsearch-page-next" class="paginate_button next disabled">';
                            html += '<a href="#">Next</a>';
                            html += '</li>';
                        }
                    }
                }
                html += '</ul>';
                html += '</div>';

                ListPage.html(html);
                tpoly.popup('close');
            });
        }

        tpoly.employeeAE.CheckNumberEmployee = function(vars) {
            tpoly.employeeAE.Criteria['mode'] = 'load_employee_ae';
            tpoly.employeeAE.Criteria['code'] = vars;
            var ajax_config = {
                url: "func/AjaxSearch.php",
                dataType: "json",
                type: "POST",
                data: tpoly.employeeAE.Criteria,
            };

            var get_ajax = $.ajax(ajax_config);
            get_ajax.done(function(response) {
                EmList = response;
                tpoly.employeeAE.setEm(0);
            });
        }

        tpoly.employeeAE.setEm = function(key) {
            result = EmList;

            var permiss = tpoly.employeeAE.Criteria['rule'];

            $('#Em_IDs').val(result[0]['IDs']);

            if(result[0]['Titel'] == 'Mr') {
                Titel = 'นาย ';
            }
            if(result[0]['Titel'] == 'Ms') {
                Titel = 'นางสาว ';
            }
            if(result[0]['Titel'] == 'Mrs') {
                Titel = 'นาง ';
            }

            if(result[0]['DayCost'] == 'Month') {
                Cost = 'รายเดือน';
            }
            if(result[0]['DayCost'] == 'Day') {
                Cost = 'รายวัน';
            }

            if(result[0]['ChoiceBank'] == 'C') {
                Choice = 'รับเงินสด';
                $('#BankD').css('display', 'none');
            }
            if(result[0]['ChoiceBank'] == 'B') {
                Choice = 'โอนเข้าธนาคาร';
            }
            if(result[0]['Soice'] == 1) {
                social = 'คิด'
            }
            if(result[0]['Soice'] == 0) {
                social = 'ไม่คิด'
            }
            if(result[0]['LivingExpenses'] == 0) {
                $('#LivingExpenses').css('display', 'none');
            }
            if(result[0]['Allowance'] == 0) {
                $('#Allowance').css('display', 'none');
            }
            if(result[0]['AllowanceDisaster'] == 0) {
                $('#AllowanceDisaster').css('display', 'none');
            }
            if(result[0]['AllowanceSafety'] == 0) {
                $('#AllowanceSafety').css('display', 'none');
            }
            if(result[0]['SpecialAllowance'] == 0) {
                $('#SpecialAllowance').css('display', 'none');
            }
            if((result[0]['LivingExpenses'] == 0) && (result[0]['Allowance'] == 0)) {
                $('#All01').css('display', 'none');
            }
            if((result[0]['AllowanceDisaster'] == 0) && (result[0]['AllowanceSafety'] == 0) && (result[0]['SpecialAllowance'] == 0)) {
                $('#All02').css('display', 'none');
            }
            if(result[0]['Status'] == 'B' && permiss == '3') {
                $('#buttons').css('display', 'none');
            } else {
                $('#buttons').css('display', '');
            }

            aDateOpen = result[0]['DateOpen'];
            spTodayA = aDateOpen.split(' ');
            todaya = spTodayA[0] + ' ' + spTodayA[1] + ' ' + spTodayA[2];
            dateTodayA = tpoly.employeeAE.formatDate(todaya);
            bDateBirthDay = result[0]['DateBirthDay'];
            spTodayB = bDateBirthDay.split(' ');
            todayb = spTodayB[0] + ' ' + spTodayB[1] + ' ' + spTodayB[2];
            dateTodayB = tpoly.employeeAE.formatDate(todayb);

            tests = Date();
            testsD = tests.split(' ');

            Daied = (testsD[3] - spTodayB[2]);

            dWork = tpoly.employeeAE.formatDateSeach(todaya);
            var res = dWork.split("-");
            var d = res[0] + '/' + res[1] + '/' + res[2];
            var c = tpoly.employeeAE.age(new Date(d));
            var c = c.toString();
            var f = c.split("-");

            if(result[0]['Pic'] != '') {
                document.getElementById('myImage').src = 'func/EmployeePicture/' + result[0]['Pic'];
            }
            if(result[0]['Pic'] == '') {
                document.getElementById('myImage').src = 'img/Login.png';
            }
            document.getElementById("Cards").innerHTML = 'เลขบัตรประชาชน : '+result[0]['Cards'];
            document.getElementById("IDs").innerHTML = 'รหัสพนักงาน : '+result[0]['IDs'];
            document.getElementById("Name").innerHTML = 'ชื่อ - นามสกุล : '+Titel+' '+result[0]['Fullname']+' '+result[0]['Lastname'];
            document.getElementById("DateBirthDay").innerHTML = 'วัน/เดือน/ปี เกิด : '+ dateTodayB;
            document.getElementById("Age").innerHTML = 'อายุ : '+ Daied + ' ปี';
            document.getElementById("Address").innerHTML = 'ที่อยู่ : '+result[0]['Address'];
            document.getElementById("DateOpen").innerHTML = 'วันที่เข้าทำงาน : '+dateTodayA;
            document.getElementById("DateOpen2").innerHTML = f[0]+' ปี '+f[1]+' เดือน '+f[2]+' วัน';
            document.getElementById("Site").innerHTML = 'โครงการ : '+result[0]['Site_Name'];
            document.getElementById("Position").innerHTML = 'ตำแหน่ง : '+result[0]['Pos_Name'];
            document.getElementById("Group").innerHTML = 'ชุด/สังกัด : '+result[0]['Group_Name'];
            document.getElementById("Personal").innerHTML = 'พนักงาน : '+ Cost;
            document.getElementById("Personal2").innerHTML = 'ค่าแรง : '+result[0]['Money']+' บาท';
            document.getElementById("LivingExpenses").innerHTML = 'เบี้ยเลี้ยง : '+result[0]['LivingExpenses']+' บาท';
            document.getElementById("Allowance").innerHTML = 'เบี้ยเลี้ยง2 : '+result[0]['Allowance']+' บาท';
            document.getElementById("AllowanceDisaster").innerHTML = 'ค่าเลี้ยงภัย : '+result[0]['AllowanceDisaster']+' บาท';
            document.getElementById("AllowanceSafety").innerHTML = 'เบี้ยเลี้ยงเซตตี้ : '+result[0]['AllowanceSafety']+' บาท';
            document.getElementById("SpecialAllowance").innerHTML = 'เบี้ยเลี้ยงพิเศษ : '+result[0]['SpecialAllowance']+' บาท';
            document.getElementById("Bank").innerHTML = 'การรับเงิน : '+Choice;
            document.getElementById("BankDetail").innerHTML = 'ธนาคาร : '+result[0]['Bank_Name'];
            document.getElementById("BankDetail2").innerHTML = 'สาขา : '+result[0]['BankBranch'];
            document.getElementById("BankDetail3").innerHTML = 'เลขบัญชี : '+result[0]['AccountNumber'];
            document.getElementById("Social").innerHTML = 'ประกันสังคม : '+ social;
            document.getElementById("InformIn").innerHTML = 'แจ้งเข้า : '+result[0]['Inform'];
            document.getElementById("InformOut").innerHTML = 'แจ้งออก : '+result[0]['Notice'];
            document.getElementById("Hospital").innerHTML = 'สถานพยาบาล : '+result[0]['Hos_name'];
        }
    }
}( jQuery ));