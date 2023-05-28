<div class="content active">
   <!-- <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i>Login As</h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"> Login As
                </a>
            </li>
        </ul>
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading bg-white">
                <h3 class="panel-title">Login as</h3>
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
                    <div class="col-xs-12 col-sm-12 col-md-12 center-block">

                        <form name="LoginAs" id="LoginAs" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="CompName"><?=COMPANY_NAME; ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="valid select2" name="CompID" id="CompID" required>
                                                <?php foreach($list as $key=>$value) {
                                                    ?>
                                                    <option value="<?php echo $value['comp_id'];?>">
                                                        <?=$value['Comp_Name']?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                                            <input type="hidden"  name="action" id="action" value="LoginAs">
                                            <i class="fa fa-lock"></i>
                                           <?php echo LOGINAS; ?>
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


