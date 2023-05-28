<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.campaign-child').addClass('active');
    } );

</script>
<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-24"><?php echo RIGHTMENU_20; ?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">
        <div class="row xsmallSpace"></div>
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo RIGHTMENU_20; ?></h3>

                <div class="panel-actions">
                    <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables">
                    <table class="table dataTableBlackList table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo ROW; ?></th>
                                <th><?php echo STATUS; ?></th>
                                <th><?php echo RIGHTMENU_17; ?></th>
                                <th><?php echo REGISTER_DATE; ?></th>
                                <th><?php echo TOOLS; ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="dataTables_empty">Loading data from server</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row xsmallSpace"></div>

                <div class="pull-left">
                    <a class="btn btn-primary btn-sm btn-icon text-13 addToList"><i class="fa fa-plus"></i>Add To Black List</a>
                </div>
            </div>



        </div>
    </div><!--/content-body -->
</div>

<!-- Modal -->
<div class="modal modal-center fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="customModal3Label" aria-hidden="true">
    <div class="modal-dialog animated bounceIn modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo ADD; ?></h4>
            </div>
            <form action="<?php print RELA_DIR; ?>blackList.php?action=add" method="post" data-validate="form">
                <div class="modal-body text-white">

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label text-18 pull-left" for="number"><?php echo ROW; ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="number" name="number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label text-18 pull-left" for="campaign">Campaign :</label>
                                <div class="col-sm-7">
                                    <select id="campaign" name="campaign" class="form-control">
                                        <?php
                                        foreach ($temp['campaigns'] as $camId=>$value) { ?>
                                            <option value="<?= $camId; ?>"><?= $value['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row xsmallSpace"></div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="status" class="col-sm-5 control-label pull-left"><?php echo STATUS; ?>: </label>
                                <div class="col-sm-7">
                                    <select name="status" id="status" class="form-control">
                                        <option value="t"><?php echo ENABLE_01; ?></option>
                                        <option value="n"><?php echo DISABLED_01; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CANCELED; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo CONFIRMED; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal modal-center fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="customModal3Label" aria-hidden="true">
    <div class="modal-dialog animated bounceIn modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo EDIT_01; ?></h4>
            </div>
            <form action="<?php print RELA_DIR; ?>blackList.php?action=edit" method="post" data-validate="form">
                <input type="hidden" name="editId" id="editId" >

                <div class="modal-body text-white">

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label text-18 pull-left" for="numberEdit"><?php echo ROW; ?>:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="numberEdit" name="numberEdit" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label text-18 pull-left" for="campaignEdit"><?php echo RIGHTMENU_17; ?> :</label>
                                <div class="col-sm-7">
                                    <select id="campaignEdit" name="campaignEdit" class="form-control">
                                        <?php
                                        foreach ($temp['campaigns'] as $camId=>$value) { ?>
                                            <option value="<?= $camId; ?>"><?= $value['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row xsmallSpace"></div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="statusEdit" class="col-sm-5 control-label pull-left"><?php echo STATUS; ?>:</label>
                                <div class="col-sm-7">
                                    <select name="statusEdit" id="statusEdit" class="form-control">
                                        <option value="t"><?php echo ENABLE_01; ?></option>
                                        <option value="n"><?php echo DISABLED_01; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CANCELED; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo CONFIRMED; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal modal-center fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="customModal3Label" aria-hidden="true">
    <div class="modal-dialog animated bounceIn">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete From Black List</h4>
            </div>
            <form action="<?php print RELA_DIR; ?>blackList.php?action=delete" method="post" data-validate="form">
                <input type="hidden" name="deleteId" id="deleteId" />
                <div class="modal-body text-white">
                    <p>Are You Sure?</p>

                    <!-- seperator -->
                    <div class="row xsmallSpace"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CANCELED; ?></button>
                    <button id="terminatedBtn" type="submit" class="btn btn-primary"><?php echo CONFIRMED; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
