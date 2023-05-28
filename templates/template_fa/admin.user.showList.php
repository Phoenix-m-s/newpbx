<?php include(ROOT_DIR . "views/" . CURRENT_SKIN . "/header.php"); ?>

<div class="page-title">
    <h1 class="text-white no-margin">Email Campaign</h1>
</div>

<div class="content-body">
    <div class="mat-card mat-elevation-z3">
        <div class="mat-card-title">
            Show Campaign list
        </div>

        <div class="mat-content">
            <div class="row mt-double">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="table-responsive table-responsive-datatables">
                        <table id="campaign_list" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Host</th>
                                <th>Port</th>
                                <th>Send Count</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <th><input type="text" name="search_1" class="search_init form-control"/></th>
                            <th><input type="text" name="search_2" class="search_init form-control"/></th>
                            <th><input type="text" name="search_3" class="search_init form-control"/></th>
                            <th><input type="text" name="search_4" class="search_init form-control"/></th>
                            <th><input type="text" name="search_5" class="search_init form-control"/></th>
                            <th><input type="text" name="search_6" class="search_init form-control"/></th>
                            <th>
                                <select name="search_4" class="search_init form-control" id="status">
                                    <option value="">All</option>
                                    <option value="0">Incompleted</option>
                                    <option value="1">Runing</option>
                                    <option value="2">Finished</option>
                                </select>
                            </th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(ROOT_DIR . "views/" . CURRENT_SKIN . "/footer.php"); ?>

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
            "ajax": "<?=RELA_DIR?>admin/email-campaign/filterCampaign/?status=<?=$export['status'] ?>"
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

    });

</script>
