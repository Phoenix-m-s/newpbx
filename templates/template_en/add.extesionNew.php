
<div class="content active">

    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->

        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"></a>
            </li>
            <li>
                <a class="text-20" href="<?=RELA_DIR?>extension.php?action=downloadExcel"><i class="fa fa-file-excel-o"></i> downloadReport</a>
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
                        <h3 class="panel-title sortable-widget-handle"><?=EXTENSION_44;?></h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <!---------------------------------- Extension_Name ------------------------------------------->
                        <div class="normal-data">
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label"
                                               for="extension_name"><?= EXTENSION_15 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" class="form-control" name="extension_name"
                                                   id="extension_name" autocomplete="off"
                                                <?=$member_info != -1 ? 'readonly' : '';?>
                                                   placeholder="<?= EXTENSION_15 ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!---------------------------------- Extension_No ------------------------------------------->
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-5 pull-left control-label" for="extension_no"><?= EXTENSION_16 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input <?=$member_info != -1 ? 'readonly' : '';?> type="tel" class="form-control" name="extension_no" id="extension_no" min="0" autocomplete="off" placeholder="<?= EXTENSION_16 ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------- UserName ------------------------------------------->
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="username"><?= EXTENSION_30 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" <?=$member_info != -1 ? 'readonly' : '';?> class="form-control" name="username" id="username" autocomplete="off" placeholder="<?= EXTENSION_30 ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <!---------------------------------- Password ------------------------------------------->
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-5 pull-left control-label" for="password"><?= EXTENSION_37 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" value="" class="form-control" name="password" id="password" autocomplete="off" placeholder="<?= EXTENSION_37 ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------- caller_id_number ------------------------------------------->
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label"
                                               for="caller_id_number"><?= EXTENSION_28 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="tel" class="form-control" <?=$member_info != -1 ? 'readonly' : '';?> name="caller_id_number"
                                                   min="0"
                                                   id="caller_id_number" autocomplete="off"
                                                   placeholder="<?= EXTENSION_29 ?>">
                                        </div>
                                    </div>
                                </div>

                                <!---------------------------------- ring_number ------------------------------------------->
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-5 pull-left control-label"
                                               for="ring_number"><?= EXTENSION_31 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="number" class="form-control" name="ring_number" id="ring_number"
                                                <?=$member_info != -1 ? 'readonly' : '';?>
                                                   autocomplete="off" placeholder="<?= EXTENSION_31 ?>" required
                                                   min="1" max="20" maxlength="2" value="2">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden-xs"></div>

                            <!---------------------------------- Secret todo: add required in password ------------------------------------------->
                            <div class="row hasReadOnly">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label"
                                               for="secret"><?= EXTENSION_17 ?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" class="form-control secret" <?=$member_info != -1 ? 'readonly' : '';?> name="secret" id="secret"
                                                   autocomplete="off" placeholder="<?= EXTENSION_17 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-5 pull-left control-label" for="ring_number">Timezone:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <select name="timezone" id="timezone" class="select2" required>
                                                <?php
                                                foreach(json_decode($list , true)['timezones'] as $item){
                                                    echo '<option value="'.$item['timezone'].'">'.$item['timezone'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row hidden-xs"></div>

                            <fieldset class="fieldset img-rounded">
                                <legend>
                                    <div class="checkbox">
                                        <label> <input <?=$member_info != -1 ? 'disabled' : '';?> id="enable_recording" name="enable_recording" type="checkbox">
                                            <?= EXTENSION_43 ?>
                                        </label>
                                    </div>
                                </legend>


                                <!---------------------------------- Internal_Recording ------------------------------------------->
                                <div class="row enable_recording hidden no-margin">
                                    <div class="col-xs-12 col-md-12 col-md-4">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-md-12 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="internal_recording" id="internal_recording" type="checkbox" <?=$member_info != -1 ? 'disabled' : '';?>>
                                                        <?= EXTENSION_19 ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- External_Recording ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-4">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-md-12 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="external_recording" id="external_recording" type="checkbox" <?=$member_info != -1 ? 'disabled' : '';?>>
                                                        <?= EXTENSION_20 ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="fieldset img-rounded">
                                <legend>
                                    <div class="checkbox">
                                        <label>
                                            <input id="voicemail_status" name="voicemail_status" type="checkbox" value="">
                                            <?= EXTENSION_21 ?>
                                        </label>
                                    </div>
                                </legend>
                                <legend>
                                    <div class="checkbox">
                                        <label> <input <?=$member_info != -1 ? 'disabled' : '';?> id="is_busy" name="is_busy" type="checkbox">
                                            callWating
                                        </label>
                                    </div>
                                </legend>
                                <!---------------------------------- Internal_Recording ------------------------------------------->
                                <div class="row no-margin">
                                    <div class="col-xs-12 col-md-12 col-md-6 voicemail_status hidden">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="voicemail_email"><?= EXTENSION_22 ?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="email" class="form-control" name="voicemail_email"
                                                       id="voicemail_email" autocomplete="off"
                                                       placeholder="<?= EXTENSION_22 ?>" required disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Voice Mail_Pass ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-6 voicemail_status hidden">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="voicemail_pass"><?= EXTENSION_23 ?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="voicemail_pass" id="voicemail_pass"
                                                       placeholder="<?= EXTENSION_23 ?>" required disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="row xsmallSpace"></div>

                            <!-- Voip Config -->
                            <div class="modal fade" id="VoipConfigModal" tabindex="-1" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-cloud">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title "><i class="fa fa-cog"></i> Phone Configuration</h4>
                                        </div>
                                        <div class="modal-body bg-white">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-12 col-md-12 no-bg center-block">
                                                    <div class="row">
                                                        <!--<div class="col-xs-12 col-md-12 col-md-8">
                                                            <div class="form-group">
                                                                <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_name">Mac Address:</label>
                                                                <div class="col-xs-12 col-md-8 pull-left">
                                                                    <input type="text" class="form-control" name="macAddress" id="macAddress" autocomplete="off" placeholder="macAddress" required>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <div class="col-xs-12 col-md-12 col-md-8">
                                                            <div class="form-group">
                                                                <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_name">Line Name:</label>
                                                                <div class="col-xs-12 col-md-8 pull-left">
                                                                    <input type="text" class="form-control" name="line1_name" id="line1_name" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row hidden-xs"></div>
                                                </div>
                                                <div class="col-xs-12 col-md-12 col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_authname">Authentication Name:</label>
                                                        <div class="col-xs-12 col-md-8 pull-left">
                                                            <input type="text" class="form-control" name="line1_authname" id="line1_authname" autocomplete="off" placeholder="line1_authname" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-12 col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_password">Password:</label>
                                                        <div class="col-xs-12 col-md-8 pull-left">

                                                            <input type="text" class="form-control" name="line1_password" id="line1_password" autocomplete="off" placeholder="line1_password" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-12 col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="line1_shortname">Short Name:</label>
                                                        <div class="col-xs-12 col-md-8 pull-left">
                                                            <input type="text" class="form-control" name="line1_shortname" id="line1_shortname" autocomplete="off" placeholder="line1_name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-12 col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="name">Server Port:</label>
                                                        <div class="col-xs-12 col-md-8 pull-left">
                                                            <input type="number" class="form-control" name="proxy1_port" id="proxy1_port" autocomplete="off" placeholder="Proxy Port" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row hidden-xs"></div>


                                                <div class="col-xs-12 col-md-12 col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="proxy1_address">Server Address:</label>
                                                        <div class="col-xs-12 col-md-8 pull-left">
                                                            <input type="text" class="form-control" name="proxy1_address" id="proxy1_address" autocomplete="off" placeholder="proxy1_address" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row hidden-xs"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-cloud ">
                                            <button id="SaveDeviceConfig" type="button" class="col-md-12 btn btn-primary center-block ">Save Config</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

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
                                    <div class="col-xs-12 col-sm-6 col-md-3 pull-left mac-address-container">

                                    </div>
                                </div>
                            </div>

                            <div class="row xsmallSpace"></div>

                            <div id="changeProtocol">
                                <label for="protocol">protocol: </label>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3 pull-left">
                                        <select name="protocol" id="protocol" class="select2" required></select>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 pull-left mac-address-protocol-holder hidden">
                                        <input name="mac_address" type="text" class="form-control" required placeholder="<?= EXTENSION_35 ?>" >

                                        <a target="_blank" id="link-download-holder" class="btn btn-link"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row xsmallSpace"></div>

                        <h3 style="border-bottom: 1px dotted black;margin-bottom: 1em;">Destination Setting</h3>

                        <section class="destination-holder  ">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title sortable-widget-handle">Success</h3>
                                </div><!-- /panel-heading -->

                                <div class="panel-body">
                                    <div class="row dialExtensionGroup">
                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-padding no-margin">
                                                <select name="dst_option_id" class="select2" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-padding no-margin">
                                                <select name="dst_option_sub_id" class="select2" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-padding no-margin">
                                                <select name="DSTOption" class="select2" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /panel-body -->
                </div>
            </section>

            <!------------------------- Failed Side ------------------------------>
            <section class="fdestination-holder">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title sortable-widget-handle">Failed</h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row dialExtensionFailedGroup">
                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-padding no-margin">
                                    <select name="fdst_option_id" class="select2"></select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-padding no-margin">
                                    <select name="fdst_option_sub_id" class="select2" required></select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-padding no-margin">
                                    <select name="fDSTOption" class="select2" required></select>
                                </div>
                            </div>
                        </div><!-- /panel-body -->
                    </div>
                </div>
            </section>

            <input type="hidden" name="action">
            <input type="hidden" name="extension_id" value="0">
            <input type="hidden" name="comp_id" value="0">

            <button id="submit_time_condition" type="submit" class="btn btn-success btn-icon">
                <i class="fa fa-download"></i> Submit
            </button>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            var $body = $('body'),
                RecordID,
                $destination = $('.destination-holder'),
                isMemberInfo = <?=$member_info != -1 ? 'true' : 'false';?>,
                result = JSON.parse('<?php echo json_encode(json_decode($list)); ?>');

            console.log('get json data from server: ');
            console.log(result);

            <?php
            if ($list['fields']['action'] == 'editExtension' && $member_info != -1) {
            ?>
            $('.hasReadOnly').find('input').each(function () {
                if ($(this).attr('id') !== 'password') {
                    $(this).prop('readonly', true);
                }
            });

            <?php
            }
            ?>

            $body.find('.control-nav a').text(result['form_action'] === 'add' ? '<?=EXTENSION_14;?>' : '<?=EXTENSION_34;?>');

            $body.find('[type="hidden"]').each(function() {
                let name = $(this).attr('name');

                $(this).val(result[name]);
            });

            if (result['form_action'] === 'edit') {
                getList({
                    el: $body.find('[name="chooseDevice"]'),
                    list: result['chooseDevice'],
                    itemVal: result['chooseDevice_selected'],
                    id: 'id',
                    name: 'name'
                }).then(function() {
                    $body.find('[name="chooseDevice"]').val(result['chooseDevice_selected']).trigger('change');

                    $('.mac-address-container').html('Mac Address : <a href="<?=RELA_DIR?>extension.php?action=download&name='+(result.tc[0].path)+'" class="text-danger text-underline" target="_blank"><i class="fa fa-download margin-right"></i>' + (result.tc[0].macAddress) + '</a>');
                });
            }

            getList({
                el: $body.find('[name="protocol"]'),
                list: result['protocol'],
                itemVal: result['protocol_selected'],
                id: 'id',
                name: 'name'
            }).then(function() {
                $body.find('[name="protocol"]').val(result['protocol_selected']).trigger('change');

                if (result['protocol_selected'] === 'sccp') {
                    $body.find('#changeProtocol .mac-address-protocol-holder').removeClass('hidden');
                } else {
                    $body.find('#changeProtocol .mac-address-protocol-holder').addClass('hidden');
                }
            });

            if (result['form_action'] === 'add') {
                fillDestinations({});
            } else {
                $('#deviceConfig').removeClass('hidden');

                // fill all inputs values
                $('.normal-data').find('[name]').each(function() {
                    let itemVal = result.tc[0][$(this).attr('name')];

                    if ($(this).prop('type') === 'checkbox') {
                        switch ($(this).attr('name')) {
                            case 'is_busy':
                                if (parseInt(itemVal)) {
                                    $(this).val(itemVal).prop('checked', true);
                                }
                                else
                                {
                                    $(this).val(itemVal).prop('checked', false);
                                }
                                break;
                            case 'enable_recording' :

                                if (parseInt(itemVal)) {
                                    $(this).val(itemVal).prop('checked', true);
                                    $(this).parents('.fieldset').addClass('active');
                                    $body.find('.'+$(this).attr('name')).removeClass('hidden');
                                } else {
                                    $(this).val(itemVal).prop('checked', false);
                                    $(this).parents('.fieldset').removeClass('active');
                                    $body.find('.'+$(this).attr('name')).addClass('hidden');
                                }

                                break;

                            case 'internal_recording' :
                                $(this).val(itemVal).prop('checked', parseInt(itemVal)).trigger('change');

                                break;

                            case 'external_recording' :
                                $(this).val(itemVal).prop('checked', parseInt(itemVal)).trigger('change');

                                break;

                            case 'voicemail_status' :

                                if (parseInt(itemVal)) {
                                    $(this).val(itemVal).prop('checked', true);
                                    $(this).parents('.fieldset').addClass('active');
                                    $body.find('.'+$(this).attr('name')).removeClass('hidden');
                                    $body.find('.'+$(this).attr('name')).find('[type="text"], [type="email"]').prop('disabled', false);
                                } else {
                                    $(this).val(itemVal).prop('checked', false);
                                    $(this).parents('.fieldset').removeClass('active');
                                    $body.find('.'+$(this).attr('name')).addClass('hidden');
                                    $body.find('.'+$(this).attr('name')).find('[type="text"], [type="email"]').prop('disabled', true);
                                }

                                break;
                        }
                    } else {
                        $(this).val(itemVal).trigger('change');
                    }
                });

                // if member logged in, then check  if voicemail is checked or not, if not checked, don't allow to edit voicemail params
                if (isMemberInfo) {
                    $('[name="voicemail_status"]').prop('disabled', true);
                }

                fillDestinations({
                    list: result.tc[0],
                    elNo: 0,
                    dst_option_id: 'dst_option_id',
                    dst_option_sub_id: 'dst_option_sub_id',
                    DSTOption: 'DSTOption',
                    selected: 'dst_option_id_selected'
                });

                fillDestinations({
                    list: result.failTc[0],
                    elNo: 0,
                    dst_option_id: 'fdst_option_id',
                    dst_option_sub_id: 'fdst_option_sub_id',
                    DSTOption: 'fDSTOption',
                    selected: 'fdst_option_id_selected'
                })
            }

            function fillDestinations(obj) {
                return new Promise(async function(resolve, reject) {
                    try {
                        if (obj.list !== undefined && obj.list[obj.selected] !== undefined) {

                            // dst_option_id
                            await getList({
                                el: $body.find('[name="'+ obj.dst_option_id +'"]:eq(' + obj.elNo + ')'),
                                list: result[obj.dst_option_id],
                                itemVal: obj.list[obj.selected][obj.dst_option_id],
                                id: 'dst_option_id',
                                name: 'name'
                            });

                            // dst_option_sub_id -> if value of dst_option_sub_id is not null
                            if (obj.list[obj.selected][obj.dst_option_sub_id] !== undefined && obj.list[obj.selected][obj.dst_option_sub_id] !== '') {
                                await getList({
                                    el: $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')'),
                                    list: $.grep(result['dst_option_id'], function(v) {
                                        return v['dst_option_id'] === $body.find('[name="'+ obj.dst_option_id +'"]:eq(' + obj.elNo + ')').val();
                                    }).pop().child,
                                    itemVal: obj.list[obj.selected][obj.dst_option_sub_id],
                                    id: 'id',
                                    name: 'name'
                                });
                            } else {
                                $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')').html('');
                                $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')').parent().hide();
                            }

                            // DSTOption -> if value of DSTOption is not null
                            if (obj.list[obj.selected][obj.DSTOption] !== null && obj.list[obj.selected][obj.DSTOption] !== "") {
                                let DSTOption_dst_option_sub_id = $.grep(result['dst_option_id'], function(v) {
                                    return v.dst_option_id === $body.find('[name="'+obj.dst_option_id+'"]:eq(' + obj.elNo + ')').val();
                                }).pop().child;

                                let DSTOption = $.grep(DSTOption_dst_option_sub_id, function(v) {
                                    return v.id === $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')').val();
                                }).pop();

                                if (DSTOption !== undefined) {
                                    await getList({
                                        el: $body.find('[name="'+ obj.DSTOption +'"]:eq(' + obj.elNo + ')'),
                                        list: DSTOption.child,
                                        itemVal: obj.list[obj.selected][obj.DSTOption],
                                        id: 'id',
                                        name: 'name'
                                    });
                                }
                            } else {
                                $body.find('[name="'+ obj.DSTOption +'"]:eq(' + obj.elNo + ')').html('');
                                $body.find('[name="'+ obj.DSTOption +'"]:eq(' + obj.elNo + ')').parent().hide();
                            }

                            resolve(true);

                        } else {
                            getList({
                                el: $body.find('[name="dst_option_id"]'),
                                list: result['dst_option_id'],
                                itemVal: '',
                                id: 'dst_option_id',
                                name: 'name'
                            }).then(function() {
                                $body.find('[name="dst_option_sub_id"]').parent('.form-group').hide();
                                $body.find('[name="DSTOption"]').parent('.form-group').hide();
                            });

                            getList({
                                el: $body.find('[name="fdst_option_id"]'),
                                list: result['fdst_option_id'],
                                itemVal: '',
                                id: 'dst_option_id',
                                name: 'name'
                            }).then(function() {
                                $body.find('[name="fdst_option_sub_id"]').parent('.form-group').hide();
                                $body.find('[name="fDSTOption"]').parent('.form-group').hide();
                            });

                            resolve(true);
                        }
                    } catch(e) {
                        console.log('error in main form fill function: ', e);

                        reject(true);
                    }
                });
            }

            function getList(obj) {
                return new Promise(function(resolve) {
                    try {
                        if (obj.el.prop('tagName') === 'SELECT') {
                            let html = '';

                            if (obj.list !== undefined && obj.list.length) {
                                $.each(obj.list, function(i, v) {
                                    html += '<option '+(parseInt(v[obj.id]) === parseInt(obj.itemVal) ? 'selected' : '')+' value="'+ v[obj.id] +'">'+ v[obj.name] +'</option>';
                                });

                                obj.el.html(html).trigger('change');

                            } else {
                                obj.el.val(obj.itemVal).trigger('change');
                            }
                        } else {
                            obj.el.val(obj.itemVal);
                        }

                        resolve(true);
                    } catch(e) {
                        console.log('error in put list in ', obj.el, e);
                    }
                });
            }

            $body.on('change', '[name="dst_option_id"]', function() {
                let $this = $(this),
                    itemVal = $this.val(),
                    $selectContainer = $this.parents('.row.dialExtensionGroup'),
                    $el = $selectContainer.find('[name="dst_option_sub_id"]'),
                    $elDstOptionFormGroup = $selectContainer.find('[name="DSTOption"]').parent(),
                    $elFormGroup = $el.parent('.form-group');

                try {
                    let list = $.grep(result['dst_option_id'], function (v) {
                        return v.dst_option_id === itemVal;
                    }).pop().child;

                    if (list !== null && list !== undefined && list.length) {
                        let html = '';
                        $.each(list, function(i, v) {
                            html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name + '</option>'
                        });

                        $elFormGroup.show();
                        $elDstOptionFormGroup.hide();
                        $selectContainer.find('[name="DSTOption"]').html('');
                        $el.html(html).trigger('change');
                    } else {
                        $selectContainer.find('[name="DSTOption"]').html('');
                        $el.html('');
                        $elDstOptionFormGroup.hide();
                        $elFormGroup.hide();
                    }
                } catch(e) {
                    // console.log('error in change dst_option_sub_id: ', e);
                }
            });

            $body.on('change', '[name="dst_option_sub_id"]', function() {
                let $this = $(this),
                    itemVal = $this.val(),
                    $selectContainer = $this.parents('.row.dialExtensionGroup'),
                    destinationVal = $selectContainer.find('[name="dst_option_id"]').val(),
                    $el = $selectContainer.find('[name="DSTOption"]'),
                    $elFormGroup = $el.parent('.form-group');

                try {
                    let parentList = $.grep(result['dst_option_id'], function(v) {
                        return v.dst_option_id === destinationVal;
                    }).pop().child;

                    if (!parentList.length) {
                        $el.html('');
                        $elFormGroup.hide();
                    } else {
                        let list = $.grep(parentList, function(v) {
                            return v.id === itemVal;
                        }).pop().child;

                        let html = '';
                        if (list !== null && list !== undefined && list.length) {
                            $.each(list, function(i, v) {
                                html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name +'</option>'
                            });

                            $elFormGroup.html('');
                            $elFormGroup.html('<select class="select2" name="DSTOption" required></select>');
                            $elFormGroup.show();
                            $selectContainer.find('[name="DSTOption"]').html(html).trigger('change').select2();
                        } else if (destinationVal === '9' && itemVal === '2') {
                            html = '<input class="form-control" name="DSTOption" required>';
                            $elFormGroup.html(html);
                            $elFormGroup.show();
                        } else {
                            $elFormGroup.hide();
                        }
                    }
                } catch(e) {
                    //console.log('error in change DSTOption: ', e);
                }
            });

            $body.on('change', '[name="fdst_option_id"]', function() {
                let $this = $(this),
                    itemVal = $this.val(),
                    $selectContainer = $this.parents('.row.dialExtensionFailedGroup'),
                    $el = $selectContainer.find('[name="fdst_option_sub_id"]'),
                    $elDstOptionFormGroup = $selectContainer.find('[name="fDSTOption"]').parent(),
                    $elFormGroup = $el.parent('.form-group');

                try {
                    let list = $.grep(result['fdst_option_id'], function (v) {
                        return v.dst_option_id === itemVal;
                    }).pop().child;

                    if (list !== null && list !== undefined && list.length) {
                        let html = '';
                        $.each(list, function(i, v) {
                            html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name + '</option>'
                        });

                        $elFormGroup.show();
                        $elDstOptionFormGroup.hide();
                        $selectContainer.find('[name="fDSTOption"]').html('');
                        $el.html(html).trigger('change');
                    } else {
                        $selectContainer.find('[name="fDSTOption"]').html('');
                        $el.html('');
                        $elDstOptionFormGroup.hide();
                        $elFormGroup.hide();
                    }
                } catch(e) {
                    // console.log('error in change fdst_option_sub_id: ', e);
                }
            });

            $body.on('change', '[name="fdst_option_sub_id"]', function() {
                let $this = $(this),
                    itemVal = $this.val(),
                    $selectContainer = $this.parents('.row.dialExtensionFailedGroup'),
                    destinationVal = $selectContainer.find('[name="fdst_option_id"]').val(),
                    $el = $selectContainer.find('[name="fDSTOption"]'),
                    $elFormGroup = $el.parent('.form-group');

                try {
                    let parentList = $.grep(result['fdst_option_id'], function(v) {
                        return v.dst_option_id === destinationVal;
                    }).pop().child;

                    if (!parentList.length) {
                        $el.html('');
                        $elFormGroup.hide();
                    } else {
                        let list = $.grep(parentList, function(v) {
                            return v.id === itemVal;
                        }).pop().child;

                        let html = '';
                        if (list !== null && list !== undefined && list.length) {
                            $.each(list, function(i, v) {
                                html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name +'</option>'
                            });

                            $elFormGroup.html('');
                            $elFormGroup.html('<select class="select2" name="fDSTOption" required></select>');
                            $elFormGroup.show();
                            $selectContainer.find('[name="fDSTOption"]').html(html).trigger('change').select2();
                        } else if (destinationVal === '9' && itemVal === '2') {
                            html = '<input class="form-control" name="fDSTOption" required>';
                            $elFormGroup.html(html);
                            $elFormGroup.show();
                        } else {
                            $elFormGroup.hide();
                        }
                    }
                } catch(e) {
                    //console.log('error in change fDSTOption: ', e);
                }
            });

            $('#extension').on('submit', function(e) {
                e.preventDefault();

                let cntErr = 0,
                    data = {
                        comp_id: result['comp_id'],
                        tc: [],
                        failTc: []
                    };

                // all elements in each panel for success time condition and destination
                $body.find('.dial-container > .panel').each(function() {
                    let inputs = {
                        dst_option_id_selected: {}
                    };

                    $(this).find('.normal-data [name]:visible').each(function() {
                        if ($(this).prop('required') && !$(this).prop('disabled') && !$(this).val().length) {
                            cntErr++;
                        } else {
                            if ($(this).prop('type') === 'checkbox') {
                                inputs[$(this).attr('name')] = $(this).prop('checked') ? '1' : '0';
                            } else {
                                inputs[$(this).attr('name')] = $(this).val();
                            }
                        }
                    });

                    $(this).find('.destination-holder').each(function() {
                        let dataTmp = {};

                        $(this).find('input, select').each(function() {
                            if ($(this).attr('name') !== undefined) {
                                if ($(this).val() !== null && $(this).is(':visible') && $(this).prop('required') && !$(this).val().length) {
                                    cntErr++;
                                }

                                dataTmp[$(this).attr('name')] = $(this).val();
                            }
                        });

                        inputs.dst_option_id_selected = dataTmp;

                        if (result['form_action'] === 'edit') {
                            inputs.extension_id = result.tc[0]['extension_id'];
                        }
                    });

                    data.tc.push(inputs);
                });

                // fail destination information
                $body.find('.fdestination-holder .row').each(function() {
                    let dataTmp = {};

                    $(this).find('input, select').each(function() {
                        if ($(this).attr('name') !== undefined) {
                            if ($(this).val() !== null && $(this).is(':visible') && $(this).prop('required') && !$(this).val().length) {
                                cntErr++;
                            }

                            dataTmp[$(this).attr('name')] = $(this).val();
                        }
                    });

                    data.failTc.push(dataTmp);
                });

                // fetch all hidden fields
                $body.find('[type="hidden"]').each(function() {
                    if ($(this).val().length) {
                        data[$(this).attr('name')] = $(this).val();
                    }
                });

                console.log(data);

                if (cntErr) {
                    swal({
                        title: '',
                        html: "Please fill required items",
                        type: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-warning btn-block'
                    });
                } else {
                    $.httpRequest(result['url'] + '?action=' + result['action'], 'POST', data, false, true)
                        .then(function(response) {
                            let resp = JSON.parse(response);

                            let html = '';
                            if (typeof resp.msg === 'string') {
                                html = resp.msg;
                            } else {
                                $.each(resp.msg, function(i, v) {
                                    html += '<div>' + v + '</div><br>';
                                });
                            }

                            if (parseInt(resp.result) === 1) {
                                swal({
                                    title: '',
                                    html: html,
                                    type: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-success btn-block'
                                }).then(function() {
                                    if (result['is_extension']) {
                                        window.location.replace('<?php echo RELA_DIR; ?>extension.php?action=showTimeCondition&id='+result['extension_id']);
                                    } else {
                                        window.location.replace('<?php echo RELA_DIR; ?>'+result['url']);
                                    }
                                });
                            } else if (parseInt(resp.result) === -1) {
                                swal({
                                    title: '',
                                    html: html,
                                    type: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-danger btn-block'
                                });
                            } else {
                                swal({
                                    title: '',
                                    text: 'A problem has been detected, please try again.',
                                    type: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-danger btn-block'
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                        });
                }
            });

            /*
             | ------------------------------------------------------------------------------------------------
             |  RECORD VOICE
             | ------------------------------------------------------------------------------------------------
             */
            function restore() {
                $("#record, #live").removeClass("disabled");
                $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
                $(".one").addClass("disabled");
                Fr.voice.stop();
            }

            $body.on("click", ".record:not(.disabled)", function () {
                RecordID = $(this).attr('id');
                var elem = $(this);

                Fr.voice.record($("#live").is(":checked"), function () {
                    elem.addClass("disabled");
                    $("#live").addClass("disabled");

                    $("." + RecordID + "_one").removeClass("disabled");

                    /**
                     * The Waveform canvas
                     */
                    var analyser = Fr.voice.context.createAnalyser();
                    analyser.fftSize = 2048;
                    analyser.minDecibels = -90;
                    analyser.maxDecibels = -10;
                    analyser.mdoothingTimeConstant = 0.85;
                    Fr.voice.input.connect(analyser);

                    var bufferLength = analyser.frequencyBinCount;
                    var dataArray = new Uint8Array(bufferLength);

                    var WIDTH = 200, HEIGHT = 100;
                    var canvasCtx = $("#" + RecordID + "_level")[0].getContext("2d");
                    canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                    function draw() {
                        var drawVisual = requestAnimationFrame(draw);
                        analyser.getByteTimeDomainData(dataArray);
                        canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                        canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                        canvasCtx.lineWidth = 2;
                        canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                        canvasCtx.beginPath();
                        var sliceWidth = (WIDTH * 1.0) / bufferLength;
                        var x = 0;
                        for (var i = 0; i < bufferLength; i++) {
                            var v = dataArray[i] / 128.0;
                            var y = v * HEIGHT / 2;

                            if (i === 0) {
                                canvasCtx.moveTo(x, y);
                            } else {
                                canvasCtx.lineTo(x, y);
                            }

                            x += sliceWidth;
                        }
                        canvasCtx.lineTo(WIDTH, HEIGHT / 2);
                        canvasCtx.stroke();
                    }

                    draw();
                });
            });

            $body.on("click", "#pause:not(.disabled)", function () {
                if ($(this).hasClass("resume")) {
                    Fr.voice.resume();
                    $(this).replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
                } else {
                    Fr.voice.pause();
                    $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
                }
            });

            $body.on("click", "#stop:not(.disabled)", function () {
                restore();
            });

            $body.on("click", "#play:not(.disabled)", function () {
                var $audio = $("#audio");
                Fr.voice.export(function (url) {
                    $audio.attr("src", url);
                    $audio[0].play();
                }, "URL");

                restore();
            });

            $body.on("click", "#save:not(.disabled)", function (e) {
                e.preventDefault();

                var id = RecordID.replace('record_', '');
                var forwardID = '#' + id + '-1';
                var DSTOption = '#' + id + '-2';
                var status = $(DSTOption).data('status');
                var tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>');
                var voiceTitle = $('#voiceTitle' + id).val();
                var url = "extension.php?action=saveVoice&status=" + status + "&voiceTitle=" + voiceTitle;

                Fr.voice.export(function (blob) {
                    var formData = new FormData();
                    formData.append('file', blob);

                    $.httpRequest(url, 'POST', formData, true)
                        .then(function (response) {
                            $body.find(forwardID).find('select').find('option[value="customMessageByRecord"]').attr("selected", null);
                            $body.find(forwardID).find('select').find('option[value="customMessageByList"]').remove().end().append(tag);
                            $body.find(DSTOption).find('#TCRecordVoiceLink').remove();
                            $body.find(DSTOption).html(response);
                            $body.find(DSTOption).find('select').select2();
                        });

                }, "blob");

                restore();
            });

            $body.on('change', '[name="voicemail_status"]', function() {
                var $container = $('.voicemail_status');
                if($(this).is(':checked')) {
                    $(this).parents('.fieldset').addClass('active');
                    $container.removeClass('hidden');
                    $container.find('input[type="text"], input[type="email"]').prop('disabled', false);
                } else {
                    $(this).parents('.fieldset').removeClass('active');
                    $container.addClass('hidden');
                    $container.find('input[type="text"], input[type="email"]').prop('disabled', true);
                }
            });

            $body.on('change', '[name="enable_recording"]', function() {
                var $container = $('.enable_recording');
                if($(this).is(':checked')) {
                    $(this).parents('.fieldset').addClass('active');
                    $container.removeClass('hidden');
                    $container.find('#internal_recording').prop('checked', true);
                    $container.find('#external_recording').prop('checked', true);
                } else {
                    $(this).parents('.fieldset').removeClass('active');
                    $container.addClass('hidden');
                    $container.find('#internal_recording').prop('checked', false);
                    $container.find('#external_recording').prop('checked', false);
                }
            });

            $body.on('change', '[name="protocol"]', function() {
                let val = $(this).val();

                if (val === 'sccp') {
                    $body.find('#changeProtocol .mac-address-protocol-holder').removeClass('hidden');
                } else {
                    $body.find('#changeProtocol .mac-address-protocol-holder').addClass('hidden');
                }
            });

            $body.on('change', 'input[type="checkbox"]', function () {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });

            $body.on('click', '#showVoipConfigModal', function(e) {
                e.preventDefault();

                $body.find('#VoipConfigModal').modal('show');
            });

            let $showVoipConfigModal = $('#showVoipConfigModal');

            if (result['form_action'] === 'edit') {
                $body.on('change', '[name="chooseDevice"]', function() {
                    let val = $(this).val();

                    if (val.length) {
                        $showVoipConfigModal.parent().removeClass('hidden');
                    } else {
                        $showVoipConfigModal.parent().addClass('hidden');
                    }
                });
            }

            $body.on('click', '#SaveDeviceConfig', function(e) {
                e.preventDefault();

                let data = {},
                    cntErr = 0;

                $(this).parents('.modal-content').find('input').each(function() {
                    if ($(this).prop('required') && !$(this).val().length) {
                        cntErr++;
                    } else {
                        data[$(this).attr('name')] = $(this).is(':cheched') ? 1 : 0;
                    }
                });

                if (cntErr) {
                    swal({
                        title: '',
                        html: "Please fill required items",
                        type: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-warning btn-block'
                    });
                } else {
                    data['comp_id'] = result['comp_id'];
                    data['action'] = result['voipConfig'];
                    data['extension_id'] = result['tc'][0]['extension_id'];
                    data['deviceId'] = $body.find('.deviceModelItemId').val();
                    data['chooseDevice'] = $body.find('[name="chooseDevice"]').val();

                    console.log($body.find('.deviceModelItemId').length);

                    $.httpRequest(result['url'] + '?action=voipConfig', 'POST', data, false, true)
                        .then(function(response) {
                            let resp = JSON.parse(response);

                            let html = '';
                            if (typeof resp.msg === 'string') {
                                html = resp.msg;
                            } else {
                                $.each(resp.msg, function(i, v) {
                                    html += '<div>' + v + '</div><br>';
                                });
                            }

                            if (parseInt(resp.result) === 1) {
                                $('.deviceModelItemId').val(resp.deviceId);
                                swal({
                                    title: '',
                                    html: html,
                                    type: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-success btn-block'
                                }).then(function() {
                                    $('.mac-address-container').html('Mac Address : <a href="<?=RELA_DIR?>extension.php?action=download&name='+resp.path+'" class="text-danger text-underline" target="_blank"><i class="fa fa-download margin-right"></i>' + ($body.find('[name="macAddress"]').val()) + '</a>');

                                    $showVoipConfigModal.modal('hide');
                                });
                            } else if (parseInt(resp.result) === -1) {
                                swal({
                                    title: '',
                                    html: html,
                                    type: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-danger btn-block'
                                });
                            } else {
                                swal({
                                    title: '',
                                    text: 'A problem has been detected, please try again.',
                                    type: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-danger btn-block'
                                });
                            }
                        });
                }
                $body.find('#VoipConfigModal').modal('hide');
                console.log(data);
            });

            $body.on('click', '#link-download-holder', function(e) {
                e.preventDefault();

                var $this = $(this),
                    macAddress = $body.find('.mac-address-protocol-holder [name="mac_address"]').val();

                if (macAddress.length) {
                    window.open("<?=RELA_DIR;?>extension.php?action=download_sccp&mac=" + macAddress, "_blank")
                } else {
                    swal({
                        title: '',
                        text: 'Please Fill Mac Address',
                        type: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-danger btn-block'
                    });
                }
            });
        });
    </script>
