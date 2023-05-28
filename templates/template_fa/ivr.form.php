<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>ivr.php?action=showIvr"></a>
            </li>
        </ul><!--/control-nav-->
    </div>

    <div class="content-body">
        <form name="IVR" id="IVR" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                    <h3 class="panel-title"><?=IVR_12?></h3>
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <div class="row no-margin">
                        <div class="jumbotron no-bg col-xs-12 col-md-12 col-md-12 center-block no-padding">
                            <div class="normal-data">
                                <input name="ivr_id" type="hidden">
                                <input type="hidden" name="action" id="action">

                                <div class="row">
                                    <!-- ivr name -->
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-left control-label" for="ivr_name"><?=IVR_13?>:</label>
                                            <div class="col-xs-12 col-sm-6 pull-left">
                                                <input type="text" class="form-control" name="ivr_name" id="ivr_name" autocomplete="off" placeholder="<?= IVR_22 ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /end of ivr name -->

                                    <!-- upload id -->
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="upload_id"><?= IVR_23 ?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <select class="select2" name="upload_id" id="upload_id" required></select>
                                            </div>
                                        </div>
                                    </div> <!-- /end of upload id -->
                                </div>

                                <div class="row hidden-xs no-margin"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="TimeOut"><?=IVR_15?> (sec):</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <select class="select2" name="timeout" id="TimeOut" required>
                                                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                                                    <option value="<?=$i;?>"> <?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-4 col-md-4 pull-left control-label" for="direct_dial"><?=IVR_16?>:</label>
                                            <div class="col-xs-4 col-md-6 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input checked name="direct_dial" id="direct_dial" value="1" type="checkbox">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hidden-xs"></div>

                                <div class="row no-margin">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="Invalid"><?=IVR_17?>:</label>
                                    </div>
                                </div>
                            </div>

                            <div class="destination-holder">
                                <div class="row jumbotron no-bg no-padding no-margin pos-rel" data-target="1">
                                    <a class="delete-condition" style="position:absolute; top:6px; left: -8px; z-index: 10;"><i class="fa fa-trash text-red text-18"></i></a>

                                    <div class="col-xs-12 col-md-2">
                                        <div class="form-group">
                                            <input type="tel" pattern="^[0-9]$" maxlength="3" min="0" max="999" class="form-control" name="ivr_menu_no" autocomplete="off" placeholder="IVRExtension" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-2">
                                        <div class="form-group">
                                            <select name="dst_option_id" class="select2" required></select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-2">
                                        <div class="form-group">
                                            <select name="dst_option_sub_id" class="select2"></select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-2">
                                        <div class="form-group">
                                            <select name="DSTOption" class="select2"></select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-2 pull-right">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="description" autocomplete="off" placeholder="<?=IVR_27?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="destination-append pos-rel"></div>

                            <!--subDstOption-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <ul class="push-to-bottom plus-outbound" style="padding-left: 1em">
                                        <li>
                                            <button type="button" class="clone-row btn btn-primary btn-icon">
                                                <i class="fa fa-plus"></i> Add More
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-md-12 col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                        <i class="fa fa-download"></i><?= IVR_28 ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->


