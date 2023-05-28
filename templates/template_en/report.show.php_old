
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
        $('.menu-hidden').removeClass('hidden');
        $('.menu-hidden .report-child').addClass('active');
        var dataTable = $('#example');
        var oTable = dataTable.DataTable({
            "aaSorting": [],
            "processing": true,
            "serverSide": true,
            "info": true,
            "scrollCollapse": true,
            "paging": true,
            "ajax": "<?=RELA_DIR?>report.php?action=search&ajax=1&<?=http_build_query($list)?>",
            "ordering": true,
            "sPaginationType": "full_numbers",
        });

        // Apply the search
        oTable.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                that.search(this.value).draw();
            });
        });
    });

</script>
<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">CDR Reports</a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo REPORT_09 ?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel"
                            data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
            <!--panel-body-->
            <div class="panel-body">

                <form method="post" id="form" action="" name="action">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="startDate">Start Date</label>
                                </div>
                                <div class="col-md-7 margin-top-half">
                                    <input type="text" id="startDate" autocomplete="off"
                                           name="filter[startDate]"
                                           class="text-left form-control"
                                           value="<?php echo(isset($_POST['filter']['startDate']) ? $_POST['filter']['startDate'] : '') ?>"
                                           data-input="datepicker"
                                           data-show-meridian="false"
                                           data-template="dropdown">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="endDate">End Date</label>
                                </div>
                                <div class="col-md-7 margin-top-half">
                                    <input type="text" id="endDate"
                                           autocomplete="off"
                                           name="filter[endDate]"
                                           class="text-left form-control"
                                           value="<?php echo(isset($_POST['filter']['endDate']) ? $_POST['filter']['endDate'] : '') ?>"
                                           data-input="datepicker"
                                           data-show-meridian="false"
                                           data-template="dropdown">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="startTime">Start Time</label>
                                </div>
                                <div class="col-xs-12 col-md-7 margin-top-half bootstrap-timepicker">
                                    <input type="text" id="startTime"
                                           data-value="<?php echo(isset($_POST['filter']['hourStart']) ? $_POST['filter']['hourStart'] : '') ?>"
                                           autocomplete="off"
                                           class="form-control activeTxt valid"
                                           name="filter[hourStart]"
                                           data-show-meridian="false"
                                           data-template="dropdown"
                                           data-input="timepicker">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="endTime">End Time</label>
                                </div>
                                <div class="col-xs-12 col-md-7 margin-top-half bootstrap-timepicker">
                                    <input type="text" id="endTime"
                                           autocomplete="off"
                                           class="form-control activeTxt valid"
                                           data-value="<?php echo(isset($_POST['filter']['hourEnd']) ? $_POST['filter']['hourEnd'] : '') ?>"
                                           name="filter[hourEnd]"
                                           data-show-meridian="false"
                                           data-template="dropdown"
                                           data-input="timepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row xsmallSpace"></div>

                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="src">Source</label>
                                </div>
                                <div class="col-md-7 margin-top-half">
                                    <input type="number" id="src" name="filter[src]" class="form-control"
                                           value="<?php echo(isset($_POST['filter']['src']) ? $_POST['filter']['src'] : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="dst">Destination</label>
                                </div>
                                <div class="col-md-7 margin-top-half">
                                    <input type="number" id="dst" name="filter[dst]" class="form-control"
                                           value="<?php echo(isset($_POST['filter']['dst']) ? $_POST['filter']['dst'] : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="billsec">Bill Sec</label>
                                </div>
                                <div class="col-md-7 margin-top-half">
                                    <input type="number" id="billsec" name="filter[billsec]"
                                           class="form-control"
                                           value="<?php echo(isset($_POST['filter']['billsec']) ? $_POST['filter']['billsec'] : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-md-5 margin-top-half">
                                    <label for="billsec_select">Bill Sec Operator</label>
                                </div>
                                <div class="col-md-7 margin-top-half">
                                    <select name="filter[billsec_select]" class="select2-container select2"
                                            id="billsec_select">
                                        <option value="=" <?php echo(isset($_POST['filter']['billsec_select']) && $_POST['filter']['billsec_select'] == '=' ? 'selected' : '') ?>>
                                            =
                                        </option>
                                        <option value=">" <?php echo(isset($_POST['filter']['billsec_select']) && $_POST['filter']['billsec_select'] == '>' ? 'selected' : '') ?>>
                                            &gt;
                                        </option>
                                        <option value="<" <?php echo(isset($_POST['filter']['billsec_select']) && $_POST['filter']['billsec_select'] == '<' ? 'selected' : '') ?>>
                                            &lt;
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 margin-top">
                            <button type="submit" class="btn btn-success btn-icon pull-right">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div id="panel-tablesorter1" class="panel panel-default">
            <div class="panel-body">
                <div class="row no-margin">
                    <?php if (isset($msg) && $msg != null) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success margin-bottom">
                            <?= $msg ?>
                        </div>
                        <?php
                    }
                    ?>
                    <!--form-->
                    <form method="post" action="<?= RELA_DIR . 'package.php?action=changePackageStatus'; ?>"
                          name="action"
                          id="action">
                        <div class="content-body" style="overflow-x: auto">
                            <table id="example" class="companyTable table table-striped table-bordered" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th><?php echo REPORT_10 ?></th>
                                    <th><?php echo REPORT_11 ?></th>
                                    <th><?php echo REPORT_12 ?></th>
                                    <th><?php echo REPORT_13 ?></th>
                                    <th><?php echo REPORT_14 ?></th>
                                    <th><?php echo REPORT_16 ?></th>
                                    <th><?php echo REPORT_17 ?></th>
                                    <th><?php echo REPORT_18 ?></th>
                                    <th><?php echo REPORT_19 ?></th>
                                    <th><?php echo REPORT_20 ?></th>
                                    <th><?php echo REPORT_21 ?></th>
                                    <th><?php echo REPORT_22 ?></th>
                                    <th><?php echo REPORT_26 ?></th>
                                    <th><?php echo REPORT_27 ?></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><input type="text" name="search_20" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_20" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                    <th><input type="text" name="search_30" value="" class="search_init form-control"/>
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row smallSpace"></div>

                    </form>
                </div>
            </div>
        </div>
        <!--/table-responsive-->
    </div>
