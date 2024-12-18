<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('.company-child').addClass('active');
    });
</script>

<div class="content active">
    <!--<div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php /*echo COMPANY_11 */?></h2>
    </div>--><!--/content-header -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">  company add
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo COMPANY_11 ?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->
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
                    <div class="col-xs-12 col-sm-12 col-md-12 center-block">

                        <form name="addCompany" id="addCompany" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Comp_Name"><?php echo COMPANY_04 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Comp_Name" id="Comp_Name" autocomplete="off" placeholder="<?php echo COMPANY_04 ?>" value="<?=$list['Comp_Name'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="ManagerName"><?php echo COMPANY_05 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Manager_Name" id="Manager_Name" autocomplete="off" placeholder="<?php echo COMPANY_05 ?>" value="<?=$list['Manager_Name'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Address"><?php echo COMPANY_06 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Address" id="Address" autocomplete="off" placeholder="<?php echo COMPANY_06 ?>" value="<?=$list['Address'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Email"><?php echo COMPANY_08 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Email" id="Email" autocomplete="off" placeholder="<?php echo COMPANY_08 ?>" value="<?=$list['Email'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Phone_Number"><?php echo COMPANY_07 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="Phone_Number" id="Phone_Number" autocomplete="off" placeholder="<?php echo COMPANY_07 ?>" value="<?=$list['Phone_Number'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <!--<div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Admin">Admin:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="Admin" name="Admin" type="checkbox"> Admin
                                                </label>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>

                            <!-- timezone Field -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="Timezone"><?php echo "Time Zone"; ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="form-control" name="timezone" id="timezone" required>
                                                <option value="UTC" <?php echo ($list['timezone'] == 'UTC') ? 'selected' : ''; ?>>UTC</option>
                                                <option value="Africa/Abidjan" <?php echo ($list['timezone'] == 'Africa/Abidjan') ? 'selected' : ''; ?>>Africa/Abidjan</option>
                                                <option value="Africa/Accra" <?php echo ($list['timezone'] == 'Africa/Accra') ? 'selected' : ''; ?>>Africa/Accra</option>
                                                <option value="Africa/Addis_Ababa" <?php echo ($list['timezone'] == 'Africa/Addis_Ababa') ? 'selected' : ''; ?>>Africa/Addis_Ababa</option>
                                                <option value="Africa/Algiers" <?php echo ($list['timezone'] == 'Africa/Algiers') ? 'selected' : ''; ?>>Africa/Algiers</option>
                                                <option value="Africa/Cairo" <?php echo ($list['timezone'] == 'Africa/Cairo') ? 'selected' : ''; ?>>Africa/Cairo</option>
                                                <option value="Africa/Nairobi" <?php echo ($list['timezone'] == 'Africa/Nairobi') ? 'selected' : ''; ?>>Africa/Nairobi</option>
                                                <option value="America/New_York" <?php echo ($list['timezone'] == 'America/New_York') ? 'selected' : ''; ?>>America/New_York</option>
                                                <option value="America/Los_Angeles" <?php echo ($list['timezone'] == 'America/Los_Angeles') ? 'selected' : ''; ?>>America/Los_Angeles</option>
                                                <option value="America/Chicago" <?php echo ($list['timezone'] == 'America/Chicago') ? 'selected' : ''; ?>>America/Chicago</option>
                                                <option value="America/Denver" <?php echo ($list['timezone'] == 'America/Denver') ? 'selected' : ''; ?>>America/Denver</option>
                                                <option value="America/Mexico_City" <?php echo ($list['timezone'] == 'America/Mexico_City') ? 'selected' : ''; ?>>America/Mexico_City</option>
                                                <option value="America/Sao_Paulo" <?php echo ($list['timezone'] == 'America/Sao_Paulo') ? 'selected' : ''; ?>>America/Sao_Paulo</option>
                                                <option value="Asia/Kolkata" <?php echo ($list['timezone'] == 'Asia/Kolkata') ? 'selected' : ''; ?>>Asia/Kolkata</option>
                                                <option value="Asia/Tehran" <?php echo ($list['timezone'] == 'Asia/Tehran') ? 'selected' : ''; ?>>Asia/Tehran</option>
                                                <option value="Asia/Dubai" <?php echo ($list['timezone'] == 'Asia/Dubai') ? 'selected' : ''; ?>>Asia/Dubai</option>
                                                <option value="Asia/Tokyo" <?php echo ($list['timezone'] == 'Asia/Tokyo') ? 'selected' : ''; ?>>Asia/Tokyo</option>
                                                <option value="Asia/Singapore" <?php echo ($list['timezone'] == 'Asia/Singapore') ? 'selected' : ''; ?>>Asia/Singapore</option>
                                                <option value="Europe/London" <?php echo ($list['timezone'] == 'Europe/London') ? 'selected' : ''; ?>>Europe/London</option>
                                                <option value="Europe/Paris" <?php echo ($list['timezone'] == 'Europe/Paris') ? 'selected' : ''; ?>>Europe/Paris</option>
                                                <option value="Europe/Berlin" <?php echo ($list['timezone'] == 'Europe/Berlin') ? 'selected' : ''; ?>>Europe/Berlin</option>
                                                <option value="Europe/Moscow" <?php echo ($list['timezone'] == 'Europe/Moscow') ? 'selected' : ''; ?>>Europe/Moscow</option>
                                                <option value="Europe/Istanbul" <?php echo ($list['timezone'] == 'Europe/Istanbul') ? 'selected' : ''; ?>>Europe/Istanbul</option>
                                                <option value="Europe/Stockholm" <?php echo ($list['timezone'] == 'Europe/Stockholm') ? 'selected' : ''; ?>>Europe/Stockholm</option>
                                                <option value="Europe/Madrid" <?php echo ($list['timezone'] == 'Europe/Madrid') ? 'selected' : ''; ?>>Europe/Madrid</option>
                                                <option value="Europe/Rome" <?php echo ($list['timezone'] == 'Europe/Rome') ? 'selected' : ''; ?>>Europe/Rome</option>
                                                <option value="Pacific/Auckland" <?php echo ($list['timezone'] == 'Pacific/Auckland') ? 'selected' : ''; ?>>Pacific/Auckland</option>
                                                <option value="Pacific/Honolulu" <?php echo ($list['timezone'] == 'Pacific/Honolulu') ? 'selected' : ''; ?>>Pacific/Honolulu</option>
                                                <option value="Australia/Sydney" <?php echo ($list['timezone'] == 'Australia/Sydney') ? 'selected' : ''; ?>>Australia/Sydney</option>
                                                <option value="Australia/Melbourne" <?php echo ($list['timezone'] == 'Australia/Melbourne') ? 'selected' : ''; ?>>Australia/Melbourne</option>
                                                <option value="Australia/Brisbane" <?php echo ($list['timezone'] == 'Australia/Brisbane') ? 'selected' : ''; ?>>Australia/Brisbane</option>
                                                <option value="Africa/Johannesburg" <?php echo ($list['timezone'] == 'Africa/Johannesburg') ? 'selected' : ''; ?>>Africa/Johannesburg</option>
                                                <option value="Africa/Lagos" <?php echo ($list['timezone'] == 'Africa/Lagos') ? 'selected' : ''; ?>>Africa/Lagos</option>
                                                <option value="Africa/Nairobi" <?php echo ($list['timezone'] == 'Africa/Nairobi') ? 'selected' : ''; ?>>Africa/Nairobi</option>
                                                <option value="Asia/Seoul" <?php echo ($list['timezone'] == 'Asia/Seoul') ? 'selected' : ''; ?>>Asia/Seoul</option>
                                                <option value="Asia/Manila" <?php echo ($list['timezone'] == 'Asia/Manila') ? 'selected' : ''; ?>>Asia/Manila</option>
                                                <option value="Asia/Hong_Kong" <?php echo ($list['timezone'] == 'Asia/Hong_Kong') ? 'selected' : ''; ?>>Asia/Hong_Kong</option>
                                                <option value="Asia/Bangkok" <?php echo ($list['timezone'] == 'Asia/Bangkok') ? 'selected' : ''; ?>>Asia/Bangkok</option>
                                                <option value="Pacific/Fiji" <?php echo ($list['timezone'] == 'Pacific/Fiji') ? 'selected' : ''; ?>>Pacific/Fiji</option>
                                                <option value="Pacific/Tongatapu" <?php echo ($list['timezone'] == 'Pacific/Tongatapu') ? 'selected' : ''; ?>>Pacific/Tongatapu</option>
                                                <option value="America/Argentina/Buenos_Aires" <?php echo ($list['timezone'] == 'America/Argentina/Buenos_Aires') ? 'selected' : ''; ?>>America/Argentina/Buenos_Aires</option>
                                                <option value="America/Lima" <?php echo ($list['timezone'] == 'America/Lima') ? 'selected' : ''; ?>>America/Lima</option>
                                                <option value="Asia/Karachi" <?php echo ($list['timezone'] == 'Asia/Karachi') ? 'selected' : ''; ?>>Asia/Karachi</option>
                                                <option value="Africa/Casablanca" <?php echo ($list['timezone'] == 'Africa/Casablanca') ? 'selected' : ''; ?>>Africa/Casablanca</option>
                                                <option value="America/Toronto" <?php echo ($list['timezone'] == 'America/Toronto') ? 'selected' : ''; ?>>America/Toronto</option>
                                                <!-- Add more timezones as needed -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php foreach($list['CompanyGroup'] as $key=>$value) {
                                if($value['Group_Status'] != -1) {
                                    ?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-8 pull-left">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="<?php echo $value['comp_group_id'] ?>"
                                                                   name="GroupID[<?php echo $value['comp_group_id'] ?>][Value]"
                                                                   type="checkbox">
                                                            <?php echo $value['Group_Name'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-8 pull-left">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="Admin"
                                                                   name="GroupID[<?php echo $value['comp_group_id'] ?>][Admin]"
                                                                   type="checkbox">
                                                            <?php echo COMPANY_14 ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }?>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" class="btn btn-icon btn-success" style="width: 175px;">
                                            <input type="hidden"  name="action" id="action" value="addCompany">
                                            <i class="fa fa-download"></i>
                                            submit company <?php echo COMPANY_15 ?>
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
</div><!--/content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timezoneSelect = document.getElementById('timezone');
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone; // گرفتن تایم‌زون مرورگر کاربر
        if (timezoneSelect.querySelector(`option[value="${timezone}"]`)) {
            timezoneSelect.value = timezone;
        }
    });
</script>