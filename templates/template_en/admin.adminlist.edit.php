<div class="content active">
    <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php echo CHANGE_PERMISSION; ?></h2>
    </div><!--/content-header -->

    <div class="content-body">
        <!-- APP CONTENT
        ================================================== -->
        <!-- DASHBOARD
    ================================================== -->
        <!-- Dashboard  -->
        <?php

    $message = $messageStack->getMessages('admin.list');
        //print_r($messageStack->getMessages('admin.list'));die();
        if(isset($message['message']) && $message['message'] != '')
        {

        ?>
        <div class="alert <?php echo ($message['type']=='error'? 'alert-danger':'alert-success') ;?> fade in">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <p><?php echo $message['message']; ?></p>
        </div>
        <?php
    }?>

        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?php echo PERMISSION; ?></h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel"
                            data-original-title="<?php echo RESIZE; ?>">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel"
                            data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->

            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-md-8 center-block">
                        <form name="add_customer_form" id="add_customer_form" role="form" enctype="multipart/form-data"
                              data-validate="form" class="form-horizontal form-bordered" autocomplete="off"
                              novalidate="novalidate" method="post">
                            <input type="hidden" name="action" value="editadmin"/>
                            <input type="hidden" name="admin_id" value="<?php echo $temp['admin_id']?>"/>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label"
                                               for="username"><?php echo USERNAME; ?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="username" id="username"
                                                   value="<?=(isset($_POST['username'])? $_POST['username']:$temp['username'])?>"
                                                   autocomplete="off" placeholder="username" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label" for="name"><?php echo NAME; ?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="name" id="name"
                                                   value="<?=(isset($_POST['name'])? $_POST['name']:$temp['name'])?>"
                                                   minLength="2" placeholder="firstname" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row xsmallSpace"></div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label" for="family"><?php echo FAMILY; ?>: ‌</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control valid" name="family" id="family"
                                                   value="<?=(isset($_POST['family'])? $_POST['family']:$temp['family'])?>"
                                                   placeholder="lastname" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row xsmallSpace"></div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label"
                                               for="password_new"><?=EXTENSION_06;?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="password" class="form-control" name="password_new"
                                                   id="password_new" placeholder="<?php echo EXAMPLE; ?> 123456">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-sm-4 pull-left control-label" for="confirm_password"><?=RE_PASSWORD;?>: </label>
                                            <div class="col-sm-8 pull-left">
                                                <input type="password" class="form-control" name="confirm_password"
                                                       id="confirm_password" placeholder="<?php echo EXAMPLE; ?> 123456">
                                            </div>
                                        </div>
                                    </div><!--/form-group-->
                                </div>
                            </div>
                            <div class="row xsmallSpace"></div>
                            <div class="row xsmallSpace"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="update" id="submit"
                                                class="btn btn-icon btn-success">
                                            <i class="fa fa-check-circle"></i>
                                            <?php echo EDIT_01; ?>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


    </div><!--/content -->