</div>
</div><!--/content -->

<script>
    $(function () {
        var $body = $('body');
        $body.find('.bootstrap-timepicker').each(function () {
            var $this = $(this),
                value = $this.find('input').data('value');

            $this.timepicker({
                showInputs: false,
                showMeridian: false,
            }).on('changeTime.timepicker', function (e) {
                $this.find('input.form-control').val((e.time.hours < 10 ? '0' + e.time.hours : e.time.hours) + ':' + (e.time.minutes < 10 ? '0' + e.time.minutes : e.time.minutes));
            }).on('show.timepicker', function (e) {
                $this.find('input.form-control').val((e.time.hours < 10 ? '0' + e.time.hours : e.time.hours) + ':' + (e.time.minutes < 10 ? '0' + e.time.minutes : e.time.minutes));
            });

            setTimeout(function () {
                $this.find('input.form-control').val('').removeClass('activeTxt');

                if (value.length) {
                    $this.timepicker('setTime', value);
                }
            }, 200);
        });

        var timeTmp = {start: 0, end: 0};
        $body.find('[data-input="datepicker"]').each(function () {
            var $this = $(this);

            $this.datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                hide: true
            }).on('changeDate', function () {
                $this.datepicker('hide');
            });
        });

        $('#form').on('submit', function (e) {
            var startDateTmp = $('#startDate').val().split('-'),
                endDateTmp = $('#endDate').val().split('-');

            var startDate = new Date(startDateTmp[0], startDateTmp[1], startDateTmp[2]).getTime(),
                endDate = new Date(endDateTmp[0], endDateTmp[1], endDateTmp[2]).getTime();

            if (startDate > endDate) {
                swal({
                    title: '',
                    html: "End Date must be greater than Start Date",
                    type: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-warning btn-block'
                });

                return false;
            }
        });


    });
</script>