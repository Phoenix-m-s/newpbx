<div class="content active">

    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>sip.php?action=showSip">
                    Add SIP
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <form name="SIP" id="SIP" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=SIP_13?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE;?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->
                <?php if ($msg != null) { ?>
                    <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                        <?=$msg?>
                    </div>
                <?php } ?>
                <div class="panel-body">
                    <div class="row">
                        <!--SIPName-->
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="sip_name"><?=SIP_14?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" class="form-control" name="sip_name" id="sip_name" autocomplete="off" placeholder="<?=SIP_14?>" value="<?=$list['sip_name']?>" required>
                                    </div>
                                </div>
                            </div>
                            <!--Password-->
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="pass"><?=SIP_15?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" class="form-control" name="pass" id="pass" value="<?=$list['pass']?>" autocomplete="off" placeholder="<?=SIP_15?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>

                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="Type">Host IP Address<br>(default dynamic):</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <div class="checkbox">
                                            <label>
                                                <input id="checkHost" name="checkHost" type="checkbox" <?=($list['host'] == 'Dynamic') ? 'checked="checked value="1"' : 'value="0"' ?>>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label">IP Address:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" name="host" id="host" class="form-control" placeholder="<?=SIP_17?>" value="<?=$list['Host']?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row hidden-xs"></div>

                        <!--NAT-->
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label">NAT:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <div class="checkbox">
                                            <label>
                                                <input id="NAT" name="NAT" type="checkbox" <?=($list['NAT'] == '1') ? 'checked="checked" value="1"' : 'value="0"' ?>> <?=SIP_17?>
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
                                                <input id="Relaxdtmf" name="Relaxdtmf" type="checkbox" <?=($list['Relaxdtmf'] == '1') ? 'checked="checked" value="1"' : 'value="0"' ?>> <?=SIP_21?>
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
                                        <select class="valid select2" name="sip_type" id="sip_type" required>
                                            <option value="Peer">Peer</option>
                                            <option value="Friend">Friend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--dtmfmode-->
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="dtmfmode"><?=SIP_18?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <select class="valid select2" name="dtmfmode" id="dtmfmode" required>
                                            <option value="auto">auto</option>
                                            <option value="rfc2833">rfc2833</option>
                                            <option value="info">info</option>
                                            <option value="shortinfo">shortinfo</option>
                                            <option value="inband">inband</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!--checkBox Dynamic For Codec-->
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label" for="codec"><?=SIP_19?>:</label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <?php
                                        $count = 0;
                                        $count2 = 0;
                                        foreach ($list['codecList'] as $val) {
                                            if ($count == 0) { ?>
                                                <div class="row">
                                        <?php
                                            }
                                            $count++;
                                            $count2++;
                                        ?>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input id="codec<?=$count;?>" data-val="<?=$val;?>" name="codec[]" <?=(in_array($val, $list['codec'])) ? 'checked="checked" value="1"' : 'value="0"' ?> type="checkbox" value="<?=$val?>"><?=$val?>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php if ($count == 3 or $count2 - 1 == count($list['codecList'])) {
                                                $count = 0; ?>
                                                </div>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden-xs"></div>
                        </div>
                        <input type="hidden" name="<?=$list['token'];?>" value="1">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                            <input type="hidden"  name="action" id="action" value="addSip">
                            <i class="fa fa-download"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->

<script>
    $(document).ready(function() {
        var $body = $('body');

        $('.menu-hidden').removeClass('hidden');

        var checkHost = $('#checkHost');

        checkHost.bind('change', function () {
            if ($(this).is(':checked'))

                $("#host").attr({
                    'disabled': 'disabled'
                });
            else
                $("#host").removeAttr('disabled');
        });

        $body.on('change', '[type="checkbox"]', function() {
            var val = $(this).data('val');

            if (val !== undefined) {
                $(this).val($(this).is(':checked') ? val : '0');
            } else {
                $(this).val($(this).is(':checked') ? '1' : '0');
            }
        });
    });
</script>
