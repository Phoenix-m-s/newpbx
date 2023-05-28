<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.campaign-child').addClass('active');
    } );

</script>
<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li><a class="text-24"> <?=ADD_NEW_SCHEDULE;?><i class="sidebar-icon fa fa-calculator"></i></a></li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">

        <?php
        $message = $messageStack->output('groupSchedule');
        if(isset($message) && $message['message'] != '')
        {
            echo $message;
        }
        ?>

        <div class="row xsmallSpace"></div>
        <div id="panel-1" class="panel panel-default border-blue">
            <div class="panel-heading bg-blue">
                <h3 class="panel-title"><?=SCHEDULE;?></h3>

                <div class="panel-actions">
                    <button data-expand="#panel-1" title="Resize" class="btn-panel">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <button data-role="add" title="Add" class="btn-panel">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button data-role="remove" title="Reduce" class="btn-panel">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
                <div class="panel-body">
                    <form action="<?php echo RELA_DIR ?>groupSchedule.php" method="post">
                        <input type="hidden" name="action" value="addSchedule">
                        <input type="hidden" name="groupId" value="<?= $temp; ?>">
                    <div class="col-xs-12 col-sm-11 col-md-11 center-block">

                        <!-- seperator -->
                        <div class="row xsmallSpace"></div>
                        <div class="appendSchedule">
                            <div class="row">
                                <div class="col-md-2 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="weekday1" class="col-sm-4 control-label pull-left text-16 text-normal">روز : </label>
                                                <div class="col-sm-8 pull-left">
                                                    <select name="weekday[]" id="weekday1" class="form-control">
                                                        <option value="7">Saturday</option>
                                                        <option value="1">Sunday</option>
                                                        <option value="2">Monday</option>
                                                        <option value="3">Tuesday</option>
                                                        <option value="4">Wednesday</option>
                                                        <option value="5">Thursday</option>
                                                        <option value="6">Friday</option>
                                                    </select>
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="startTime1" class="col-sm-5 control-label pull-left text-14 text-normal"><?=START_DATE;?>:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="startTime[]" id="startTime1" class="form-control">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stopTime1" class="col-sm-5 control-label pull-left text-14 text-normal"><?=END_DATE;?>:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="stopTime[]" id="stopTime1" class="form-control">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="startExTime1" class="col-sm-5 control-label pull-left text-14 text-normal">Since the beginning of exceptions:</label>
                                                <div class="col-sm-5 pull-left">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="startExTime[]" id="startExTime1" class="form-control">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stopExTime1" class="col-sm-5 control-label pull-left text-14 text-normal">Since the end of the exception:</label>
                                                <div class="col-sm-5 pull-left">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="stopExTime[]" id="stopExTime1" class="form-control">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer clearfix">
                    <div class="pull-left">
                        <button type="submit" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD;?></button>
                    </div>
                </div>
            </form>
        </div>
    </div><!--/content-body -->
</div>
