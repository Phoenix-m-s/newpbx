
    <div class="content active">
        <!-- content-control -->
        <div class="content-control">
            <!--control-nav-->
            <ul class="control-nav pull-left">
                <li>
                    <a class="text-20"><?=(!empty($list['admin_id']) ? 'Edit admin' : 'Add admin');?></a>
                </li>
            </ul><!--/control-nav-->
        </div><!-- /content-control -->
        <?php if ($message != null) { ?>
            <?php foreach ($message as $msg) { ?>
                <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                    <?= $msg ?>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="content-body">
            <form name="add_customer_form" id="add_customer_form" role="form" data-validate="form" enctype="multipart/form-data" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
                <div id="panel-sortable" class="panel panel-default" data-boxid="1">
                    <div class="panel-heading">
                        <div class="panel-actions">
                            <button data-collapse="#panel-sortable" title="collapse" class="btn-panel">
                                <i class="fa fa-caret-down text-midnight text-18"></i>
                            </button>
                        </div><!-- /panel-actions -->
                        <h3 class="panel-title sortable-widget-handle">Admin Info</h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 pull-left control-label"
                                           for="username"><?php echo USERNAME; ?>: </label>
                                    <div class="col-sm-8 pull-left">
                                        <input type="text" class="form-control" name="username" id="username"
                                               autocomplete="off"
                                               placeholder="<?php echo EXAMPLE; ?> admin" value="<?=(!empty($list['username']) ? $list['username'] : '');?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 pull-left control-label" for="name"><?php echo NAME; ?>
                                        : </label>
                                    <div class="col-sm-8 pull-left">
                                        <input type="text" class="form-control" name="name" id="name" minLength="2"
                                               placeholder="<?php echo EXAMPLE; ?> " autocomplete="off" value="<?=(!empty($list['name']) ? $list['name'] : '');?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row xsmallSpace"></div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 pull-left control-label"
                                           for="family"><?php echo FAMILY; ?>: ‌</label>
                                    <div class="col-sm-8 pull-left">
                                        <input type="text" class="form-control valid" name="family" id="family"
                                               placeholder="<?php echo EXAMPLE; ?> " autocomplete="off" value="<?=(!empty($list['family']) ? $list['family'] : '');?>" required>
                                    </div>
                                </div>
                            </div>
                            <!--
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label" for="cell_phone"><?php echo PHONE_NUMBER; ?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="cell_phone" id="cell_phone" placeholder="<?php echo EXAMPLE; ?> 09123456789" required>
                                        </div>
                                    </div>
                                </div>
                            -->
                        </div>
                        <div class="row xsmallSpace"></div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 pull-left control-label"
                                           for="password_new"><?=EXTENSION_06;?>: </label>
                                    <div class="col-sm-8 pull-left">
                                        <input type="password" class="form-control" name="password_new"
                                               id="password_new" placeholder="<?php echo EXAMPLE; ?> 123456"
                                            <?=(!empty($list['admin_id']) ? '' : 'required');?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label"
                                               for="confirm_password"><?=RE_PASSWORD;?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="password" class="form-control" name="confirm_password"
                                                   id="confirm_password" placeholder="<?php echo EXAMPLE; ?> 123456"
                                                <?=(!empty($list['admin_id']) ? '' : 'required');?>>
                                        </div>
                                    </div>
                                </div><!--/form-group-->
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4     pull-left control-label" for="type">Type:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <select class="valid select2" name="type" id="type" required>
                                                <option value="1" <?= (!empty($list['type'] == 1)) ? 'selected' : '' ?>>Admin</option>
                                                <option value="2" <?= (!empty($list['type'] == 2)) ? 'selected' : '' ?>>Member</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row xsmallSpace"></div>
                        <div class="row xsmallSpace"></div>
                    </div>
                </div>

                <input type="hidden" name="admin_id" value="<?=(!empty($list['admin_id']) ? $list['admin_id'] : '');?>"/>
                <input type="hidden" name="action" value="<?=(!empty($list['admin_id']) ? 'editAdmin' : 'addAdmin');?>"/>

                <button type="submit" name="" id="submit"
                        class="btn btn-icon btn-success">
                    <i class="fa fa-plus"></i>
                    Submit
                </button>
            </form>
        </div>
    </div>
</div>