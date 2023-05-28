
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.menu-hidden').removeClass('hidden');
    } );
</script>
<div class="content active">
    <div class="content-header">

        <?php if (is_array($message) and !empty($message)) {
            foreach ($message as $msg) {
                echo $msg . "<br>";
            }
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-bottom"> </div>
            <?php } ?>

        <h2 class="content-title"><i class="undefined"></i> </h2>
    </div><!--/content-header -->

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title">DST menu detail</h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="Resize">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="Collapse-Expand">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables ts-pager1">
                    <table class="tablesorter table table-bordered">
                        <thead>
                        <tr>
                            <th><?=ROW?></th>
                            <th><?=EXIT_NO?></th>
                            <th><?=OPTION?></th>
                            <th><?=DESCRIPTION?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 1;
                        foreach ($list as $key => $value) { ?>
                            <tr>
                                <td><?=$counter++?></td>
                                <td><?=$value['ivr_menu_no']?></td>
                                <td>
                                    <?php
                                    switch ($value['dst_option_id']) {
                                    case 1:
                                        echo 'SIP';
                                    break;
                                    case 2:
                                        echo 'Queue';
                                    break;
                                    case 3:
                                        echo 'Extension';
                                    break;
                                    case 4:
                                        echo 'Announce';
                                    break;
                                    case 5:
                                        echo 'IVR';
                                    break;
                                    case 6:
                                        echo 'Voicemail';
                                    break;
                                    }
                                    ?>
                                </td>
                                <td><?=$value['description']?></td>
                            </tr>
                        <?php } ?>
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
