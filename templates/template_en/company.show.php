
<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('.company-child').addClass('active');
        var dataTable = $('#example');

        var oTable = dataTable.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?=RELA_DIR?>company.php?action=search&ajax=1",
            "language": {
                "zeroRecords": "<?=DATA_TABLE_ZERO_RECORDS;?>"
            }/*,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]*/
        } );

        // Apply the search

        //////
        // Apply the search
        oTable.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
        ///////////


    } );

</script>


<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  Show Companies
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo COMPANY_01*/?></h2>
    </div>--><!--/content-header -->
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo COMPANY_01?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <div class="panel-body">
                <?php

                if($list!=null)
                {
                ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom">
                        <?php
                        echo $list['label']['announce'];
                        foreach($list['list']['announce'] as $key=>$value)
                        {
                           echo '<strong>'.$value['announce_name'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['extension'];
                        foreach($list['list']['extension'] as $key=>$value)
                        {
                           echo '<strong>'.$value['extension_name'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['upload'];
                        foreach($list['list']['upload'] as $key=>$value)
                        {
                           echo '<strong>'.$value['title'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['ivr'];
                        foreach($list['list']['ivr'] as $key=>$value)
                        {
                           echo '<strong>'.$value['ivr_name'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['queue'];
                        foreach($list['list']['queue'] as $key=>$value)
                        {
                           echo '<strong>'.$value['queue_name'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['sip'];
                        foreach($list['list']['sip'] as $key=>$value)
                        {
                            echo '<strong>'.$value['sip_name'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['inbound'];
                        foreach($list['list']['inbound'] as $key=>$value)
                        {
                            echo '<strong>'.$value['inbound_name'].'</strong>, ';
                        }
                        echo '</br>';

                        echo $list['label']['outbound'];
                        foreach($list['list']['outbound'] as $key=>$value)
                        {
                            echo '<strong>'.$value['outbound_name'].'</strong>, ';
                        }
                        echo '</br>';
                        ?>
                    </div>
                <?php
                }
                ?>
                <form method="post" action="<?=RELA_DIR.'company.php?action=changeStatus';?>" name="action" id="action">
                    <div class="pull-left margin-bottom">
                        <a href="<?php echo RELA_DIR.'company.php?action=addCompany'?>" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?php echo ADD; ?> company</a>
                    </div>

                    <div class="row smallSpace"></div>

                    <div class="pull-left margin-right margin-left">
                        <label class="pull-left" for="checkAll"><?php echo COMPANY_02?>
                            <input type="checkbox" id="checkAll" name="checkAll">
                        </label>
                    </div>
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
</div>

<!--/content -->
