<div class="content active">
    <?php
    $list['id']=$_GET['id'];
    ?>

    <div class="content-body">
        <form name="voipconfig" id="voipconfig" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">VoipConfig</h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="Collapse-Expand">
                            <i class="fa fa-caret-down text-midnight text-18"></i>

                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->
                <?php if ($message != null) { ?>
                    <?php foreach ($message as $msg) { ?>
                        <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                            <?= $msg ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php //if ($msg != null) { ?>
                <!--<div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                        <?/*= $msg */?>
                    </div>-->
                <?php //} ?>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-12 no-bg center-block">
                            <div class="row">

                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_name">macAddress:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" class="form-control" name="macAddress" id="macAddress" autocomplete="off" placeholder="macAddress" value=""required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_name">line1_name:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" class="form-control" name="line1_name" id="line1_name" autocomplete="off" placeholder="line1_name" value="<?php echo $list['extensionList']['extension_name'] ?>" readonly="readonly" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row hidden-xs"></div>


                        </div>


                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_name">line1_authname:</label>
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control" name="line1_authname" id="line1_authname" autocomplete="off" placeholder="line1_authname" value="<?php echo $list['extensionList']['extension_name']; ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_password">line1_password:</label>
                                <div class="col-xs-12 col-md-6 pull-left">

                                    <input type="text" class="form-control" name="line1_password" id="line1_password" autocomplete="off" placeholder="line1_password" value="<?=$list['extensionList']['password']; ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_shortname">line1_shortname:</label>
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control" name="line1_shortname" id="line1_shortname" autocomplete="off" placeholder="line1_name" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="name">proxy1_port:</label>
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="number" class="form-control" name="proxy1_port" id="proxy1_port" autocomplete="off" placeholder="proxy1_port" value="" required>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>


                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="proxy1_address">proxy1_address:</label>
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control" name="proxy1_address" id="proxy1_address" autocomplete="off" placeholder="proxy1_address" value="" required>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>
                    </div>

                </div>
                <input type="hidden" name="<?=$list['token'];?>" value="1">
                <input type="hidden" name="id" value="<?php echo $list['id'];?>">
                <input type="hidden" name="comp_id" value="<?php echo $list['extensionList']['comp_id'];?>">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <button name="add" id="add" type="submit" class="btn btn-success btn-icon">
                            <input type="hidden"  name="action" id="action" value="addVoipConfig">

                            <i class="fa fa-download"></i>Submit
                        </button>
                    </p>
                </div>

        </form>
    </div>
</div>
</div><!--/content -->



<style>
    .button {
        background: #555;
        border: 1px dotted black;
        border-radius: 50px;
        margin:auto 20px 20px auto;
        font-size: 15px;
        color: #000;
    }

    .button:hover, .button:focus  {
        box-shadow: 0 5px 10px #000;
        color: #fff;
    }

    .disabled {
        box-shadow:none;
        opacity:0.7;
    }

    canvas {
        display: block;
    }
</style>