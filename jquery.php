<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    
    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Bootstrap Colorpicker Js -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="plugins/dropzone/dropzone.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Multi Select Plugin Js -->
    <script src="plugins/multi-select/js/jquery.multi-select.js"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="plugins/jquery-spinner/js/jquery.spinner.js"></script>

    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- noUISlider Plugin Js -->
    <!--script src="plugins/nouislider/nouislider.js"></script-->

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- TinyMCE -->
    <script src="plugins/tinymce/tinymce.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <?php echo in_array("home", $path) ? '<script src="js/pages/index.js"></script>' : ""; ?>
    <?php echo in_array("modify", $path) ? '<script src="js/pages/tables/jquery-datatable.js"></script>' : ""; ?>
    <?php echo in_array("reject", $path) ? '<script src="js/pages/tables/jquery-datatable.js"></script>' : ""; ?>
    <?php echo in_array("copy", $path) ? '<script src="js/pages/tables/jquery-datatable.js"></script>' : ""; ?>
    <?php echo (in_array("upload", $path) && in_array("file", $path)) ? '<script src="js/pages/forms/advanced-form-elements.js"></script>' : ""; ?>
    <?php //echo in_array("update", $path)&&in_array("content", $path) ? '<script src="js/pages/forms/editors.js"></script>' : ""; ?>
    <!--script src="js/pages/forms/advanced-form-elements.js"></script-->
