@extends('admin.layouts.app')
@section('title',$module_name)
@section('content')
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                @foreach($index_fields as $labels => $fields)
                                    <th> {{ $labels }} </th>
                                @endforeach
                                <th> صﻻحيات الدور </th>
                                <th> التحكم </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    @foreach($index_fields as $labels => $fields)
                                        @if($row->$fields==null)
                                            <td> ﻻ يوجد </td>
                                        @else
                                            <td> {{ $row->$fields }} </td>
                                        @endif
                                    @endforeach
                                    @php
                                    $permission_ids=\App\Models\RolePermission::where('role_id',$row->id)->pluck('permission_id');
                                    $permissions=\App\Models\Permission::whereIn('id',$permission_ids)->get();
                                    @endphp
                                        <td>
                                            @foreach($permissions as $permission)
                                            {{ $permission->name }},
                                            @endforeach
                                        </td>

                                        <td class="actions">
                                        <div class="row" style="margin-top: 20px">
                                            <div class="col-md-3">
                                                {!! Form::open(['method' => 'DELETE','data-id'=>$row->id, 'route' => [$route.'.destroy',$row->id],'class'=>'delete']) !!}
                                                {!! Form::hidden('id', $row->id) !!}
                                                <button type="button"  class="btn btn-danger btn-custom waves-effect waves-light"><i class="fa fa-trash"></i></button>
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="col-md-3">
                                                <a href="{{route($route.'.edit',$row->id)}}">
                                                    <button type="button" class="btn btn-info btn-custom waves-effect waves-light"><i class="fa fa-edit"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({keys: true});
            $('#datatable-responsive').DataTable();
            $('#datatable-colvid').DataTable({
                "dom": 'C<"clear">lfrtip',
                "colVis": {
                    "buttonText": "Change columns"
                }
            });
            $('#datatable-scroller').DataTable({
                ajax: "public/panel/assets/plugins/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
            var table = $('#datatable-fixed-col').DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                }
            });
        });
        TableManageButtons.init();

    </script>

    <script>
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "هل انت متأكد من الحذف ؟",
                    text: "لن تستطيع استعادة هذا العنصر مرة أخرى!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'نعم , قم بالحذف!',
                    cancelButtonText: 'ﻻ , الغى عملية الحذف!',
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        swal("تم الحذف !", "تم حذف العنصر من قاعدة البيانات!", "success");
                        $("form[data-id='"+id+"']").submit();
                    } else {
                        swal("تم الالغاء", "ما زال العنصر متاح بقاعدة بياناتك :)", "error");
                    }
                });
        });
    </script>

@endsection
