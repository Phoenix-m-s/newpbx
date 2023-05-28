
<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.company-child').addClass('active');
        var dataTable = $('#example');

        var oTable = dataTable.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?=RELA_DIR?>company.php?action=searchGroupCompany&ajax=1"
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
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  <?php echo CompanyGroup_01 ?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <!--div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo CompanyGroup_01 */?></h2>
    </div>--><!--/content-header -->
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
                    <h3 class="panel-title"><?php echo CompanyGroup_01 ?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <form method="post" action="<?=RELA_DIR.'company.php?action=changeGroupStatus';?>" name="action" id="action">
                    <div class="pull-left margin-right">
                        <a href="<?php echo RELA_DIR.'company.php?action=addCompanyGroup'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?php echo ADD; ?></a>
                    </div>
                    <div class="row smallSpace"></div>

                    <div class="pull-left margin-right">
                        <label class="pull-left" for="checkAll"><?php echo CompanyGroup_02 ?>
                            <input type="checkbox" id="checkAll" name="checkAll">
                        </label>
                    </div>

                    <table id="example" class="companyTable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo CompanyGroup_03 ?></th>
                            <th><?php echo CompanyGroup_04 ?></th>
                            <th><?php echo CompanyGroup_05 ?></th>
                            <th><?php echo CompanyGroup_06 ?></th>

                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <th><input type="text" name="search_10" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_20" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>
                            <th><input type="text" name="search_30" value="" class="search_init form-control" /></th>

                        </tr>
                        </tfoot>
                    </table>
                        <div class="pull-left margin-right margin-left">
                            <input type="submit" class="btn btn-success" name="active" id="action" value="<?php echo ENABLE_01; ?>"/>
                        </div>
                        <div class="pull-left margin-right">
                            <input type="submit" class="btn btn-danger" name="inactive" id="action1" value="<?php echo DISABLED_01; ?>"/>
                        </div>
    </form>
                </div>
            </div>

        </div>

</div><!--/content -->


