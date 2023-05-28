<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .trash-child').addClass('active');
        var dataTable = $('#example');

        var oTable = dataTable.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?=RELA_DIR?>trash.php?action=searchExtensionTrash&ajax=1"
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
        <h2 class="content-title"><i class="fa fa-user"></i><?php echo TRASH_03?></h2>
    </div><!--/content-header -->

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?php echo TRASH_03?></h3>
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                        <?= $msg ?>
                    </div>
                    <?php
                }
                ?>
                <form method="post" action="<?=RELA_DIR.'extension.php?action=changeStatus';?>" name="action" id="action">
                    <!--<div class="pull-left margin-right">
                        <label class="pull-left" for="checkAll"><?php /*echo TRASH_02*/?>
                            <input type="checkbox" id="checkAll" name="checkAll">
                        </label>
                    </div>-->
                    <table id="example" class="companyTable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo EXTENSION_03 ?></th>
                            <th><?php echo EXTENSION_04 ?></th>
                            <th><?php echo EXTENSION_05 ?></th>
                            <th><?php echo EXTENSION_06 ?></th>
                            <th><?php echo EXTENSION_07 ?></th>
                            <th><?php echo EXTENSION_08 ?></th>
                            <th><?php echo EXTENSION_09 ?></th>
                            <th><?php echo EXTENSION_10 ?></th>
                            <th><?php echo EXTENSION_11 ?></th>
                            <th><?php echo EXTENSION_12 ?></th>
                            <th><?php echo EXTENSION_13 ?></th>
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


