<?php
class cdrModel extends looeic
{
    protected $TABLE_NAME = 'cdr';


    public static $cdrFillable=array(
        'cdr.cdr_id',
        'cdr.calldate',
        'cdr.clid',
        'cdr.src',
        'cdr.dst',
        'cdr.duration',
        'cdr.disposition',
        'cdr.billsec',
        'cdr.dcontext',
        'cdr.uniqueid'
    )
    ;
}