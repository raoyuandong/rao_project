<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ActionLog extends Model
{
    /**
     * laravel 禁止自动更新 update_at 字段
     * @var type 
     */
    public $timestamps = false;
    
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'actions_log';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['admin_id','type','content','created_at'];

    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * type 对应的解释
     * @var array
     */
    public $typeTip  = [
        '1'=>'添加数据',
        '2'=>'更新数据',
        '3'=>'删除数据',
        '4'=>'上传文件',
        '5'=>'删除文件',
        '6'=>'下载文件',
        '7'=>'管理员登录',
        '8'=>'管理员退出'
    ];

    /**
     * 添加后台操作日志
     * @param type $data
     * @return type
     */
    public function addActionLog($data){
        $insterRes = self::create($data);
        return $insterRes;
    }

    /**
     * 获取菜单列表信息
     * @return type
     */
    public function findActionList($params = [],$all = false){
        $count_sql = 'select count(1) as total from `lar_actions_log` action  where 1=1 ';


        $sql = 'SELECT action.*,lar_admins.name FROM `lar_actions_log` action LEFT JOIN lar_admins ON action.admin_id = lar_admins.id where 1=1 ';

        if(isset($params['content']) && !empty($params['content'])){
            $sql .= " and action.content like '%{$params['content']}%'";
            $count_sql .= " and action.content like '%{$params['content']}%'";
        }

        if(isset($params['type'])){
            $sql .= " and action.type = {$params['type']}";
            $count_sql .= " and action.type = {$params['type']}";
        }

        $count_info = DB::select($count_sql);
        
        $offset = isset($params['offset'])?$params['offset']:0;
        $pageindex = isset($params['pageindex'])?$params['pageindex']:1;
        $pagesize  = isset($params['pagesize'])?$params['pagesize']:10;


        $page_info = getPagingInfo($count_info[0]->total,$pageindex,$pagesize,$offset);
        
        if(isset($params['orderBy']) && isset($params['sort'])){
            $sql .= " order by {$params['orderBy']} {$params['sort']}";
        }else{
            $sql .= " order by created_at desc";
        }

        if($all === true){
            $page_info['limit'] = '';
        }

        $list = DB::select($sql.$page_info['limit']);
        foreach($list as $_k=>$_v){
            $list[$_k] = (array)$_v;
        }

        $page_info['filteredTotal'] = count($list);
        $page_info['data'] = $list;
        return $page_info;
    }
}
