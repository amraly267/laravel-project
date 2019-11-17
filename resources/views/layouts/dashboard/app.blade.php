<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
  <head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{asset('dashboard/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('dashboard/dist/css/font-awesome.min.css')}}">
    <!-- Ionicons 2.0.0 -->
    <link rel="stylesheet" href="{{asset('dashboard/dist/css/ionicons.min.css')}}">
    <!-- Theme style -->
    @if(App::isLocale('ar'))
      <link rel="stylesheet" href="{{asset('dashboard/dist/css/AdminRTL.min.css')}}">
    @else
      <link rel="stylesheet" href="{{asset('dashboard/dist/css/AdminLTE.min.css')}}">
    @endif
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dashboard/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/dist/fonts/fonts-fa.css')}}">
    @if(App::isLocale('ar'))
      <link rel="stylesheet" href="{{asset('dashboard/dist/css/bootstrap-rtl.min.css')}}">
      <link rel="stylesheet" href="{{asset('dashboard/dist/css/rtl.css')}}">
    @endif
    <!-- jQuery 2.1.4 -->
    <script src="{{asset('dashboard/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('dashboard/dist/js/jquery-ui.min.js')}}"></script>

    <!-- Toastr Plugin -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/toastr/toastr.css')}}"/>
    <script type="text/javascript" src="{{asset('dashboard/plugins/toastr/toastr.js')}}"></script>

  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <!-- Header Section  -->
      <header class="main-header">
        @include('layouts.dashboard.header')
      </header>
      <!-- End Header Section -->

      <!-- Aside Menu Section -->
      <aside class="main-sidebar">
        @include('layouts.dashboard.aside')
      </aside>
      <!-- End Aside Menu Section -->

      <!-- Content section -->
      <div class="content-wrapper">
          @yield('content')
          @include('partial.session')
      </div>
      <!--End Content Section -->

      <!-- Footer Section -->
      <footer class="main-footer">
          @include('layouts.dashboard.footer')
      </footer>
      <!-- End Footer Section -->
    </div>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.4 -->
    <script src="{{asset('dashboard/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('dashboard/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dashboard/dist/js/app.min.js')}}"></script>
    <!-- AdminLTE App -->
    @if(!App::isLocale('ar'))
      <script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
    @endif
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('dashboard/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('dashboard/dist/js/demo.js')}}"></script>
    <!-- Confirmation Message Box -->
    <script src="{{asset('dashboard/dist/js/bootbox.all.js')}}"></script>

    <!-- Confirm Delete From Grid Script -->
    <script>
      $('.delete').click(function(event){
        event.preventDefault();
        var deleteBtn = $(this);
        bootbox.confirm({
          message: "@lang('site.delete_msg')",
          buttons: {
            confirm: {label: "@lang('site.ok')", className: 'btn-success'},
            cancel: {label: "@lang('site.cancle')",className: 'btn-danger'}
          },
          callback: function (result) {
            if(result)
            {
              $(deleteBtn).closest('form').submit();
            }
          }
        });
      })
    </script>
    <!-- End Script -->
    
    <!-- Image Preview Script -->
    <script>
    $('.image').change(function(){
      if (this.files && this.files[0])
      {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('.preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
      }
    })
    </script>
    <!-- End Script -->










  </body>
</html>
