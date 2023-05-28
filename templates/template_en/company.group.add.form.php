
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.company-child').addClass('active');
    } );
</script>
<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo CompanyGroup_07 */?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  Add Company Group
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo CompanyGroup_07 ?></h3>
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

                        <form name="addCompany" id="addCompany" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Group_Name"><?php echo CompanyGroup_04 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Group_Name" id="Group_Name" autocomplete="off" placeholder="<?php echo CompanyGroup_04 ?>" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <!--<div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="email">Email:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="email" id="email" autocomplete="off" placeholder="Email" required>
                                        </div>
                                    </div>-->
                                </div>
                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                                            <input type="hidden"  name="action" id="action" value="addCompanyGroup">
                                            <i class="fa fa-download"></i>
                                            submit <?php echo CompanyGroup_08 ?> company
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


