<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?=ANNOUNCE_01?></a>


            </li>
            <li>
                <a class="text-20" href="<?=RELA_DIR?>announce.php?action=downloadExcel"><i class="fa fa-file-excel-o"></i> downloadReport</a>


            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <?php
        if (is_array($message) and !empty($message)) {
            foreach ($message as $msg) {
                echo  '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">' . $msg . '</div>';
            }
        }
        ?>
        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'announce.php?action=addAnnounce'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ANNOUNCE_17?> Announcement</a>
            </div>

            <?php foreach ($list as $key => $value) { ?>
                <div class="panel panel-default box-items theme-teal">
                    <a class="btn btn-link delete-button text-red"
                       href="<?=RELA_DIR.'announce.php?action=deleteAnnounce&id='. $value['announce_id']?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>
                    <a class="link-block"
                       rel="tooltip" data-original-title="<?=MORE?>" data-placement="bottom"
                       href="<?=RELA_DIR.'announce.php?action=editAnnounce&id='. $value['announce_id']?>">
                        <i class="fa fa-volume-up item-center text-32"></i>
                        <div class="panel-body">
                            <label class="margin-top text-normal text-gray">Announce name :</label>
                            <h3 class="text-normal text-midnight no-margin"><?=$value['announce_name']?></h3>
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