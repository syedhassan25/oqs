  <!-- Favicons -->
  <style>
  .dataTables_wrapper .dataTables_processing {
position: absolute;
top: 30%;
left: 50%;
width: 30%;
height: 40px;
margin-left: -20%;
margin-top: -25px;
padding-top: 10px;
text-align: center;
font-size: 1.2em;
background:#00bca4;
border-radius:2px;
color:#fff;
z-index: 100 !important;
}
.error{
    color:red;
    font-size:14px;
}


  </style>
  
  <style>
   

table.dataTable thead > tr > th {
    font-size: 11px;
}
table.dataTable tbody > tr > td {
    font-size: 13px;
}
</style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="apple-touch-icon-precomposed" sizes="144x144"
            href="{{ asset('assets/images/icons/apple-touch-icon-144-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114"
            href="{{ asset('assets/images/icons/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72"
            href="{{ asset('assets/images/icons/apple-touch-icon-72-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed"
            href="{{ asset('assets/images/icons/apple-touch-icon-57-precomposed.png') }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/icons/favicon.png') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">


        <!-- HELPERS -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/animate.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/backgrounds.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/boilerplate.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/border-radius.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/grid.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/page-transitions.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/spacing.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/typography.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/utils.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/colors.css') }}">

        <!-- ELEMENTS -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/badges.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/buttons.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/content-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/dashboard-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/forms.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/images.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/info-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/invoice.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/loading-indicators.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/menus.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/panel-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/response-messages.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/responsive-tables.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/ribbon.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/social-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/tables.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/tile-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/elements/timeline.css') }}">



        <!-- ICONS -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/icons/fontawesome/fontawesome.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/icons/linecons/linecons.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/icons/spinnericon/spinnericon.css') }}">


        <!-- WIDGETS -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/accordion-ui/accordion.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/calendar/calendar.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/carousel/carousel.css') }}">

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/charts/justgage/justgage.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/charts/morris/morris.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/charts/piegage/piegage.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/charts/xcharts/xcharts.css') }}">

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/chosen/chosen.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/colorpicker/colorpicker.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/datatable/datatable.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/datepicker/datepicker.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/datepicker-ui/datepicker.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/dialog/dialog.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/dropdown/dropdown.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/dropzone/dropzone.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/file-input/fileinput.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/input-switch/inputswitch.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/input-switch/inputswitch-alt.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/ionrangeslider/ionrangeslider.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/jcrop/jcrop.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/jgrowl-notifications/jgrowl.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/loading-bar/loadingbar.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/maps/vector-maps/vectormaps.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/markdown/markdown.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/modal/modal.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/multi-select/multiselect.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/multi-upload/fileupload.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/nestable/nestable.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/noty-notifications/noty.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/popover/popover.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/pretty-photo/prettyphoto.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/progressbar/progressbar.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/range-slider/rangeslider.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/slidebars/slidebars.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/slider-ui/slider.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/summernote-wysiwyg/summernote-wysiwyg.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/tabs-ui/tabs.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/theme-switcher/themeswitcher.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/timepicker/timepicker.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/tocify/tocify.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/tooltip/tooltip.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/touchspin/touchspin.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/uniform/uniform.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/wizard/wizard.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/widgets/xeditable/xeditable.css') }}">

        <!-- SNIPPETS -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/chat.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/files-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/login-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/notification-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/progress-box.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/todo.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/user-profile.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/snippets/mobile-navigation.css') }}">

        <!-- APPLICATIONS -->

        <!-- <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/applications/mailbox.css') }}"> -->

        <!-- Admin theme -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/themes/admin/layout.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/themes/admin/color-schemes/default.css') }}">

        <!-- Components theme -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/themes/components/default.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/themes/components/border-radius.css') }}">

        <!-- Admin responsive -->

        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/responsive-elements.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/helpers/admin-responsive.css') }}">

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />