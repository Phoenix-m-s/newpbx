
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.company-child').addClass('active');
    } );
</script>
<div class="content active">
   <!-- <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i> <?php /*echo COMPANY_14 */?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  edit Company
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> <?php echo COMPANY_16 ?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="????">
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
                        <form name="announce" id="announce" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
                            <input name="id" id=id type="hidden" value="<?=$list['comp_id']?>"/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Comp_Name"><?php echo COMPANY_04 ?></label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Comp_Name" id="Comp_Name" value="<?=$list['Comp_Name']?>" autocomplete="off" placeholder="<?php echo COMPANY_04 ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="ManagerName"><?php echo COMPANY_05 ?></label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Manager_Name" value="<?=$list['Manager_Name']?>" id="Manager_Name" autocomplete="off" placeholder="<?php echo COMPANY_05 ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row xsmallSpace hidden-xs"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="address"><?php echo COMPANY_06 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Address" value="<?=$list['Address']?>" id="Address" autocomplete="off" placeholder="<?php echo COMPANY_06 ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Email"> <?php echo COMPANY_08 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input class="form-control" name="Email" value="<?=$list['Email']?>" id="Email" autocomplete="off" placeholder=" <?php echo COMPANY_08 ?>" type="email" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row xsmallSpace hidden-xs"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="PhoneNumber"> <?php echo COMPANY_07 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Phone_Number" value="<?=$list['Phone_Number']?>" id="Phone_Number" autocomplete="off" placeholder=" <?php echo COMPANY_07 ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <!--<div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="email">Email:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="email" id="email" autocomplete="off" placeholder="email" required>
                                        </div>
                                    </div>-->
                                </div>
                            </div>



                            <?php foreach($list['CompanyGroup'] as $key=>$value) {
                                if($value['Group_Status'] != -1) {
                                    ?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-8 pull-left">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="<?php echo $value['comp_group_id'] ?>"
                                                                   name="GroupID[<?php echo $value['comp_group_id'] ?>][Value]"
                                                                   type="checkbox">
                                                            <?php echo $value['Group_Name'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-8 pull-left">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="Admin"
                                                                   name="GroupID[<?php echo $value['comp_group_id'] ?>][Admin]"
                                                                   type="checkbox">
                                                            <?php echo COMPANY_14 ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }?>






                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success" style="width: 175px;">
                                            <input type="hidden"  name="action" id="action" value="update">
                                            <i class="fa fa-download"></i>
                                            submit <?php echo COMPANY_17 ?> company
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


