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
                                 data-id="languageSwitcher" title="English"><span class="filter-option pull-left"><span
                                         class="flag-icon flag-icon-us"></span>
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
                                 <img src="https://erp.erabesa.co.in/uploads/staff_images/1.png" class="topuser-image"
                                     alt="User Image">
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
                                             <a class="pl25" href="https://erp.erabesa.co.in/admin/admin/changepass"
                                                 data-toggle="tooltip" title=""
                                                 data-original-title="Change Password"><i
                                                     class="fa fa-key"></i>Password</a> <a class="pull-right"
                                                 href="{{ url('site/logout') }}"><i
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
