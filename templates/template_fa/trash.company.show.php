
<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .trash-child').addClass('active');
        var dataTable = $('#example');

        var oTable = dataTable.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?=RELA_DIR?>trash.php?action=searchCompanyTrash&ajax=1"
        } );

        // Apply the search
        oTable.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                that.search( this.value ).draw();
            } );
        } );

    } );

</script>


<div class="content active">
    <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php echo TRASH_10?></h2>
    </div><!--/content-header -->
    <?php if($msg!=null)
    { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success margin-bottom">
            <?= $msg ?>
        </div>
    <?php
    }
    ?>

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?php echo TRASH_10?></h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo RESIZE; ?>">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <div class="panel-body">
                <form method="post" action="<?=RELA_DIR.'company.php?action=changeStatus';?>" name="action" id="action">
                 <!--   <div class="pull-left margin-right">
                        <label class="pull-left" for="checkAll">انتخاب همه
                            <input type="checkbox" id="checkAll" name="checkAll">
                        </label>
                    </div>-->
                    <table id="example" class="companyTable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo COMPANY_03?></th>
                            <th><?php echo COMPANY_04?></th>
                            <th><?php echo COMPANY_05?></th>
                            <th><?php echo COMPANY_06?></th>
                            <th><?php echo COMPANY_07?></th>
                            <th><?php echo COMPANY_08?></th>
                            <th><?php echo COMPANY_09?></th>
                            <th><?php echo COMPANY_10?></th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <th><input type="text" name="search_10" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_20" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>

                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!--/content -->



<div class="content active">
    <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i>Companies</h2>
    </div><!--/content-header -->
    <?php if($msg!=null)
    { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success margin-bottom">
            <?= $msg ?>
        </div>
    <?php
    }
    ?>
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title">Companies</h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo RESIZE; ?>">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->

            <div class="panel-body">


                <div class="pull-left margin-bottom">
                    <a href="<?php echo RELA_DIR.'company.php?action=addCompany'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?php echo ADD; ?></a>
                </div>
                <div class="row xsmallSpace"></div>

                <div class="table-responsive table-responsive-datatables ts-pager1">
                    <table class="tablesorter table table-bordered">
                        <thead>
                        <tr>
                            <th><?=ROW; ?></th>
                            <th><?=COMPANY_NAME; ?></th>
                            <th><?=MANAGER; ?></th>
                            <th><?=ADDRESS; ?></th>
                            <th><?=TELL; ?></th>
                            <th><?=EMAIL; ?></th>
                            <th><?=TOOLS; ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $cnt = 1;

                        //echo '<pre>';
                        //print_r($list);
                        //die();
                        foreach ($list as $compID => $companyInfo)
                        {
                            if($companyInfo['compStatus']== -1)
                            {
                                ?>

                                <tr>

                                    <td><?php echo $cnt++;?></td>
                                    <td><?php echo $companyInfo['CompName'];?></td>
                                    <td><?php echo $companyInfo['ManagerName'];?></td>
                                    <td><?php echo $companyInfo['Address'];?></td>
                                    <td><?php echo $companyInfo['PhoneNumber'];?></td>
                                    <td><?php echo $companyInfo['Email'];?></td>
                                    <td>
                                        <a href="<?php echo RELA_DIR.'company.php?action=enableCompany&id='. $companyInfo['compID'];?>"  rel="tooltip" data-original-title="<?php echo ENABLE_01; ?>">
                                            <i class="fa fa-toggle-off text-red"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php
                            }
                            else{


                                ?>
                                <tr>

                                    <td><?php echo $cnt++;?></td>
                                    <td><?php echo $companyInfo['CompName'];?></td>
                                    <td><?php echo $companyInfo['ManagerName'];?></td>
                                    <td><?php echo $companyInfo['Address'];?></td>
                                    <td><?php echo $companyInfo['PhoneNumber'];?></td>
                                    <td><?php echo $companyInfo['Email'];?></td>
                                    <td>
                                        <a href="<?php echo RELA_DIR.'company.php?action=editCompany&id=' . $companyInfo['compID'];?>"  rel="tooltip" data-original-title="<?php echo EDIT_01; ?>">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="<?php echo RELA_DIR.'company.php?action=deleteCompany&id='. $companyInfo['compID'];?>"  rel="tooltip" data-original-title="<?php echo DELETE_01; ?>">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>
                                        <a href="<?php echo RELA_DIR.'company.php?action=disableCompany&id='. $companyInfo['compID'];?>"  rel="tooltip" data-original-title="<?php echo DISABLED_01; ?>">
                                            <i class="fa fa-toggle-on text-success"></i>
                                        </a>
                                    </td>

                                </tr>

                            <?php
                            }
                        } ?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="14" class="ts-pager1 form-horizontal ltr">
                                <button type="button" class="btn btn-default btn-sm first"><i class="icon-step-backward fa fa-angle-double-left"></i></button>
                                <button type="button" class="btn btn-default btn-sm prev"><i class="icon-arrow-left fa fa-angle-left"></i></button>
                                <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                                <button type="button" class="btn btn-default btn-sm next"><i class="icon-arrow-right fa fa-angle-right"></i></button>
                                <button type="button" class="btn btn-default btn-sm last"><i class="icon-step-forward fa fa-angle-double-right"></i></button>
                                <select class="pagesize input-sm" title="Select page size">
                                    <option value="5" selected="selected">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </th>
                        </tr>
                        </tfoot><!--/tfoot-->
                    </table>
                </div>
                <!--/table-responsive-->

            </div>
        </div>
    </div>
</div><!--/content -->


