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
            <li><a class="text-24"><?=MODIFIED_SCHEDULE;?><i class="sidebar-icon fa fa-calculator"></i></a></li>
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
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo RELA_DIR ?>groupSchedule.php" method="post">
                    <input type="hidden" name="action" value="editSchedule">
                    <input type="hidden" name="id" value="<?= $temp['id']; ?>">
                    <input type="hidden" name="groupId" value="<?= $temp['groupId']; ?>">

                    <div class="col-xs-12 col-sm-11 col-md-11 center-block">

                        <!-- seperator -->
                        <div class="row xsmallSpace"></div>
                        <div class="appendSchedule">
                            <div class="row">
                                <div class="col-md-2 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="weekday" class="col-sm-4 control-label pull-left text-16 text-normal">Day:</label>
                                                <div class="col-sm-8 pull-left">
                                                    <select name="weekday" id="weekday" class="form-control">
                                                        <option <?php if ($temp['schedule']['weekday'] == 7) print "selected"; ?> value="7">Saturday</option>
                                                        <option <?php if ($temp['schedule']['weekday'] == 1) print "selected"; ?> value="1">Sunday</option>
                                                        <option <?php if ($temp['schedule']['weekday'] == 2) print "selected"; ?> value="2">Monday</option>
                                                        <option <?php if ($temp['schedule']['weekday'] == 3) print "selected"; ?> value="3">Tuesday</option>
                                                        <option <?php if ($temp['schedule']['weekday'] == 4) print "selected"; ?> value="4">Wednesday</option>
                                                        <option <?php if ($temp['schedule']['weekday'] == 5) print "selected"; ?> value="5">Thursday</option>
                                                        <option <?php if ($temp['schedule']['weekday'] == 6) print "selected"; ?> value="6">Friday</option>
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
                                                <label for="startTime" class="col-sm-5 control-label pull-left text-14 text-normal">Start Time:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="startTime" id="startTime" class="form-control" value="<?= $temp['schedule']['start_time'] ?>">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stopTime" class="col-sm-5 control-label pull-left text-14 text-normal">End Time:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="stopTime" id="stopTime" class="form-control" value="<?= $temp['schedule']['end_time'] ?>">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="startExTime" class="col-sm-5 control-label pull-left text-14 text-normal">زمان شروع استثناء :</label>
                                                <div class="col-sm-5 pull-left">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="startExTime" id="startExTime" class="form-control" value="<?= $temp['schedule']['start_except_time'] ?>">
                                                </div><!--/cols-->
                                            </div><!--/form-group-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 pull-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stopExTime" class="col-sm-5 control-label pull-left text-14 text-normal">Since the end of the exception:</label>
                                                <div class="col-sm-5 pull-left">
                                                    <input type="text" data-input="timepicker" data-template="dropdown" data-show-meridian="false" name="stopExTime" id="stopExTime" class="form-control" value="<?= $temp['schedule']['end_except_time'] ?>">
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
                    <button type="submit" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-pencil"></i><?=EDIT_01;?></button>
                </div>
            </div>
            </form>
        </div>
    </div><!--/content-body -->
</div>
