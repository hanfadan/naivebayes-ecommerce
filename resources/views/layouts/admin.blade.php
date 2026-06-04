<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/overlay-scrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/datatable.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/adminlte.min.css') }}">
    <script src="{{ asset('assets/js/admin/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/overlay-scrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/jquery.datatable.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/datatable.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/autonumeric.min.js') }}"></script>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('assets/img/admin.png') }}" alt="Logo" height="60" width="60">
    </div>

    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" role="button">
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/admin.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
            <span class="brand-text font-weight-light">AdminLTE</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transaction') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>Produk <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.category') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i><p>Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.product') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i><p>Produk</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.customer') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i><p>Pelanggan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.user') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i><p>Pengguna</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid"></div>
        </div>

        @yield('content')

    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
</div>

<script src="{{ asset('assets/js/admin/adminlte.min.js') }}"></script>
<script src="{{ asset('assets/js/admin/javascript.min.js') }}"></script>
<script>
$(function(){
    $(document).on('click','.btn-delete',function(){
        let btn=$(this), id=btn.data('id'), url=btn.data('url');
        Swal.fire({title:'Hapus?',text:'Data akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'})
        .then(r=>{ if(r.isConfirmed){ $.post(url,{id,_token:'{{ csrf_token() }}'},function(res){ if(!res.error) window.location.href=res.url; },'json'); } });
    });

    $(document).on('submit','.form-ajax',function(e){
        e.preventDefault();
        let form=$(this);
        let fd=new FormData(this);
        fd.append('_token','{{ csrf_token() }}');
        $.ajax({url:form.attr('action'),type:'POST',data:fd,contentType:false,processData:false,
            success:function(res){ if(!res.error){ window.location.href=res.url; }else{ alert(res.message); } }
        });
    });

    $(document).on('submit','.form-file',function(e){
        e.preventDefault();
        let form=$(this);
        let fd=new FormData(this);
        fd.append('_token','{{ csrf_token() }}');
        $.ajax({url:form.attr('action'),type:'POST',data:fd,contentType:false,processData:false,
            success:function(res){ if(!res.error){ window.location.href=res.url; }else{ alert(res.message); } }
        });
    });

    $('.table-data').DataTable();
    $('.autonumeric').each(function(){ new AutoNumeric(this,{digitGroupSeparator:'.', decimalCharacter:',', minimumValue:'0'}); });
});
</script>

@yield('scripts')
</body>
</html>
