<script>
    $(document).ready(function () {

        //	datatable
        var dataTable = $('#campaign_list');

        var oTable = dataTable.DataTable({
            /*data:[
             ['1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1'],
             ['1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1']
             ],*/
            "processing": true,
            "serverSide": true,
            "sPaginationType": "bs_full",
            "oLanguage": {
                "sProcessing": "Loading ..."
            },
            "aaSorting": [],
            "ajax": "<?=RELA_DIR?>admin.list.php?action=filterUser<?=$export['status'];?>"
        });

        // Apply the search
        var timerId;
        oTable.columns().every(function () {
            var that = this;
            $('input , select', this.footer()).on('keyup change', function () {
                var d = this;
                clockStop();
                clockStart();
                function clockStart() {
                    if (timerId) return;
                    timerId = setInterval(update, 1200);
                }

                function clockStop() {
                    if (!timerId) return;
                    clearInterval(timerId);
                    timerId = null;
                }

                function update() {
                    clockStop();
                    that.search(d.value).draw();
                }

            });
        });

        $('body').on('click', '.remove-item', function(e) {
            e.preventDefault();

            var dataUrl = $(this).attr('data-url'),
                confirmation = confirm('Are you sure want to delete this item?');

            if (confirmation) {
                window.location.replace(dataUrl);
            } else {
                return false;
            }
        });
    });
</script>
<!--    move up <script> by Zeinab Jahanbakhsh    -->

<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left full-width full-height">
            <li class="display-flex flex-direction-row align-items-center full-width">
                <button class="no-bg no-border flex-center" onclick="window.history.back()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="3" stroke="#fb8c00" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <line x1="5" y1="12" x2="9" y2="16" />
                        <line x1="5" y1="12" x2="9" y2="8" />
                    </svg>
                </button>
                <a class="text-24">Admin List</a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <!-- APP CONTENT
        ================================================== -->
        <!-- DASHBOARD
================================================== -->
        <!-- Dashboard  -->

        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'admin.list.php?action=addAdmin'?>" class="margin-bottom btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD?> new admin</a>
                <div id="panel-tablesorter" class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Admin List</h3>
                        <div class="panel-actions">
                            <button data-collapse="#panel-tablesorter" title="" class="btn-panel"
                                    data-original-title="<?php echo COLLAPSE; ?>">
                                <i class="fa fa-caret-down text-midnight text-18"></i>
                            </button>
                        </div><!-- /panel-actions -->
                    </div><!-- /panel-heading -->

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-md-12 center-block">
                                <div class="content-body">
                                    <div class="mat-card mat-elevation-z3">
                                        <div class="mat-content">
                                            <div class="row mt-double">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="table-responsive table-responsive-datatables">
                                                        <table id="campaign_list" class="table table-striped table-bordered rtl">
                                                            <thead>
                                                            <tr>
                                                                <th>username</th>
                                                                <th>name</th>
                                                                <th>family</th>
                                                                <th>comp_name</th>
                                                                <th>type</th>
                                                                <th>tools</th>
                                                            </tr>
                                                            </thead>


                                                            <tfoot>
                                                            <th><input type="text" name="search_1" class="search_init form-control"/></th>
                                                            <th><input type="text" name="search_2" class="search_init form-control"/></th>
                                                            <th><input type="text" name="search_3" class="search_init form-control"/></th>
                                                            <th><input type="text" name="search_4" class="search_init form-control"/></th>
                                                            </th>

                                                            <th>
                                                                <select name="search_5" class="search_init form-control" id="status">
                                                                    <option value="">All</option>
                                                                    <option value="1">admin</option>
                                                                    <option value="2">member</option>
                                                                </select>
                                                            </th>

                                                            <th><input type="text" name="search_6" class="search_init form-control"/>

                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/content -->