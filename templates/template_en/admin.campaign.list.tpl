<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function () {
        $('.campaign-child').addClass('active');
    });

</script>

<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li><a class="text-24"><?=CAMPAGINS;?></a></li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">

        <?php
        $message = $messageStack->output('campaign');
        if(isset($message) && $message['message'] != '')
        {
        echo $message;
        }
        ?>

        <div class="row xsmallSpace"></div>
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=CAMPAGINS;?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">

                <div class="pull-left">
                    <a href="<?php print RELA_DIR; ?>campaign.php?action=showAddCamp" class="btn btn-primary btn-sm btn-icon text-13">
                        <i class="fa fa-plus"></i><?php echo ADD; ?>
                        Execute Executable Campaign
                    </a>
                </div>
                <div class="row xsmallSpace "></div>
                <div class="table-responsive table-responsive-datatables">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><?php echo ROW; ?></th>
                            <th><?=CAMPAGIN;?> <?=NAME;?></th>
                            <th><?=SCHEDULE_GROUP;?></th>
                            <th><?=STATUS;?></th>
                            <th><?=COMPAGIN_05; ?></th>
                            <th><?=COMPAGIN_01; ?></th>
                            <th><?=START_DATE;?></th>
                            <th><?=END_DATE;?></th>
                            <th><?=STATUS;?></th>
                            <th><?=COMPAGIN_06; ?></th>
                            <th><?=CHANNEL_NUMBER; ?></th>
                            <th><?=TOOLS;?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cn = 1;
                        if(isset($temp['campaigns'])) {
                            foreach ($temp['campaigns'] as $campaignsID=>$row) {
                        ?>
                        <tr>
                            <td class="text-center"><?= $cn++; ?></td>
                            <td class="text-center"><?= $row['name']; ?></td>
                            <td class="text-center"><?= $temp['group'][$row['scheduleGroupId']]['name']; ?></td>
                            <td class="text-center"><?= $row['status']; ?></td>
                            <td class="text-center"><?= $row['prefixNumber']; ?></td>
                            <td class="text-center"><?= $row['campExtensions']; ?></td>
                            <td class="text-center ltr"><?= $row['startDate']; ?></td>
                            <td class="text-center ltr"><?= $row['endDate']; ?></td>
                            <td class="text-center"><?php if ($row['isEnable'] == 'y') print ENABLE_01; elseif ($row['isEnable'] == 'n') print DISABLED_01; ?></td>
                            <td class="text-center"><?= $row['creationType']; ?></td>
                            <td class="text-center"><?= $row['chanelNumber']; ?></td>
                            <td class="text-center">
                                <a href="<?php print RELA_DIR; ?>campaign.php?action=setEnable&id=<?= $campaignsID; ?>" class="fa fa-toggle-on <?php if ($row['isEnable'] == 'y') print 'text-success'; elseif ($row['isEnable'] == 'n') print 'text-danger fa-rotate-180'; ?> fa-2x"
                                   rel="tooltip" data-original-title="<?php echo INBOUND_21; ?>" style="margin: 0 3px"></a>
                                <a href="<?php print RELA_DIR; ?>campaign.php?action=editCampaign&id=<?= $campaignsID; ?>"
                                   class="fa fa-edit text-orange fa-2x" rel="tooltip"
                                   data-original-title="<?php echo EDIT_01; ?>" style="font-size: 20px; margin: 0 3px"></a>
                                <a href="<?php print RELA_DIR; ?>campaign.php?action=deleteCampaign&id=<?= $campaignsID; ?>"
                                   class="fa fa-trash text-red fa-2x" rel="tooltip"
                                   data-original-title="<?php echo DELETE_01; ?>" style="font-size: 20px;margin: 0 3px"></a>
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

        </div>
        <div class="row">
            <div class="col-md-6 pull-left ">
                <a href="<?php print RELA_DIR; ?>campaign.php?action=runCampaign"
                   class="btn btn-icon btn-success pull-left">
                    <i class="fa fa-download"></i>
                    submit Execute Executable Campaign
                </a>
            </div>
        </div>
    </div><!--/content-body -->
</div>
