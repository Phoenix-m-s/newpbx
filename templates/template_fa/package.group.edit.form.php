<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .package-child').addClass('active');
    } );

</script>
<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo PACKAGE_38*/?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
    <ul class="control-nav pull-left">
        <li>
            <a class="text-20"> <?php echo PACKAGE_38?>
            </a>
        </li>
    </ul>
    </div>

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo PACKAGE_38?></h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo RESIZE; ?>">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down"></i>
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

                        <form name="editGroupPackage" id="editGroupPackage" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
                            <input name="package_group_id" id=package_group_id type="hidden" value="<?=$list['package_group_id']?>"/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Group_Name"><?php echo PACKAGE_39?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="package_group_name" id="package_group_name" autocomplete="off" placeholder="<?php echo PACKAGE_39?>" value="<?=$list['package_group_name']?>" required>
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
                                        <button type="submit" name="update" id="update" class="btn btn-icon btn-success">

                                            <input type="hidden" name="action" id="action" value="update">
                                            <i class="fa fa-plus"></i><?php echo PACKAGE_40?>
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


