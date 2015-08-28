<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GWSTATS 2.0</title>

    <link href="<?= base_url() ?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="<?= base_url() ?>public/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="<?= base_url() ?>public/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="<?= base_url() ?>public/css/animate.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/css/style.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?=base_url()?>public/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?=base_url()?>public/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="<?=base_url()?>public/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="<?= base_url() ?>public/js/jquery-2.1.1.js"></script>
    <script src="<?= base_url() ?>public/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>public/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= base_url() ?>public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="<?= base_url() ?>public/js/gwstat.js"></script>
</head>

<body>
<div id="wrapper">

    <?php $this->load->view('main/menu') ?>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
                </div>
            </nav>
        </div>