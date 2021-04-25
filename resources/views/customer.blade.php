@extends('app')
@section('extra-css')
    <style>
        .modal-dialog {
            max-width: 650px;
        }

        .form-group input {
            max-width: 410px;
            display: inline-block;
        }

        .form-group span {
            margin-left: 210px;
        }

        .form-group label {
            min-width: 200px;
        }

        .ui-dialog-titlebar-close {
            opacity: 0;
        }

        .customerList > thead > tr > th:last-child {
            min-width: 100px;
        }


    </style>
@endsection
@section('content')
    <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-primary btn-sm" onClick="addCustomer()"><i class="ft-plus white"></i>Create Customer</button>
    </div>
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

    <!-- AddContact Modal -->
    <div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <inpu type="hidden" class="modal-status" value="add" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="customer_form">
                        @csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" id="company"  class="form-control" placeholder="Company" name="company" required>
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name"  class="form-control" placeholder="First Name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name"  class="form-control" placeholder="Last Name" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label for="email_address">Email Address</label>
                                <input type="text" id="email_address"  class="form-control" placeholder="Email Address" name="email_address">
                            </div>
                            <div class="form-group">
                                <label for="job_title">Job Title</label>
                                <input type="text" id="job_title"  class="form-control" placeholder="Job Title" name="job_title">
                            </div>
                            <div class="form-group">
                                <label for="business_phone">Business Phone</label>
                                <input type="text" id="business_phone"  class="form-control" placeholder="Business Phone" name="business_phone">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address"  class="form-control" placeholder="Address" name="address">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city"  class="form-control" placeholder="City" name="city">
                            </div>
                            <div class="form-group">
                                <label for="state_province">State Province</label>
                                <input type="text" id="state_province"  class="form-control" placeholder="State Province" name="state_province">
                            </div>
                            <div class="form-group">
                                <label for="zip_postal_code">Zip Postal Code</label>
                                <input type="text" id="zip_postal_code"  class="form-control" placeholder="Zip Postal Code" name="zip_postal_code">
                            </div>
                            <div class="form-group">
                                <label for="country_region">Country Region</label>
                                <input type="text" id="country_region"  class="form-control" placeholder="Country Region" name="country_region">
                            </div>
                        </div>

                        <div class="form-actions d-flex justify-content-end">
                            <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">
                                <i class="ft-x"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary save-vendor-contact">
                                <i class="fa fa-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
<script type="text/javascript">
    function editCustomer (customer_id)
    {
        const url = `/editCustomer/${customer_id}`;

        // get Customer data
        jQuery.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url         : url, // the url where we want to POST
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })
            // using the done promise callback
            .done(function(data) {

                if(!data.error)
                {
                    jQuery('#createCustomer .modal-title').html('Edit Customer');
                    jQuery('#createCustomer .modal-status').val(`edit_${data.id}`);
                    jQuery('#createCustomer [name|="company"]').val(data.company).change();
                    jQuery('#createCustomer [name|="first_name"]').val(data.first_name).change();
                    jQuery('#createCustomer [name|="last_name"]').val(data.last_name).change();
                    jQuery('#createCustomer [name|="email_address"]').val(data.email_address).change();
                    jQuery('#createCustomer [name|="job_title"]').val(data.job_title).change();
                    jQuery('#createCustomer [name|="business_phone"]').val(data.business_phone).change();
                    jQuery('#createCustomer [name|="address"]').val(data.address).change();
                    jQuery('#createCustomer [name|="city"]').val(data.city).change();
                    jQuery('#createCustomer [name|="state_province"]').val(data.state_province).change();
                    jQuery('#createCustomer [name|="zip_postal_code"]').val(data.zip_postal_code).change();
                    jQuery('#createCustomer [name|="country_region"]').val(data.country_region).change();

                    jQuery('#createCustomer').modal();
                }
            });
    }

    function addCustomer()
    {
        jQuery('#createCustomer .modal-title').html('Create Customer');
        jQuery('#createCustomer .modal-status').val('add');
        jQuery('#customer_form').trigger("reset");
        jQuery('#createCustomer').modal();
    }

    jQuery(document).ready(function($){
        $("#customer_form").validate({
            rules: {
                first_name: {
                    required: true,
                    alphabets_only:true,
                },
                last_name: {
                    required: true,
                    alphabets_only:true,
                },
                company:{
                    required:true,
                },
                business_phone:{
                    num_dashes:true,
                },
                zip_postal_code:{
                    num_dashes:true,
                },
                email_address:{
                    email:true,
                },
            },//end of bracket of rules
            messages :{
            },//end of bracket of messages
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

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
            "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0, 4, 5, 6, 9, 11, 12, 13] }],
            "createdRow": function(row, data, index) {
                let url='{{ url('/') }}';
                let actionHtml=
                    '<button class="btn btn-info btn-sm" onclick="editCustomer(ID)"><i class="ft-edit white"></i></button>\n' +
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
                                let url = `/deleteCustomer/${rowId}`;
                                $.ajax({
                                    url: url,
                                    type: 'DELETE',
                                    data:{
                                        'id': rowId,
                                        '_token': '{{ csrf_token() }}',
                                    },
                                    success: function(result) {
                                        $( ".conf-modal-dialog-"+rowId).data('id',rowId).dialog("close");
                                        customerList.clear().draw();
                                    },
                                    error: function(result){

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

        // process the contact modal
        $("#customer_form").submit(function (e) {
            e.preventDefault();

            if ($("#customer_form").is(':valid')) {
                // const formData = $( '#customer_form' ).serialize();

                const company = $("#company").val();
                const firstName = $("#first_name").val();
                const lastName = $("#last_name").val();
                const emailAddress = $("#email_address").val();
                const jobTitle = $("#job_title").val();
                const businessPhone = $("#business_phone").val();
                const address = $("#address").val();
                const city = $("#city").val();
                const stateProvince = $("#state_province").val();
                const zipPostalCode = $("#zip_postal_code").val();
                const countryRegion = $("#country_region").val();

                const data = {
                    company,
                    'first_name': firstName,
                    'last_name': lastName,
                    '_token': '{{ csrf_token() }}',
                };
                if (emailAddress) data.email_address = emailAddress;
                if (jobTitle) data.job_title = jobTitle;
                if (businessPhone) data.business_phone = businessPhone;
                if (address) data.address = address;
                if (city) data.city = city;
                if (stateProvince) data.state_province = stateProvince;
                if (zipPostalCode) data.zip_postal_code = zipPostalCode;
                if (countryRegion) data.country_region = countryRegion;

                const status = $('#createCustomer .modal-status').val();

                let url = '/createCustomer';
                let type = 'post';

                if (status !== 'add') {
                    const customer_id = status.split('_').pop();
                    type = 'PUT';
                    url = `/updateCustomer/${customer_id}`;
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                    success: function(result) {
                        if (!result.error) {
                            // toastr.success(result.msg);
                            $('#createCustomer .close').click();
                            customerList.clear().draw();
                            $('#customer_form').trigger("reset");
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                    error: function(result){
                        console.log(result);
                    }
                });
            }
        });
    })
</script>
@endsection

