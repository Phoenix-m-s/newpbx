
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
    } );
</script>
<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="undefined"></i> </h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Agents</h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables ts-pager1">
                    <table class="tablesorter table table-bordered">
                        <thead>
                        <tr>
                            <th><?php echo ROW; ?></th>
                            <th>Agents</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $cnt = 1;
                        foreach ($list as $key => $value)
                        {
                            if ($value != NULL){
                                ?>
                                <tr>
                                    <td><?php echo $cnt++;?></td>
                                    <td><?php echo $value;?></td>
                                </tr>
                            <?php
                            }
                        } ?>
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
