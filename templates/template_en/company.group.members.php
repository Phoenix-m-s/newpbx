
<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
            $('.company-child').addClass('active');
        var dataTable = $('#example');

        var oTable = dataTable.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?=RELA_DIR?>company.php?action=searchMember&ajax=1&groupID=<?php echo $list['GroupID']?>"
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
   <!-- <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo CompanyGroup_11*/?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  <?php echo CompanyGroup_11?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <?php if($msg!=null)
    { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success margin-bottom">
            <?= $msg ?>
        </div>
    <?php
    }
    ?>

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?php echo CompanyGroup_11?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>

                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <div class="panel-body">

                <div class="pull-left margin-bottom">
                    <a  href="<?php echo RELA_DIR.'company.php?action=AddCompanyToGroup&id=' . $list['GroupID'];?>"  class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i>
                        <?php echo CompanyGroup_12?>
                    </a>
                </div>


                <div class="row smallSpace"></div>

                <table id="example" class="companyTable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><?php echo CompanyGroup_13?></th>
                        <th><?php echo CompanyGroup_14?></th>
                        <th><?php echo CompanyGroup_15?></th>
                        <th><?php echo CompanyGroup_16?></th>

                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th><input type="text" name="search_10" value="" class="search_init form-control" /></th>
                        <th><input type="text" name="search_20" value="" class="search_init form-control" /></th>
                        <th><input type="text" name="search_20" value="" class="search_init form-control" /></th>
                        <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

<!--/content -->



<div class="content active">
    <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i>Company Group Members</h2>
    </div><!--/content-header -->

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title">Company Group Members</h3>
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

                <?php if($msg!=null)
                { ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success margin-bottom">
                        <?= $msg ?>
                    </div>
                    <div class="row smallSpace"></div>
                <?php
                }
                ?>

                <div class="pull-left margin-bottom">
                    <a  href="<?php echo RELA_DIR.'company.php?action=AddCompanyToGroup&id=' . $list['GroupID'];?>"  class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i>
                        Add a company in this group
                    </a>
                </div>

                <?php
                if(count($list))
                {
                    ?>
                    <div class="table-responsive table-responsive-datatables ts-pager1">
                        <table class="tablesorter table table-bordered">
                            <thead>
                            <tr>
                                <th><?php echo ROW; ?></th>
                                <th><?=COMPANY_NAME;?></th>
                                <th><?php echo TOOLS; ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $cnt = 1;

                            //echo '<pre>';
                            //print_r($list);
                            //die();
                            foreach ($list['list'] as $compID => $companyInfo)
                            {
                                ?>
                                <tr>

                                    <td><?php echo $cnt++;?></td>
                                    <td><?php echo $companyInfo['Comp_Name'];?></td>
                                    <td>
                                        <a href="<?php echo RELA_DIR.'company.php?action=RemoveCompanyFromGroup&id=' . $companyInfo['comp_id'];?>" rel="tooltip" data-original-title="Remove label from this group">
                                            <i class="fa fa-minus text-red"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php
                            } ?>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" class="ts-pager1 form-horizontal ltr">
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
                <?php
                }
                else
                {
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                        No information found.
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</div><!--/content -->


