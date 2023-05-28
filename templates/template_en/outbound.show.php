<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?=OUTBOUND_01?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <?php if ($msg != null) { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                <?=$msg?>
            </div>
            <?php } ?>
        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'outbound.php?action=addOutbound'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD?> Outbound</a>
            </div>
            <?php foreach ($list['list'] as $key => $value) { ?>
                <div class="panel panel-default box-items theme-green">
                    <a class="btn btn-link delete-button text-red"
                       href="<?=RELA_DIR.'outbound.php?action=deleteOutbound&id=' . $value['outbound_id']?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>
                    <a class="link-block"
                       rel="tooltip" data-original-title="<?=MORE?>" data-placement="bottom"
                       href="<?=RELA_DIR.'outbound.php?action=editOutbound&id=' . $value['outbound_id']?>">
                        <i class="fa fa-sign-in item-center text-32"></i>
                        <div class="panel-body">
                            <label class="margin-top text-normal text-gray">Outbound name :</label>
                            <h3 class="text-normal text-midnight no-margin"><?=$value['outbound_name']?></h3>
                        </div>
                    </a>
                </div><!-- /panel-default -->
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.outbound-menu a').addClass('outbound-active');
    });
</script>