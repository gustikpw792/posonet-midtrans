<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BAYAR WIFI</title>
    <!-- </?php if ($active == 'firstpage') : ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </?php endif; ?> -->

    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/posonet/img/favicon.ico') ?>">

    <link href="<?= base_url('assets/inspinia271/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia271/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">
    
    <link href="<?= base_url('assets/inspinia271/css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia271/css/style.css') ?>" rel="stylesheet">

    <?php if ($active == 'getOrder') : ?>
        <script type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-eGXEePyTJUHopg1U"></script>
    <?php endif; ?>
</head>