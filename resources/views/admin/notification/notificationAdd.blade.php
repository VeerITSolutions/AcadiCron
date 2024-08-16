<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-bullhorn"></i> <?php echo $this->lang->line('notifications'); ?> <small><?php echo $this->lang->line('student_fee1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- left column -->
                <form id="form1" action="<?php echo base_url() ?>admin/notification/add"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-commenting-o"></i> <?php echo $this->lang->line('compose_new_message'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">  
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="title" name="title" placeholder="" type="text" class="form-control"  value="<?php echo set_value('title'); ?>" />
                                        <span class="text-danger"><?php echo form_error('title'); ?></span>
                                    </div>
                                    <div class="form-group"><label><?php echo $this->lang->line('message'); ?></label><small class="req"> *</small>
                                        <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">
                                            <?php echo set_value('message'); ?>
                                        </textarea>
                                        <span class="text-danger"><?php echo form_error('message'); ?></span>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                        <?php
                                        if (isset($error_message)) {
                                            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                        }
                                        ?>    
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('notice_date'); ?></label><small class="req"> *</small>
                                            <input id="date" name="date"  placeholder="" type="text" class="form-control date"  value="<?php echo set_value('date'); ?>" />
                                            <span class="text-danger"><?php echo form_error('date'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('publish_on'); ?></label><small class="req"> *</small>
                                            <input id="publish_date" name="publish_date"  placeholder="" type="text" class="form-control date"  value="<?php echo set_value('publish_date'); ?>" />
                                            <span class="text-danger"><?php echo form_error('publish_date'); ?></span>
                                        </div>
                                        <div class="form-horizontal">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('message_to'); ?></label>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="visible[]" value="student" <?php echo set_checkbox('visible[]', 'student', false) ?> /> <b><?php echo $this->lang->line('student'); ?></b> </label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="visible[]"  value="parent" <?php echo set_checkbox('visible[]', 'parent', false) ?> /> <b><?php echo $this->lang->line('parent'); ?></b></label>
                                            </div>
                                            <?php
                                            foreach ($roles as $role_key => $role_value) {
                                                $userdata = $this->customlib->getUserData();
                                                $role_id = $userdata["role_id"];
                                                ?>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="visible[]" value="<?php echo $role_value['id']; ?>" <?php
                                                        if ($role_value["id"] == $role_id) {
                                                            echo "checked";
                                                        }
                                                        ?>  <?php echo set_checkbox('visible[]', $role_value['id'], false) ?> /> <b><?php echo $role_value['name']; ?></b> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="checkbox">
                                                <label><input id="specific_class" type="checkbox" name="visible[]" value="specific_class" <?php echo set_checkbox('visible[]', 'specific_class', false) ?> /> <b>Class</b> </label>
                                            </div>

                                        </div>
                                        <span class="text-danger"><?php echo form_error('visible[]'); ?></span>

                                    </div>
                                </div>  
                               


                                <div  id="specific_class_selector" style="display: none; padding-top:20px;" class="col-md-3">
                                    

                    

                        <div class="">

                            <?php if ($this->session->flashdata('msg')) { ?>

                                <?php echo $this->session->flashdata('msg') ?>

                            <?php } ?>

                            <?php echo $this->customlib->getCSRF(); ?>

                        </div>

                        <div class="">

                            <div class="form-group">

                                <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>

                                <select autofocus="" id="searchclassid" name="class_id" onchange="getSectionByClass(this.value, 0, 'secid')"  class="form-control" >

                                    <option value=""><?php echo $this->lang->line('select'); ?></option>

                                    <?php

                                    foreach ($classlist as $class) {

                                        ?>

                                        <option <?php

                                        if ($class_id == $class["id"]) {

                                            echo "selected";

                                        }

                                        ?> value="<?php echo $class['id'] ?>"><?php echo $class['class'] ?></option>

                                            <?php

                                        }

                                        ?>

                                </select>

                                <span class="text-danger" id="error_class_id"></span>

                            </div>

                        </div>

                        <div class="">

                            <div class="form-group">

                                <label><?php echo $this->lang->line('section'); ?></label>

                                <select  id="secid" name="section_id" class="form-control" >

                                    <option value=""><?php echo $this->lang->line('select'); ?></option>

                                </select>

                                <span class="section_id_error text-danger"></span>

                            </div>

                        </div>

                        

                       

                 
                            </div> 


                     <div class="row">
                                    <div class="col-md-9">
                                        
                                    </div>
                                    <div class="col-md-3">
                                    <div class="">

                            <div class="form-group">

                                <label>Multiple Select</label>

                                
                                <div class="checkbox">
                                                    <label><input type="checkbox" name="classMultiple[]" value="1-2"> <b>Class 1 to 2</b> </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="classMultiple[]" value="3-4"> <b>Class 3 to 4</b> </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="classMultiple[]" value="5-7"> <b>Class 5 to 7</b> </label>
                                                </div>
                                                 <div class="checkbox">
                                                    <label><input type="checkbox" name="classMultiple[]" value="8-10"> <b>Class 8 to 10</b> </label>
                                                </div>
                               

                            </div>

                        </div>
                                </div>
                                </div>

                
                                
                            
                            <div  class='row'>
                                <div class="col-md-6">
                                     <label for="exampleInputEmail1">Upload File</label><br/>
                                     <span><i class="fa fa-upload"><input class="btn btn-primary form-control" type='file' name='userfile'  /></i></span>
                                     
                                </div>
                        
                     </div>                       
                            <div class="box-footer">
                                <div class="pull-right">

                                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> <?php echo $this->lang->line('send'); ?></button>
                                </div>
                            </div>  

                        </div>                      
                    </div>
                     
                </form>              
            </div>
        </div><!--./wrapper-->
        <div class="row">            
            <div class="col-md-12">
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

    });
