<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <form id="extension" data-validate="form" class="form-horizontal" autocomplete="off" novalidate="novalidate" method="post" style="width: 75%;  margin: 0 auto;">
            <section class="dial-container">
                <div id="panel-sortable" class="panel panel-default" data-boxid="1">
                    <div class="panel-heading">
                        <div class="panel-actions">
                            <button data-collapse="#panel-sortable" title="collapse" class="btn-panel">
                                <i class="fa fa-caret-down text-midnight text-18"></i>
                            </button>
                        </div><!-- /panel-actions -->
                        <h3 class="panel-title sortable-widget-handle">voipConfigSetting</h3>
                    </div><!-- /panel-heading -->
                    <div class="panel-body">
                        <!---------------------------------- section ------------------------------------------->
                        <div class="normal-data">
                            <div class="col-xs-12 col-md-12 col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-icon" id="showVoipConfigModal">
                                        <i class="fa fa-plus"></i>Add Brand
                                    </button>
                                </div>
                            </div>
                            <div class="row hidden-xs"></div>
                            <!---------------------------------- Brand ------------------------------------------->
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-12">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label"
                                               for="extension_name">Brand:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <select type="text" class="form-control" name="Brand_name"
                                                    id="Brand_name" autocomplete="off"
                                                    required>
                                                <option value="1">Panasonic</option>
                                                <option value="1">cssico</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---------------------------------- Model ------------------------------------------->
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-12">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label"
                                               for="extension_name">Model:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" class="form-control" name="Model_name"
                                                   id="extension_name" autocomplete="off"
                                                   placeholder="Model" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---------------------------------- Browser ------------------------------------------->
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-12">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label"
                                               for="extension_name">Browser:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input class="fa fa-upload" type="file" name="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row hidden-xs"></div>
                            <!---------------------------------- Secret ------------------------------------------->
                            <!-- Button trigger modal -->
                            <div id="deviceConfig" class="hidden">
                                <label for="chooseDevice">Device Models: </label>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3 pull-left">
                                        <select name="chooseDevice" id="chooseDevice" class="select2"></select>
                                        <input name="deviceId" type="hidden" class="deviceModelItemId" value="">
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-2 pull-left hidden">
                                        <button id="showVoipConfigModal" type="button" class="btn btn-primary btn-icon">
                                            <i class="fa fa-cog"></i>Phone Config
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /panel-body -->
                </div>
            </section>
            <div class="col-md-12   pull-left">


                <button id="submit" type="submit" class="btn btn-success btn-icon pull-left">
                    <input type="hidden" name="action" id="action" value="stepform">
                    <input type="hidden" name="step"  value="2">

                    <!-- <input type="hidden" name="comp_id" value="1">-->
                    <i class="fa fa-download"></i>Next
                </button>
            </div>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Brand</h4>
                </div>
                <div class="modal-body">
                    <div class="form-control">
                        <label for="new_brand">BrandName:</label>
                        <select name="new_brand" id="new_brand">
                            <option value="1">Panasonic</option>
                            <option value="2">CSSCO</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" >save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    
    <script>
        $(function() {
            let $body = $('body');
            
            $body.on('click', '#showVoipConfigModal', function(e) {
                e.preventDefault();

                $('#myModal').modal('show');
            });
        });
    </script>