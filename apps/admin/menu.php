<?php
$menu['admin']= array(
    'class' => "header",
    'title' => 'ดูแลระบบ',
    'cond' => current_user('user_type')=='admin',
    'bullet' => 'nature_people',
    'color' => 'col-green',
    'item' => array(
        'billing' => array('bullet' => '',
            'title' => 'ค่าบริการ',
            'url' => 'main/admin/billing/manage',
            'cond' => true,
            ),
        'coupon' => array('bullet' => '',
                'title' => 'คูปอง',
                'url' => 'main/admin/coupon/view',
                'cond' => true,
                ),
        ),
        
    );