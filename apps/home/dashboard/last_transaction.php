<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');


$user_wallet=sSelectTb($systemDb,'wallet','*','owner_id='.current_user('id'));
$user_wallet=$user_wallet[0];
$oldtime=strtotime("-15 minutes",time());
$revoke_ts=sUpdateTb($systemDb,"transaction",array('status'=>sQ('revoke')),'type='.sQ('usage').' AND status='.sQ('wait').' AND time_recorded < '.sQ(date('Y-m-d H:i:s',$oldtime)));

$ts_data=sSelectTb($systemDb,"transaction",'*','source_address='.sQ($user_wallet['address']).' OR destination_address='.sQ($user_wallet['address']).' order by time_recorded desc limit 5');
//print_r($complaint_data);

$i=-1;

$typeSymbol=array(
    'invest'=>'<i class="material-icons col-green">account_balance</i> เพิ่มทุน',
    'withdraw'=>'<i class="material-icons col-red">money_off</i> ถอนเงิน',
    'usage'=>'<i class="material-icons col-blue">print</i> พิมพ์',
    'topup'=>'<i class="material-icons col-green">attach_money</i> เติมเงิน',
    'transfer'=>'<i class="material-icons col-orange">transform</i> โอนเงิน',
);

$statusSymbol=array(
    'wait'=>'<i class="material-icons col-orange">local_cafe</i> รอ',
    'complete'=>'<i class="material-icons col-green">check_circle</i> สำเร็จ',
    'cancel'=>'<i class="material-icons col-black">cancel</i> ยกเลิก',
    'revoke'=>'<i class="material-icons col-red">close</i> โมฆะ',
);


foreach($ts_data as $row){
    $i++;
    if($row['destination_address']==$user_wallet['address'])$multiply=+1;
    if($row['source_address']==$user_wallet['address'])$multiply=-1;

    $amount_show=$row['amount']*$multiply;

    $showtype=$typeSymbol[$row['type']];
    $table_data[]=array(
        'type'=>$showtype,
        'time_recorded'=>$row['time_recorded'],
        'amount'=>($amount_show>0?"<span class='col-green'>".$amount_show."</span>":"<span class='col-red'>".$amount_show."</span>"),
        'status'=>$statusSymbol[$row['status']],
    );
    
}
$data=array("head"=>array(
    'ประเภท',
    'วันที่ทำรายการ',
    'จำนวนเงิน (บาท)',
    'สถานะ'
    ),
    'id'=>'last_saction',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 1, "desc" ]]'
    );
    print rhtable($data);
    ?>
    </div>