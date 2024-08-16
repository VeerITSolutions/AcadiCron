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

 <script>
     $.widget.bridge('uibutton', $.ui.button);
 </script>
 <link href="https://erp.erabesa.co.in/backend/toast-alert/toastr.css" rel="stylesheet">
 <script src="https://erp.erabesa.co.in/backend/toast-alert/toastr.js"></script>
 <script src="https://erp.erabesa.co.in/backend/bootstrap/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://erp.erabesa.co.in/backend/plugins/select2/select2.min.css">
 <script src="https://erp.erabesa.co.in/backend/plugins/select2/select2.full.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/input-mask/jquery.inputmask.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/input-mask/jquery.inputmask.extensions.js"></script>
 <script src="https://erp.erabesa.co.in/backend/dist/js/moment.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/daterangepicker/daterangepicker.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>
 <script type="text/javascript">
     $('body').tooltip({
         selector: '[data-toggle]',
         trigger: 'click hover',
         placement: 'top',
         delay: {
             show: 50,
             hide: 400
         }
     })
 </script>
 <!--language js-->
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/js/bootstrap-select.min.js"></script>

 <script type="text/javascript">
     $(function() {
         $('.languageselectpicker').selectpicker();
     });
 </script>
 <script type="text/javascript">
     $(document).ready(function() {
         $(".studentsidebar").mCustomScrollbar({
             theme: "minimal"
         });

         $('.studentsideclose, .overlay').on('click', function() {
             $('.studentsidebar').removeClass('active');
             $('.overlay').fadeOut();
         });

         $('#sidebarCollapse').on('click', function() {
             $('.studentsidebar').addClass('active');
             $('.overlay').fadeIn();
             $('.collapse.in').toggleClass('in');
             $('a[aria-expanded=true]').attr('aria-expanded', 'false');
         });
     });
 </script>


 <script src="https://erp.erabesa.co.in/backend/plugins/iCheck/icheck.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/datepicker/bootstrap-datepicker.js"></script>
 <script src="https://erp.erabesa.co.in/backend/datepicker/js/bootstrap-datetimepicker.js"></script>

 <script src="https://erp.erabesa.co.in/backend/plugins/chartjs/Chart.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/plugins/fastclick/fastclick.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/dist/js/app.min.js"></script>
 <!--nprogress-->
 <script src="https://erp.erabesa.co.in/backend/dist/js/nprogress.js"></script>
 <!--file dropify-->
 <script src="https://erp.erabesa.co.in/backend/dist/js/dropify.min.js"></script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/jquery.dataTables.min.js">
 </script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/dataTables.buttons.min.js">
 </script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/jszip.min.js"></script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/pdfmake.min.js"></script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/vfs_fonts.js"></script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/buttons.html5.min.js"></script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/buttons.print.min.js"></script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/buttons.colVis.min.js">
 </script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/dataTables.responsive.min.js">
 </script>
 <script type="text/javascript" src="https://erp.erabesa.co.in/backend/dist/datatables/js/ss.custom.js"></script>
 <!-- <script src="https://erp.erabesa.co.in/backend/dist/datatables/js/datetime-moment.js"></script>
