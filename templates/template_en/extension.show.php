<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?= EXTENSION_01 ?></a>
            </li>
            <li>
                <a class="text-20" href="<?=RELA_DIR?>extension.php?action=downloadExcel"><i class="fa fa-file-excel-o"></i> downloadReport</a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <?php if ( $message != null ) { ?>
            <?php foreach ($message as $msg){?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom"> <?= $msg; ?> </div>
                <?php }?>
        <?php } ?>

        <div class="container">
            <?php if ($member_info == -1) { ?>

            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?= RELA_DIR.'extension.php?action=addExtension'?>" class="btn btn-primary btn-sm btn-icon text-13 pull-left"><i class="fa fa-plus"></i><?= EXTENSION_27?></a>

                <div class="form-group margin-left pull-left">
                    <input type="text" class="form-control search-task-items active" placeholder="Search for an extension">
                </div><!-- /input-group -->
            </div>
            <?php } ?>

            <div class="row no-margin">
                <div class="col-xs-12 col-sm-4 col-md-4 no-padding">

                </div>
            </div>

            <br>

            <?php foreach ( $list as $key => $value ) { ?>

                <div class="panel panel-default box-items theme-pink">
                    <?php if ($member_info == -1) { ?>

                    <a class="btn btn-link delete-button text-red"
                       href="<?= RELA_DIR.'extension.php?action=deleteExtension&id='. $value[ 'extension_id' ]?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>

                    <?php } ?>

                    <a class="btn btn-link <?=($member_info == -1 ? 'second-button' : 'delete-button second-button');?> text-midnight"
                       href="<?=RELA_DIR.'extension.php?action=showTimeCondition&id=' . $value[ 'extension_id' ]?>"
                       rel="tooltip" data-original-title="<?=TIMECONDITION_01?>" data-placement="bottom">
                        <i class="fa fa-clock-o text-24"></i>
                    </a>

                    <a class="link-block"
                       rel="tooltip" data-original-title="<?=MORE?>" data-placement="bottom"
                       href="<?=RELA_DIR.'extension.php?action=editExtension&id='. $value['extension_id']?>">
                        <i class="fa fa-phone item-center text-32"></i>
                        <div class="panel-body">
                            <label class="margin-top text-normal text-gray">Extension name :</label>
                            <h3 class="text-normal text-midnight no-margin"><?=$value['extension_name']?></h3>

                            <label class="margin-top text-normal text-gray">Extension number :</label>
                            <h4 class="text-normal text-midnight no-margin"><?=$value['extension_no']?>
                                <?php
                                if ($value['extension_type']==2) {
                                    echo '<span class="text-normal "> webrtc</span>';
                                }
                                ?>
                            </h4>
                        </div>
                    </a>

                </div><!-- /panel-default -->
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
    });
</script>