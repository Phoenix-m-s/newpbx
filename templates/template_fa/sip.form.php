<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?= RELA_DIR ?>sip.php?action=showSip"></a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <form name="sip" id="sip" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=SIP_13?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE;?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="sip_name"><?=SIP_14?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" class="form-control" name="sip_name" id="sip_name" autocomplete="off" placeholder="<?= SIP_14 ?>" required>
                                    </div>
                                </div>
                            </div>
                            <!--Password-->
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="pass"><?=SIP_15?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" class="form-control" name="pass" id="pass" autocomplete="off" placeholder="<?=SIP_15?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>

                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="checkHost">Host IP Address<br>(default dynamic):</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <div class="checkbox">
                                            <label>
                                                <input id="checkHost" name="checkHost" type="checkbox" value="0">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="host">IP Address:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" name="host" id="host" class="form-control" required placeholder="<?= SIP_17 ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>

                        <!--NAT-->
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="NAT">NAT:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <div class="checkbox">
                                            <label>
                                                <input id="NAT" name="NAT" type="checkbox"> <?=SIP_17?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row hidden-xs"></div>
                        <!--relaxdtmf-->
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label">Relaxdtmf:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <div class="checkbox">
                                            <label>
                                                <input id="Relaxdtmf" name="Relaxdtmf" type="checkbox" <?=($list['Relaxdtmf'] == '1') ? 'checked="checked" value=1' : 'value=0' ?>> <?=SIP_23?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>

                        <!--SipType-->
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="sip_type"><?=SIP_18?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <select class="valid select2" name="sip_type" id="sip_type" required></select>
                                    </div>
                                </div>
                            </div>


                            <!--dtmfmode-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="dtmfmode"><?=SIP_24?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <select class="valid select2" name="dtmfmode" id="dtmfmode" >

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--checkBox Dynamic For Codec-->
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="codec"><?=SIP_19?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <div class="row codec_holder"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden-xs"></div>
                        </div>
                    </div>
                </div>
            </div>

            <input name="id" type="hidden">
            <input name="comp_id" type="hidden">
            <input type="hidden" name="action">

            <button type="submit" class="btn btn-success btn-icon">
                <i class="fa fa-download"></i> Submit
            </button>
        </form>

    </div><!--/content -->

    <script>
        $(document).ready(function () {
            var $body = $('body');

            let result = JSON.parse('<?php echo json_encode(json_decode($list)); ?>');

            // change title and action of form by action in json object
            $body.find('.control-nav a').text(result['action'] === 'addSip' ? '<?=SIP_20?>' : '<?=SIP_21?>');

            $body.find('[name]').each(function() {
                let itemVal = result[$(this).attr('name')];

                if ($(this).prop('type') === 'checkbox') {
                    $(this).val(parseInt(itemVal)).prop('checked', parseInt(itemVal)).trigger('change');

                    if ($(this).attr('name') === 'checkHost' && $(this).prop('checked')) {
                        $body.find('[name="host"]').val(result['host']).prop('disabled', true);
                    }
                } else {
                    $(this).val(result[$(this).attr('name')]);
                }
            });

            getList({
                el: $body.find('[name="sip_type"]'),
                list: result['sip_type'],
                itemVal: result['sip_type_selected'],
                id: 'id',
                name: 'name'
            });
            getList({
                el: $body.find('[name="dtmfmode"]'),
                list: result['dtmfmode'],
                itemVal: result['dtmfmode_selected'],
                id: 'id',
                name: 'name'
            });
            function getList(obj) {
                return new Promise(function(resolve) {
                    try {
                        if (obj.el.prop('tagName') === 'SELECT') {
                            let html = '';

                            if (obj.list.length) {
                                $.each(obj.list, function(i, v) {
                                    html += '<option '+(v[obj.id] === obj.itemVal ? 'selected' : '')+' value="'+ v[obj.id] +'">'+ v[obj.name] +'</option>';
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
                        console.log('error in put list in '+obj.el, e);
                    }
                });
            }

            $.each(result['codecList'], function(i, v) {
                let codec_html = `<div class="col-xs-12 col-md-4">
                                    <div class="checkbox">
                                        <label for="`+ v.id +`">
                                            <input id="`+ v.id +`" data-val="`+ v.id +`" name="codec" type="checkbox"> `+ v.name +`
                                        </label>
                                    </div>
                                  </div>`;

                $body.find('.codec_holder').append(codec_html);
            });

            $.each(result['codecList_selected'], function(i, v) {
                $body.find('.codec_holder [data-val="'+ v.name +'"]').prop('checked', true);
            });


            $('#sip').on('submit', function(e) {
                e.preventDefault();

                let cnt = 0,
                    data = {
                    codecList_selected: []
                };

                $(this).find('[name]').each(function() {
                    if ($(this).prop('required') && !$(this).val().length) {
                        cnt++;
                    }

                    if ($(this).prop('type') === 'checkbox') {
                        if ($(this).attr('name') === 'codec') {
                            if ($(this).prop('checked')) {
                                data.codecList_selected.push($(this).attr('data-val'));
                            }
                        } else {
                            data[$(this).attr('name')] = $(this).prop('checked') ? '1' : '0';
                        }
                    } else {
                        data[$(this).attr('name')] = $(this).val();
                    }
                });

                if (cnt) {
                    swal({
                        title: '',
                        html: "Please fill required items",
                        type: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-warning btn-block'
                    });
                } else {
                    $.httpRequest("sip.php?action="+result['action'], 'post', data)
                        .then(function (response) {
                            let result = JSON.parse(response);

                            swal({
                                title: '',
                                html: result.msg,
                                type: result.result === 1 ? 'success' : 'error',
                                confirmButtonText: 'OK',
                                confirmButtonClass: 'btn '+(result.result === 1 ? 'btn-success' : 'btn-danger')+' btn-block'
                            }).then(function() {
                                if (result.result === 1) {
                                    window.location.replace('<?php echo RELA_DIR; ?>sip.php');
                                }
                            });
                        });
                }
            });

            $body.on('change', '[name="checkHost"]', function() {
                if ($(this).prop('checked')) {
                    $(this).val('1');
                    $('[name="host"]').val('Dynamic').prop('disabled', true);
                } else {
                    $(this).val('0');
                    $('[name="host"]').val('').prop('disabled', false);
                }
            });
    /*        $body.on('change', '[name="Relaxdtmf"]', function() {
                if ($(this).prop('checked')) {
                    $(this).val('1');
                    $('[name="Relaxdtmf"]').val('1').prop('disabled', true);
                } else {
                    $(this).val('0');
                    $('[name="Relaxdtmf"]').val('0').prop('disabled', false);
                }
            });*/

            /*$('.menu-hidden').removeClass('hidden');

            var checkHost = $('#checkHost');

            if (checkHost.is(':checked'))
                $("#host").prop('disabled', true);

            checkHost.on('change', function () {
                var $host = $("#host");

                if (!$(this).is(':checked')) {
                    $host.prop('disabled', false);

                    $host.val('');
                } else {
                    $host.prop('disabled', true);
                    $host.val('Dynamic');
                }
            });

            $body.on('change', '[type="checkbox"]', function() {
                var val = $(this).data('val');

                if (val !== undefined) {
                    $(this).val($(this).is(':checked') ? val : '0');
                } else {
                    $(this).val($(this).is(':checked') ? '1' : '0');
                }
            });*/
        });
    </script>
</div>