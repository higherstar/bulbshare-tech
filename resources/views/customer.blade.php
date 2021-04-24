@extends('app')
@section('content')
    <table class="table table-striped table-bordered customerList" width="100%">
        <thead>
        <tr>
            <th></th>
            @foreach($cols as $k=>$v)
                <th>{{$v}}</th>
            @endforeach
        </tr>
        </thead>
    </table>
@endsection

@section('extra-js')
    <script type="text/javascript">
        jQuery(document).ready(function($){
            let count = 1;
            let columns=[];
            columns[0]={data:'id',"defaultContent": "<i>N/A</i>"};
            @foreach($cols as $k=>$v)
                columns[count]={data:'{{$k}}', "defaultContent": "<i>N/A</i>"};
            count++;
                    @endforeach
            const customerList = $('.customerList').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/getCustomers",
                },
                "columns": columns,
                "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0, 4, 5, 6, 9, 11 ] }],
                "createdRow": function(row, data, index) {
                    let url='{{ url('/') }}';
                    let actionHtml='<a href="/customers">\n' +
                        '<button class="btn btn-info btn-sm"><i class="ft-edit white"></i></button>\n' +
                        '</a>&nbsp; \n' +
                        '<button data-id="'+ data.id +'" class="btn btn-danger btn-sm conf-modal-dialog-'+ data.id +'-btn"><i class="ft-trash white"></i></button>\n' +
                        '<div class="conf-modal-dialog-'+ data.id +'" title="Delete Customer">\n' +
                        '</div>';
                    let finalHtml=actionHtml.replace(/ID/g,data.id);
                    $('td', row).eq(count-1).html(finalHtml);
                },
                "drawCallback": function( settings ) {
                    for(let i=0; i<settings.aoData.length; i++){
                        //*-- Modal Code Start --
                        $(".conf-modal-dialog-" + settings.aoData[i]._aData.id).dialog({
                            autoOpen: false,
                            resizable: false,
                            height: "auto",
                            width: 400,
                            modal: true,
                            buttons: {
                                "Delete ": function() {
                                    let rowId=$(this).data('id');
                                    $( this ).dialog( "close" );
                                    let url = '/customers';
                                    let finalUrl = url.replace(/ID/g,rowId);
                                    $.ajax({
                                        url: finalUrl,
                                        type: 'DELETE',
                                        data:{
                                            'id': rowId,
                                            '_token': '{{ csrf_token() }}',
                                        },
                                        success: function(result) {
                                            window.location=location.href;
                                        },
                                        error: function(result){
                                            window.location=location.href;
                                        }
                                    });
                                },
                                Cancel: function() {
                                    $( this ).dialog( "close" );
                                }
                            },
                        });
                        $( ".conf-modal-dialog-"+settings.aoData[i]._aData.id+"-btn" ).on("click",function(){
                            let rowId=$(this).attr('data-id');
                            $( ".conf-modal-dialog-"+rowId).data('id',rowId).dialog("open");
                        });
                        //-- Modal Code End --
                    }
                }
            } );
        })
    </script>
@endsection

