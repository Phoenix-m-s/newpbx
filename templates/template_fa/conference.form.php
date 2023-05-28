<style type="text/css">
    .display-flex {
        display: flex;
    }

    .flex-space-between {
        justify-content: space-between
    }

    .flex-center {
        display: flex;
        align-items: center;
        justify-content: center
    }

    .extension-container {
        width: 600px;
        height: 400px;
    }

    .extension-added, .extension-list {
        border: solid 1px #e1e1e1;
        background-color: #F5F5F5;
        width: 45%;
        height: 100%;
        overflow: hidden;
    }

    .extension-container header {
        height: 40px;
        line-height: 40px;
        background-color: #FFF;
        border-bottom: solid 1px #e1e1e1;
    }

    .extension-container .list-content {
        height: calc(100% - 40px);
    }

    .extension-container ul {
        padding: 0;
        margin: 0;
        height: 100%;
        list-style: none;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .extension-container ul li {
        height: 35px;
        position: relative;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .extension-container ul li .remove-item {
        background: none;
        border: 0;
        position: absolute;
        right: -30px;
        top: 5px;
        -webkit-transition: all .3s;
        -moz-transition: all .3s;
        -ms-transition: all .3s;
        -o-transition: all .3s;
        transition: all .3s;
    }

    .extension-container ul li a {
        display: block;
        width: 100%;
        height: 100%;
        color: #3079b9;
        padding: .5em;
        text-decoration: none;
        -webkit-transition: .3s all;
        -moz-transition: .3s all;
        -ms-transition: .3s all;
        -o-transition: .3s all;
        transition: .3s all;
    }

    .extension-container ul li:hover a {
        color: #f46b2b;
        padding-left: 1em;
        font-weight: bold;
    }

    .extension-container ul li:hover .remove-item {
        right: 0;
    }

    .extension-container ul li:not(:last-child) {
        border-bottom: solid 1px #e1e1e1;
    }

    .extension-added ul {
        height: calc(100% - 50px);
    }

    .extension-added .external-number {
        height: 50px;
        padding: .5em;
    }

    .extension-container .cursor-pointer {
        cursor: pointer;
    }

    .text-light-gray {
        color: #999;
    }
</style>
<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?= RELA_DIR ?>conference.php?action=showConference"></a>
            </li>
        </ul><!--/control-nav-->
    </div>

    <div class="content-body">
        <form name="conference" id="conference" role="form" data-validate="form" class="form-horizontal form-bordered"
              autocomplete="off" novalidate="novalidate" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Conference_02 ?></h3>
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 center-block no-bg">
                            <div class="normal-data">
                                <input name="conf_id" id="conf_id" type="hidden" value="<?= $list['conf_id']; ?>">
                                <input type="hidden" name="action" id="action" value="update">

                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="conf_name"><?= Conference_04 ?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="conf_name"
                                                       id="conf_name" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="conf_number"><?= Conference_05 ?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="conf_number"
                                                       id="conf_number" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hidden-xs"></div>

                                <!--<div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="extention_id"><?/*= Conference_06 */?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <select class="select2" name="extention_id" id="extention_id"
                                                        multiple="multiple">
                                                </select>
                                            </div>
                                        </div>
                                    </div>-->



<!--    **********************  Invitation Phone ********************** -->

                                   <!--<div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="phone_number"><?/*= Conference_07 */?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input class="select2" id="phone_number" type="text" name="phone_number" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="extension-selection-container">
                                        <div class="extension-temp"></div>

                                        <div class="selected-extensions">

                                        </div>
                                    </div>
                                </div>-->

                                <div class="row">
                                    <!--Password-->
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="pass"><?=SIP_15?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="password" class="form-control" name="password" id="password" autocomplete="off" placeholder="<?=SIP_15?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row xsmallSpace hidden-xs"></div>

                                <div class="row no-margin">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="all_extension_list" id="all_extension_list"
                                                           type="checkbox">
                                                    <?= Conference_08 ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hidden-xs"></div>

                                <div class="row no-margin extension-container-holder">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <label class="control-label"><?=Conference_09?>:</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="extension-container display-flex flex-space-between">
                                            <div class="extension-list img-rounded">
                                                <header class="text-center">Available Extensions</header>

                                                <div class="list-content">
                                                    <ul></ul>
                                                </div>
                                            </div>

                                            <span class="display-flex flex-center"><i class="fa fa-exchange"></i></span>

                                            <div class="extension-added img-rounded">
                                                <header class="text-center">Added Extensions</header>

                                                <div class="list-content">
                                                    <ul></ul>

                                                    <div class="external-number">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control external-number-input" placeholder="Add Invitation number">
                                                            <span class="input-group-btn">
                                                            <button class="btn btn-success appendToAddedExtensionList" type="button"><i class="fa fa-arrow-up"></i></button>
                                                        </span>
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

            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <input type="hidden" name="comp_id" value="0">

                        <button type="submit" class="btn btn-success btn-icon">
                            <i class="fa fa-download"></i>Submit
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div><!--/content -->

    <script type="text/javascript">
        $(function () {
            let $body = $('body'),
                result = JSON.parse('<?php echo json_encode(json_decode($list)); ?>');
                console.log(result);
            console.log(result);

            //!************************* Invitation Phone *******************************
            $("#phone_number").select2({
                tags: [],
                maximumInputLength: 1000
            });
            //
            getList({
                el: $body.find('[name="phone_number"]'),
                // list: result['phoneList_selected'],
                // itemVal: result['phoneList_selected'],
                id: 'id',
                name: 'name'
            }).then(function () {
                $body.find('[name="phone_number"]').val(result['phoneList_selected']).trigger('change');
            });

            // change title and action of form by action in json object
            $body.find('.control-nav a').text(result['action'] === 'editConference' ? '<?=Conference_03?>' :
                '<?=Conference_02?>');

            // fill voice fill (upload_id) select box
            getList({
                el: $body.find('[name="extention_id"]'),
                list: result['extentionList'],
                itemVal: result['extentionList_selected'],
                id: 'id',
                name: 'name'
            }).then(function () {
                $body.find('[name="extention_id"]').val(result['extentionList_selected']).trigger('change');
            });

            // fill all inputs values
            $('.normal-data').find('[name]').each(function () {
                let itemVal = result[$(this).attr('name')];

                if ($(this).prop('type') === 'checkbox') {
                    $(this).val(itemVal).prop('checked', parseInt(itemVal));
                    let $extensionContainerHolder = $('.extension-container-holder');

                    if (parseInt(itemVal)) {
                        $extensionContainerHolder.addClass('hidden');
                    } else {
                        $extensionContainerHolder.removeClass('hidden');
                    }
                } else {
                    $(this).val(itemVal).trigger('change');
                }
            });

            function getList(obj) {
                return new Promise(function (resolve) {
                    try {
                        if (obj.el.prop('tagName') === 'SELECT') {
                            let html = '';

                            if (obj.list.length) {
                                $.each(obj.list, function (i, v) {
                                    html += '<option ' + (v[obj.id] === obj.itemVal ? 'selected' : '') + ' value="' + v[obj.id] + '">' + v[obj.name] + '</option>';
                                });

                                obj.el.html(html).trigger('change');

                            } else {
                                obj.el.val(obj.itemVal).trigger('change');
                            }
                        } else {
                            obj.el.val(obj.itemVal);
                        }

                        resolve(true);
                    } catch (e) {
                        console.log('error in put list in ', obj.el, e);
                    }
                });
            }

            // submit form
            $('#conference').on('submit', function (e) {
                e.preventDefault();

                let $allExtensionList = $('#all_extension_list'),
                    cnt = 0,
                    data = {};

                try {
                    $('.normal-data').find('[name]').each(function () {
                        if ($(this).prop('required') && !$(this).val().length) {
                            if (!$(this).prop('disabled')) {
                                cnt++;
                            }
                        }

                        if ($(this).prop('type') === 'checkbox') {
                            data[$(this).attr('name')] = $(this).prop('checked') ? '1' : '0'
                        } else {
                            data[$(this).attr('name')] = $(this).val() && $(this).val().length ? $(this).val() : ''
                        }
                    });

                    if (addedExtensionList.length && !$allExtensionList.is(':checked')) {
                        const extensionItems = [];
                        const externalItems = [];
                        $.each(addedExtensionList, function(index, item) {
                            if (item.type === 0) { // 0 means usual extension
                                extensionItems.push(item.id.toString());
                            } else if (item.type === 1) { // 1 means invitation numbers
                                externalItems.push(item.id.toString());
                            }
                        });

                        data['extention_id'] = extensionItems;
                        data['phone_number'] = externalItems.join(',');
                    } else if ($allExtensionList.is(':checked')) {
                        data['extention_id'] = [];
                        data['phone_number'] = '';
                    }

                    if (cnt) {
                        swal({
                            title: '',
                            html: "Please fill required items",
                            type: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonClass: 'btn btn-warning btn-block'
                        });
                    } else {
                        $.httpRequest("conference.php?action=" + result['action'], 'post', data)
                            .then(function (response) {
                                let result = JSON.parse(response);

                                swal({
                                    title: '',
                                    html: result.msg,
                                    type: result.result === 1 ? 'success' : 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn ' + (result.result === 1 ? 'btn-success' : 'btn-danger') + ' btn-block'
                                }).then(function () {
                                    if (result.result === 1) {
                                        window.location.replace('<?php echo RELA_DIR; ?>conference.php');
                                    }
                                });
                            });
                    }
                } catch (e) {
                    console.log('error in sending form: ', e);
                }
            });

            $body.on('change', '[name="all_extension_list"]', function() {
                let $extensionId = $('#extention_id'),
                    $phoneNumber = $('#phone_number'),
                    $extensionContainerHolder = $('.extension-container-holder');

                let checked = $(this).is(':checked');

                $extensionId.prop('disabled', checked);
                $phoneNumber.prop('disabled', checked);

                if (checked) {
                    $extensionContainerHolder.addClass('hidden');
                } else {
                    $extensionContainerHolder.removeClass('hidden');
                }
            });

            let extensionList = result.extentionList && result.extentionList.length ? result.extentionList : [];
            let addedExtensionList = [];

            // add default extensions number from api to extension list
            if (extensionList.length) {
                $.each(extensionList, function (index, item) {
                    let html = `<li>
                                <a data-type="add"
                                   data-external-number="0" data-extension-type="${item.type}"
                                   data-extension-id="${item.id}" data-extension-name="${item.name}"
                                   class="cursor-pointer">
                                    ${item.name}
                                </a>

                                <button class="remove-item text-success" type="button"><i class="fa fa-plus"></i></button>
                            </li>`;

                    $('.extension-list .list-content ul').append(html);
                });
            }

            // if extension list selected is not undefined and has some items, include them into added extension list
            if (result.extentionList_selected && result.extentionList_selected.length) {
                $.each(result.extentionList_selected, function (index, item) {
                    const findItem = result.extentionList.filter(function(extItem) {
                        return extItem.id === item;
                    }).pop();

                    if (!findItem) {return;}

                    const findItemAdded = extensionList.filter(function(extItem) {
                        return extItem.id === item;
                    }).pop();

                    const findItemAddedIndex = extensionList.findIndex(function(extItem) {
                        return extItem.id === item;
                    });

                    if (findItemAddedIndex !== -1) {
                        extensionList.splice(findItemAddedIndex, 1);

                        $('.extension-list .list-content ul li a[data-extension-id="'+findItemAdded.id+'"]').parent().remove();
                    }

                    let html = `<li>
                                <a data-type="remove"
                                   data-external-number="0" data-extension-type="0"
                                   data-extension-id="${findItem.id}" data-extension-name="${findItem.name}"
                                   class="cursor-pointer">
                                    ${findItem.name}
                                </a>

                                <button class="remove-item text-danger" type="button"><i class="fa fa-times"></i></button>
                            </li>`;

                    $('.extension-added .list-content ul').append(html);

                    addedExtensionList.push({
                        id: findItem.id,
                        name: findItem.name,
                        type: 0
                    });
                });
            }

            // if phoneList selected is not undefined and has some items, include them into added extension list
            if (result.phoneList_selected && result.phoneList_selected.length) {
                $.each(result.phoneList_selected, function (index, item) {
                    let html = `<li>
                                <a data-type="remove"
                                   data-external-number="1" data-extension-type="0"
                                   data-extension-id="${item}" data-extension-name="${item}"
                                   class="cursor-pointer">
                                    ${item}
                                </a>

                                <button class="remove-item text-danger" type="button"><i class="fa fa-times"></i></button>
                            </li>`;

                    $('.extension-added .list-content ul').append(html);

                    addedExtensionList.push({
                        id: item,
                        name: item,
                        type: 1
                    });
                });
            }

            $body.on('click', '.list-content a', function () {
                let type = $(this).data('type'),
                    externalNumber = $(this).data('externalNumber'),
                    parent = $(this).parent(),
                    extensionListContainer = $('.extension-list .list-content ul'),
                    addedExtensionContainer = $('.extension-added .list-content ul'),
                    extensionId = $(this).data('extensionId'),
                    extensionType = $(this).data('extensionType'),
                    extensionName = $(this).data('extensionName');

                let html = `<li>
                                <a data-type="${type === 'add' ? 'remove' : 'add'}"
                                   data-external-number="0" data-extension-type="${extensionType}"
                                   data-extension-id="${extensionId}" data-extension-name="${extensionName}"
                                   class="cursor-pointer">
                                    ${extensionName}
                                </a>

                                <button class="remove-item text-${type === 'add' ? 'danger' : 'success'}" type="button">
                                    <i class="fa fa-${type === 'add' ? 'times' : 'plus'}"></i>
                                </button>
                            </li>`;

                if (type === 'add') {
                    const extIndex = extensionList.findIndex(function(item) {
                        return item.id === extensionId.toString();
                    });

                    const removedItem = extensionList.splice(extIndex, 1);

                    addedExtensionList.push(removedItem.pop());

                    addedExtensionContainer.append(html);
                } else if (type === 'remove') {
                    const extIndex = addedExtensionList.findIndex(function(item) {
                        return item.id === extensionId.toString();
                    });

                    const removedItem = addedExtensionList.splice(extIndex, 1);

                    if (!externalNumber) {
                        extensionList.push(removedItem.pop());

                        extensionListContainer.append(html);
                    }
                }

                parent.remove();
            });

            $body.on('keyup', '.external-number input', function (e) {
                let code = e.which ? e.which : e.keyCode,
                    value = $(this).val(),
                    addedExtensionContainer = $('.extension-added .list-content ul');

                let html = `<li>
                                <a data-type="remove"
                                   data-external-number="1"
                                   data-extension-id="${value}"
                                   data-extension-name="${value}"
                                   data-extension-type="1"
                                   class="cursor-pointer">
                                    ${value}
                                </a>

                                <button class="remove-item text-danger" type="button"><i class="fa fa-times"></i></button>
                            </li>`;

                if (value.length > 1 && code === 13) {
                    const extIndex = addedExtensionList.findIndex(function(item) {
                        return item.id === value.toString();
                    });

                    if (extIndex === -1) {
                        addedExtensionList.push({
                            name: value,
                            id: value,
                            type: 1
                        });

                        addedExtensionContainer.append(html);
                    }

                    $(this).val('');
                }
            });

            $body.on('click', '.appendToAddedExtensionList', function (e) {
                let $valueInput = $body.find('.external-number-input'),
                    value = $valueInput.val(),
                    addedExtensionContainer = $('.extension-added .list-content ul');

                let html = `<li>
                                <a data-type="remove"
                                   data-external-number="1"
                                   data-extension-id="${value}"
                                   data-extension-name="${value}"
                                   data-extension-type="1"
                                   class="cursor-pointer">
                                    ${value}
                                </a>

                                <button class="remove-item text-danger" type="button"><i class="fa fa-times"></i></button>
                            </li>`;

                if (value.length > 1) {
                    const extIndex = addedExtensionList.findIndex(function(item) {
                        return item.id === value.toString();
                    });

                    if (extIndex === -1) {
                        addedExtensionList.push({
                            name: value,
                            id: value,
                            type: 1
                        });

                        addedExtensionContainer.append(html);
                    }

                    $valueInput.val('').focus();
                }
            });

            $body.on('click', '.remove-item', function(e) {
                e.preventDefault();

                $(this).prev().trigger('click');
            });

            $(document).on("keypress", 'form', function (e) {
                let code = e.keyCode || e.which;

                if (code === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>