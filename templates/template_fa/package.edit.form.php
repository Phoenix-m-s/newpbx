<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .package-child').addClass('active');
    } );

</script>
<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo PACKAGE_41*/?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  <?php echo PACKAGE_41?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel  panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo PACKAGE_41?></h3>
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

                        <form name="editPackage" id="editPackage" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
                            <input name="package_id" id=package_id type="hidden" value="<?=$list['PackageInfo']['id']?>"/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Package_Name"><?php echo PACKAGE_11?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="package_name" id="package_name" autocomplete="off" placeholder="<?php echo PACKAGE_11?>" value="<?php echo $list['PackageInfo']['package_name']?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="price"><?php echo PACKAGE_12?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="price" id="price" autocomplete="off" placeholder="<?php echo PACKAGE_12?>" value="<?php echo $list['PackageInfo']['price']?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="extension_count"><?php echo PACKAGE_13?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="extension_count" id="extension_count" autocomplete="off" placeholder="<?php echo PACKAGE_13?>" value="<?php echo $list['PackageInfo']['extension_count']?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="duration"><?php echo PACKAGE_14?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="select2" name="duration" id="duration" required>
                                                <?php for($x = 1; $x <= 12; $x++){?>
                                                    <option <?php echo $list['PackageInfo']['duration'] == $x ? 'selected' : ''?>value="<?php echo $x?> Month"><?php echo $x;?><?php echo PACKAGE_06?></option>
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
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="group_id"><?php echo PACKAGE_15?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="select2" name="group_id" id="group_id" required>
                                                <?php foreach ($list['GroupList'] as $key=>$value  ){?>
                                                    <option  <?php if($value['package_group_id'] == $list['PackageInfo']['package_group_id']) echo 'selected';?> value="<?php echo $value['package_group_id']?>"><?php echo $value['package_group_name'];?></option>
                                                <?php
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
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                                            <input type="hidden"  name="action" id="action" value="update">
                                            <i class="fa fa-download"></i>
                                            submit <?php echo PACKAGE_40?>
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