<?php //alert($path);?>
    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <script type="text/javascript">
        $("#Edit_Action, #123").on("click", function(e) {
    e.preventDefault();
    id = $(this).val();
    //alert(id);
    uid_valv = $("#uid_val"+id).val();
    request_oprv = $("#request_opr"+id).val();
    request_idv = $("#request_id"+id).val();
    //alert(uid_valv + request_oprv + request_idv);
    $.ajax({type: "POST",
        url: "blaze/action.blaze.php",
        dataType: 'json',
        data: { request_opr: $("#request_opr"+id).val(), request_id: $("#request_id"+id).val(), uid_val: $("#uid_val"+id).val() },
        success:function(result) {
           // alert(JSON.stringify(result));
            
        if(result.redirect==1)
        {
            //alert(result.message);
            window.location.href=result.url;
        }
        else
        {
            swal("Error!!!", "Error Occured, Try Again or Contact Admin!!!", "error");    
        }
        },
        error:function(result) {
          alert('error');
        }
        });
    });
    </script>

    <script type="text/javascript">
       $("#Delete_Action, #123").on("click", function(e) {
    e.preventDefault();
    id = $(this).val();
    //alert(id);
    uid_valv = $("#duid_val"+id).val();
    request_oprv = $("#drequest_opr"+id).val();
    request_idv = $("#drequest_id"+id).val();
    //alert(uid_valv + request_oprv + request_idv);
    swal({
        title: "Are you sure ?",
        text: "You will not be able to recover this action!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
          $.ajax({type: "POST",
        url: "blaze/action.blaze.php",
        dataType: 'json',
        data: { request_opr: $("#drequest_opr"+id).val(), request_id: $("#drequest_id"+id).val(), uid_val: $("#duid_val"+id).val() },
        success:function(result) {
        if(result.result==1)    
        {
            //swal("Deleted!!!",result.message,"success");   
            swal({title: "Deleted!!!", text: result.message, type: "success"},
            function(){ 
            //location.reload();
            window.location.href = window.location.href.replace(/#.*$/, '');
            }
            ); 
        }
        else
        {
            swal("Failed!!!",result.message, "error");
        }
        },
        error:function(result) {
          swal("Error!!!", "Error Occured, Try Again or Contact Admin!!!", "error");
        }
        });  

        } 
        else {
            swal("Cancelled", "Your data is safe :)", "error");
        }
    });

    });

    //-----------Cancel Action Added By Rizwan----------------
    $("#Cancel_Action, #123").on("click", function(e) {
    e.preventDefault();
    id = $(this).val();
    //alert(id);
    uid_valv = $("#cuid_val"+id).val();
    request_oprv = $("#crequest_opr"+id).val();
    request_idv = $("#crequest_id"+id).val();
    //alert(uid_valv + request_oprv + request_idv);
    swal({
        title: "Are you sure ?",
        text: "You will not be able to recover this action!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, do it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
          $.ajax({type: "POST",
        url: "blaze/action.blaze.php",
        dataType: 'json',
        data: { request_opr: $("#crequest_opr"+id).val(), request_id: $("#crequest_id"+id).val(), uid_val: $("#cuid_val"+id).val() },
        success:function(result) {
        if(result.result==1)    
        {
            //swal("Deleted!!!",result.message,"success");   
            swal({title: "Form Cancelled/Restored!!!", text: result.message, type: "success"},
            function(){ 
            //location.reload();
            window.location.href = window.location.href.replace(/#.*$/, '');
            }
            ); 
        }
        else
        {
            swal("Failed!!!",result.message, "error");
        }
        },
        error:function(result) {
          swal("Error!!!", "Error Occured, Try Again or Contact Admin!!!", "error");
        }
        });  

        } 
        else {
            swal("Action Cancelled", "Your data is safe :)", "error");
        }
    });

    });


    //-----------Reject Action Added By Rizwan----------------
    $("#Reject_Action, #123").on("click", function(e) {
    e.preventDefault();
    id = $(this).val();
    //alert(id);
    uid_valv = $("#ruid_val"+id).val();
    request_oprv = $("#rrequest_opr"+id).val();
    request_idv = $("#rrequest_id"+id).val();
    //alert(uid_valv + request_oprv + request_idv);
    swal({
        title: "Enter Reason!",
        text: "Please Enter Reason for Action:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Write something"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!"); return false
        }
        $.ajax({type: "POST",
        url: "blaze/action.blaze.php",
        dataType: 'json',
        data: { request_opr: $("#rrequest_opr"+id).val(), request_id: $("#rrequest_id"+id).val(), uid_val: $("#ruid_val"+id).val(), rreason: inputValue },
        success:function(result) {
        if(result.result==1)    
        {
            //swal("Deleted!!!",result.message,"success");   
            swal({title: "Form Rejected/Restored!!!", text: result.message, type: "success"},
            function(){ 
            //location.reload();
            window.location.href = window.location.href.replace(/#.*$/, '');
            }
            ); 
        }
        else
        {
            swal("Failed!!!",result.message, "error");
        }
        },
        error:function(result) {
          swal("Error!!!", "Error Occured, Try Again or Contact Admin!!!", "error");
        }
        });
        //swal("Nice!", "You wrote: " + inputValue, "success");
    });

    /*swal({
        title: "Are you sure ?",
        text: "You will not be able to recover this action!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, do it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
          $.ajax({type: "POST",
        url: "blaze/action.blaze.php",
        dataType: 'json',
        data: { request_opr: $("#rrequest_opr"+id).val(), request_id: $("#rrequest_id"+id).val(), uid_val: $("#ruid_val"+id).val() },
        success:function(result) {
        if(result.result==1)    
        {
            //swal("Deleted!!!",result.message,"success");   
            swal({title: "Form Rejected/Restored!!!", text: result.message, type: "success"},
            function(){ 
            //location.reload();
            window.location.href = window.location.href.replace(/#.*$/, '');
            }
            ); 
        }
        else
        {
            swal("Failed!!!",result.message, "error");
        }
        },
        error:function(result) {
          swal("Error!!!", "Error Occured, Try Again or Contact Admin!!!", "error");
        }
        });  

        } 
        else {
            swal("Action Cancelled", "Your data is safe :)", "error");
        }
    });*/

    });



    $(function () {

   
    //TinyMCE
    tinymce.init({
        selector: "textarea#tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = 'plugins/tinymce';
});
 
    </script>
