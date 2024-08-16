@extends('admin.layouts.main')



@section('main-container')

    <div class="wrapper">

        <header class="main-header affix-top" id="alert">
            <a href="https://erp.erabesa.co.in/admin/admin/dashboard" class="logo">
                <span class="logo-mini"><img src="https://erp.erabesa.co.in/uploads/school_content/admin_small_logo/1.png"
                        alt="Era International School"></span>
                <span class="logo-lg"><img src="https://erp.erabesa.co.in/uploads/school_content/admin_logo/1.png"
                        alt="Era International School"></span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a onclick="collapseSidebar()" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="col-lg-5 col-md-3 col-sm-2 col-xs-5">
                    <span href="#" class="sidebar-session">
                        Era International School </span>
                </div>
                <div class="col-lg-7 col-md-9 col-sm-10 col-xs-7">
                    <div class="pull-right">

                        <form id="header_search_form" class="navbar-form navbar-left search-form" role="search"
                            action="https://erp.erabesa.co.in/admin/admin/search" method="POST">
                            <input type="hidden" name="ci_csrf_token" value="">
                            <div class="input-group">
                                <input type="text" value="" name="search_text1" id="search_text1"
                                    class="form-control search-form search-form3"
                                    placeholder="Search By Student Name, Roll Number, Enroll Number, National Id, Local Id Etc.">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" onclick="getstudentlist()"
                                        style="" class="btn btn-flat topsidesearchbtn"><i
                                            class="fa fa-search"></i></button>
                                </span>
                            </div>

                        </form>
                        <div class="navbar-custom-menu">
                            <div class="langdiv"><select class="languageselectpicker" onchange="set_languages(this.value)"
                                    type="text" id="languageSwitcher" style="display: none;">

                                    <option data-content="<span class=&quot;flag-icon flag-icon-us&quot;></span> English"
                                        value="4" selected=""></option>

                                </select>
                                <div class="btn-group bootstrap-select language"><button type="button"
                                        class="btn dropdown-toggle selectpicker btn-default" data-toggle="dropdown"
                                        data-id="languageSwitcher" title="English"><span
                                            class="filter-option pull-left"><span class="flag-icon flag-icon-us"></span>
                                            English</span>&nbsp;<span class="caret"></span></button>
                                    <div class="dropdown-menu open">
                                        <ul class="dropdown-menu inner selectpicker" role="menu">
                                            <li rel="0" class="selected"><a tabindex="0" class=""
                                                    style=""><span class="flag-icon flag-icon-us"></span> English<i
                                                        class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <ul class="nav navbar-nav headertopmenu">
                                <li class="dropdown user-menu">
                                    <a class="dropdown-toggle" style="padding: 15px 13px;" data-toggle="dropdown"
                                        href="#" aria-expanded="false">
                                        <img src="https://erp.erabesa.co.in/uploads/staff_images/1.png"
                                            class="topuser-image" alt="User Image">
                                    </a>
                                    <ul class="dropdown-menu dropdown-user menuboxshadow">
                                        <li>
                                            <div class="sstopuser">
                                                <div class="ssuserleft">
                                                    <a href="https://erp.erabesa.co.in/admin/staff/profile/1"><img
                                                            src="https://erp.erabesa.co.in/uploads/staff_images/1.png"
                                                            alt="User Image"></a>
                                                </div>

                                                <div class="sstopuser-test">
                                                    <h4 class="text-capitalize">Rashmi Shrivastav</h4>
                                                    <h5>Super Admin</h5>

                                                </div>

                                                <div class="divider"></div>
                                                <div class="sspass">
                                                    <a href="https://erp.erabesa.co.in/admin/staff/profile/1"
                                                        data-toggle="tooltip" title=""
                                                        data-original-title="My Profile"><i class="fa fa-user"></i>Profile
                                                    </a>
                                                    <a class="pl25"
                                                        href="https://erp.erabesa.co.in/admin/admin/changepass"
                                                        data-toggle="tooltip" title=""
                                                        data-original-title="Change Password"><i
                                                            class="fa fa-key"></i>Password</a> <a class="pull-right"
                                                        href="https://erp.erabesa.co.in/site/logout"><i
                                                            class="fa fa-sign-out fa-fw"></i>Logout</a>
                                                </div>
                                            </div><!--./sstopuser-->
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar affix-top" id="alert2">


            <form class="navbar-form navbar-left search-form2" role="search"
                action="https://erp.erabesa.co.in/admin/admin/search" method="POST">

                <input type="hidden" name="ci_csrf_token" value="">
                <div class="input-group ">



                    <input type="text" name="search_text" class="form-control search-form"
                        placeholder="Search By Student Name, Roll Number, Enroll Number, National Id, Local Id Etc.">

                    <span class="input-group-btn">

                        <button type="submit" name="search" id="search-btn"
                            style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;"
                            class="btn btn-flat"><i class="fa fa-search"></i></button>

                    </span>

                </div>

            </form>


            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 547px;">
                <section class="sidebar" id="sibe-box" style="height: 547px; overflow: hidden; width: auto;">

                    <ul class="sessionul fixedmenu">
                        <li class="removehover">
                            <a data-toggle="modal" data-target="#sessionModal"><span>Current Session: 2024-25</span><i
                                    class="fa fa-pencil pull-right"></i></a>


                        </li>

                        <li style="display:none;" class="dropdown">

                            <a class="dropdown-toggle drop5" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <span>Quick Links</span> <i class="fa fa-th pull-right ftlayer"></i>
                            </a>

                            <ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">

                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/student/search"><i
                                            class="fa fa-user-plus"></i>Student Details</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/studentfee"><i
                                            class="fa fa-money"></i>Collect Fees</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/admin/income">
                                        &nbsp;<i class="fa fa-usd"></i> Add Income</a></li>

                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/admin/expense"><i
                                            class="fa fa-credit-card"></i>Add Expense</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/stuattendence"><i
                                            class="fa fa-calendar-check-o"></i>Student Attendance</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/staffattendance"><i
                                            class="fa fa-calendar-check-o"></i>Staff Attendance</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/admin/staff"><i
                                            class="fa fa-calendar-check-o"></i>Staff Directory</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/examgroup"><i class="fa fa-map-o"></i>Exam
                                        Group</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/examresult"><i
                                            class="fa fa-columns"></i>Exam Result</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/timetable/create"><i
                                            class="fa fa-calendar-times-o"></i>Class Timetable</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/admin/enquiry"><i
                                            class="fa fa-calendar-check-o"></i>Admission Enquiry</a></li>

                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/complaint"><i
                                            class="fa fa-calendar-check-o"></i>Complain</a></li>

                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1" href="https://erp.erabesa.co.in/admin/content"><i
                                            class="fa fa-download"></i>Upload Content</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/itemstock"><i
                                            class="fa fa-object-group"></i>Add Item Stock</a></li>


                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/notification"><i
                                            class="fa fa-bullhorn"></i>Notice Board</a></li>

                                <li role="presentation"><a
                                        style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                        role="menuitem" tabindex="-1"
                                        href="https://erp.erabesa.co.in/admin/mailsms/compose"><i
                                            class="fa fa-envelope-o"></i>Send Email / SMS</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="sidebar-menu verttop">






                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-user-plus ftlayer"></i> <span>Student Information</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">




                                <li class=""><a href="https://erp.erabesa.co.in/student/search"><i
                                            class="fa fa-angle-double-right"></i> Student Details</a></li>






                                <li class=""><a href="https://erp.erabesa.co.in/student/create"><i
                                            class="fa fa-angle-double-right"></i> Student Admission</a></li>




                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/onlinestudent"><i
                                            class="fa fa-angle-double-right"></i> Online Admission</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/student/disablestudentslist"><i
                                            class="fa fa-angle-double-right"></i> Disabled Students</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/student/multiclass"><i
                                            class="fa fa-angle-double-right"></i> Multi Class Student</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/student/bulkdelete"><i
                                            class="fa fa-angle-double-right"></i> Bulk Delete</a>

                                </li>




                                <li class=""><a href="https://erp.erabesa.co.in/category"><i
                                            class="fa fa-angle-double-right"></i> Student Categories</a></li>





                                <li class=""><a href="https://erp.erabesa.co.in/admin/schoolhouse"><i
                                            class="fa fa-angle-double-right"></i> Student House</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/disable_reason"><i
                                            class="fa fa-angle-double-right"></i> Disable Reason</a></li>







                            </ul>

                        </li>


                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-money ftlayer"></i> <span> Fees Collection</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/studentfee"><i
                                            class="fa fa-angle-double-right"></i> Collect Fees</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/studentfee/searchpayment"><i
                                            class="fa fa-angle-double-right"></i> Search Fees Payment</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/studentfee/feesearch"><i
                                            class="fa fa-angle-double-right"></i> Search Due Fees </a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/feemaster"><i
                                            class="fa fa-angle-double-right"></i> Fees Master</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/feegroup"><i
                                            class="fa fa-angle-double-right"></i> Fees Group</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/feetype"><i
                                            class="fa fa-angle-double-right"></i> Fees Type</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/feediscount"><i
                                            class="fa fa-angle-double-right"></i> Fees Discount</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/feesforward"><i
                                            class="fa fa-angle-double-right"></i> Fees Carry Forward</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/feereminder/setting"><i
                                            class="fa fa-angle-double-right"></i> Fees Reminder</a></li>




                            </ul>

                        </li>


                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-calendar-check-o ftlayer"></i> <span>Attendance</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/admin/stuattendence"><i
                                            class="fa fa-angle-double-right"></i> Student Attendance</a></li>


                                <li class=""><a
                                        href="https://erp.erabesa.co.in/admin/stuattendence/attendencereport"><i
                                            class="fa fa-angle-double-right"></i> Attendance By Date</a></li>






                                <li class=""><a href="https://erp.erabesa.co.in/admin/approve_leave"><i
                                            class="fa fa-angle-double-right"></i> Approve Leave</a></li>


                            </ul>

                        </li>








                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-list-alt ftlayer"></i> <span>Lesson Plan</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/admin/syllabus"><i
                                            class="fa fa-angle-double-right"></i> Manage Lesson Plan</a></li>



                                <li class=""><a href="https://erp.erabesa.co.in/admin/syllabus/status"><i
                                            class="fa fa-angle-double-right"></i> Manage Syllabus Status</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/lessonplan/lesson"><i
                                            class="fa fa-angle-double-right"></i> Lesson</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/lessonplan/topic"><i
                                            class="fa fa-angle-double-right"></i> Topic</a></li>




                            </ul>

                        </li>



                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-mortar-board ftlayer"></i> <span>Academics</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">




                                <li class=""><a href="https://erp.erabesa.co.in/admin/timetable/classreport"><i
                                            class="fa fa-angle-double-right"></i> Class Timetable</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/timetable/mytimetable"><i
                                            class="fa fa-angle-double-right"></i> Teachers Timetable</a></li>


                                <li class=""><a
                                        href="https://erp.erabesa.co.in/admin/teacher/assign_class_teacher"><i
                                            class="fa fa-angle-double-right"></i> Assign Class Teacher</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/admin/stdtransfer"><i
                                            class="fa fa-angle-double-right"></i> Promote Students</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/subjectgroup"><i
                                            class="fa fa-angle-double-right"></i> Subject Group</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/subject"><i
                                            class="fa fa-angle-double-right"></i> Subjects</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/classes"><i
                                            class="fa fa-angle-double-right"></i> Class</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/sections"><i
                                            class="fa fa-angle-double-right"></i> Sections</a></li>




                            </ul>

                        </li>





                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-sitemap ftlayer"></i> <span>Human Resource</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/admin/staff"><i
                                            class="fa fa-angle-double-right"></i> Staff Directory</a></li>







                                <li class=""><a href="https://erp.erabesa.co.in/admin/staffattendance"><i
                                            class="fa fa-angle-double-right"></i> Staff Attendance</a></li>






                                <li class=""><a href="https://erp.erabesa.co.in/admin/payroll"><i
                                            class="fa fa-angle-double-right"></i> Payroll</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/leaverequest/leaverequest"><i
                                            class="fa fa-angle-double-right"></i> Approve Leave Request</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/admin/staff/leaverequest"><i
                                            class="fa fa-angle-double-right"></i> Apply Leave</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/admin/leavetypes"><i
                                            class="fa fa-angle-double-right"></i> Leave Type</a></li>




                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/staff/rating"><i
                                            class="fa fa-angle-double-right"></i> Teachers Rating</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/department/department"><i
                                            class="fa fa-angle-double-right"></i> Department</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/admin/designation/designation"><i
                                            class="fa fa-angle-double-right"></i> Designation</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/admin/staff/disablestafflist"><i
                                            class="fa fa-angle-double-right"></i> Disabled Staff</a></li>


                            </ul>

                        </li>


                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-bullhorn ftlayer"></i> <span>Communicate</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">




                                <li class=""><a href="https://erp.erabesa.co.in/admin/notification"><i
                                            class="fa fa-angle-double-right"></i> Notice Board</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/mailsms/compose"><i
                                            class="fa fa-angle-double-right"></i> Send Email</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/mailsms/compose_sms"><i
                                            class="fa fa-angle-double-right"></i> Send SMS</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/mailsms/index"><i
                                            class="fa fa-angle-double-right"></i> Email / SMS Log</a></li>




                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/student/bulkmail"><i
                                            class="fa fa-angle-double-right"></i> Login Credentials Send</a></li>


                            </ul>

                        </li>














                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-download ftlayer"></i> <span>Download Center</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/admin/content"><i
                                            class="fa fa-angle-double-right"></i> Upload Content</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/content/assignment"><i
                                            class="fa fa-angle-double-right"></i> Assignments</a></li>

                                <li class=""><a href="https://erp.erabesa.co.in/admin/content/studymaterial"><i
                                            class="fa fa-angle-double-right"></i> Study Material</a></li>

                                <li class=""><a href="https://erp.erabesa.co.in/admin/content/syllabus"><i
                                            class="fa fa-angle-double-right"></i> Syllabus</a></li>

                                <li class=""><a href="https://erp.erabesa.co.in/admin/content/other"><i
                                            class="fa fa-angle-double-right"></i> Other Downloads</a></li>

                            </ul>

                        </li>


                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-flask ftlayer"></i> <span>Homework</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/homework"><i
                                            class="fa fa-angle-double-right"></i> Add Homework</a></li>


                            </ul>

                        </li>


                        <li class="treeview ">

                            <a href="#">

                                <i class="fa fa-newspaper-o ftlayer"></i> <span>Certificate</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/admin/certificate/"><i
                                            class="fa fa-angle-double-right"></i>Student Certificate</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/generatecertificate/"><i
                                            class="fa fa-angle-double-right"></i>Generate Certificate</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/studentidcard/"><i
                                            class="fa fa-angle-double-right"></i>Student ID Card</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/generateidcard/search"><i
                                            class="fa fa-angle-double-right"></i>Generate ID Card</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/staffidcard/"><i
                                            class="fa fa-angle-double-right"></i>Staff ID Card</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/generatestaffidcard/"><i
                                            class="fa fa-angle-double-right"></i>Generate Staff ID Card</a></li>


                            </ul>

                        </li>




                        <li style="display:none;" class="treeview ">

                            <a href="#">

                                <i class="fa fa-line-chart ftlayer"></i> <span>Reports</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/report/studentinformation"><i
                                            class="fa fa-angle-double-right"></i> Student Information</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/report/finance"><i
                                            class="fa fa-angle-double-right"></i> Finance</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/report/attendance"><i
                                            class="fa fa-angle-double-right"></i> Attendance</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/report/examinations"><i
                                            class="fa fa-angle-double-right"></i> Examinations</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/report/lesson_plan"><i
                                            class="fa fa-angle-double-right"></i> Lesson Plan</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/report/staff_report"><i
                                            class="fa fa-angle-double-right"></i> Human Resource</a></li>




                                <li class=""><a href="https://erp.erabesa.co.in/admin/userlog"><i
                                            class="fa fa-angle-double-right"></i> User Log</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/audit"><i
                                            class="fa fa-angle-double-right"></i>

                                        Audit Trail Report</a></li>






                            </ul>

                        </li>




                        <li style="display:none;" class="treeview ">

                            <a href="#">

                                <i class="fa fa-gears ftlayer"></i> <span>System Settings</span> <i
                                    class="fa fa-angle-left pull-right"></i>

                            </a>

                            <ul class="treeview-menu">


                                <li class=""><a href="https://erp.erabesa.co.in/schsettings"><i
                                            class="fa fa-angle-double-right"></i> General Setting</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/sessions"><i
                                            class="fa fa-angle-double-right"></i> Session Setting</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/notification/setting"><i
                                            class="fa fa-angle-double-right"></i> Notification Setting</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/smsconfig"><i
                                            class="fa fa-angle-double-right"></i> SMS Setting</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/emailconfig"><i
                                            class="fa fa-angle-double-right"></i> Email Setting</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/paymentsettings"><i
                                            class="fa fa-angle-double-right"></i> Payment Methods</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/print_headerfooter"><i
                                            class="fa fa-angle-double-right"></i> Print Header Footer</a></li>



                                <li class=""><a href="https://erp.erabesa.co.in/admin/roles"><i
                                            class="fa fa-angle-double-right"></i> Roles Permissions</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/admin/backup"><i
                                            class="fa fa-angle-double-right"></i> Backup / Restore</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/language"><i
                                            class="fa fa-angle-double-right"></i> Languages</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/users"><i
                                            class="fa fa-angle-double-right"></i> Users</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/module"><i
                                            class="fa fa-angle-double-right"></i> Modules</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/customfield"><i
                                            class="fa fa-angle-double-right"></i> Custom Fields</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/captcha"><i
                                            class="fa fa-angle-double-right"></i> Captcha Setting</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/systemfield"><i
                                            class="fa fa-angle-double-right"></i> System Fields</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/student/profilesetting"><i
                                            class="fa fa-angle-double-right"></i> Student Profile Update</a></li>


                                <li style="display:none;" class=""><a
                                        href="https://erp.erabesa.co.in/admin/onlineadmission/admissionsetting"><i
                                            class="fa fa-angle-double-right"></i> Online Admission</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/admin/filetype"><i
                                            class="fa fa-angle-double-right"></i> File Types</a></li>


                                <li class=""><a href="https://erp.erabesa.co.in/admin/updater"><i
                                            class="fa fa-angle-double-right"></i> System Update</a></li>




                            </ul>

                        </li>


                    </ul>

                </section>
                <div class="slimScrollBar"
                    style="background: rgba(0, 0, 0, 0.2); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 547px;">
                </div>
                <div class="slimScrollRail"
                    style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                </div>
            </div>

        </aside>
        <script>
            function defoult(id) {
                var defoult = $('#languageSwitcher').val();


                $.ajax({
                    type: "POST",
                    url: base_url + "admin/language/default_language/" + id,
                    data: {},
                    success: function(data) {
                        successMsg("Status Change Successfully");
                        $('#languageSwitcher').html(data);

                    }
                });

                window.location.reload('true');
            }

            function set_languages(lang_id) {
                $.ajax({
                    type: "POST",
                    url: base_url + "admin/language/user_language/" + lang_id,
                    data: {},
                    success: function(data) {
                        successMsg("Status Change Successfully");
                        window.location.reload('true');

                    }
                });

            }
        </script>


        <style type="text/css">
            .borderwhite {
                border-top-color: #fff !important;
            }

            .box-header>.box-tools {
                display: none;
            }

            .sidebar-collapse #barChart {
                height: 100% !important;
            }

            .sidebar-collapse #lineChart {
                height: 100% !important;
            }
        </style>
        <div class="content-wrapper" style="min-height: 578px;">
            <section class="content">
                <div class="">



                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="topprograssstart">
                            <p class="text-uppercase mt5 clearfix"><i class="fa fa-money ftlayer"></i>Fees Awaiting
                                Payment<span class="pull-right">0/312</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->
                    </div><!--./col-md-3-->


                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="topprograssstart">
                            <p class="text-uppercase mt5 clearfix"><i class="fa fa-calendar-check-o ftlayer"></i>Staff
                                Present Today<span class="pull-right">0/37</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-green" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->
                    </div><!--./col-md-3-->


                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="topprograssstart">
                            <p class="text-uppercase mt5 clearfix"><i class="fa fa-calendar-check-o ftlayer"></i>Student
                                Present Today<span class="pull-right"> 0/678</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->
                    </div><!--./col-md-3-->
                </div><!--./row-->


                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col60">

                        <div class="box box-primary borderwhite">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fees Collection &amp; Expenses For August 2024</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                    <button class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="barChart" height="95"></canvas>
                                </div>
                            </div>

                        </div>

                    </div><!--./col-lg-7-->
                </div><!--./row-->

                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col60">

                        <div class="box box-info borderwhite">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fees Collection &amp; Expenses For Session 2024-25</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                    <button class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="lineChart" height="95"></canvas>
                                </div>
                            </div>

                            <!--  <div class="box-body">
                                             <div class="chart">
                                                 <canvas id="lineChart" style="height: 233px; width: 100%; white-space: nowrap;"></canvas>
                                             </div>
                                         </div> -->
                        </div>

                    </div><!--./col-lg-7-->
                </div><!--./row-->




                <div class="row">


                    <div class="col-md-3 col-sm-6">

                        <div class="topprograssstart">
                            <h5 class="pro-border pb10">Fees Overview</h5>
                            <p class="text-uppercase mt10 clearfix">312 Unpaid<span class="pull-right">100%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Partial<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Paid<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->

                    </div><!--./col-md-3-->
                    <div class="col-md-3 col-sm-6">

                        <div class="topprograssstart">
                            <h5 class="pro-border pb10"> Student Today Attendance</h5>

                            <p class="text-uppercase mt10 clearfix"> Present<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix"> Late<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>
                            <p class="text-uppercase mt10 clearfix"> Absent<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>
                            <p class="text-uppercase mt10 clearfix"> Half Day<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->

                    </div><!--./col-md-3-->


                    <div class="row">

                        <div class="col-lg-9 col-md-9 col-sm-12 col80">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="info-box">
                                        <a href="https://erp.erabesa.co.in/studentfee">
                                            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Monthly Fees Collection</span>
                                                <span class="info-box-number">₹0</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>


                                <div class="col-md-4 col-sm-6">
                                    <div class="info-box">
                                        <a href="https://erp.erabesa.co.in/student/search">
                                            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Student</span>
                                                <span class="info-box-number">678</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="box box-primary borderwhite">
                                <div class="box-body">
                                    <!-- THE CALENDAR -->
                                    <div id="calendar" class="fc fc-unthemed fc-ltr">
                                        <div class="fc-toolbar fc-header-toolbar">
                                            <div class="fc-left">
                                                <div class="fc-button-group"><button type="button"
                                                        class="fc-prev-button fc-button fc-state-default fc-corner-left"><span
                                                            class="fc-icon fc-icon-left-single-arrow"></span></button><button
                                                        type="button"
                                                        class="fc-next-button fc-button fc-state-default"><span
                                                            class="fc-icon fc-icon-right-single-arrow"></span></button><button
                                                        type="button"
                                                        class="fc-today-button fc-button fc-state-default fc-corner-right fc-state-disabled"
                                                        disabled="">today</button></div>
                                            </div>
                                            <div class="fc-right">
                                                <div class="fc-button-group"><button type="button"
                                                        class="fc-month-button fc-button fc-state-default fc-corner-left">month</button><button
                                                        type="button"
                                                        class="fc-agendaWeek-button fc-button fc-state-default fc-state-active">week</button><button
                                                        type="button"
                                                        class="fc-agendaDay-button fc-button fc-state-default fc-corner-right">day</button>
                                                </div>
                                            </div>
                                            <div class="fc-center">
                                                <h2> August 12 – 18 2024</h2>
                                            </div>
                                            <div class="fc-clear"></div>
                                        </div>
                                        <div class="fc-view-container" style="">
                                            <div class="fc-view fc-agendaWeek-view fc-agenda-view" style="">
                                                <table class="">
                                                    <thead class="fc-head">
                                                        <tr>
                                                            <td class="fc-head-container fc-widget-header">
                                                                <div class="fc-row fc-widget-header"
                                                                    style="border-right-width: 1px; margin-right: 16px;">
                                                                    <table class="">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="fc-axis fc-widget-header"
                                                                                    style="width: 40px;"></th>
                                                                                <th class="fc-day-header fc-widget-header fc-mon fc-past"
                                                                                    data-date="2024-08-12"><span>Mon
                                                                                        8/12</span></th>
                                                                                <th class="fc-day-header fc-widget-header fc-tue fc-past"
                                                                                    data-date="2024-08-13"><span>Tue
                                                                                        8/13</span></th>
                                                                                <th class="fc-day-header fc-widget-header fc-wed fc-past"
                                                                                    data-date="2024-08-14"><span>Wed
                                                                                        8/14</span></th>
                                                                                <th class="fc-day-header fc-widget-header fc-thu fc-past"
                                                                                    data-date="2024-08-15"><span>Thu
                                                                                        8/15</span></th>
                                                                                <th class="fc-day-header fc-widget-header fc-fri fc-today"
                                                                                    data-date="2024-08-16"><span>Fri
                                                                                        8/16</span></th>
                                                                                <th class="fc-day-header fc-widget-header fc-sat fc-future"
                                                                                    data-date="2024-08-17"><span>Sat
                                                                                        8/17</span></th>
                                                                                <th class="fc-day-header fc-widget-header fc-sun fc-future"
                                                                                    data-date="2024-08-18"><span>Sun
                                                                                        8/18</span></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fc-body">
                                                        <tr>
                                                            <td class="fc-widget-content">
                                                                <div class="fc-day-grid fc-unselectable">
                                                                    <div class="fc-row fc-week fc-widget-content"
                                                                        style="border-right-width: 1px; margin-right: 16px;">
                                                                        <div class="fc-bg">
                                                                            <table class="">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="fc-axis fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>all-day</span>
                                                                                        </td>
                                                                                        <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                            data-date="2024-08-12"></td>
                                                                                        <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                            data-date="2024-08-13"></td>
                                                                                        <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                            data-date="2024-08-14"></td>
                                                                                        <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                            data-date="2024-08-15"></td>
                                                                                        <td class="fc-day fc-widget-content fc-fri fc-today "
                                                                                            data-date="2024-08-16"></td>
                                                                                        <td class="fc-day fc-widget-content fc-sat fc-future"
                                                                                            data-date="2024-08-17"></td>
                                                                                        <td class="fc-day fc-widget-content fc-sun fc-future"
                                                                                            data-date="2024-08-18"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="fc-content-skeleton">
                                                                            <table>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="fc-axis"
                                                                                            style="width:40px"></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="fc-divider fc-widget-header">
                                                                <div class="fc-scroller fc-time-grid-container"
                                                                    style="overflow: hidden scroll; height: 921px;">
                                                                    <div class="fc-time-grid fc-unselectable">
                                                                        <div class="fc-bg">
                                                                            <table class="">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="fc-axis fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                            data-date="2024-08-12"></td>
                                                                                        <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                            data-date="2024-08-13"></td>
                                                                                        <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                            data-date="2024-08-14"></td>
                                                                                        <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                            data-date="2024-08-15"></td>
                                                                                        <td class="fc-day fc-widget-content fc-fri fc-today "
                                                                                            data-date="2024-08-16"></td>
                                                                                        <td class="fc-day fc-widget-content fc-sat fc-future"
                                                                                            data-date="2024-08-17"></td>
                                                                                        <td class="fc-day fc-widget-content fc-sun fc-future"
                                                                                            data-date="2024-08-18"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="fc-slats">
                                                                            <table class="">
                                                                                <tbody>
                                                                                    <tr data-time="00:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>12am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="00:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="01:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>1am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="01:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="02:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>2am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="02:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="03:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>3am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="03:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="04:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>4am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="04:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="05:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>5am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="05:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="06:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>6am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="06:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="07:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>7am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="07:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="08:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>8am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="08:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="09:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>9am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="09:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="10:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>10am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="10:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="11:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>11am</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="11:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="12:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>12pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="12:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="13:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>1pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="13:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="14:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>2pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="14:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="15:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>3pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="15:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="16:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>4pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="16:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="17:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>5pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="17:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="18:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>6pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="18:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content"></td>
                                                                                    </tr>
                                                                                    <tr data-time="19:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>7pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="19:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="20:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>8pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="20:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="21:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>9pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="21:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="22:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>10pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="22:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="23:00:00">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;">
                                                                                            <span>11pm</span>
                                                                                        </td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr data-time="23:30:00"
                                                                                        class="fc-minor">
                                                                                        <td class="fc-axis fc-time fc-widget-content"
                                                                                            style="width: 40px;"></td>
                                                                                        <td class="fc-widget-content">
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="fc-content-skeleton">
                                                                            <table>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="fc-axis"
                                                                                            style="width: 40px;"></td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="fc-content-col">
                                                                                                <div
                                                                                                    class="fc-event-container fc-helper-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-event-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-highlight-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-bgevent-container">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="fc-business-container">
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <hr class="fc-divider fc-widget-header"
                                                                            style="display: none;">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. box -->

                        </div><!--./col-lg-9-->

                        <div class="col-lg-3 col-md-3 col-sm-12 col20">

                            <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Admin</span>
                                        <span class="info-box-number">3</span>
                                    </div>
                                </a>
                            </div>
                            <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Teacher</span>
                                        <span class="info-box-number">33</span>
                                    </div>
                                </a>
                            </div>
                            <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Accountant</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                            <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Librarian</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                            <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Receptionist</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                            <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Super Admin</span>
                                        <span class="info-box-number">1</span>
                                    </div>
                                </a>
                            </div>



                        </div><!--./col-lg-3-->
                    </div><!--./row-->








                </div><!--./row-->


            </section>
        </div>
        <div id="newEventModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Add New Event</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <form role="form" id="addevent_form" method="post" enctype="multipart/form-data"
                                action="">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Event Title</label><small class="req"> *</small>
                                    <input class="form-control" name="title" id="input-field">
                                    <span class="text-danger"></span>

                                </div>

                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea name="description" class="form-control" id="desc-field"></textarea>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Event From</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" autocomplete="off" name="event_from"
                                                class="form-control pull-right event_from">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Event To</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" autocomplete="off" name="event_to"
                                                class="form-control pull-right event_to">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Event Color</label>
                                    <input type="hidden" name="eventcolor" autocomplete="off" id="eventcolor"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-12">

                                    <div class="cpicker-wrapper">
                                        <div class="calendar-cpicker cpicker cpicker-big" data-color="#03a9f4"
                                            style="background:#03a9f4;border:1px solid #03a9f4; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#c53da9"
                                            style="background:#c53da9;border:1px solid #c53da9; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#757575"
                                            style="background:#757575;border:1px solid #757575; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#8e24aa"
                                            style="background:#8e24aa;border:1px solid #8e24aa; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#d81b60"
                                            style="background:#d81b60;border:1px solid #d81b60; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#7cb342"
                                            style="background:#7cb342;border:1px solid #7cb342; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#fb8c00"
                                            style="background:#fb8c00;border:1px solid #fb8c00; border-radius:100px">
                                        </div>
                                        <div class="calendar-cpicker cpicker cpicker-small" data-color="#fb3b3b"
                                            style="background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Event Type</label>
                                    <br>
                                    <label class="radio-inline">

                                        <input type="radio" name="event_type" value="public" id="public">Public
                                    </label>
                                    <label class="radio-inline">

                                        <input type="radio" name="event_type" value="private" checked=""
                                            id="private">Private </label>
                                    <label class="radio-inline">

                                        <input type="radio" name="event_type" value="sameforall"
                                            id="public">All Super Admin </label>
                                    <label class="radio-inline">

                                        <input type="radio" name="event_type" value="protected"
                                            id="public">Protected </label>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input type="submit" class="btn btn-primary submit_addevent pull-right"
                                        value="Save">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="viewEventModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Edit Event</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <form role="form" method="post" id="updateevent_form" enctype="multipart/form-data"
                                action="">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">EventTitle</label>
                                    <input class="form-control" name="title" placeholder="" id="event_title">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea name="description" class="form-control" placeholder="" id="event_desc"></textarea>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Event From</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" autocomplete="off" name="event_from"
                                                class="form-control pull-right event_from">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Event To</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" autocomplete="off" name="event_to"
                                                class="form-control pull-right event_to">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="eventid" id="eventid">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">EventColor</label>
                                    <input type="hidden" name="eventcolor" autocomplete="off"
                                        placeholder="Event Color" id="event_color" class="form-control">
                                </div>
                                <div class="form-group col-md-12">

                                    <div class="cpicker-wrapper selectevent">
                                        <div id="03a9f4" class="calendar-cpicker cpicker cpicker-big"
                                            data-color="#03a9f4"
                                            style="background:#03a9f4;border:1px solid #03a9f4; border-radius:100px">
                                        </div>
                                        <div id="c53da9" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#c53da9"
                                            style="background:#c53da9;border:1px solid #c53da9; border-radius:100px">
                                        </div>
                                        <div id="757575" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#757575"
                                            style="background:#757575;border:1px solid #757575; border-radius:100px">
                                        </div>
                                        <div id="8e24aa" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#8e24aa"
                                            style="background:#8e24aa;border:1px solid #8e24aa; border-radius:100px">
                                        </div>
                                        <div id="d81b60" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#d81b60"
                                            style="background:#d81b60;border:1px solid #d81b60; border-radius:100px">
                                        </div>
                                        <div id="7cb342" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#7cb342"
                                            style="background:#7cb342;border:1px solid #7cb342; border-radius:100px">
                                        </div>
                                        <div id="fb8c00" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#fb8c00"
                                            style="background:#fb8c00;border:1px solid #fb8c00; border-radius:100px">
                                        </div>
                                        <div id="fb3b3b" class="calendar-cpicker cpicker cpicker-small"
                                            data-color="#fb3b3b"
                                            style="background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">EventType</label>
                                    <label class="radio-inline">

                                        <input type="radio" name="eventtype" value="public" id="public">Public
                                    </label>
                                    <label class="radio-inline">

                                        <input type="radio" name="eventtype" value="private"
                                            id="private">Private </label>
                                    <label class="radio-inline">

                                        <input type="radio" name="eventtype" value="sameforall" id="public">All
                                        Super Admin </label>
                                    <label class="radio-inline">

                                        <input type="radio" name="eventtype" value="protected"
                                            id="public">Protected </label>
                                </div>

                                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">

                                    <input type="submit" class="btn btn-primary submit_update pull-right"
                                        value="Save">
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <input type="button" id="delete_event"
                                        class="btn btn-primary submit_delete pull-right" value="Delete">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <style>
            canvas {
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <!-- <script src="https://erp.erabesa.co.in/backend/js/Chart.min.js"></script>
            <script src="https://erp.erabesa.co.in/backend/js/utils.js"></script> -->
        <script type="text/javascript">
            new Chart(document.getElementById("doughnut-chart"), {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        label: "Income",
                        backgroundColor: [],
                        data: []
                    }]
                },
                options: {
                    responsive: true,
                    circumference: Math.PI,
                    rotation: -Math.PI,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
            new Chart(document.getElementById("doughnut-chart1"), {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: [],
                        data: []
                    }]
                },
                options: {
                    responsive: true,
                    circumference: Math.PI,
                    rotation: -Math.PI,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
            $(function() {
                var areaChartOptions = {
                    showScale: true,
                    scaleShowGridLines: false,
                    scaleGridLineColor: "rgba(0,0,0,.05)",
                    scaleGridLineWidth: 1,
                    scaleShowHorizontalLines: true,
                    scaleShowVerticalLines: true,
                    bezierCurve: true,
                    bezierCurveTension: 0.3,
                    pointDot: false,
                    pointDotRadius: 4,
                    pointDotStrokeWidth: 1,
                    pointHitDetectionRadius: 20,
                    datasetStroke: true,
                    datasetStrokeWidth: 2,
                    datasetFill: true,
                    maintainAspectRatio: true,
                    responsive: true
                };
                var bar_chart = "1";
                var line_chart = "1";
                if (line_chart) {


                    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
                    var lineChart = new Chart(lineChartCanvas);
                    var lineChartOptions = areaChartOptions;
                    lineChartOptions.datasetFill = false;
                    var yearly_collection_array = [30260, "0.00", "0.00", 31148, "0.00", "0.00", "0.00", "0.00", "0.00",
                        "0.00", "0.00", "0.00"
                    ];
                    var yearly_expense_array = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    var total_month = ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb",
                        "Mar"
                    ];
                    var areaChartData_expense_Income = {
                        labels: total_month,
                        datasets: [{
                                label: "Expense",
                                fillColor: "rgba(215, 44, 44, 0.7)",
                                strokeColor: "rgba(215, 44, 44, 0.7)",
                                pointColor: "rgba(233, 30, 99, 0.9)",
                                pointStrokeColor: "#c1c7d1",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: yearly_expense_array
                            },
                            {
                                label: "Collection",
                                fillColor: "rgba(102, 170, 24, 0.6)",
                                strokeColor: "rgba(102, 170, 24, 0.6)",
                                pointColor: "rgba(102, 170, 24, 0.9)",
                                pointStrokeColor: "rgba(102, 170, 24, 0.6)",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(60,141,188,1)",
                                data: yearly_collection_array
                            }
                        ]
                    };
                    lineChart.Line(areaChartData_expense_Income, lineChartOptions);
                }

                var current_month_days = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13",
                    "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29",
                    "30", "31"
                ];
                var days_collection = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0
                ];
                var days_expense = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0
                ];
                var areaChartData_classAttendence = {
                    labels: current_month_days,
                    datasets: [{
                            label: "Electronics",
                            fillColor: "rgba(102, 170, 24, 0.6)",
                            strokeColor: "rgba(102, 170, 24, 0.6)",
                            pointColor: "rgba(102, 170, 24, 0.6)",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: days_collection
                        },
                        {
                            label: "Digital Goods",
                            fillColor: "rgba(233, 30, 99, 0.9)",
                            strokeColor: "rgba(233, 30, 99, 0.9)",
                            pointColor: "rgba(233, 30, 99, 0.9)",
                            pointStrokeColor: "rgba(233, 30, 99, 0.9)",
                            pointHighlightFill: "rgba(233, 30, 99, 0.9)",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: days_expense
                        }
                    ]
                };
                if (bar_chart) {
                    var current_month_days = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12",
                        "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27",
                        "28", "29", "30", "31"
                    ];
                    var days_collection = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        0, 0, 0, 0, 0
                    ];
                    var days_expense = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        0, 0, 0, 0
                    ];
                    var areaChartData_classAttendence = {
                        labels: current_month_days,
                        datasets: [{
                                label: "Electronics",
                                fillColor: "rgba(102, 170, 24, 0.6)",
                                strokeColor: "rgba(102, 170, 24, 0.6)",
                                pointColor: "rgba(102, 170, 24, 0.6)",
                                pointStrokeColor: "#c1c7d1",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: days_collection
                            },
                            {
                                label: "Digital Goods",
                                fillColor: "rgba(233, 30, 99, 0.9)",
                                strokeColor: "rgba(233, 30, 99, 0.9)",
                                pointColor: "rgba(233, 30, 99, 0.9)",
                                pointStrokeColor: "rgba(233, 30, 99, 0.9)",
                                pointHighlightFill: "rgba(233, 30, 99, 0.9)",
                                pointHighlightStroke: "rgba(60,141,188,1)",
                                data: days_expense
                            }
                        ]
                    };
                    var barChartCanvas = $("#barChart").get(0).getContext("2d");
                    var barChart = new Chart(barChartCanvas);
                    var barChartData = areaChartData_classAttendence;
                    barChartData.datasets[1].fillColor = "rgba(233, 30, 99, 0.9)";
                    barChartData.datasets[1].strokeColor = "rgba(233, 30, 99, 0.9)";
                    barChartData.datasets[1].pointColor = "rgba(233, 30, 99, 0.9)";
                    var barChartOptions = {
                        scaleBeginAtZero: true,
                        scaleShowGridLines: true,
                        scaleGridLineColor: "rgba(0,0,0,.05)",
                        scaleGridLineWidth: 1,
                        scaleShowHorizontalLines: false,
                        scaleShowVerticalLines: false,
                        barShowStroke: true,
                        barStrokeWidth: 2,
                        barValueSpacing: 5,
                        barDatasetSpacing: 1,
                        responsive: true,
                        maintainAspectRatio: true
                    };
                    barChartOptions.datasetFill = false;
                    barChart.Bar(barChartData, barChartOptions);
                }
            });


            $(document).ready(function() {

                $(document).on('click', '.close_notice', function() {
                    var data = $(this).data();
                    $.ajax({
                        type: "POST",
                        url: base_url + "admin/notification/read",
                        data: {
                            'notice': data.noticeid
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.status == "fail") {

                                errorMsg(data.msg);
                            } else {
                                successMsg(data.msg);
                            }

                        }
                    });
                });
            });
        </script>
        <footer class="main-footer">
            © 2024 Era International School</footer>
        <div class="control-sidebar-bg" style="position: fixed; height: auto;"></div>
    </div>
@stop
