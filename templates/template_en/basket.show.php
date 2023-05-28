
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function()
    {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .package-child').addClass('active');
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
                <a class="text-20">show Basket</a>
            </li>
        </ul><!--/control-nav-->
    </div>

    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-shopping-cart text-orange"></i> <?php echo BASKET_01 ?> </h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
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

                if($list!=NULL)
                {
                    ?>
                    <div class="table-responsive table-responsive-datatables ts-pager1">
                        <table class="tablesorter table table-bordered">
                            <thead>
                            <tr>
                                <th><?php echo BASKET_02 ?> </th>
                                <th><?php echo BASKET_03 ?> </th>
                                <th><?php echo BASKET_04 ?> </th>
                                <th><?php echo BASKET_05 ?> </th>
                                <th><?php echo BASKET_06 ?> م</th>
                                <th><?php echo BASKET_07 ?> </th>
                                <th><?php echo BASKET_08 ?> </th>
                                <th><?php echo BASKET_09 ?> </th>
                                <th><?php echo BASKET_10 ?> </th>
                                <th><?php echo BASKET_11 ?> </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $cnt = 1;
                            foreach($list as $key=>$value){

                                ?>

                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $value['package_name']; ?></td>
                                    <td><?php echo $value['extension_count']; ?></td>
                                    <td><?php echo $value['issue_date'] ?></td>
                                    <td><?php echo $value['expire_date'] ?></td>
                                    <td><?php echo $value['start_date'] ?></td>
                                    <td><?php echo $value['new_expire_date'] ?></td>
                                    <td><?php echo $value['price'] ?></td>
                                    <td><?php echo $status = ($value['status'] == 0 ? DISABLED_01 : ENABLE_01); ?></td>
                                    <td>
                                        <a href="<?php echo RELA_DIR ?>basket.php?action=deleteBasket&basket_id=<?php echo $key ?>"
                                           rel="tooltip" data-original-title="<?php echo DELETE_01; ?>">
                                            <i class="fa fa-minus text-red"></i>
                                        </a>
                                    </td>

                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>

                            <tfoot>

                            <!-- <tr>
                                 <th colspan="10" class="ts-pager1 form-horizontal ltr">
                                     <button type="button" class="btn btn-default btn-sm first"><i class="icon-step-backward fa fa-angle-double-left"></i></button>
                                     <button type="button" class="btn btn-default btn-sm prev"><i class="icon-arrow-left fa fa-angle-left"></i></button>
                                     <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                            <!--<button type="button" class="btn btn-default btn-sm next"><i class="icon-arrow-right fa fa-angle-right"></i></button>
                            <button type="button" class="btn btn-default btn-sm last"><i class="icon-step-forward fa fa-angle-double-right"></i></button>
                            <select class="pagesize input-sm" title="Select page size">
                                <option value="5" selected="selected">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </th>
                    </tr>-->
                            </tfoot><!--/tfoot-->
                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning margin-top margin-bottom">
                            <label class="col-xs-12 col-sm-2 pull-left control-label"><?=BASKET_10; ?></label>
                            <div class="col-xs-12 col-sm-10 pull-left">
                                <?php
                                $priceSum = 0;
                                foreach($list as $key=>$value)
                                {
                                    $priceSum = $value['price'] + $priceSum;
                                }
                                echo $priceSum;
                                ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-info margin-bottom">
                            <label class="col-xs-12 col-sm-2 pull-left control-label"><?=BASKET_13; ?></label>
                            <div class="col-xs-12 col-sm-10 pull-left">
                                <?php
                                $priceTotal = 0;
                                foreach($list as $keyT=>$valueT)
                                {
                                    $priceTotal = $valueT['total_price'] + $priceTotal;
                                }
                                echo $priceTotal;
                                ?>
                            </div>
                        </div>

                        <div class="pull-left margin-bottom">
                            <a href="<?php echo RELA_DIR ?>basket.php?action=sendInvoice" class="btn btn-info btn-sm btn-icon text-13"><i class="fa fa-dollar"></i><?=BASKET_14; ?></a>
                        </div>
                    </div>
                    <!--/table-responsive-->
                    <?php
                }
                else
                {
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert margin-bottom">
                        Your Basket Is Empty
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
