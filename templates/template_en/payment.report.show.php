

<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .report-child').addClass('active');
        var dataTable = $('#example');

        var oTable = dataTable.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?=RELA_DIR?>report.php?action=searchPayment&ajax=1"
        } );

        // Apply the search
        oTable.columns().every( function ()
        {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                that.search( this.value ).draw();
            });
        } );

    } );

</script>
<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">payment report</a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo REPORT_01*/?></h2>
    </div>--><!--/content-header -->
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo REPORT_01?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <!--panel-body-->
            <div class="panel-body">

                <?php if($msg!=null)
                { ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success margin-bottom">
                        <?= $msg ?>
                    </div>
                    <?php
                }
                ?>
                <!--form-->
                <form method="post" action="<?=RELA_DIR.'package.php?action=changePackageStatus';?>" name="action" id="action">
                    <div class="content-body">
                        <table id="example" class="companyTable table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo REPORT_02?></th>
                                <th><?php echo REPORT_03?></th>
                                <th><?php echo REPORT_04?></th>
                                <th><?php echo REPORT_05?></th>
                                <th><?php echo REPORT_06?></th>
                                <th><?php echo REPORT_07?></th>
                                <th><?php echo REPORT_08?></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th><input type="text" name="search_20" value="" class="search_init form-control" /></th>
                                <th><input type="text" name="search_20" value="" class="search_init form-control" /></th>
                                <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                                <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                                <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                                <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                                <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row smallSpace"></div>

                </form>
            </div>
            <!--/table-responsive-->
        </div>
    </div>
</div><!--/content -->


