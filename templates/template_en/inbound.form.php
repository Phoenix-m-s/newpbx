<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>inbound.php?action=showInbound"></a>
            </li>
        </ul><!--/control-nav-->
    </div>

    <div class="content-body">
        <form name="inbound" id="inbound" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=INBOUND_22?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 center-block">
                            <div class="normal-data">
                                <input name="inbound_id" type="hidden">
                                <input type="hidden" name="action" id="action" value="update">

                                <div class="row">
                                    <!-- inbound name -->
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-6 pull-left control-label" for="inbound_name"><?=INBOUND_14?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                               <input type="text" class="form-control" name="inbound_name" id="inbound_name"  autocomplete="off" placeholder="<?=INBOUND_14?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /end of inbound name -->
                                </div>

                                <div class="row hidden-xs"></div>

                                <!--checkbox-->
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_15?>:</label>
                                            <div class="col-xs-12 col-md-2 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input id="check_did_name" name="check_did_name" type="checkbox"> Any
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" pattern="^[0-9]$" class="form-control ltr just_number" name="did_name" id="did_name"  autocomplete="off" placeholder="<?=INBOUND_15?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hidden-xs"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <!--DIDName-->
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_16?>:</label>
                                            <div class="col-xs-12 col-md-2 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input id="check_cid_name" name="check_cid_name" type="checkbox"> Any
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" pattern="^[0-9]$" class="form-control ltr just_number" name="cid_name" id="cid_name"  autocomplete="off" placeholder="<?=INBOUND_16?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hidden-xs"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_17?>:</label>
                                            <div class="col-xs-12 col-md-2 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input id="check_fax_ext" name="check_fax_ext" type="checkbox"> <?=INBOUND_24?>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="email" class="form-control" name="fax_email" id="fax_email" disabled="disabled" autocomplete="off" placeholder="<?=INBOUND_18?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 style="border-bottom: 1px dotted black;margin-bottom: 1em;">Destination Setting</h3>

                    <section class="destination-holder">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dial Destination</h3>
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
                                            <select name="dst_option_sub_id" class="select2"></select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-padding no-margin">
                                            <select name="DSTOption" class="select2"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="row hidden-xs"></div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <button title="Submit" type="submit" name="update" id="submit"  class="btn btn-success btn-icon">
                            <i class="fa fa-download"></i> Submit
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->

