<!--script-->
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function()
    {
        $('.menu-hidden').removeClass('hidden');
        $("body").delegate(".DSTOption","change", function()
        {
            var option = '#'+this.id;
            var subOption = "#"+this.id+"-1";
            var optionVal=$(option+' option:selected').val();

            $.ajax
            ({
                type:'POST',
                url:'dstOption.php?action=dstOptionIvr',
                data:{"DSTOption":optionVal},
                success: function (html)
                {
                    $(subOption).html(html);

                }
            });
        });
    });
</script>

<div class="content active">
  <div class="content-header">
    <h2 class="content-title"><i class="glyphicon glyphicon-user"></i><?php echo IVR_12 ?></h2>
  </div>
  <!--/content-header -->
  <div class="content-body">
    <div id="panel-tablesorter" class="panel panel-warning">
      <div class="panel-heading bg-white">
        <h3 class="panel-title"><?php echo IVR_12 ?></h3>
        <div class="panel-actions">
          <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="تمام صفحه"> <i class="fa fa-expand"></i> </button>
          <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="باز و بسته شدن"> <i class="fa fa-caret-down"></i> </button>
        </div>
        <!-- /panel-actions --> 
      </div>
      <!-- /panel-heading -->
      <?php if($msg!=null)
            { ?>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
        <?= $msg ?>
      </div>
      <?php
            }
            ?>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-8  center-block">
            <form name="IVR" id="IVR" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-4 pull-right control-label" for="Ivr_Name"><?php echo 'name' ?>:</label>
                    <div class="col-xs-12 col-sm-8 pull-right">
                      <input value= "<?php echo $list['name'] ?>" type="text" class="form-control" name="Ivr_Name" id="Ivr_Name" autocomplete="off" placeholder="<?php echo 'name' ?>" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row xsmallSpace hidden-xs">
                <select id="lang" class="lang" name="lang">
                  <option value="en">en</option>
                  <option>fa</option>
                </select>
              </div>
              <div class="row xsmallSpace hidden-xs"></div>
              <div class="row">
                <div class="form-group">
                  <label class="col-xs-12 col-sm-4 pull-right control-label" for="Invalid"><?php echo IVR_17 ?>:</label>
                </div>
              </div>
              
              <!--DstOption--> 
              
              <!--DstOption--><!--DstOption-->
              <div class="row jumbotron">
                <div class="col-xs-6 col-sm-6 col-md-6 ">
                  <div class="form-group">
                    <label for="hoursStart" class="col-xs-12 col-sm-4 pull-right control-label">از ساعت</label>
                    <div class="col-xs-12 col-sm-8 pull-right">
                      <input type="text" class="form-control" name="hoursStart[]" id="hoursStart" autocomplete="off" placeholder="<?php echo 'hoursStart'; ?>" value="" required data-show-meridian="false" data-template="dropdown" data-input="timepicker">
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 ">
                  <div class="form-group">
                    <label for="hoursStart" class="col-xs-12 col-sm-4 pull-right control-label">تا ساعت</label>
                    <div class="col-xs-12 col-sm-8 pull-right">
                      <input type="text" class="form-control" name="hoursEnd[]" id="hoursEnd" autocomplete="off" placeholder="<?php echo 'hours end'; ?>" value="" required data-show-meridian="false" data-template="dropdown" data-input="timepicker">
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 ">
                  <div class="form-group">
                    <label for="daysWeekStart1" class="col-xs-12 col-sm-4 pull-right control-label">روز های هفته از روز</label>
                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                      <select name="daysWeekStart[]" class="daysWeekStart select2" id="daysWeekStart1" required>
                        <option>Choose from list </option>
                        <?php foreach($list['daysWeekList'] as $key=>$value) {

                                                    ?>
                        <option <?php echo $value['value'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['value']?>">
                        <?=$value['label']?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 ">
                  <div class="form-group">
                    <label for="daysWeekStart1" class="col-xs-12 col-sm-4 pull-right control-label">تا روز</label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="daysWeekEnd[]" class="daysWeekStart select2" id="daysWeekEnd1" required>
                        <option>Choose from list </option>
                        <?php foreach($list['daysWeekList'] as $key=>$value) {

                                                    ?>
                        <option <?php echo $value['value'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['value']?>">
                        <?=$value['label']?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                  <div class="form-group">
                    <label for="daysMonthStart1" class="col-xs-12 col-sm-4 pull-right control-label">روز های ماه از روز</label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="daysMonthStart[]" class="daysMonthStart select2" id="daysMonthStart1" required>
                        <option>Choose from list</option>
                        <?php foreach($list['daysMonthList'] as $key=>$value) {

                                                    ?>
                        <option <?php echo $value == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value?>">
                        <?=$key;?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                  <div class="form-group">
                    <label for="daysMonthEnd1" class="col-xs-12 col-sm-4 pull-right control-label">تا روز</label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="daysMonthEnd[]" class="daysMonthEnd select2" id="daysMonthEnd1" required>
                        <option>Choose from list</option>
                        <?php foreach($list['daysMonthList'] as $key=>$value) {

                                                    ?>
                        <option <?php echo $value == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value?>">
                        <?=$key;?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                  <div class="form-group">
                    <label for="monthStart1" class="col-xs-12 col-sm-4 pull-right control-label">ماه های سال از ماه </label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="monthStart[]" class="monthStart select2" id="monthStart1" required>
                        <option>Choose from list</option>
                        <?php foreach($list['monthList'] as $key=>$value) {
                                                    ?>
                        <option <?php echo $value['value'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['value']?>">
                        <?=$value['label']?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ">
                  <div class="form-group">
                    <label for="daysWeekStart1" class="col-xs-12 col-sm-4 pull-right control-label">تا ماه</label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="monthEnd[]" class="monthEnd select2" id="monthEnd1" required>
                        <option>Choose from list</option>
                        <?php foreach($list['monthList'] as $key=>$value) {
                                                    ?>
                        <option <?php echo $value['value'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['value']?>">
                        <?=$value['label']?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
<div class="col-xs-12 col-sm-12 col-md-6 ">
                  <div class="form-group">
                    <label for="daysWeekStart1" class="col-xs-12 col-sm-4 pull-right control-label">مقصد درصورت تطابقزمانی</label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="monthEnd[]" class="monthEnd select2" id="monthEnd1" required>
                        <option>Choose from list</option>
                        <?php foreach($list['monthList'] as $key=>$value) {
                                                    ?>
                        <option <?php echo $value['value'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['value']?>">
                        <?=$value['label']?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>  
<div class="col-xs-12 col-sm-12 col-md-6 ">
                  <div class="form-group">
                    <label for="daysWeekStart1" class="col-xs-12 col-sm-4 pull-right control-label">مقصد درصورت عدم تطابق زمانی</label>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <select name="monthEnd[]" class="monthEnd select2" id="monthEnd1" required>
                        <option>Choose from list</option>
                        <?php foreach($list['monthList'] as $key=>$value) {
                                                    ?>
                        <option <?php echo $value['value'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['value']?>">
                        <?=$value['label']?>
                        </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>                              
              </div>
              <div class="appendDST"> </div>
              
              <!--subDstOption-->
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                  <ul class="push-to-bottom plus-outbound">
                    <li><i class="fa fa-plus-circle fa-2x"></i></li>
                    <li><i class="fa fa-minus-circle fa-2x"></i></li>
                  </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6"> </div>
              </div>
              <div class="row xsmallSpace hidden-xs"></div>
              <div class="row">
                <div class="col-md-12">
                  <p class="pull-right">
                    <button type="submit" id="submit" class="btn btn-icon btn-success">
                    <input type="hidden" name="action" id="action" value="addIvr">
                    <i class="fa fa-plus"></i> <?php echo IVR_20 ?>
                    </button>
                  </p>
                </div>
              </div>
              <input TYPE="hidden" NAME="<?=$list['token'];?>" VALUE="1" >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/content --> 

<script>
    $(function () {
        var $body = $('body');
        $(".fa.fa-plus-circle").bind("click", function () {
            var htmlStream = "";
            var counter = $(".jumbotron select[name='DSTOption[]']").length +2;
            if (counter < 100) {
                htmlStream += '<div class="row jumbotron" data-target=' + (counter + 1) + '>';
                htmlStream += '<div class="col-xs-12 col-sm-12 col-md-3 ">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<input type="text" class="form-control" name="IVRExtension[]" id="IVRExtension" autocomplete="off" placeholder="IVRExtension" value="" required>';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '<div class="col-xs-12 col-sm-12 col-md-3 ">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<select data-input="select2" class="DSTOption"  name="DSTOption[]" id="DSTOption' + (counter + 1) + '"> <option>Choose from list</option>';
                <?php foreach($list['DSTList'] as $key=>$value)
                {
                ?>
                htmlStream+=' <option <?php echo $value['DstOptionID'] == $list['DSTOption'] ? 'selected' : '' ?> value="<?=$value['DstOptionID']?>"><?=$value['OptionValue']?></option>';
                <?php
                }
                ?>
                htmlStream+='</select>';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '<div class="col-xs-12 col-sm-12 col-md-3">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<div class="col-xs-12 col-sm-12 pull-right" name="subDstOption[]" id="DSTOption' + (counter + 1) + '-1">';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '</div>';
                htmlStream += '<div class="col-xs-12 col-sm-12 col-md-3 ">';
                htmlStream += '<div class="form-group">';
                htmlStream += '<input type="text" class="form-control" name="Description[]" id="Description" autocomplete="off" placeholder="<?php echo IVR_18?>" value="">';
                htmlStream += '</div>';
                htmlStream += '</div>';
            }

            $('.appendDST').append(htmlStream);
            $('[data-input="select2"]').select2();
            $('select').each(function(){
                $(this).select2();
            })
        });

        $body.on('click', '.fa.fa-minus-circle', function (e)
        {
            e.preventDefault();
            var counter = $(".jumbotron select[name='DSTOption[]']").length +2;
            if (counter > 0) {
                $('.row[data-target="' + counter + '"]').remove();
            }
        });

        ////////////////////////lang/////////////////////////////



        var monthFa="";
        <?php foreach($list['daysWeekList'] as $key=>$value)
         {
         ?>
            monthFa+='<option <?php echo $value['value']?> value="<?=$value['value']?>"><?=$key;?> </option>';
        <?php
        }
        ?>

        $("#lang").change(function(){
            lang=$("#lang option:selected").val();
            $('.lang').html(monthFa);
            alert(lang);
        })



    });
</script> 
