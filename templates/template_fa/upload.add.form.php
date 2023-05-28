<?php //print_r_debug($message); ?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
    } );
</script>
<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?/*=UPLOAD_08*/?> </h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>extension.php?action=showUploads">
                    <?=UPLOAD_08?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body" >
        <form name="addFile" id="addFile" role="form" data-validate="form" enctype="multipart/form-data" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=UPLOAD_08?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE;?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->

            <?php if($message != null)  foreach ($message as $msg) {
                echo  '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert" style="background:rgba(255,149,144,0.99);">' . $msg . '</div>';
            }?>

            <div class="panel-body">

                <div class="row">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Title"><?=UPLOAD_09?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" <?php if (!empty($list['Title'])) {?> value="<?=$list['Title']?>" <?php }?> name="Title" id="Title" autocomplete="off" placeholder="<?=UPLOAD_09?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="PlayBackFile"><?=UPLOAD_10?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="file" class="form-control" name="PlayBackFile" id="PlayBackFile" autocomplete="off" placeholder="<?=UPLOAD_10?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input TYPE="hidden" NAME="<?=$list['token'];?>" VALUE="1" >

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="pull-left">
                    <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                        <input type="hidden"  name="submit" id="submit" value="addFile">
                        <i class="fa fa-download"></i>
                        submit
                    </button>
                </p>
            </div>
        </div>
        </form>
    </div>
</div><!--/content -->



