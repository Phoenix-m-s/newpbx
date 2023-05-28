
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.admin-package-child').addClass('active');
    } );
</script>

<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo PACKAGE_01 */?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  <?php echo PACKAGE_01 ?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo PACKAGE_01 ?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <?php if($msg!=null)
            { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
                    <?= $msg ?>
                </div>
            <?php
            }
            ?>

            <div class="panel-body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12  center-block">

                        <form name="addPackage" id="addPackage" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Package_Name"><?php echo PACKAGE_02 ?>:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="package_name" id="package_name"  autocomplete="off" placeholder="<?php echo PACKAGE_02 ?>" value="<?php echo $list['package_name']?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="price"><?php echo PACKAGE_03 ?>:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="price" id="price" autocomplete="off" placeholder="<?php echo PACKAGE_03 ?>" value="<?php echo $list['price']?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="extension_count"><?php echo PACKAGE_04 ?>:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="extension_count" id="extension_count" autocomplete="off" placeholder="<?php echo PACKAGE_04?>" value="<?php echo $list['extension_count']?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="duration"><?php echo PACKAGE_05 ?>:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <select class="select2" name="duration" id="duration" required>
                                                <?php for($x = 1; $x <= 12; $x++)
                                                {?>
                                                    <option value="<?php echo $x?> Month"><?php echo $x;?> <?php echo PACKAGE_06 ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="group_id"><?php echo PACKAGE_07 ?>:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <select class="select2" name="group_id" id="group_id" required>
                                                <?php foreach ($list['GroupList'] as $key=>$value)
                                                { if($value['package_group_status'] == 1){?>
                                                    <option value="<?php echo $value['package_group_id']?>"><?php echo $value['package_group_name'];?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">

                                </div>
                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>
                            <input TYPE="hidden" NAME="<?=$list['token'];?>" VALUE="1" >
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                                            <input type="hidden"  name="action" id="action" value="addGroupPackage">
                                            <i class="fa fa-download"></i>
                                           submit <?php echo PACKAGE_08 ?>
                                        </button>
                                    </p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--/content -->


