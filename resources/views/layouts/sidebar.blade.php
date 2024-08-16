 <aside class="main-sidebar affix-top" id="alert2">


     <form class="navbar-form navbar-left search-form2" role="search" action="{{ url('/') }}/admin/admin/search"
         method="POST">

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

                     <a class="dropdown-toggle drop5" data-toggle="dropdown" href="#" aria-expanded="false">
                         <span>Quick Links</span> <i class="fa fa-th pull-right ftlayer"></i>
                     </a>

                     <ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">

                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/student/search"><i
                                     class="fa fa-user-plus"></i>Student Details</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/studentfee"><i
                                     class="fa fa-money"></i>Collect Fees</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/income">
                                 &nbsp;<i class="fa fa-usd"></i> Add Income</a></li>

                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/expense"><i
                                     class="fa fa-credit-card"></i>Add Expense</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/stuattendence"><i
                                     class="fa fa-calendar-check-o"></i>Student Attendance</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/staffattendance"><i
                                     class="fa fa-calendar-check-o"></i>Staff Attendance</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/staff"><i
                                     class="fa fa-calendar-check-o"></i>Staff Directory</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/examgroup"><i
                                     class="fa fa-map-o"></i>Exam
                                 Group</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/examresult"><i
                                     class="fa fa-columns"></i>Exam Result</a></li>


                         <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;"
                                 role="menuitem" tabindex="-1" href="{{ url('/') }}/admin/timetable/create"><i
                                     class="fa fa-calendar-times-o"></i>Class Timetable</a></li>


                         <li role="presentation"><a
                                 style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem"
                                 tabindex="-1" href="{{ url('/') }}/admin/enquiry"><i
                                     class="fa fa-calendar-check-o"></i>Admission Enquiry</a></li>

                         <li role="presentation"><a
                                 style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem"
                                 tabindex="-1" href="{{ url('/') }}/admin/complaint"><i
                                     class="fa fa-calendar-check-o"></i>Complain</a></li>

                         <li role="presentation"><a
                                 style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem"
                                 tabindex="-1" href="{{ url('/') }}/admin/content"><i
                                     class="fa fa-download"></i>Upload Content</a></li>


                         <li role="presentation"><a
                                 style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem"
                                 tabindex="-1" href="{{ url('/') }}/admin/itemstock"><i
                                     class="fa fa-object-group"></i>Add Item Stock</a></li>


                         <li role="presentation"><a
                                 style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem"
                                 tabindex="-1" href="{{ url('/') }}/admin/notification"><i
                                     class="fa fa-bullhorn"></i>Notice Board</a></li>

                         <li role="presentation"><a
                                 style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem"
                                 tabindex="-1" href="{{ url('/') }}/admin/mailsms/compose"><i
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




                         <li class=""><a href="{{ url('/') }}/student/search"><i
                                     class="fa fa-angle-double-right"></i> Student Details</a></li>






                         <li class=""><a href="{{ url('/') }}/student/create"><i
                                     class="fa fa-angle-double-right"></i> Student Admission</a></li>




                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/onlinestudent"><i
                                     class="fa fa-angle-double-right"></i> Online Admission</a></li>




                         <li class=""><a href="{{ url('/') }}/student/disablestudentslist"><i
                                     class="fa fa-angle-double-right"></i> Disabled Students</a></li>


                         <li class=""><a href="{{ url('/') }}/student/multiclass"><i
                                     class="fa fa-angle-double-right"></i> Multi Class Student</a></li>


                         <li class=""><a href="{{ url('/') }}/student/bulkdelete"><i
                                     class="fa fa-angle-double-right"></i> Bulk Delete</a>

                         </li>




                         <li class=""><a href="{{ url('/') }}/category"><i
                                     class="fa fa-angle-double-right"></i> Student Categories</a></li>





                         <li class=""><a href="{{ url('/') }}/admin/schoolhouse"><i
                                     class="fa fa-angle-double-right"></i> Student House</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/disable_reason"><i
                                     class="fa fa-angle-double-right"></i> Disable Reason</a></li>







                     </ul>

                 </li>


                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-money ftlayer"></i> <span> Fees Collection</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/studentfee"><i
                                     class="fa fa-angle-double-right"></i> Collect Fees</a></li>


                         <li class=""><a href="{{ url('/') }}/studentfee/searchpayment"><i
                                     class="fa fa-angle-double-right"></i> Search Fees Payment</a></li>


                         <li class=""><a href="{{ url('/') }}/studentfee/feesearch"><i
                                     class="fa fa-angle-double-right"></i> Search Due Fees </a></li>


                         <li class=""><a href="{{ url('/') }}/admin/feemaster"><i
                                     class="fa fa-angle-double-right"></i> Fees Master</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/feegroup"><i
                                     class="fa fa-angle-double-right"></i> Fees Group</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/feetype"><i
                                     class="fa fa-angle-double-right"></i> Fees Type</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/feediscount"><i
                                     class="fa fa-angle-double-right"></i> Fees Discount</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/feesforward"><i
                                     class="fa fa-angle-double-right"></i> Fees Carry Forward</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/feereminder/setting"><i
                                     class="fa fa-angle-double-right"></i> Fees Reminder</a></li>




                     </ul>

                 </li>


                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-calendar-check-o ftlayer"></i> <span>Attendance</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/admin/stuattendence"><i
                                     class="fa fa-angle-double-right"></i> Student Attendance</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/stuattendence/attendencereport"><i
                                     class="fa fa-angle-double-right"></i> Attendance By Date</a></li>






                         <li class=""><a href="{{ url('/') }}/admin/approve_leave"><i
                                     class="fa fa-angle-double-right"></i> Approve Leave</a></li>


                     </ul>

                 </li>








                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-list-alt ftlayer"></i> <span>Lesson Plan</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/admin/syllabus"><i
                                     class="fa fa-angle-double-right"></i> Manage Lesson Plan</a></li>



                         <li class=""><a href="{{ url('/') }}/admin/syllabus/status"><i
                                     class="fa fa-angle-double-right"></i> Manage Syllabus Status</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/lessonplan/lesson"><i
                                     class="fa fa-angle-double-right"></i> Lesson</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/lessonplan/topic"><i
                                     class="fa fa-angle-double-right"></i> Topic</a></li>




                     </ul>

                 </li>



                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-mortar-board ftlayer"></i> <span>Academics</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">




                         <li class=""><a href="{{ url('/') }}/admin/timetable/classreport"><i
                                     class="fa fa-angle-double-right"></i> Class Timetable</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/timetable/mytimetable"><i
                                     class="fa fa-angle-double-right"></i> Teachers Timetable</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/teacher/assign_class_teacher"><i
                                     class="fa fa-angle-double-right"></i> Assign Class Teacher</a></li>




                         <li class=""><a href="{{ url('/') }}/admin/stdtransfer"><i
                                     class="fa fa-angle-double-right"></i> Promote Students</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/subjectgroup"><i
                                     class="fa fa-angle-double-right"></i> Subject Group</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/subject"><i
                                     class="fa fa-angle-double-right"></i> Subjects</a></li>


                         <li class=""><a href="{{ url('/') }}/classes"><i
                                     class="fa fa-angle-double-right"></i> Class</a></li>


                         <li class=""><a href="{{ url('/') }}/sections"><i
                                     class="fa fa-angle-double-right"></i> Sections</a></li>




                     </ul>

                 </li>





                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-sitemap ftlayer"></i> <span>Human Resource</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/admin/staff"><i
                                     class="fa fa-angle-double-right"></i> Staff Directory</a></li>







                         <li class=""><a href="{{ url('/') }}/admin/staffattendance"><i
                                     class="fa fa-angle-double-right"></i> Staff Attendance</a></li>






                         <li class=""><a href="{{ url('/') }}/admin/payroll"><i
                                     class="fa fa-angle-double-right"></i> Payroll</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/leaverequest/leaverequest"><i
                                     class="fa fa-angle-double-right"></i> Approve Leave Request</a></li>




                         <li class=""><a href="{{ url('/') }}/admin/staff/leaverequest"><i
                                     class="fa fa-angle-double-right"></i> Apply Leave</a></li>




                         <li class=""><a href="{{ url('/') }}/admin/leavetypes"><i
                                     class="fa fa-angle-double-right"></i> Leave Type</a></li>




                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/staff/rating"><i
                                     class="fa fa-angle-double-right"></i> Teachers Rating</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/department/department"><i
                                     class="fa fa-angle-double-right"></i> Department</a></li>




                         <li class=""><a href="{{ url('/') }}/admin/designation/designation"><i
                                     class="fa fa-angle-double-right"></i> Designation</a></li>




                         <li class=""><a href="{{ url('/') }}/admin/staff/disablestafflist"><i
                                     class="fa fa-angle-double-right"></i> Disabled Staff</a></li>


                     </ul>

                 </li>


                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-bullhorn ftlayer"></i> <span>Communicate</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">




                         <li class=""><a href="{{ url('/') }}/admin/notification"><i
                                     class="fa fa-angle-double-right"></i> Notice Board</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/mailsms/compose"><i
                                     class="fa fa-angle-double-right"></i> Send Email</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/mailsms/compose_sms"><i
                                     class="fa fa-angle-double-right"></i> Send SMS</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/mailsms/index"><i
                                     class="fa fa-angle-double-right"></i> Email / SMS Log</a></li>




                         <li style="display:none;" class=""><a href="{{ url('/') }}/student/bulkmail"><i
                                     class="fa fa-angle-double-right"></i> Login Credentials Send</a></li>


                     </ul>

                 </li>














                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-download ftlayer"></i> <span>Download Center</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/admin/content"><i
                                     class="fa fa-angle-double-right"></i> Upload Content</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/content/assignment"><i
                                     class="fa fa-angle-double-right"></i> Assignments</a></li>

                         <li class=""><a href="{{ url('/') }}/admin/content/studymaterial"><i
                                     class="fa fa-angle-double-right"></i> Study Material</a></li>

                         <li class=""><a href="{{ url('/') }}/admin/content/syllabus"><i
                                     class="fa fa-angle-double-right"></i> Syllabus</a></li>

                         <li class=""><a href="{{ url('/') }}/admin/content/other"><i
                                     class="fa fa-angle-double-right"></i> Other Downloads</a></li>

                     </ul>

                 </li>


                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-flask ftlayer"></i> <span>Homework</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/homework"><i
                                     class="fa fa-angle-double-right"></i> Add Homework</a></li>


                     </ul>

                 </li>


                 <li class="treeview ">

                     <a href="#">

                         <i class="fa fa-newspaper-o ftlayer"></i> <span>Certificate</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/admin/certificate/"><i
                                     class="fa fa-angle-double-right"></i>Student Certificate</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/generatecertificate/"><i
                                     class="fa fa-angle-double-right"></i>Generate Certificate</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/studentidcard/"><i
                                     class="fa fa-angle-double-right"></i>Student ID Card</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/generateidcard/search"><i
                                     class="fa fa-angle-double-right"></i>Generate ID Card</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/staffidcard/"><i
                                     class="fa fa-angle-double-right"></i>Staff ID Card</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/generatestaffidcard/"><i
                                     class="fa fa-angle-double-right"></i>Generate Staff ID Card</a></li>


                     </ul>

                 </li>




                 <li style="display:none;" class="treeview ">

                     <a href="#">

                         <i class="fa fa-line-chart ftlayer"></i> <span>Reports</span> <i
                             class="fa fa-angle-left pull-right"></i>

                     </a>

                     <ul class="treeview-menu">


                         <li class=""><a href="{{ url('/') }}/report/studentinformation"><i
                                     class="fa fa-angle-double-right"></i> Student Information</a></li>


                         <li class=""><a href="{{ url('/') }}/report/finance"><i
                                     class="fa fa-angle-double-right"></i> Finance</a></li>




                         <li class=""><a href="{{ url('/') }}/report/attendance"><i
                                     class="fa fa-angle-double-right"></i> Attendance</a></li>


                         <li class=""><a href="{{ url('/') }}/report/examinations"><i
                                     class="fa fa-angle-double-right"></i> Examinations</a></li>


                         <li class=""><a href="{{ url('/') }}/report/lesson_plan"><i
                                     class="fa fa-angle-double-right"></i> Lesson Plan</a></li>




                         <li class=""><a href="{{ url('/') }}/report/staff_report"><i
                                     class="fa fa-angle-double-right"></i> Human Resource</a></li>




                         <li class=""><a href="{{ url('/') }}/admin/userlog"><i
                                     class="fa fa-angle-double-right"></i> User Log</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/audit"><i
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


                         <li class=""><a href="{{ url('/') }}/schsettings"><i
                                     class="fa fa-angle-double-right"></i> General Setting</a></li>


                         <li class=""><a href="{{ url('/') }}/sessions"><i
                                     class="fa fa-angle-double-right"></i> Session Setting</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/notification/setting"><i
                                     class="fa fa-angle-double-right"></i> Notification Setting</a></li>


                         <li class=""><a href="{{ url('/') }}/smsconfig"><i
                                     class="fa fa-angle-double-right"></i> SMS Setting</a></li>


                         <li class=""><a href="{{ url('/') }}/emailconfig"><i
                                     class="fa fa-angle-double-right"></i> Email Setting</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/paymentsettings"><i
                                     class="fa fa-angle-double-right"></i> Payment Methods</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/print_headerfooter"><i
                                     class="fa fa-angle-double-right"></i> Print Header Footer</a></li>



                         <li class=""><a href="{{ url('/') }}/admin/roles"><i
                                     class="fa fa-angle-double-right"></i> Roles Permissions</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/admin/backup"><i
                                     class="fa fa-angle-double-right"></i> Backup / Restore</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/language"><i
                                     class="fa fa-angle-double-right"></i> Languages</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/users"><i
                                     class="fa fa-angle-double-right"></i> Users</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/module"><i
                                     class="fa fa-angle-double-right"></i> Modules</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/customfield"><i
                                     class="fa fa-angle-double-right"></i> Custom Fields</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/captcha"><i
                                     class="fa fa-angle-double-right"></i> Captcha Setting</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/systemfield"><i
                                     class="fa fa-angle-double-right"></i> System Fields</a></li>


                         <li class=""><a href="{{ url('/') }}/student/profilesetting"><i
                                     class="fa fa-angle-double-right"></i> Student Profile Update</a></li>


                         <li style="display:none;" class=""><a
                                 href="{{ url('/') }}/admin/onlineadmission/admissionsetting"><i
                                     class="fa fa-angle-double-right"></i> Online Admission</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/admin/filetype"><i
                                     class="fa fa-angle-double-right"></i> File Types</a></li>


                         <li class=""><a href="{{ url('/') }}/admin/updater"><i
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
