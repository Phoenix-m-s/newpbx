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
            <li><a class="text-24"><?php echo LIST_NUMBER; ?></a></li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">
        <div class="row xsmallSpace"></div>
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo LIST_NUMBER; ?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables">
                    <table class="table dataTableNumberList table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo USER_NUMBER; ?></th>
                                <th><?php echo CALL_STATUS; ?></th>
                                <th><?php echo BLACK_LIST; ?></th>
                                <th><?php echo CAMPAGIN; ?></th>
                                <th><?php echo CREATE_DATE; ?></th>
                                <th><?php echo END_DATE; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="dataTables_empty">Loading data from server</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/content-body -->
</div>
