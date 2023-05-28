<!--script-->
<script type="text/javascript" language="javascript" class="init">

    $(function()
    {

        var DSTOption = $('#adsPeriodInput1');
        $('body').on('change','.selectbox',function()

        {

            inputBoxName = $(this).attr("id");


            $.ajax
            ({
                type:'POST',
                url:'test.php?action=dstOption',
                data:{"DSTOption":DSTOption.val()},
                success: function (html)
                {
                    divname=inputBoxName+'div';
                    $('.inputBoxName').html(html);
                }
            });
        });
    });
</script>
<!--advertisement panel-->
<div class="panel panel-success">
    <!-- /panel-heading -->
    <div class="row xsmallSpace"></div>
    <div class="jumbotron col-sm-6">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="adsPeriodInput1">dstOption
                        : </label>

                    <div class="col-sm-8">
                        <select class="form-control selectbox" name="adsPeriod[]" id="adsPeriodInput1" required>
                            <option value="Peer">Peer</option>
                            <option value="Friend">Friend</option>
                        </select>
                    </div>
                </div>
                <!-- /form-group -->
            </div>
            <div class="appendAdsPeriod">

            </div>
        </div>

        <ul class="pull-left push-to-bottom">
            <a><i class="fa fa-plus-circle fa-2x"></i></a>
            <a><i class="fa fa-minus-circle fa-2x"></i></a>
        </ul>

    </div>
</div>
</div>

<script>
    $(function () {
        var $body = $('body');

        $(".fa.fa-plus-circle").bind("click", function () {
            var htmlStream = "";
            counter = $(".jumbotron select[name='adsPeriod[]']").length;
            if (counter < 10) {



                htmlStream += '<div class="row" data-target=' + (counter + 1) + '>';
                htmlStream += '<div class="form-group">';
                htmlStream+='<br/>';
                htmlStream += '<label class="col-sm-2 control-label" for="adsPeriodInput' + (counter + 1) + '">dstoption: </label>';
                htmlStream += '<div class="col-sm-8">';
                htmlStream+='<br/>';
                htmlStream += '<select class="form-control selectbox"  name="adsPeriod[]" id="adsPeriodInput' + (counter + 1) + '">';
                htmlStream+='<option value="Peer">Peer</option>';
                htmlStream+='<option value="Friend">Friend</option>';
                htmlStream+='</select>';

                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '</div>';

            }

            $('.appendAdsPeriod').append(htmlStream);
        });

        $body.on('click', '.fa.fa-minus-circle', function (e)
        {
            e.preventDefault();
            var counter = $(".jumbotron select[name='adsPeriod[]']").length;
            if (counter > 1) {
                $('.row[data-target="' + counter + '"]').remove();
            }
        });

        $('#registerService').bind('click', function (e) {
            e.preventDefault();
            $('#add_service_form').submit();
        });

        $body.on('click', '.controlNav li a[data-role="minus"]', function (e) {
            e.preventDefault();
            var counter = $('select[name="dayTimeWeek[][select]"]').length;
            if (counter > 1) {
                $('.row[data-target="' + counter + '"]').remove();
            }
        });
    });

</script>