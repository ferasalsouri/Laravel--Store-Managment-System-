@extends("_layout")

@section("title")
ادارة الوحدات
@endsection()

@section("content")
<div class="row">
    <div class="col-sm-8">
        <form method="get" class="row DTForm" action="/unit">
            <div class="col-sm-5">
                <input name="q" type="text" class="form-control" placeholder="بحث عن وحدة...">
            </div>
            <div class="col-sm-1 text-right">
                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> بحث!</button>
            </div>
        </form>
    </div>
    <div class="col-sm-4 text-right">
        <a href="/unit/create" title="انشاء وحدة جديدة" class="btn Popup btn-success"><i class="glyphicon glyphicon-plus"></i> اضافة وحدة جديدة</a>
    </div>
</div>
<hr>

<table id="tblAjax" class="table table-hover table-stripped">
    <thead>
        <tr>
            <th>الوحدة</th>
            <th width="15%">تاريخ الانشاء</th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection()
@section("css")
    
        <link href="/metronic-rtl/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
        <style>
        table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting{
			padding-right:15px;
		}
        </style>
@endsection()
@section("js")
    <script src="/metronic-rtl/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/metronic-rtl/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/metronic-rtl/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

    <script>
        var oTable;
        $(function(){
            BindDataTable(); 
        });
        
        //هذه تختلف حسب الصفحة
        function BindDataTable() {
           oTable = $('#tblAjax').dataTable(
           {
			   language: {
               aria: {
						sortAscending: ": فعال لترتيب العمود تصاعديا", sortDescending: ": فعال لترتيب العمود تنازليا"
					}
					, emptyTable:"لا يوجد بيانات لعرضها", info:"عرض _START_ الى _END_ من _TOTAL_ صف", infoEmpty:"لا يوجد نتائج لعرضها", infoFiltered:"(filtered1 من _MAX_ اجمالي صفوف)", lengthMenu:"_MENU_ صف", search:"بحث", zeroRecords:"لا يوجد نتائج لعرضها",
					paginate:{sFirst:"الاول",sLast:"الاخير",sNext:"التالي",sPrevious:"السابق"}
				},
               "iDisplayLength": 10,
               "sPaginationType": "full_numbers",
               "bFilter": false,
               "bDestroy": true,
               "bSort": true,
			   "bStateSave": true,
               "columnDefs": [ {
                   "targets": 2,
                   "orderable": false
               } ],
 		       "order": [[ 1, "asc" ]],
               serverSide: true,
               columns: [                       
                       { data: 'name', name: 'name' },
                       { data: 'created_at', name: 'created_at' },                                       
                       {
                           name: 'buttons', "render": function (data, type, row) {
                               return "<a title='تعديل وحدة' href='/unit/" + row["id"] + "/edit' class='btn btn-primary Popup btnEdit btn-xs'><i class='glyphicon glyphicon-edit'></i></a> "                              
                               + " <a href='/unit/" + row["id"] + "/delete' class='btn ConfirmLink btn-danger btn-xs'><i class='glyphicon glyphicon-trash'></i></a>";
                           }
                       }
               ],
               ajax: {
                   type: "POST",
                   contentType: "application/json",
                   url: '/unit/AjaxDT',
                   data: function (d) {
					   d._token="{{csrf_token()}}";
                       d.q = $("[name=q]").val();
                       return JSON.stringify(d);
                   }
               },
               fnDrawCallback: function () {
               }
           });
        }
    </script>
@endsection()
