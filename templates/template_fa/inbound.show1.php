
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
    } );
</script>

<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?php echo INBOUND_01?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="margin-top margin-left text-left">
        <a href="<?php echo RELA_DIR.'inbound.php?action=addInbound'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD;?></a>
    </div>
    <div class="content-body">
        <?php if($msg!=null)
        {
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                <?php
                echo $msg;
                ?>
            </div>
            <?php
        }
        ?>
        <div class="container">
            <?php foreach ($list['list'] as $key=>$value)
            {
                ?>
                <div class="col-md-3 col-sm-6 margin-bottom">
                    <div id="panel-context" class="panel panel-primary sortable-widget-item">
                        <div class="panel-body widget-inbound" style="display: block;">
                            <div class="widget-circle-inbound item-center">
                                <i class="fa fa-arrow-circle-o-left item-center text-32"></i>
                            </div>
                            <h1 class="item-center"></h1>
                            <h3 class="item-center"><?php echo $value['inbound_name']?></h3
                            <p></p>
                        </div>

                        <div class="panel-footer widget-footer-inbound">
                            <a class="pull-left" href="<?php echo RELA_DIR.'inbound.php?action=trashInbound&id='. $value['inbound_id']?>"  rel="tooltip" data-original-title="<?php echo DELETE_01; ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href=" <?php echo RELA_DIR.'inbound.php?action=editInbound&id='. $value['inbound_id']?>"  rel="tooltip" data-original-title="<?php echo EDIT_01; ?>">
                                <?php echo MORE; ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
