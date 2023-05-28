<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
        $('.outbound-menu a').addClass('outbound-active');
    } );
</script>
<div class="content active">
    <div class="content-header">
        <h2 class="content-title"><i class="undefined"></i> </h2>
    </div><!--/content-header -->
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title">Outbound Dial Pattern Show</h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="���� ����">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="��� � ���� ���">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables ts-pager1">
                    <table class="tablesorter table table-bordered">
                        <thead>
                        <tr>
                            <th><?=ROW; ?></th>
                            <th><?=OUTBOUND_15; ?></th>
                            <th><?=OUTBOUND_14; ?></th>
                            <th><?=OUTBOUND_13; ?></th>
                            <th><?=OUTBOUND_12; ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $count=  count ($list['outboundDialPatternInfo']['prepend']);
                        for($i=0;$i<=$count-1;$i++)
                        {
                            ?>
                            <tr >
                                <td><?php echo $i;?></td>
                                <td><?php echo $list['outboundDialPatternInfo']['caller_id'][$i]; ?></td>
                                <td><?php echo $list['outboundDialPatternInfo']['match_pattern'][$i]; ?></td>
                                <td><?php echo $list['outboundDialPatternInfo']['prefix'][$i]; ?></td>
                                <td><?php echo $list['outboundDialPatternInfo']['prepend'][$i]; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="10" class="ts-pager1 form-horizontal ltr">
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
</div>
