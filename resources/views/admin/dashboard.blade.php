@extends('admin.layouts.main')



@section('main-container')

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

    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>


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
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
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
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
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
                                                    type="button" class="fc-next-button fc-button fc-state-default"><span
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
                                                                                <tr data-time="00:30:00" class="fc-minor">
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
                                                                                <tr data-time="01:30:00" class="fc-minor">
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
                                                                                <tr data-time="02:30:00" class="fc-minor">
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
                                                                                <tr data-time="03:30:00" class="fc-minor">
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
                                                                                <tr data-time="04:30:00" class="fc-minor">
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
                                                                                <tr data-time="05:30:00" class="fc-minor">
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
                                                                                <tr data-time="06:30:00" class="fc-minor">
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
                                                                                <tr data-time="07:30:00" class="fc-minor">
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
                                                                                <tr data-time="08:30:00" class="fc-minor">
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
                                                                                <tr data-time="09:30:00" class="fc-minor">
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
                                                                                <tr data-time="10:30:00" class="fc-minor">
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
                                                                                <tr data-time="11:30:00" class="fc-minor">
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
                                                                                <tr data-time="12:30:00" class="fc-minor">
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
                                                                                <tr data-time="13:30:00" class="fc-minor">
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
                                                                                <tr data-time="14:30:00" class="fc-minor">
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
                                                                                <tr data-time="15:30:00" class="fc-minor">
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
                                                                                <tr data-time="16:30:00" class="fc-minor">
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
                                                                                <tr data-time="17:30:00" class="fc-minor">
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
                                                                                <tr data-time="18:30:00" class="fc-minor">
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
                                                                                <tr data-time="19:30:00" class="fc-minor">
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
                                                                                <tr data-time="20:30:00" class="fc-minor">
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
                                                                                <tr data-time="21:30:00" class="fc-minor">
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
                                                                                <tr data-time="22:30:00" class="fc-minor">
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
                                                                                <tr data-time="23:30:00" class="fc-minor">
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

                                    <input type="radio" name="event_type" value="sameforall" id="public">All Super
                                    Admin </label>
                                <label class="radio-inline">

                                    <input type="radio" name="event_type" value="protected" id="public">Protected
                                </label>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="submit" class="btn btn-primary submit_addevent pull-right" value="Save">
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
                                <input type="hidden" name="eventcolor" autocomplete="off" placeholder="Event Color"
                                    id="event_color" class="form-control">
                            </div>
                            <div class="form-group col-md-12">

                                <div class="cpicker-wrapper selectevent">
                                    <div id="03a9f4" class="calendar-cpicker cpicker cpicker-big" data-color="#03a9f4"
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

                                    <input type="radio" name="eventtype" value="private" id="private">Private
                                </label>
                                <label class="radio-inline">

                                    <input type="radio" name="eventtype" value="sameforall" id="public">All
                                    Super Admin </label>
                                <label class="radio-inline">

                                    <input type="radio" name="eventtype" value="protected" id="public">Protected
                                </label>
                            </div>

                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">

                                <input type="submit" class="btn btn-primary submit_update pull-right" value="Save">
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <input type="button" id="delete_event" class="btn btn-primary submit_delete pull-right"
                                    value="Delete">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


@stop
