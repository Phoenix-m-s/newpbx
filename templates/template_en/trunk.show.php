<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left full-width full-height">
            <li class="display-flex flex-direction-row align-items-center full-width">
                <button class="no-bg no-border flex-center" onclick="window.history.back()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="3" stroke="#fb8c00" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <line x1="5" y1="12" x2="9" y2="16" />
                        <line x1="5" y1="12" x2="9" y2="8" />
                    </svg>
                </button>
                <a class="text-20"><?=Trunk_01?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <?php if ($message != null) { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                <?php
                if ($message['label']['announce'] != NULL)
                {
                    echo $message['label']['announce'];
                    foreach($message['list']['announce'] as $key => $value) {
                        echo '<strong>'.$value['announce_name'].'</strong>, ';
                    }
                    echo "</br>";
                }

                if ($message['label']['queue'] != NULL) {
                    echo $message['label']['queue'];
                    foreach ($message['list']['queue'] as $key => $value) {
                        echo '<strong>' . $value['queue_name'] . '</strong>, ';
                    }
                    echo "</br>";
                }

                if ($message['label']['ivr'] != NULL) {
                    echo $message['label']['ivr'];
                    foreach ($message['list']['ivr'] as $key => $value) {
                        echo '<strong>' . $value['name'] . '</strong>, ';
                    }
                    echo "</br>";
                }

                if ($message['label']['outbound'] != NULL) {
                    echo $message['label']['outbound'];
                    foreach ($message['list']['outbound'] as $key => $value) {
                        echo '<strong>' . $value['outbound_name'] . '</strong>, ';
                    }
                    echo "</br>";
                }

                if ($message['label']['inbound'] != NULL) {
                    echo $message['label']['inbound'];
                    foreach ($message['list']['inbound'] as $key => $value) {
                        echo '<strong>' . $value['inbound_name'] . '</strong>, ';
                    }
                    echo "</br>";
                }
                ?>
            </div>
            <?php } ?>


        <?php
        if (is_array(isset($msg)) and !empty($msg)) {
            foreach ($msg as $array_msg) {
                echo  '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">' . $array_msg . '</div>';
            }
        }
        ?>
        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'trunk.php?action=addTrunk'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD?> Trunk</a>
            </div>

            <?php foreach ($list as $key => $value) {
                if($value['id'] != '') { ?>
                    <div class="panel panel-default box-items theme-orange">
                        <a class="btn btn-link delete-button text-red"
                       href="<?=RELA_DIR.'trunk.php?action=deleteTrunk&id='. $value['id']?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>
                    <a class="btn btn-link delete-button text-red"
                       href="<?=RELA_DIR.'trunk.php?action=deleteTrunk&id='. $value['sip_id']?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>
                    <a class="link-block"
                       rel="tooltip" data-original-title="<?=MORE?>" data-placement="bottom"
                       href="<?=RELA_DIR.'trunk.php?action=editTrunk&id='. $value['id']?>">
                        <i class="fa fa-gear item-center text-32"></i>
                        <div class="panel-body">
                            <label class="margin-top text-normal text-gray">Trunk name :</label>
                            <h3 class="text-normal text-midnight no-margin"><?=$value['name']?></h3>
                        </div>
                    </a>
                </div><!-- /panel-default -->
            <?php }} ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.menu-hidden').removeClass('hidden');
    });
</script>
