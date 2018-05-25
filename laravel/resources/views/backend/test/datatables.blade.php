@extends('layouts.body')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-info">
            <form class="form-inline" role="form" id="grid-search-form" onsubmit="return false;">
                <div class="form-group">
                    <label for="search-iframe-10" class="sr-only">ID</label>                
                    <input type="text" id="search-id" name="params[id]" class="form-control" title="ID" placeholder="请输入ID">
                </div>
                <div class="form-group">
                    <label for="search-iframe-10" class="sr-only">名称</label>                
                    <input type="text" id="search-name" name="params[name]" class="form-control" title="名称" placeholder="请输入名称">             
                </div> 
                <button class="btn btn-info btn-sm"><i class="ace-icon fa fa-search"></i>搜索</button>
            </form>
        </div>
        <div class="clearfix"><div class="pull-right tableTools-container"></div></div>
        <div class="table-header">数据表标题</div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover" style="width:100%;"></table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="/ace-asstes/js/jquery.dataTables.min.js"></script>
<script src="/ace-asstes/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="/js/myTable.js"></script>
<script>

    var obj = {
        columns: [
                {data:null,title:'<label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label>',width:50,orderable:false,class:'table-checkbox',
                    render:function(data){
                        return '<label class="pos-rel"><input type="checkbox" class="ace" value="' + data["id"] + '" /><span class="lbl"></span></label>';
                    }
                },
                {title: 'ID',data: 'id',"render": function ( data, type, row, meta ) {
                    return '<a href="'+data+'">Download</a>';
                }},
                {title: '栏目',data: 'name',name:'testname'},
                {title: '路由',data: 'note'},
                {title: '图标',data: 'stock'},
                {title: '图标2',data: 'ship'},
                {title: '图标3',data: 'sdate'},
                {title: '图标4',data: 'sdate'},
            ],
    };
    var myTable = new MyTable('#dynamic-table',obj,"{{route('b_test_datatableslist')}}");
    myTable.init();
    $('#grid-search-form').on('click',function(){
       myTable.refresh();
       return false;
   });
</script>
@endpush