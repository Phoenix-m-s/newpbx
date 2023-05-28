<?php
/**
 * Class TimezoneService
 * @author:Husin Sajjadi
 * @Email:h.sajjadi@dabacenter.ir
 */
class TimezoneService
{
    public function getAllTimezone()
    {

        $string = file_get_contents(ROOT_DIR. "common/timezones.json");
        $result = json_decode($string, true);
        for($i=0; $i < sizeof($result); $i++){
            $result[$i]['name'] = $result[$i]['text'];
            $result[$i]['id'] = $result[$i]['utc'][0];
        }
        array_unshift($result , array('name' => 'choose from list', 'id' => ''));
        return $result;
    }
}
