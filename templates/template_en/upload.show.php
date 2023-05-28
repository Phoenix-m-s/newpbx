<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?=UPLOAD_01?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <?php /*
        if($message!=null) {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
            <?php
            if ($message['label']['announce'] != NULL) {
                echo $message['label']['announce'];
                foreach ($message['list']['announce'] as $key => $value) {
                    echo '<strong>' . $value['announce_name'] . '</strong>, ';
                }
                echo "</br>";
            }

            if ($message['label']['ivr'] != NULL) {
                echo $message['label']['ivr'];
                foreach ($message['list']['ivr'] as $key => $value) {
                    echo '<strong>' . $value['ivr_name'] . '</strong>, ';
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

            if ($message['label']['inbound'] != NULL) {
                echo $message['label']['inbound'];
                foreach ($message['list']['inbound'] as $key => $value) {
                    echo '<strong>' . $value['inbound_name'] . '</strong>, ';
                }
                echo "</br>";
            }
            ?>
        </div>
        <?php } */?>
        <?php
        if (is_array($message['msg']) and !empty($message['msg'])) {
            foreach ($message['msg'] as $msg) {
                echo  '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">' . $msg . '</div>';
            }
        }
        ?>

        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'upload.php?action=addFile'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD?> Audio Files</a>
            </div>

            <?php foreach ($list as $value) { ?>

                <div class="panel panel-default box-items theme-light-green">
                    <a class="btn btn-link delete-button text-red"
                       href="<?=RELA_DIR.'upload.php?action=deleteFiles&id='. $value['upload_id']?>"
                       rel="tooltip" data-original-title="<?=DELETE_01?>" data-placement="bottom"
                       onclick="return confirm('Are you sure want to delete item?');">
                        <i class="fa fa-trash text-24"></i>
                    </a>
                    <a class="link-block">
                        <i class="fa fa-play-circle-o item-center text-32"></i>
                        <div class="panel-body">
                            <label class="margin-top text-normal text-gray">Upload file name :</label>
                            <h3 class="text-normal text-midnight no-margin">
                                <?php if (!empty($value['title'])) { ?>
                                    <?=$value['title']?>
                                <?php } else { ?>
                                    <?=$value['file_name']?>
                                <?php } ?>
                            </h3>

                            <div>
                                <?php
                                global $admin_info;
                                $directoryName=UPLOAD_IVR_DIR.$admin_info['comp_id'].DS;
                                $path = $directoryName.$value['file_name'];
                                ?>

                                <audio controls class="margin-top-half margin-bottom-half">
                                    <source src="<?=$path?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
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
    } );
</script>