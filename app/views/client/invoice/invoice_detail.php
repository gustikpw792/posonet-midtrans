

<body class="gray-bg">

    <div class="middle-box loginscreen animated fadeInDown">
        <div class="col-md-12 m-t-sm">
            <div class="text-center my-4">
                <img src="<?= base_url('assets/posonet/img/posonetnew.png') ?>" alt="Logo" width="" height="40">
            </div>
            <div class="text-center m-t">

                <label for="invoiceForm">Detail Tagihan</label>
                <!-- <h2 class="font-bold"></?=$kode_invoice ?></h2> -->
            </div>

            <form id="invoiceForm" class="m-t" role="form" action="#" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="form-group">
                    <label for="noint">Nomor Internet</label>
                    <input type="text" id="noint" class="form-control" disabled value="<?= $no_internet ?>">
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control font-bold bg-muted" disabled value="<?= $nama_pelanggan ?>">
                </div>
                <div class="form-group">
                    <label for="npaket">Paket</label>
                    <input type="text" id="npaket" class="form-control" disabled value="<?= $nama_paket ?>">
                </div>
                <div class="form-group tooltip-demo">
                    <label for="wa">Telp | WhatsApp </label>
                    <!-- <button class="btn btn-circle btn-xs" type="button" data-toggle="popover" data-placement="auto top" data-content="Notifikasi pembayaran akan dikirim ke nomor ini!"> ? </button> -->
                    <input type="text" id="wa" name="telp" class="form-control" disabled value="<?= $telp ?>">
                    <small>
                        <span class="text-muted font-italic">Notifikasi pembayaran akan dikirim ke nomor ini!</span>
                    </small>
                </div>
                <div class="form-group" hidden>
                    <label for="sts">Status Berlangganan</label>
                    <input type="text" id="sts" name="status_berlangganan" class="form-control text-bold" disabled value="<?= $status_berlangganan ?>">
                </div>
                <input type="text" name="no_internet" value="<?= $no_internet ?>" hidden>
                <input type="text" name="nama_pelanggan" value="<?= $nama_pelanggan ?>" hidden>
                <input type="text" name="nama_paket" value="<?= $nama_paket ?>" hidden>
                <input type="text" name="telp" value="<?= $telp ?>" hidden>
                <input type="text" name="next_expired" value="<?= $next_expired ?>" hidden>
                <input type="text" name="jumlah_pembayaran" value="<?= $jumlah_pembayaran ?>" hidden>
                <input type="text" name="kode_invoice" value="<?= $kode_invoice ?>" hidden>
                <!-- <div class="form-group">
                    <label for="status_pembayaran">Status Pembayaran</label>
                    <input type="text" name="status_pembayaran" class="form-control" disabled value="</?= $status_pembayaran ?>">
                </div> -->
                <!-- <div class="form-group">
                    <label for="expired">Paket berakhir pada</label>
                    <input type="text" name="expired" class="form-control" disabled value="</?= $expired ?>">
                </div> -->
                <div class="row xno-marginsm-l-n-xs">
                    <hr class="hr-line-solid">
                    <div class="col-lg-6 pull-left">
                        <h3>TOTAL</h3>
                    </div>
                    <div class="col-lg-6 m-">
                        <span class="text-strong pull-right"><h3><?= $v_jumlah_pembayaran ?></h3></span>
                    </div>
                </div>
                <?php if ($jumlah_pembayaran >= 10000) : ?>
                    <div class="alert alert-warning">
                        <span class="text-danger font-bold">Tagihan ini untuk pemakaian internet s/d <?= $next_expired_local ?></span><br><br>
                        <small>Tekan tombol "PROSES PEMBAYARAN" untuk melanjutkan pembayaran. Pastikan data diatas sudah benar.</small>
                    </div>
                <?php endif; ?>
                <?php if ($jumlah_pembayaran >= 10000) : ?>
                    <button type="button" id="btnProsesTrx" onclick="getTrxToken()" class="btn btn-block btn-outline btn-primary btn-lg">PROSES PEMBAYARAN</button>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="col-md-12 xtext-center m-t">
            <p class="text-muted">
                <small>
                    Mengalami kendala? Silahkan hubungi customer service kami <a href="https://wa.me/<?= $telp_cs ?>" target="_blank"><strong>wa.me/<?= $telp_cs ?></strong></a><br>
                    <!-- Tagihan ini berlaku sampai dengan tanggal <strong></?= $expired ?></strong>. -->
                </small>
            </p>
        </div>
        <div class="col-lg-12 text-center">
            <br>
            <img class="img-responsive center-block" src="<?= base_url('assets/posonet/img/primahomelogo3.png') ?>" alt="" style="height:30px;">
            
        </div>
        <div class="col-lg-12 text-center"><br><br><br><br></div>
        </div>
        
    </div>
    

    <script>
        const myElement = document.getElementById("btnProsesTrx");

        function getTrxToken() {
            myElement.disabled = true; // Disable the button to prevent multiple clicks
            myElement.innerHTML = "Memproses...";
            myElement.classList.add("disabled");
            // Send AJAX request to get the transaction token

            var postData = $('#invoiceForm').serializeArray();

            $.post("<?= site_url('placeOrder') ?>", postData , 
            function(data) {
                if (data.status) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // alert("Payment Success "+result);
                            console.log(result);
                            window.location.href = result.finish_redirect_url;
                        },
                        onPending: function(result) {
                            // alert("Waiting for your payment!"+result);
                            console.log(result);
                            window.location.href = result.pdf_url;
                        },
                        onError: function(result) {
                            // alert("Payment Failed"+result);
                            console.log(result);
                        },
                        onClose: function(result) {
                            myElement.innerHTML = "PROSES PEMBAYARAN"; // Reset button text
                            myElement.disabled = false; // Re-enable the button
                            myElement.classList.remove("disabled");
                            
                            // alert('You closed the popup without finishing the payment'+result);
                            console.log(result);
                            // window.location.href = "</?= site_url('welcome/payment_failed') ?>";
                        }
                    });
                } else {
                    alert('Error: ' + data.message);
                }
            }, 'json');
        }
    </script>