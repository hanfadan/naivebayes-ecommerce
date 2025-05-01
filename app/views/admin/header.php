<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="<?php echo img('favicon.png');?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo css('admin/fontawesome.min');?>">
    <link rel="stylesheet" href="<?php echo css('admin/overlay-scrollbars.min');?>">
    <link rel="stylesheet" href="<?php echo css('admin/datatable.bootstrap4.min');?>">
    <link rel="stylesheet" href="<?php echo css('sweetalert2.min');?>">
    <link rel="stylesheet" href="<?php echo css('admin/adminlte.min');?>">
    <script src="<?php echo js('admin/jquery.min');?>"></script>
    <script src="<?php echo js('admin/bootstrap.min');?>"></script>
    <script src="<?php echo js('admin/overlay-scrollbars.min');?>"></script>
    <script src="<?php echo js('admin/jquery.datatable.min');?>"></script>
    <script src="<?php echo js('admin/datatable.bootstrap4.min');?>"></script>
    <script src="<?php echo js('sweetalert2.min');?>"></script>
    <script src="<?php echo js('autonumeric.min');?>"></script>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="<?php echo img('admin.png');?>" alt="AdminLTELogo" height="60" width="60">
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
                <a class="nav-link" href="<?php echo url('logout');?>" role="button">
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?php echo url('admin/dashboard');?>" class="brand-link">
            <img src="<?php echo img('admin.png');?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?php echo url('admin/dashboard');?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo url('admin/transaction');?>" class="nav-link">
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
                                <a href="<?php echo url('admin/category');?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo url('admin/product');?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Produk</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo url('admin/customer');?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Pelanggan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo url('admin/user');?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Pengguna</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>

