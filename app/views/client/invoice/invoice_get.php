

<body class="gray-bg">
    <div class="middle-box xcol-md-12 loginscreen">
        <div class="ibox-content">
            <div class="col-md-12 text-center m-t-lg">
                <div class="text-center my-4">
                    <img src="<?= base_url('assets/posonet/img/posonetnew.png') ?>" alt="Logo" width="" height="40">
                    <!-- <h1 class="mt-2">Bayar Wi-Fi</h1> -->
                     <br><br><br><br>
                </div>
                <p class="text-muted text-center">
                <small>
                    Silahkan masukan nomor pelanggan atau nomor internet untuk mengecek tagihan internet Anda.</p>
                </small>
            </div>

            <form class="m-t" role="form" action="<?=site_url('getInvoice')?>" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                <div class="form-group">
                    <!-- <label for="">No Internet</label> -->
                    <input type="number" name="no_internet" value="<?= $no_internet ?>" pattern="[0-9]*" class="form-control input-lg text-center font-bold text-info bg-muted" placeholder="Nomor Internet" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">CEK TAGIHAN</button>
            </form>

            <br><br><br>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger text-center">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h2 class="xlogo-name">POSONET</h2>
            </div>

            <form class="m-t" role="form" action="</?=site_url('welcome/getInvoice')?>" method="post">
                <div class="form-group">
                    <label for="">Masukan No Pelanggan/No Internet</label>
                    <input type="number" name="no_internet" pattern="[0-9]*" class="form-control input-lg text-center font-bold text-info bg-muted" placeholder="Nomor Internet" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">CEK TAGIHAN</button>
            </form>
        </div>
        
    </div> -->
    
    <div class="footer">
        <div class="col-lg-12 text-center">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <img class="img-responsive center-block" src="<?= base_url('assets/posonet/img/primahomelogo3.png') ?>" alt="" style="width:120px; margin: 0 auto;">
            </div>
            <div class="col-lg-4"></div>
        </div>

    </div>