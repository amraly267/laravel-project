@if(session('success'))
    <script type="text/javascript">

        toastr.options = {
          "debug": false,
          "positionClass": @if(App::isLocale('ar')) "toast-top-right" @else "toast-top-right" @endif,
          "onclick": null,
          "fadeIn": 300,
          "fadeOut": 1000,
          "timeOut": 3000,
          "extendedTimeOut": 1000
        };
        toastr.success("{{session('success')}}");
    </script>
@endif
