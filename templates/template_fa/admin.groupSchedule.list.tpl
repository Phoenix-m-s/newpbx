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
            <li>
                <a class="text-24">
                    <?=SCHEDULE_GROUP_LIST;?>
                </a>
            </li>
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
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=SCHEDULE_GROUP_LIST;?></h3>

                <div class="panel-actions">
                    <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?=ROW;?></th>
                                <th><?=GROUP_NAME;?></th>
                                <th><?=STATUS;?></th>
                                <th><?=TOOLS;?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cn = 1;
                        if(isset($temp['groupSchedule'])) {
                            foreach ($temp['groupSchedule'] as $groupScheduleID=>$row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $cn++; ?></td>
                                    <td class="text-center"><?= $row['scheduleGroupName']; ?></td>
                                    <td class="text-center"><?php if($row['Status'] == 1) { print ENABLE_01; } else { print DISABLED_01; } ?></td>
                                    <td class="text-center">
                                        <a data-id="<?= $groupScheduleID; ?>" data-name="<?= $row['scheduleGroupName']; ?>" data-status="<?= $row['Status']; ?>" href="<?php print RELA_DIR; ?>groupSchedule.php?action=showEditGroup&id=<?= $groupScheduleID; ?>" class="fa fa-pencil editGroup" rel="tooltip" data-original-title="<?php echo EDIT_01; ?>"></a>
                                        <a href="<?php print RELA_DIR; ?>groupSchedule.php?action=showSchedule&id=<?= $groupScheduleID; ?>" class="fa fa-calendar" rel="tooltip" data-original-title="Show Group Scheduling"></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="row xsmallSpace"></div>

                <div class="pull-left">
                    <a href="<?php print RELA_DIR; ?>groupSchedule.php?action=showAddGroup" class="btn btn-primary btn-sm btn-icon text-13 addGroup"><i class="fa fa-plus"></i><?php echo ADD; ?></a>
                </div>
            </div>

        </div>
    </div><!--/content-body -->
</div>

<div class="modal fade" id="modalAddGroup" tabindex="-1" role="dialog" aria-labelledby="modalBasicLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalBasicLabel"><?php echo ADD; ?></h4>
            </div>
            <form action="<?php echo RELA_DIR ?>groupSchedule.php" role="form" data-validate="form" class="form-horizontal form-bordered" novalidate="novalidate" method="post">
                <input type="hidden" name="action" value="addGroup" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-6 control-label pull-left" for="scheduleGroupName"><?=GROUP_NAME;?>: </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="scheduleGroupName" name="scheduleGroupName" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="status" class="col-sm-4 control-label pull-left"><?php echo STATUS; ?></label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1"><?php echo ENABLE_01; ?></option>
                                        <option value="0"><?php echo DISABLED_01; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CANCELED; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo SAVE; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalGroupEdit" tabindex="-1" role="dialog" aria-labelledby="modalBasicLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalBasicLabel">Edit Product Group</h4>
            </div>
            <form action="<?php echo RELA_DIR ?>groupSchedule.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="action" value="editGroup">
                    <input type="hidden" name="GroupIdEdit" id="GroupIdEdit">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="GroupNameEdit" class="col-sm-6 control-label pull-left"><?=GROUP_NAME;?>: </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="GroupNameEdit" name="GroupNameEdit" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="GroupStatusEdit" class="col-sm-4 control-label pull-left"><?php echo STATUS; ?></label>
                                <div class="col-sm-8">
                                    <select name="GroupStatusEdit" id="GroupStatusEdit" class="form-control">
                                        <option value="1"><?php echo ENABLE_01; ?></option>
                                        <option value="0"><?php echo DISABLED_01; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CANCELED; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo SAVE; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
