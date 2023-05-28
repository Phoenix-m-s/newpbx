
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function()
    {
        $('.admin-package-child').addClass('active');
    } );
</script>

<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo PACKAGE_26; */?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"> <?php echo PACKAGE_26;?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo PACKAGE_26; ?></h3>
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
                        <form name="addGroupPackage" id="addGroupPackage" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="comp_id"><?php echo PACKAGE_27?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="valid select2" name="comp_id" id="comp_id" required>
                                                <?php foreach($list['CompanyList'] as $key=>$value)
                                                {?>
                                                    <option value="<?php echo $value['comp_id'];?>"><?php echo $value['Comp_Name']?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="package_id"><?php echo PACKAGE_28?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="valid select2" name="package_id" id="package_id" required >
                                                <?php foreach($list['PackageList'] as $key=>$value)
                                                {?>
                                                    <option value="<?php echo $value['id'];?>"><?php echo $value['package_name']?></option>
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
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="comment"><?php echo PACKAGE_29?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <textarea class="form-control" type="text" name="comment" id="comment"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-12 pull-left control-label" for="assign_package_now">
                                            <input type="checkbox" class="valid" name="assign_package_now" id="assign_package_now" />
                                            <?php echo PACKAGE_30?>:
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                                            <input type="hidden"  name="action" id="action" value="addPackageToCompany">
                                            <i class="fa fa-download"></i>

                                            submit <?php echo PACKAGE_31?>
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



