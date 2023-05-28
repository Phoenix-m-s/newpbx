<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>ivr.php?action=showIvr">
                  Add menu
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <form name="IVR" id="IVR" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=IVR_12?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->
                <?php if ($message != null) { ?>
                    <?php foreach ($message as $msg) { ?>
                        <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                            <?= $msg ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="panel-body">
                    <div class="row no-margin">
                        <div class="jumbotron no-bg col-xs-12 col-md-12 col-md-12 center-block no-padding">

                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="ivr_name"><?=IVR_13?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <input type="text" class="form-control" name="ivr_name" id="Ivr_Name" autocomplete="off" placeholder="<?=IVR_13?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="upload_id"><?=IVR_14?>:</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <select class="select2" name="upload_id" id="upload_id" required>
                                                <?php foreach ($list['uploadList'] as $key => $value): ?>
                                                    <option value="<?=$key?>"><?=$value?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden-xs no-margin"></div>

                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-4 pull-left control-label" for="TimeOut"><?=IVR_15?> (sec):</label>
                                        <div class="col-xs-12 col-md-6 pull-left">
                                            <select class="select2" name="timeout" id="TimeOut" required>
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                                <option <?=($list['Timeout'] == $i) ? 'selected' : ''?> > <?= $i ?></option>
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
                                                    <input checked name="direct_dial" id="direct_dial" value="1" type="checkbox" <?=($list['direct_dial'] == 1) ? 'checked="checked"' : ''?>>
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

                            <!--DstOption-->
                            <div class="row jumbotron destination-holder no-bg no-padding no-margin pos-rel" data-target='1'>
                                <div class="col-xs-12 col-md-12 col-md-2 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="Invalid" readonly name="ivr_menu_no[]" autocomplete="off" placeholder="Invalid" value="Invalid" required>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2 ">
                                    <div class="form-group">
                                        <select name="dst_option_id[]" class="DSTOption select2" id="DSTOption0" required data-combo="dialExtension">
                                            <option value="">Choose from list</option>
                                        <?php foreach($list['DSTList'] as $key => $value): ?>
                                            <option <?=($key == $list['DSTOption']) ? 'selected' : '' ?> value="<?=$key?>"><?=$value?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left" data-combo="activeExtension" id="DSTOption0-1"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left VMForward" data-combo="forward" id="DSTOption0-2"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left VMDSTOption" data-combo="DSTOption" data-status="IVRDSTOption" id="DSTOption0-3"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="description[]" id="Description" autocomplete="off" placeholder="<?php echo IVR_18 ?>" value="">
                                    </div>
                                </div>
                            </div>

                            <!--DstOption-->
                            <div class="row jumbotron destination-holder no-bg no-padding no-margin pos-rel" data-target='2'>
                                <div class="col-xs-12 col-md-12 col-md-2 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="TimeOut" readonly name="ivr_menu_no[]" autocomplete="off" placeholder="<?=IVR_15?>" value="TimeOut" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-md-2 ">
                                    <div class="form-group">
                                        <select name="dst_option_id[]" class="DSTOption select2" id="DSTOption1" required>
                                            <option>Choose from list</option>
                                            <?php foreach($list['DSTList'] as $key => $value): ?>
                                            <option <?=($key == $list['DSTOption']) ? 'selected' : '' ?> value="<?=$key?>"><?=$value?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left" data-combo="activeExtension" id="DSTOption1-1"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left VMForward" data-combo="forward" id="DSTOption1-2"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left VMDSTOption" data-status="IVRDSTOption" data-combo="DSTOption" id="DSTOption1-3"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2 pull-right">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="description[]" id="Description" autocomplete="off" placeholder="<?php echo IVR_18 ?>" value="">
                                    </div>
                                </div>
                            </div>

                            <!--DstOption-->
                            <div class="row jumbotron destination-holder no-bg no-padding no-margin pos-rel" data-target='3'>
                                <a class="delete-condition" style="position:absolute; top:6px; left: -8px; z-index: 10;"><i class="fa fa-trash text-red text-18"></i></a>
                                <div class="col-xs-12 col-md-12 col-md-2 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="ivr_menu_no[]" id="IVRExtension<?=$j?>" autocomplete="off" placeholder="<?php echo IVR_19 ?>" value="" required>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2 ">
                                    <div class="form-group">
                                            <select name="dst_option_id[]" class="DSTOption select2" id="DSTOption2" required>
                                                <option value="">Choose from list</option>
                                                <?php foreach ($list['DSTList'] as $key => $value): ?>
                                                    <option <?=($key == $list['DSTOption']) ? 'selected' : '' ?> value="<?=$key?>"><?=$value?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left" data-combo="activeExtension" id="DSTOption2-1"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left VMForward" data-combo="forward" id="DSTOption2-2"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-md-12 col-md-12 pull-left VMDSTOption" data-status="IVRDSTOption" data-combo="DSTOption" id="DSTOption2-3"></div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-md-2 pull-right">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="description[]" id="Description" autocomplete="off" placeholder="<?=IVR_18?>" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="appendDST"></div>

                            <!--subDstOption-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <ul class="push-to-bottom plus-outbound" style="padding-left: 1em">
                                        <li>
                                            <button type="button" class="clone-condition btn btn-primary btn-icon">
                                                <i class="fa fa-plus"></i>
                                                &nbsp; Add More
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
                    <input type="hidden" name="<?=$list['token']?>" value="1">
                    <button type="submit" id="submit" class="btn btn-success btn-icon">
                        <input type="hidden" name="action" id="action" value="addIvr">
                        <i class="fa fa-download"></i><?= IVR_28 ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->


<script>
    $(document).ready(function () {

        $('.menu-hidden').removeClass('hidden');

        var $body = $('body');

        $(".clone-condition").bind("click", function() {
            var htmlStream = "";
            var counter = $body.find(".jumbotron select[name='dst_option_id[]']").length + 1;
            if (counter < 10) {
                htmlStream += '<div class="row jumbotron destination-holder no-bg no-padding no-margin pos-rel" data-target=' + counter + '>';
                htmlStream += '<a class="delete-condition" style="position:absolute; top:6px; left: -8px; z-index: 10;"><i class="fa fa-trash text-red text-18"></i></a>';
                htmlStream += '<div class="col-xs-12 col-md-12 col-md-2 ">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<input type="text" class="form-control" name="ivr_menu_no[]" id="IVRExtension" autocomplete="off" placeholder="IVRExtension" value="" required>';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '<div class="col-xs-12 col-md-12 col-md-2 ">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<select data-input="select2" class="DSTOption" name="dst_option_id[]" id="DSTOption' + counter + '" data-combo="dialExtension"><option>Choose from list</option>';
                <?php foreach($list['DSTList'] as $key => $value) { ?>
                htmlStream += ' <option <?=$key == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$key?>"><?=$value?></option>';
                <?php } ?>
                htmlStream += '</select>';
                htmlStream += '</div>';
                htmlStream += '</div>';

                htmlStream += '<div class="col-xs-12 col-md-12 col-md-2">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<div class="col-xs-12 col-md-12 pull-left" data-combo="activeExtension" id="DSTOption' + counter + '-1">';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '</div>';

                htmlStream += '<div class="col-xs-12 col-md-12 col-md-2">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<div class="col-xs-12 col-md-12 col-md-12 pull-left VMForward" data-combo="forward" id="DSTOption' + counter + '-2">';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '</div>';

                htmlStream += '<div class="col-xs-12 col-md-12 col-md-2">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<div class="col-xs-12 col-md-12 col-md-12 pull-left VMDSTOption" data-combo="DSTOption" data-status="IVRDSTOption" id="DSTOption' + counter + '-3">';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '<div class="col-xs-12 col-md-12 col-md-2 ">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<input type="text" class="form-control" name="description[]" id="Description" autocomplete="off" placeholder="<?php echo IVR_18?>" value="">';
                htmlStream += '</div>';
                htmlStream += '</div>';
            }

            $('.appendDST').append(htmlStream);

            $('[data-input="select2"]').select2();

            $('select').each(function(){
                $(this).select2();
            })
        });

        $body.on('click', '.delete-condition', function(e) {
            e.preventDefault();

            $(this).parent('.row').remove();
        });

        $body.on("change", ".DSTOption", function () {
            var $subOption = $(this).closest('.row').find('[data-combo="activeExtension"]');
            var $VMForward = $(this).closest('.row').find('[data-combo="forward"]');
            var $VMDSTOption = $(this).closest('.row').find('[data-combo="DSTOption"]');
            var optionVal = $(this).val();

            if (optionVal != '6') {
                $VMForward.hide();
                $VMDSTOption.hide();
            }

            $.httpRequest("dstOption.php?action=dstOptionIvr", 'post', {"DSTOption": optionVal})
                .then(function (response) {
                    $subOption.html(response);
                    $subOption.find('select').select2();
                });

            /*if (optionVal == '6') {
                $VMForward.show();
                $VMDSTOption.show();

                $.httpRequest("dstOption.php?action=VMForward", 'post', {DSTOption: optionVal, name: 'forward[]'})
                    .then(function (response) {
                        $VMForward.html(response);
                        $VMForward.find('select').select2();
                    });
            }*/

        });

        $body.on("change", ".VMForward select", function () {
            var id = $(this).parent().attr('id'),
                $DSTId = $(this).closest('.row').find('[data-combo="DSTOption"]'),
                recordId = id.replace('-2', ''),
                dstOption = $(this).val();

            recordId = recordId.replace('DSTOption', '');
            // DSTId = "#" + DSTId;
            $DSTId.show();

            $.httpRequest("dstOption.php?action=VMDSTOption", 'post', {dstOption: dstOption, recordId: recordId, name: 'DSTOption[]'})
                .then(function (response) {
                    $DSTId.html(response);
                    $DSTId.find('select').select2();
                });
        });

        //--------------------------------- RECORD VOICE ---------------------------------//

        function restore() {
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $body.on("click", ".record:not(.disabled)", function(){
            RecordID = $(this).attr('id');
            var classValue = $(this).attr('class');
            elem = $(this);
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
                    var sliceWidth = WIDTH * 1.0 / bufferLength;
                    var x = 0;
                    for (var i = 0; i < bufferLength; i++) {
                        var v = dataArray[i] / 128.0;
                        var y = v * HEIGHT/2;

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
            var id = RecordID.replace('record_', ''),
                forwardID = '#DSTOption' + id + '-2',
                DSTOption = '#DSTOption' + id + '-3',
                status = $(DSTOption).data('status'),
                tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>'),
                voiceTitle = $('#voiceTitle' + id).val(),
                url = "mainTimeCondition.php?action=saveVoice&status=" + status + "&voiceTitle=" + voiceTitle;

            Fr.voice.export(function (blob) {
                var formData = new FormData();
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
        });

        $('#IVR').on('submit', function(e) {
            var cnt = 0;

            try {
                $(this).find('[required]').each(function() {
                    if ($(this).val() === null || !$(this).val().length) {
                        cnt++;
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

                    return false;
                } else {
                    return true;
                }

            } catch(e) {
                console.log(e);
            }
        });
    });

</script>

<style>
    .button {
        background: #555;
        border: 1px dotted black;
        border-radius: 50px;
        margin:auto 20px 20px auto;
        font-size: 15px;
        color: #000;
    }

    .button:hover, .button:focus  {
        box-shadow: 0 5px 10px #000;
        color: #fff;
    }

    .disabled {
        box-shadow:none;
        opacity:0.7;
    }

    canvas {
        display: block;
    }

    @media screen and (max-width: 768px) {
        .panel-body .no-padding.jumbotron.destination-holder {
            padding-bottom: 0 !important;
            border: solid 1px #dadada;
            border-radius: 5px;
            padding-top: 1em !important;
            margin-bottom: 2em !important;
        }
        .panel-body .no-padding.jumbotron.destination-holder .delete-condition {
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