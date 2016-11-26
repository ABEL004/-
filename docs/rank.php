<?php
function rank($bullets){
    if($bullets<200){
        return '步兵';
    }else if($bullets<300){
        return '通信兵';
    }else if($bullets<400){
        return '工程兵';
    }else if($bullets<500){
        return '炮兵';
    }else if($bullets<600){
        return '装甲兵';
    }else if($bullets<1000){
        return '防化兵';
    }else if($bullets<1500){
        return '全能特种兵';
    }else if($bullets<2000){
        return '中队长';
    }else {
        return '大队长';
    }
}

function skill($bullets){
    if($bullets<200){
        return '刺杀、射击';
    }else if($bullets<300){
        return '通讯、干扰';
    }else if($bullets<400){
        return '建设、维修';
    }else if($bullets<500){
        return '炮火、导弹';
    }else if($bullets<600){
        return '机动、猛攻';
    }else if($bullets<1000){
        return '生化、消菌';
    }else if($bullets<1500){
        return '尖刀战士';
    }else if($bullets<2000){
        return '战士楷模';
    }else {
        return '最高指挥官';
    }
}


function depart($bullets)
{
    if ($bullets < 200) {
        return '步兵班';
    } else if ($bullets < 300) {
        return '通信班';
    } else if ($bullets < 400) {
        return '工程班';
    } else if ($bullets < 500) {
        return '炮兵班';
    } else if ($bullets < 600) {
        return '装甲班';
    } else if ($bullets < 1000) {
        return '生化班';
    } else {
        return '特战营';
    }
}