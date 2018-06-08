<?php

/**
 * 获取列表分页信息
 * @param type $total
 * @param type $pageindex
 * @param type $pagesize
 * @return type
 */
function getPagingInfo($total,$pageindex=1,$pagesize=20,$offset = false){

    if($offset === false){
        $page_index = $pageindex;
        $pagesize = ((int)$pagesize == 0?1:(int)$pagesize);
        $offset = (intval($pageindex) - 1) * intval($pagesize);
    }else{
        $page_index = ((int) $offset / (int)$pagesize) + 1;
    }

    return [
        'offset'=>$offset,
        'pagesize'=>$pagesize,
        'total'=>$total,
        'page_index'=>$page_index,
        'page_total'=>ceil((int)$total/(int)$pagesize),
        'limit'=>" limit {$offset},{$pagesize}"
    ];
}

/**
 * 获取处理结果
 * @param type $result
 * @param type $code      301:参数错误, ,305:处理失败
 * @param type $msg
 * @return type
 */
function handleResult($result=true,$code=200,$msg=''){
    return [
        'result'=>$result,
        'code'=>$code,
        'message'=>$msg
    ];
}

/**
 * 判断字符串编码是否为 UTF-8
 * @param type $string
 * @return blooean
 */
function mb_is_utf8($string){
    return mb_detect_encoding($string, 'UTF-8') === 'UTF-8';
}

/**
 * 获取字符串编码类型
 * @param type $string
 * @return blooean
 */
function mb_str_encoding($string){
    return  mb_detect_encoding($string, ["ASCII","UTF-8","GB2312","GBK","BIG5"]);
}
