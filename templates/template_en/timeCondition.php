<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?=TIMECONDITION_01?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <?php if ($message != null) { ?>
        <?php foreach ($message as $msg) { ?>
            <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                <?= $msg ?>
            </div>
        <?php } ?>
    <?php } ?>
    <div class="content-body">
        <?php /*if($message != null) { */?><!--
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                <?php
/*                if ($message['label']['announce'] != NULL) {
                    echo $message['label']['announce'];
                    foreach ($message['list']['announce'] as $key => $value) {
                        echo '<strong>' . $value['announce_name'] . '</strong>, ';
                    }
                    echo "</br>";
                } elseif ($message['label']['queue'] != NULL) {
                    echo $message['label']['queue'];
                    foreach ($message['list']['queue'] as $key => $value) {
                        echo '<strong>' . $value['queue_name'] . '</strong>, ';
                    }
                    echo "</br>";
                } elseif ($message['label']['inbound'] != NULL) {
                    echo $message['label']['inbound'];
                    foreach ($message['list']['inbound'] as $key => $value) {
                        echo '<strong>' . $value['inbound_name'] . '</strong>, ';
                    }
                    echo "</br>";
                } elseif ($message['label']['ivr'] != NULL) {
                    echo $message['label']['ivr'];
                    foreach ($message['list']['ivr'] as $key => $value) {
                        echo '<strong>' . $value['name'] . '</strong>, ';
                    }
                    echo "</br>";
                }
                */?>
            </div>
            --><?php
/*        }
        */?>
        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'mainTimeCondition.php?action=addTimeCondition'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=TIMECONDITION_02?></a>
            </div>

            <?php foreach ($list as $key => $value) { ?>
                <div class="panel panel-default box-items theme-midnight">
                    <a class="btn btn-link delete-button text-red"
                       href="<?=RELA_DIR.'mainTimeCondition.php?action=deleteTimeCondition&id=' . $value[ 'id' ]?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>
                    <a class="link-block"
                       rel="tooltip" data-original-title="<?=MORE?>" data-placement="bottom"
                       href="<?=RELA_DIR.'mainTimeCondition.php?action=editTimeCondition&id=' . $value['id']?>">
                        <i class="fa fa-clock-o item-center text-32"></i>
                        <div class="panel-body">
                            <label class="margin-top text-normal text-gray">Time condition name :</label>
                            <h3 class="text-normal text-midnight no-margin"><?=$value['name']?></h3>
                        </div>
                    </a>
                </div><!-- /panel-default -->
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.menu-hidden').removeClass('hidden');
    });
</script>