<script>
    $(document).ready(function () {
        let $body = $('body'),
            $destination = $('.destination-holder'),
            htmlClone = $destination.html(),
            result = JSON.parse('<?php echo json_encode(json_decode($list)); ?>');

        // change title and action of form by action in json object
        $body.find('.control-nav a').text(result['action'] === 'editIvr' ? '<?=IVR_21?>' : '<?=IVR_20?>');

        // fill voice fill (upload_id) select box
        getList({
            el: $body.find('[name="upload_id"]'),
            list: result['upload_id'],
            itemVal: result['upload_id_selected'],
            id: 'id',
            name: 'name'
        }).then(function() {
            $body.find('[name="upload_id"]').val(result['upload_id_selected']).trigger('change');
        });

        // fill all inputs values
        $('.panel-body').find('input').each(function() {
            let itemVal = result[$(this).attr('name')];

            if ($(this).prop('type') === 'checkbox') {
                $(this).val(itemVal).prop('checked', parseInt(itemVal));
            } else {
                $(this).val(itemVal).trigger('change');
            }
        });

        // fill timeout select box
        $body.find('[name="timeout"]').val(result['timeout']).trigger('change');

        fillDestinations();

        function fillDestinations() {
            // loaded destination to each row
            try {
                $destination.html('');

                if (result['dst_option_id_selected'] !== undefined && result['dst_option_id_selected'].length) {
                    $.each(result['dst_option_id_selected'], async function(i, v) {
                        $destination.append($(htmlClone));

                        // ivr_menu_no
                        await getList({
                            el: $body.find('[name="ivr_menu_no"]:eq(' + i + ')'),
                            list: [],
                            itemVal: v['ivr_menu_no']
                        });

                        //  dst_option_id
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

                        // description
                        await getList({
                            el: $body.find('[name="description"]:eq(' + i + ')'),
                            list: [],
                            itemVal: v['description']
                        });
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

                        if (obj.itemVal === 'Invalid' || obj.itemVal === 'TimeOut') {
                            obj.el.prop({
                                'readonly': true,
                                'type': 'text',
                                'pattern': '',
                                'maxlength': '',
                                'min': '',
                                'max': ''
                            });

                            obj.el.parents('[data-target]').find('.delete-condition').remove();
                        }
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
                $selectContainer = $this.parents('[data-target]'),
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
                $selectContainer = $this.parents('.row.jumbotron'),
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

        $body.on('click', '.delete-condition', function(e) {
            e.preventDefault();

            let len = $(this).parent().parent('.destination-holder').find('.row').length;

            if (len > 2) {
                $(this).parent().remove();
            }
        });

        // submit form
        $('#IVR').on('submit', function(e) {
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
                    $.httpRequest("ivr.php?action="+result['action'], 'post', data)
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
                                    window.location.replace('<?php echo RELA_DIR; ?>ivr.php');
                                }
                            });
                        });
                }
            } catch(e) {
                console.log('error in sending form: ', e);
            }
        });

        $body.on('click', '.clone-row', function() {
            $destination.append($(htmlClone));

            //  dst_option_id
            getList({
                el: $destination.find('.row:last-child [name="dst_option_id"]'),
                list: result['dst_option_id'],
                itemVal: 0,
                id: 'dst_option_id',
                name: 'name'
            }).then(function() {
                $destination.find('.row:last-child select').select2();
            });
        });

        /*function restore() {
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $body.on("click", ".record:not(.disabled)", function(){
            RecordID = $(this).attr('id');
            let classValue = $(this).attr('class');
            elem = $(this);
            Fr.voice.record($("#live").is(":checked"), function () {
                elem.addClass("disabled");
                $("#live").addClass("disabled");

                $("." + RecordID + "_one").removeClass("disabled");

                /!**
                 * The Waveform canvas
                 *!/
                let analyser = Fr.voice.context.createAnalyser();
                analyser.fftSize = 2048;
                analyser.minDecibels = -90;
                analyser.maxDecibels = -10;
                analyser.mdoothingTimeConstant = 0.85;
                Fr.voice.input.connect(analyser);

                let bufferLength = analyser.frequencyBinCount;
                let dataArray = new Uint8Array(bufferLength);

                let WIDTH = 200, HEIGHT = 100;
                let canvasCtx = $("#" + RecordID + "_level")[0].getContext("2d");
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                function draw() {
                    let drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);
                    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    let sliceWidth = WIDTH * 1.0 / bufferLength;
                    let x = 0;
                    for (let i = 0; i < bufferLength; i++) {
                        let v = dataArray[i] / 128.0;
                        let y = v * HEIGHT/2;

                        if (i === 0) {
                            canvasCtx.moveTo(x, y);
                        } else {
                            canvasCtx.lineTo(x, y);
                        }

                        x += sliceWidth;
                    }
                    canvasCtx.lineTo(WIDTH, HEIGHT/2);
                    canvasCtx.stroke();
                }

                draw();
            });
        });

        $body.on("click", "#pause:not(.disabled)", function(){
            if ($(this).hasClass("resume")) {
                Fr.voice.resume();
                $(this).replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            } else {
                Fr.voice.pause();
                $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
            }
        });

        $body.on("click", "#stop:not(.disabled)", function(){
            restore();
        });

        $body.on("click", "#play:not(.disabled)", function(){
            Fr.voice.export(function (url) {
                $("#audio").attr("src", url);
                $("#audio")[0].play();
            }, "URL");
            restore();
        });

        $body.on("click", "#save:not(.disabled)", function(e){
            e.preventDefault();
            let id = RecordID.replace('record_', ''),
                forwardID = '#DSTOption' + id + '-2',
                DSTOption = '#DSTOption' + id + '-3',
                status = $(DSTOption).data('status'),
                tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>'),
                voiceTitle = $('#voiceTitle' + id).val(),
                url = "mainTimeCondition.php?action=saveVoice&status=" + status + "&voiceTitle=" + voiceTitle;

            Fr.voice.export(function (blob) {
                let formData = new FormData();
                formData.append('file', blob);

                $.httpRequest(url, 'post', formData)
                    .then(function (response) {
                        $body.find(forwardID).find('select').find('option[value="customMessageByRecord"]').attr("selected",null);
                        $body.find(forwardID).find('select').find('option[value="customMessageByList"]').remove().end().append(tag);
                        $body.find(DSTOption).find('#TCRecordVoiceLink').remove();
                        $body.find(DSTOption).html(response);
                        $body.find(DSTOption).find('select').select2();
                    });

            }, "blob");
            restore();
        });*/
    });
</script>

<style>
    @media screen and (max-width: 768px) {
        .push-to-bottom.plus-outbound {
            padding-left: 0 !important  ;
        }
        .panel-body .row.no-padding.jumbotron {
            padding-top: 1em !important;
            padding-bottom: 0 !important;
        }
        .panel-body .destination-holder .row {
            border: solid 1px #dadada;
            border-radius: 5px;
            margin-bottom: 2em !important;
        }
        .panel-body .destination-holder .delete-condition {
            top: -20px !important;
            left: -10px !important;
            z-index: 10 !important;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background: #FFF;
            border: solid 1px #c30;
            border-radius: 5px;
        }
    }
</style>