<script src="{{ url('/js/core/libraries/jquery.min.js') }}"></script>
<script src="{{ url('/js/core/libraries/jquery_ui/jquery-ui.min.js') }}"></script>
<script src="{{ url('/js/core/libraries/bootstrap.min.js') }}"></script>
<script src="{{ url('/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ url('/js/extensions/toastr.js') }}"></script>
<script src="{{ url('/js/forms/input-groups.min.js') }}"></script>
<script src="{{ url('/js/forms/wizard-steps.min.js') }}"></script>
<script src="{{ url('/js/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="{{ url('/js/jquery-validate/additional-methods.min.js') }}"></script>
<script src="{{ url('/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ url('/js/core/libraries/dialog-tooltip.min.js') }}"></script>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $.validator.addMethod("alphabets_only", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Only alphabetical characters");

        // this is for numbers and dashes only
        $.validator.addMethod("num_dashes", function (value, element) {
            return this.optional(element) || /^[0-9\-\()\+]+$/i.test(value);
        }, "Numbers and dashes only");

        // this is for domain
        $.validator.addMethod("domain", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/);
            // return this.optional(element) || value == value.match(/^(http(s)?\/\/:)?(www\.)?[a-zA-Z\-]{3,}(\.)?$/);

        });

        //this is used to allow to enter numbers only
        $.validator.addMethod("numbersOnly", function(value, element) {
            return this.optional(element) || value == value.match(/[^0-9]/);
        });


        // this is for numbers, letters, spcaes and dashes ...it is used for title
        $.validator.addMethod("alpha_num_dash", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Username must contain only letters, numbers, or dashes.");

        //this is used to validate image for vendor for pixels 170px x 100px.
        $.validator.addMethod('dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true;
            }
            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            if(width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        });
    });
</script>
@yield('extra-js')