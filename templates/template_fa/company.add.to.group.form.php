
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.company-child').addClass('active');
    } );
</script>
<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo CompanyGroup_17 */?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  <?php echo CompanyGroup_17 ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?php echo CompanyGroup_17 ?></h3>
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
                            <input name="GroupID[<?=$list['id']?>][Value]" id=GroupID type="hidden" value="<?=$list['id']?>"/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="CompName"><?php echo CompanyGroup_14 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="select2 valid" name="CompID" id="CompID" required>
                                                <?php foreach($list['CompanyList'] as $key=>$value) {
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
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="email"><?php echo CompanyGroup_15 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="GroupID[<?=$list['id']?>][Admin]" id="Admin" type="checkbox"> <?php echo CompanyGroup_15 ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                                            <input type="hidden"  name="action" id="action" value="addCompany">
                                            <i class="fa fa-download"></i>
                                            submit <?php echo CompanyGroup_08 ?>
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