</script>
<script>
    $(function () {
        $("#compose-textarea").wysihtml5();
    });
</script>

 <script type="text/javascript">
                                        $('#specific_class').click(function(){
                                            var specific_class_selected = $('#specific_class').val();
                                        console.log(specific_class_selected);

                                            $('#specific_class_selector').toggle();
                                        })
                                    </script>
                                     <script type="text/javascript">

    $(document).ready(function (e) {

        getSectionByClass("<?php echo $class_id ?>", "<?php echo $section_id ?>", 'secid');

        getSubjectGroup("<?php echo $class_id ?>", "<?php echo $section_id ?>", "<?php echo $subject_group_id ?>", 'subject_group_id')

        getsubjectBySubjectGroup("<?php echo $class_id ?>", "<?php echo $section_id ?>", "<?php echo $subject_group_id ?>", "<?php echo $subject_id ?>", 'subid');



    });

    var save_method; //for save method string

    var update_id; //for save method string



    function getSectionByClass(class_id, section_id, select_control) {

        if (class_id != "") {

            $('#' + select_control).html("");

            var base_url = '<?php echo base_url() ?>';

            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({

                type: "GET",

                url: base_url + "sections/getByClass",

                data: {'class_id': class_id},

                dataType: "json",

                beforeSend: function () {

                    $('#' + select_control).addClass('dropdownloading');

                },

                success: function (data) {

                    $.each(data, function (i, obj)

                    {

                        var sel = "";

                        if (section_id == obj.section_id) {

                            sel = "selected";

                        }

                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";

                    });

                    $('#' + select_control).append(div_data);

                },

                complete: function () {

                    $('#' + select_control).removeClass('dropdownloading');

                }

            });

        }

    }

     function getSubjectGroup(class_id, section_id, subjectgroup_id, subject_group_target) {

        if (class_id != "" && section_id != "") {



            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';



            $.ajax({

                type: 'POST',

                url: base_url + 'admin/subjectgroup/getGroupByClassandSection',

                data: {'class_id': class_id, 'section_id': section_id},

                dataType: 'JSON',

                beforeSend: function () {

                    // setting a timeout

                    $('#' + subject_group_target).html("").addClass('dropdownloading');

                },

                success: function (data) {



                    $.each(data, function (i, obj)

                    {

                        var sel = "";

                        if (subjectgroup_id == obj.subject_group_id) {

                            sel = "selected";

                        }

                        div_data += "<option value=" + obj.subject_group_id + " " + sel + ">" + obj.name + "</option>";

                    });

                    $('#' + subject_group_target).append(div_data);

                },

                error: function (xhr) { // if error occured

                    alert("Error occured.please try again");



                },

                complete: function () {

                    $('#' + subject_group_target).removeClass('dropdownloading');

                }

            });

        }



    }

    function getsubjectBySubjectGroup(class_id, section_id, subject_group_id, subject_group_subject_id, subject_target) {

        if (class_id != "" && section_id != "" && subject_group_id != "") {



            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';



            $.ajax({

                type: 'POST',

                url: base_url + 'admin/subjectgroup/getGroupsubjects',

                data: {'subject_group_id': subject_group_id},

                dataType: 'JSON',

                beforeSend: function () {

                    // setting a timeout

                    $('#' + subject_target).html("").addClass('dropdownloading');

                },

                success: function (data) {

                    console.log(data);

                    $.each(data, function (i, obj)

                    {

                        var sel = "";

                        if (subject_group_subject_id == obj.id) {

                            sel = "selected";

                        }

                        div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";

                    });

                    $('#' + subject_target).append(div_data);

                },

                error: function (xhr) { // if error occured

                    alert("Error occured.please try again");



                },

                complete: function () {

                    $('#' + subject_target).removeClass('dropdownloading');

                }

            });

        }

    }

</script>