-->




 <script src="https://erp.erabesa.co.in/backend/fullcalendar/dist/fullcalendar.min.js"></script>
 <script src="https://erp.erabesa.co.in/backend/fullcalendar/dist/locale-all.js"></script>
 <script type="text/javascript">
     $(document).ready(function() {

     });


     function complete_event(id, status) {
         $.ajax({
             url: "https://erp.erabesa.co.in/admin/calendar/markcomplete/" + id,
             type: "POST",
             data: {
                 id: id,
                 active: status
             },
             dataType: 'json',

             success: function(res) {

                 if (res.status == "fail") {
                     var message = "";
                     $.each(res.error, function(index, value) {

                         message += value;
                     });
                     errorMsg(message);

                 } else {
                     successMsg(res.message);
                     window.location.reload(true);
                 }
             }
         });
     }

     function markc(id) {
         $('#newcheck' + id).change(function() {
             if (this.checked) {
                 complete_event(id, 'yes');
             } else {
                 complete_event(id, 'no');
             }
         });
     }
 </script>


 <!-- Button trigger modal -->
 <!-- Modal -->
 <div class="row">
     <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
         <form action="https://erp.erabesa.co.in/admin/admin/activeSession" id="form_modal_session" class="">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                 aria-hidden="true">×</span></button>
                         <h4 class="modal-title" id="sessionModalLabel">Session</h4>
                     </div>
                     <div class="modal-body sessionmodal_body pb0">
                     </div>
                     <div class="modal-footer">
                         <div class="col-md-12">
                             <button type="button" class="btn btn-primary submit_session"
                                 data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait">Save</button>
                         </div>
                     </div>
                 </div>
             </div>
         </form>
     </div>
 </div>


 <div id="activelicmodal" class="modal fade">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                 <h4 class="modal-title">Register your purchase code</h4>
             </div>
             <form action="https://erp.erabesa.co.in/admin/admin/updatePurchaseCode" method="POST" id="purchase_code">
                 <div class="modal-body lic_modal-body">
                     <div class="form-group">
                         <div class="req"><b>Important:</b> Smart School Regular License allows to use Smart School
                             for single school/branch/end/client but for customer convenience registering Smart School
                             allows to register Smart School licence purchase code on upto 3 urls e.g. 1. For localhost
                             2. For testing environment and 3. For your production url (testing and production url
                             should
                             be on same domain).</div>
                     </div>
                     <div class="error_message">

                     </div>
                     <div class="form-group">
                         <label class="ainline"><span>Envato Market Purchase Code for Smart School ( <a target="_blank"
                                     href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">
                                     How to find it?</a> )</span></label>
                         <input type="text" class="form-control" id="input-envato_market_purchase_code"
                             name="envato_market_purchase_code">
                         <div id="error" class="text text-danger"></div>
                     </div>

                     <div class="form-group">
                         <label for="exampleInputEmail1">Your Email registered with Envato</label>
                         <input type="text" class="form-control" id="input-email" name="email">
                         <div id="error" class="text text-danger"></div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-success"
                         data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Save</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <div id="addonModal" class="modal fade">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                 <h4 class="modal-title">Register your Addon</h4>
             </div>
             <form action="https://erp.erabesa.co.in/admin/admin/updateaddon" method="POST" id="addon_verify">
                 <div class="modal-body addon_modal-body">
                     <div class="error_message">

                     </div>
                     <input type="hidden" name="addon" class="addon_type" value="">
                     <input type="hidden" name="addon_version" class="addon_version" value="0">
                     <div class="form-group">
                         <label class="ainline"><span>Envato Market Purchase Code for Addon ( <a target="_blank"
                                     href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">
                                     How to find it?</a> )</span></label>
                         <input type="text" class="form-control" id="input-app-envato_market_purchase_code"
                             name="app-envato_market_purchase_code">
                         <div id="error" class="input-error text text-danger"></div>
                     </div>

                     <div class="form-group">
                         <label for="exampleInputEmail1">Your Email registered with Envato</label>
                         <input type="text" class="form-control" id="input-app-email" name="app-email">
                         <div id="error" class="input-error text text-danger"></div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-info"
                         data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Save</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <script type="text/javascript">
     var calendar_date_time_format = 'DD-MM-YYYY';

     var datetime_format = 'DD-MM-YYYY';

     var date_format = 'dd-mm-yyyy';


     function savedata(eventData) {
         var base_url = 'https://erp.erabesa.co.in/';
         $.ajax({
             url: base_url + 'admin/calendar/saveevent',
             type: 'POST',
             data: eventData,
             dataType: "json",
             success: function(msg) {
                 alert(msg);

             }
         });
     }

     $calendar = $('#calendar');
     var base_url = 'https://erp.erabesa.co.in/';
     today = new Date();
     y = today.getFullYear();
     m = today.getMonth();
     d = today.getDate();
     var viewtitle = 'month';
     var pagetitle = "Dashboard";

     if (pagetitle == "Dashboard") {

         viewtitle = 'agendaWeek';
     }

     $calendar.fullCalendar({
         viewRender: function(view, element) {

         },

         header: {
             center: 'title',
             right: 'month,agendaWeek,agendaDay',
             left: 'prev,next,today'
         },
         firstDay: start_week,
         defaultDate: today,
         defaultView: viewtitle,
         selectable: true,
         selectHelper: true,
         views: {
             month: { // name of view
                 titleFormat: 'MMMM YYYY'
                 // other view-specific options here
             },
             week: {
                 titleFormat: " MMMM D YYYY"
             },
             day: {
                 titleFormat: 'D MMM, YYYY'
             }
         },
         timezone: 'UTC',
         draggable: false,
         lang: 'en',
         editable: false,
         eventLimit: false, // allow "more" link when too many events

         // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
         events: {
             url: base_url + 'admin/calendar/getevents'

         },

         eventRender: function(event, element) {
             element.attr('title', event.title);
             element.attr('onclick', event.onclick);
             element.attr('data-toggle', 'tooltip');
             if ((!event.url) && (event.event_type != 'task')) {
                 element.attr('title', event.title + '-' + event.description);
                 element.click(function() {
                     view_event(event.id);
                 });
             }
         },
         dayClick: function(date, jsEvent, view) {
             console.log('Clicked on the entire day: ' + date.format());


             var newEventModal = $('#newEventModal');
             $("#input-field").val('');
             $("#desc-field").text('');
             var event_start_from = new Date(date);
             console.log(event_start_from);
             $('.event_from', newEventModal).data("DateTimePicker").date(event_start_from);
             $('.event_to', newEventModal).data("DateTimePicker").date(event_start_from);
             $('#newEventModal').modal('show');

             return false;
         }

     });

     function view_event(id) {

         $('.selectevent').find('.cpicker-big').removeClass('cpicker-big').addClass('cpicker-small');
         var base_url = 'https://erp.erabesa.co.in/';
         if (typeof(id) == 'undefined') {
             return;
         }
         $.ajax({
             url: base_url + 'admin/calendar/view_event/' + id,
             type: 'POST',
             //data: '',
             dataType: "json",
             success: function(msg) {


                 $("#event_title").val(msg.event_title);
                 $("#event_desc").text(msg.event_description);

                 $('#eventid').val(id);
                 if (msg.event_type == 'public') {

                     $('input:radio[name=eventtype]')[0].checked = true;

                 } else if (msg.event_type == 'private') {
                     $('input:radio[name=eventtype]')[1].checked = true;

                 } else if (msg.event_type == 'sameforall') {
                     $('input:radio[name=eventtype]')[2].checked = true;

                 } else if (msg.event_type == 'protected') {
                     $('input:radio[name=eventtype]')[3].checked = true;

                 }
                 //===========

                 var __viewModal = $('#viewEventModal');
                 var event_start_from = new Date(msg.start_date);
                 $('.event_from', __viewModal).data("DateTimePicker").date(event_start_from);

                 var event_end_to = new Date(msg.end_date);
                 $('.event_to', __viewModal).data("DateTimePicker").date(event_end_to);
                 //============

                 $("#event_color").val(msg.event_color);
                 $("#delete_event").attr("onclick", "deleteevent(" + id + ",'Event')");
                 $("#" + msg.colorid).removeClass('cpicker-small').addClass('cpicker-big');
                 $('#viewEventModal').modal('show');
             }
         });

     }

     $(document).ready(function(e) {
         $("#addevent_form").on('submit', (function(e) {

             e.preventDefault();
             $.ajax({
                 url: "https://erp.erabesa.co.in/admin/calendar/saveevent",
                 type: "POST",
                 data: new FormData(this),
                 dataType: 'json',
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(res) {

                     if (res.status == "fail") {

                         var message = "";
                         $.each(res.error, function(index, value) {

                             message += value;
                         });
                         errorMsg(message);

                     } else {

                         successMsg(res.message);

                         window.location.reload(true);
                     }
                 }
             });
         }));


     });


     $(document).ready(function(e) {
         $("#updateevent_form").on('submit', (function(e) {

             e.preventDefault();
             $.ajax({
                 url: "https://erp.erabesa.co.in/admin/calendar/updateevent",
                 type: "POST",
                 data: new FormData(this),
                 dataType: 'json',
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(res) {

                     if (res.status == "fail") {

                         var message = "";
                         $.each(res.error, function(index, value) {

                             message += value;
                         });
                         errorMsg(message);

                     } else {

                         successMsg(res.message);
                         window.location.reload(true);
                     }
                 }
             });
         }));

     });

     function deleteevent(id, msg) {
         if (typeof(id) == 'undefined') {
             return;
         }
         if (confirm("Are you sure to delete this ")) {
             $.ajax({
                 url: base_url + 'admin/calendar/delete_event/' + id,
                 type: 'POST',
                 dataType: "json",
                 success: function(res) {
                     if (res.status == "fail") {
                         errorMsg(res.message);
                     } else {
                         successMsg(msg + " Record Delete Successfully");
                         window.location.reload(true);
                     }
                 }
             })
         }
     }

     $("body").on('click', '.cpicker', function() {
         var color = $(this).data('color');
         // Clicked on the same selected color
         if ($(this).hasClass('cpicker-big')) {
             return false;
         }

         $(this).parents('.cpicker-wrapper').find('.cpicker-big').removeClass('cpicker-big').addClass(
             'cpicker-small');
         $(this).removeClass('cpicker-small', 'fast').addClass('cpicker-big', 'fast');
         if ($(this).hasClass('kanban-cpicker')) {
             $(this).parents('.panel-heading-bg').css('background', color);
             $(this).parents('.panel-heading-bg').css('border', '1px solid ' + color);
         } else if ($(this).hasClass('calendar-cpicker')) {
             $("body").find('input[name="eventcolor"]').val(color);
         }
     });

     $(document).ready(function() {
         moment.lang('en', {
             week: {
                 dow: start_week
             }
         });

         $("body").delegate(".date", "focusin", function() {
             $(this).datepicker({
                 todayHighlight: false,
                 format: date_format,
                 autoclose: true,
                 weekStart: start_week,
                 language: 'en'
             });
         });

         $("body").delegate(".datetime", "focusin", function() {
             $(this).datetimepicker({
                 format: calendar_date_time_format + ' hh:mm a',
                 locale: 'en',

             });
         });

         $('body').on('focus', ".date_fee", function() {
             $(this).datepicker({
                 format: date_format,
                 autoclose: true,
                 language: 'en',
                 endDate: '+0d',
                 weekStart: start_week,
                 todayHighlight: true
             });
         });

         $('.datetime_twelve_hour').datetimepicker({
             format: calendar_date_time_format + ' hh:mm a'
         });


         $("#event_date").daterangepicker({
             timePickerIncrement: 5,
             locale: {
                 format: calendar_date_time_format
             }
         });


         ///================

         $('.event_from').datetimepicker({
             format: calendar_date_time_format + ' hh:mm a'
         });

         $('.event_to').datetimepicker({
             format: calendar_date_time_format + ' hh:mm a'
         });
         //==============


     });

     function loadDate() {

         var date_format = 'dd-mm-yyyy';

         $('.date').datetimepicker({
             format: datetime_format,
             locale: 'en',

         });
     }

     // showdate('this_year');

     function showdate(type) {

         var date_from = '16-08-2024';
         var date_to = '16-08-2024';

         if (type == 'period') {

             $.ajax({
                 url: base_url + 'Report/get_betweendate/' + type,
                 type: 'POST',
                 data: {
                     date_from: date_from,
                     date_to: date_to
                 },
                 success: function(res) {

                     $('#date_result').html(res);

                     loadDate();
                 }

             });

         } else {
             $('#date_result').html('');
         }

     }
 </script>
 </body>

 </html>
