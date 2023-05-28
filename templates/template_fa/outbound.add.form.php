<style type="text/css">
    .custom-grid {
        padding-left: 30px;
        padding-right: 30px;
    }
    .prepend:before, .prepend:after,
    .prefix:before, .prefix:after,
    .match-pattern:before, .match-pattern:after,
    .caller-id:before, .caller-id:after {
        position: absolute;
        font-size: 1.5em;
        top: 0;
        color: #000;
    }

    .prepend:before {
        color: #5BB75B;
        content: '(' !important;
        left: 0;
    }

    .prepend:after {
        color: #5BB75B;
        content: ')' !important;
        right: 0;
    }

    .prefix:before {
        content: '+' !important;
        left: -15px;
    }

    .prefix:after {
        content: '|' !important;
        right: -8px;
        font-size: 1.8em !important;
    }


    .match-pattern:before {
        color: #5BB75B;
        content: '[' !important;
        left: 0;
    }

    .match-pattern:after {
        content: '/' !important;
        right: -15px;
    }

    .caller-id:after {
        color: #5BB75B;
        content: ']' !important;
        right: -5px;
    }
</style>

<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>outbound.php?action=showOutbound">
                    <?=OUTBOUND_10?>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <!--/content-header -->
    <div class="content-body contentOutbound">
        <form name="outbound" id="outbound" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=OUTBOUND_14?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?= COLLAPSE ?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->

                <?php if ($msg != null) { ?>
                    <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                        <?= $msg ?>
                    </div>
                <?php } ?>
                <div class="panel-body">
                    <!--outbound-->
                    <div class="row margin-bottom">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-4 col-md-5 pull-left control-label" for="name"><?=OUTBOUND_11?>:</label>
                                <div class="col-xs-12 col-sm-8 col-md-7 pull-left">
                                    <input value="<?=$list['outbound_name']?>" type="text" class="form-control" name="outbound_name" id="outbound_name" autocomplete="off" placeholder="<?=OUTBOUND_11?>" required tabindex="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <label class="col-xs-12 col-sm-4 col-md-4 pull-left control-label" for="name"><?=OUTBOUND_19?>:</label>
                            <div class="col-xs-12 col-sm-4 col-md-4 pull-left margin-bottom-half">
                                <input type="text" class="form-control" value="<?=$list['outboundInfo']['caller_id_name'];?>" name="caller_id_name" id="outbound_name" autocomplete="off" placeholder="<?=OUTBOUND_20?>" tabindex="2">
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 pull-left">
                                <input type="text" class="form-control" value="<?=$list['outboundInfo']['caller_id_number'];?>" name="caller_id_number" id="outbound_name" autocomplete="off" placeholder="<?=OUTBOUND_21?>" tabindex="3">
                            </div>
                        </div>
                    </div>

                    <div class="row xsmallSpace"></div>
                    <!--menu-->

                    <div class="row destination-holder pull-left no-margin pos-rel" style="max-width: 1000px;">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                    <div class="form-group prepend pos-rel">
                                        <input type="text" class="form-control" name="prepend[]" id="prepend[]" autocomplete="off" placeholder="<?=OUTBOUND_12?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                    <div class="form-group prefix pos-rel">
                                        <input type="text" class="form-control" name="prefix[]" id="prefix[]" autocomplete="off" placeholder="<?=OUTBOUND_13?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                    <div class="form-group match-pattern pos-rel">
                                        <input type="text" class="form-control" name="match_pattern[]" id="match_pattern[]" autocomplete="off" required placeholder="<?=OUTBOUND_15?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                    <div class="form-group caller-id pos-rel">
                                        <input type="text" class="form-control" name="caller_id[]" id="caller_id[]" autocomplete="off" placeholder="<?=OUTBOUND_19?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic generate menu -->
                    <div class="appendAdsPeriod" style="margin-top:10px;"></div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <ul class="pull-left push-to-bottom plus-outbound no-padding" style="margin-top:10px;">
                                <li>
                                    <button type="button" class="clone-condition btn btn-primary btn-icon">
                                        <i class="fa fa-plus"></i><?= OUTBOUND_22?>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row xsmallSpace hidden-xs"></div>
                    <!-- icon + and - btn -->

                    <!-- sip_id -->
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-2 pull-left control-label" for="DSTOption"><?=OUTBOUND_16?>:</label>
                                <div class="col-xs-12 col-md-8 pull-left">

                                    <select class="valid select2" name="sip_id" id="sip_id" required >
                                        <?php foreach($list['sipList'] as $key=>$value) { ?>
                                            <option <?php if($value['sip_id'] == $list['outboundInfo']['siptrunk_id']) echo 'selected';?> value="<?=$value['sip_id']?>"><?=$value['sip_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-2 pull-left control-label" for="priority"><?=OUTBOUND_17?>:</label>
                                <div class="col-xs-12 col-md-8 pull-left">

                                    <!--<input value="<?/*=$list['outboundInfo']['priority']*/?>" type="text" class="form-control" name="priority" id="outbound_name" autocomplete="off" placeholder="<?/*=OUTBOUND_17*/?>" required>-->
                                    <select class="valid select2" name="priority" id="priority" required >
                                        <?php foreach ($list['priority'] as $key => $value){ ?>
                                            <option  value="<?=$value['priorityNum'] ?>"
                                                <?=($value['isUsed']=="1" ? 'disabled' : '')?>>
                                                <?= ($value['isUsed']=="1" ? $value['priorityNum'].' - used by '.$value['usedBy'] : $value['priorityNum'])?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- addOutbound -->
                    <input TYPE="hidden" NAME="<?=$list['token'];?>" VALUE="1" >
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <button type="submit" name="add" id="submit" class="btn btn-icon btn-success">
                            <i class="fa fa-download"></i>Submit
                            <input type="hidden" name="action" id="action" value="addOutbound">
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->

<script>

    $(function () {
        var $body = $('body');

        $('.clone-condition').on('click', function () {
            var htmlStream = "";
            var counter = $('.row input[name="caller_id[]"]').length;

            if (counter < 10) {
                htmlStream = '' +
                '<div class="row destination-holder pull-left no-margin pos-rel" style="max-width: 1000px;" data-target="' + (counter + 1) + '">' +
                    '<div class="col-xs-6 col-sm-6 col-md-6">' +
                        '<div class="row">' +
                            '<div class="col-xs-12 col-sm-6 col-md-6 custom-grid">' +
                                '<div class="form-group prepend pos-rel">' +
                                    '<input type="text" class="form-control" name="prepend[]" id="prepend[]" autocomplete="off" placeholder="<?=OUTBOUND_12?>" >' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-xs-12 col-sm-6 col-md-6 custom-grid">' +
                                '<div class="form-group prefix pos-rel">' +
                                    '<input type="text" class="form-control" name="prefix[]" id="prefix[]" autocomplete="off" placeholder="<?=OUTBOUND_13?>" >' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-6 col-sm-6 col-md-6">' +
                        '<div class="row">' +
                            '<div class="col-xs-12 col-sm-6 col-md-6 custom-grid">' +
                                '<div class="form-group match-pattern pos-rel">' +
                                    '<input type="text" class="form-control" name="match_pattern[]" id="match_pattern[]" autocomplete="off" required placeholder="<?=OUTBOUND_15?>" >' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-xs-12 col-sm-6 col-md-6 custom-grid">' +
                                '<div class="form-group caller-id pos-rel">' +
                                    '<input type="text" class="form-control" name="caller_id[]" id="caller_id[]" autocomplete="off" placeholder="<?=OUTBOUND_19?>" >' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<a class="delete-condition" style="position:absolute; top:8px;left: -10px;float: right;"><i class="fa fa-trash text-red text-18"></i></a>' +
                '</div>';
            }

            $('.appendAdsPeriod').append(htmlStream);
        });

        $body.on('click', '.delete-condition', function (e) {
            e.preventDefault();

            $(this).parent().remove();
        });
    });

</script>

<style type="text/css">
    @media screen and (max-width: 768px) {
        .destination-holder {
            border: solid 1px #dadada;
            border-radius: 5px;
            margin-bottom: 2em !important;
            padding: 1em;
        }
        .destination-holder .delete-condition {
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