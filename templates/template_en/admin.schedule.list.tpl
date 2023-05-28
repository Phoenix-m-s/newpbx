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
            <li><a class="text-24"><?=SCHEDULE_LIST;?><i class="sidebar-icon fa fa-user"></i></a></li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">
        <div class="row xsmallSpace"></div>
        <div id="panel-1" class="panel panel-default border-blue">
            <div class="panel-heading bg-blue">
                <h3 class="panel-title"><?=SCHEDULE_LIST;?></h3>

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
                <div class="table-responsive table-responsive-datatables">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?=ROW;?></th>
                                <th><?=DAY;?></th>
                                <th><?=START_DATE;?></th>
                                <th><?=END_DATE;?></th>
                                <th>Since the beginning exception</th>
                                <th>Since the end of the exception</th>
                                <th><?=TOOLS;?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cn = 1;
                        if(isset($temp['schedule'])) {
                            foreach ($temp['schedule'] as $scheduleID=>$row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $cn++; ?></td>
                                    <td class="text-center">
                                        <?php

                                        if($row['weekday'] == 7) {
                                            print "Saturday";
                                        } elseif($row['weekday'] == 1) {
                                            print "Sunday";
                                        } elseif($row['weekday'] == 2) {
                                            print "Monday";
                                        } elseif($row['weekday'] == 3) {
                                            print "Tuesday";
                                        } elseif($row['weekday'] == 4) {
                                            print "Wednesday";
                                        } elseif($row['weekday'] == 5) {
                                            print "Thursday";
                                        } else {
                                            print "Friday";
                                        }

                                        ?>
                                    </td>
                                    <td class="text-center"><?= $row['start_time']; ?></td>
                                    <td class="text-center"><?= $row['end_time']; ?></td>
                                    <td class="text-center"><?= $row['start_except_time']; ?></td>
                                    <td class="text-center"><?= $row['end_except_time']; ?></td>
                                    <td class="text-center">
                                        <a data-id="<?= $scheduleID; ?>" href="<?php print RELA_DIR; ?>groupSchedule.php?action=showEditSchedule&id=<?= $scheduleID; ?>&groupId=<?= $temp['scheduleGroupId'] ?>" class="fa fa-pencil" rel="tooltip" data-original-title="<?php echo EDIT_01; ?>"></a>
                                        <a data-id="<?= $scheduleID; ?>" class="fa fa-trash deleteSchedule" rel="tooltip" data-original-title="<?php echo DELETE_01; ?>"></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <div class="pull-left">
                    <a href="<?php print RELA_DIR; ?>groupSchedule.php?action=showAddSchedule&id=<?= $temp['scheduleGroupId'] ?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD_NEW_SCHEDULE;?></a>
                </div>
            </div>
    </div><!--/content-body -->
</div>

<!-- Modal -->
<div class="modal modal-center fade" id="deleteScheduleModal" tabindex="-1" role="dialog" aria-labelledby="customModal3Label" aria-hidden="true">
    <div class="modal-dialog animated bounceIn">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=DELETE_SCHEDULE;?></h4>
            </div>
            <form action="<?php print RELA_DIR; ?>groupSchedule.php" method="post" data-validate="form">
                <input type="hidden" name="action" value="deleteSchedule" />
                <input type="hidden" name="deleteScheduleId" id="deleteScheduleId" />
                <input type="hidden" name="scheduleGroupId" value="<?= $temp['scheduleGroupId'] ?>" />
                <div class="modal-body text-white">
                    <p class="text-18">Are you sure you want to delete this item?</p>

                    <!-- seperator -->
                    <div class="row xsmallSpace"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CANCELED; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo CONFIRMED; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