<script>
    $(document).ready(function() {
        let $body = $('body'),
            $destination = $('.destination-holder'),
            result = JSON.parse('<?php echo json_encode(json_decode($list)); ?>');

        // change title and action of form by action in json object
        $body.find('.control-nav a').text(result['action'] === 'addInbound' ? '<?=INBOUND_20?>' : '<?=INBOUND_23?>');

        // fill all inputs values
        $('.normal-data').find('[name]').each(function() {
            let itemVal = result[$(this).attr('name')];

            if ($(this).prop('type') === 'checkbox') {
                $(this).val(itemVal).prop('checked', parseInt(itemVal));

                switch ($(this).attr('name')) {
                    case ('check_did_name') : {
                        if ($(this).prop('checked')) {
                            $body.find('[name="did_name"]').prop('disabled', true);
                        }
                        break;
                    }

                    case ('check_cid_name') : {
                        if ($(this).prop('checked')) {
                            $body.find('[name="cid_name"]').prop('disabled', true);
                        }
                        break;
                    }

                    case ('check_fax_ext') : {
                        if ($(this).prop('checked')) {
                            $body.find('[name="fax_email"]').prop('disabled', false);
                        }
                        break;
                    }
                }
            } else {
                $(this).val(itemVal).trigger('change');
            }
        });

        fillDestinations();

        function fillDestinations() {
            // loaded destination to each row
            try {
                if (result['dst_option_id_selected'] !== undefined && result['dst_option_id_selected'].length) {
                    $.each(result['dst_option_id_selected'], async function(i, v) {

                        // dst_option_id
                        await getList({
                            el: $body.find('[name="dst_option_id"]:eq(' + i + ')'),
                            list: result['dst_option_id'],
                            itemVal: v['dst_option_id'],
                            id: 'dst_option_id',
                            name: 'name'
                        });

                        // dst_option_sub_id -> if value of dst_option_sub_id is not null
                        if (v['dst_option_sub_id'] !== undefined && v['dst_option_sub_id'].length && v['dst_option_sub_id'] !== '0') {
                            await getList({
                                el: $body.find('[name="dst_option_sub_id"]:eq(' + i + ')'),
                                list: $.grep(result['dst_option_id'], function(v) {
                                    return v['dst_option_id'] === $body.find('[name="dst_option_id"]:eq(' + i + ')').val();
                                }).pop().child,
                                itemVal: v['dst_option_sub_id'],
                                id: 'id',
                                name: 'name'
                            });
                        } else {
                            $body.find('[name="dst_option_sub_id"]:eq(' + i + ')').html('');
                            $body.find('[name="dst_option_sub_id"]:eq(' + i + ')').parent().hide();
                        }

                        // DSTOption -> if value of DSTOption is not null
                        if (v['DSTOption'] !== null && v['DSTOption'].length) {
                            let DSTOption_dst_option_sub_id = $.grep(result['dst_option_id'], function(v) {
                                return v.dst_option_id === $body.find('[name="dst_option_id"]:eq(' + i + ')').val();
                            }).pop().child;

                            let DSTOption = $.grep(DSTOption_dst_option_sub_id, function(v) {
                                return v.id === $body.find('[name="dst_option_sub_id"]:eq(' + i + ')').val();
                            }).pop();

                            if (DSTOption !== undefined) {
                                await getList({
                                    el: $body.find('[name="DSTOption"]:eq(' + i + ')'),
                                    list: DSTOption.child,
                                    itemVal: v['DSTOption'],
                                    id: 'id',
                                    name: 'name'
                                });
                            }
                        } else {
                            $body.find('[name="DSTOption"]:eq(' + i + ')').html('');
                            $body.find('[name="DSTOption"]:eq(' + i + ')').parent().hide();
                        }
                    });
                } else {
                    getList({
                        el: $body.find('[name="dst_option_id"]'),
                        list: result['dst_option_id'],
                        itemVal: result['dst_option_id_selected'],
                        id: 'dst_option_id',
                        name: 'name'
                    }).then(function() {
                        $body.find('[name="dst_option_sub_id"]').parent('.form-group').hide();
                        $body.find('[name="DSTOption"]').parent('.form-group').hide();
                    });
                }
            } catch(e) {
                console.log('error in main form fill function: ', e);
                // reject(true);
            }
        }

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
                console.log('error in change dst_option_sub_id: ', e);
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
                        $elFormGroup.html('<select class="select2" name="DSTOption"></select>');
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
                console.log('error in change DSTOption: ', e);
            }
        });

        // submit form
        $('#inbound').on('submit', function(e) {
            e.preventDefault();

            let cnt = 0,
                data = {
                    dst_option_id_selected: []
                };

            try {
                $('.normal-data').find('[name]').each(function() {
                    if ($(this).prop('required') && !$(this).val().length) {
                        cnt++;
                    }

                    if ($(this).prop('type') === 'checkbox') {
                        data[$(this).attr('name')] = $(this).prop('checked') ? '1' : '0'
                    }  else {
                        data[$(this).attr('name')] = $(this).val()
                    }
                });

                $destination.find('.row').each(function(i, v) {
                    let dataTmp = {};

                    $(this).find('input, select').each(function() {
                        if ($(this).attr('name') !== undefined) {
                            if ($(this).prop('required') && !$(this).val().length) {
                                cnt++;
                            }

                            dataTmp[$(this).attr('name')] = $(this).val();
                        }
                    });

                    data.dst_option_id_selected.push(dataTmp);
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
                    console.log(data);
                    $.httpRequest("inbound.php?action="+result['action'], 'post', data)
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
                                    window.location.replace('<?php echo RELA_DIR; ?>inbound.php');
                                }
                            });
                        });
                }
            } catch(e) {
                console.log('error in sending form: ', e);
            }
        });

        $body.on('change', '[name="check_did_name"]',  function() {
            let $did_name = $('[name="did_name"]');

            $did_name.prop('disabled', $(this).is(':checked'));

            if ($(this).is(':checked')) {
                $did_name.val('');
            }
        });

        $body.on('change', '[name="check_cid_name"]',  function() {
            let $cid_name = $('[name="cid_name"]');

            $cid_name.prop('disabled', $(this).is(':checked'));

            if ($(this).is(':checked')) {
                $cid_name.val('');
            }
        });

        $body.on('change', '[name="check_fax_ext"]',  function() {
            let $fax_email = $('[name="fax_email"]');

            $fax_email.prop('disabled', !$(this).is(':checked'));

            if (!$(this).is(':checked')) {
                $fax_email.val('');
            }
        });

        /*function restore() {
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $(document).on("click", ".record:not(.disabled)", function () {
            RecordID = $(this).attr('id');
            var classValue = $(this).attr('class');
            elem = $(this);
            Fr.voice.record($("#live").is(":checked"), function () {
                elem.addClass("disabled");
                $("#live").addClass("disabled");

                $("." + RecordID + "_one").removeClass("disabled");

                /!**
                 * The Waveform canvas
                 *!/
                analyser = Fr.voice.context.createAnalyser();
                analyser.fftSize = 2048;
                analyser.minDecibels = -90;
                analyser.maxDecibels = -10;
                analyser.mdoothingTimeConstant = 0.85;
                Fr.voice.input.connect(analyser);

                var bufferLength = analyser.frequencyBinCount;
                var dataArray = new Uint8Array(bufferLength);

                WIDTH = 200, HEIGHT = 100;
                canvasCtx = $("#" + RecordID + "_level")[0].getContext("2d");
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                function draw() {
                    drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);
                    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    var sliceWidth = WIDTH * 1.0 / bufferLength;
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
                };
                draw();
            });
        });

        $(document).on("click", "#pause:not(.disabled)", function () {
            if ($(this).hasClass("resume")) {
                Fr.voice.resume();
                $(this).replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            } else {
                Fr.voice.pause();
                $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
            }
        });

        $(document).on("click", "#stop:not(.disabled)", function () {
            restore();
        });

        $(document).on("click", "#play:not(.disabled)", function () {
            Fr.voice.export(function (url) {
                $("#audio").attr("src", url);
                $("#audio")[0].play();
            }, "URL");
            restore();
        });

        $(document).on("click", "#save:not(.disabled)", function (e) {
            e.preventDefault();
            var id = RecordID.replace('record_', '');
            var forwardID = '#DSTOption-2';
            var DSTOption = '#DSTOption-3';
            var status = $(DSTOption).data('status');
            var tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>');
            var voiceTitle = $('#voiceTitle' + id).val();
            var url = "mainTimeCondition.php?action=saveVoice&status=" + status + "&voiceTitle=" + voiceTitle;
            Fr.voice.export(function (blob) {
                var formData = new FormData();
                formData.append('file', blob);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(document).find(forwardID).find('select').find('option[value="customMessageByRecord"]').attr("selected", null);
                        $(document).find(forwardID).find('select').find('option[value="customMessageByList"]').remove().end().append(tag);
                        $(document).find(DSTOption).find('#TCRecordVoiceLink').remove();
                        $(document).find(DSTOption).html(response);
                        $(document).find(DSTOption).find('select').select2();

                    }
                });

            }, "blob");
            restore();
        });*/
    });
</script>