<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/posonet/img/favicon.ico') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        
        body {
            background: <?=($is_production == 'PRODUCTION') ? '#036ffc' : '#e4af02ff' ?>;
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(3, 111, 252, 0.10);
            max-width: 350px;
            width: 100%;
            padding: 40px 24px 32px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .success-icon {
            background: linear-gradient(135deg, #ffffff 0%, #036ffc 100%);
            border-radius: 50%;
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px auto;
            box-shadow: 0 4px 16px rgba(3, 111, 252, 0.15);
            border: 2px solid #fff;
        }
        .success-icon svg {
            width: 36px;
            height: 36px;
            color: #036ffc;
        }
        h1 {
            font-size: 1.7rem;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: #036ffc;
        }
        .desc {
            color: #3b82f6;
            font-size: 1rem;
            margin-bottom: 28px;
        }
        .details {
            background: #e8f1fd;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 28px;
            text-align: left;
            font-size: 0.98rem;
            color: #1e293b;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        .details strong {
            color: #036ffc;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #60a5fa 0%, #036ffc 100%);
            color: #fff;
            font-weight: 600;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border 0.2s;
            box-shadow: 0 2px 8px rgba(3, 111, 252, 0.08);
        }
        .btn:hover {
            background: linear-gradient(90deg, #036ffc 0%, #60a5fa 100%);
        }
        .btn-outline {
            display: inline-block;
            background: #fff;
            color: #036ffc;
            font-weight: 600;
            padding: 12px 32px;
            border: 2px solid #036ffc;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border 0.2s;
            box-shadow: 0 2px 8px rgba(3, 111, 252, 0.08);
        }
        .btn-outline:hover {
            background: #036ffc;
            color: #fff;
            border-color: #036ffc;
        }
        @media (max-width: 400px) {
            .container {
                padding: 24px 8px 16px 8px;
            }
        }
        /* Watermark background */
        .watermark-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            width: 100%;
            height: 100%;
            opacity: 0.06;
        }
        .watermark-pattern {
            width: 100%;
            height: 100%;
            background:
                repeating-linear-gradient(
                    45deg,
                    transparent 0 24px,
                    #036ffc10 24px 48px
                );
            position: relative;
        }
        .watermark-text {
            position: absolute;
            font-size: 14px;
            font-weight: 900;
            color: #036ffc;
            opacity: 1;
            letter-spacing: 0.08em;
            white-space: nowrap;
            transform: rotate(-45deg);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Watermark background -->
        <div class="watermark-bg">
            <div class="watermark-pattern">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; pointer-events: none;">
                <?php
                $mode_production = ($is_production == 'PRODUCTION') ? 'POSONET' : 'SANDBOX';
                $fontSize = 14; // px
                $gapY = 24;
                $gapX = 80;
                $containerHeight = 500;
                $containerWidth = 350;
                for ($y = -$gapY; $y < $containerHeight + $gapY; $y += $gapY) {
                    for ($x = -$gapX; $x < $containerWidth + $gapX; $x += $gapX) {
                        echo '<div class="watermark-text" style="left: '.$x.'px; top: '.$y.'px;">' . $mode_production . '</div>';
                    }
                }
                ?>
                </div>
            </div>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom:24px;">
            <a href="/">
                <img src="<?= base_url('/assets/posonet/img/primahomelogo3.png') ?>" alt="Logo Kiri" style="height:24px;width:auto;display:block;">
            </a>
            <a href="/">
                <img src="<?= base_url('/assets/posonet/img/posonetnew.png') ?>" alt="Logo Kanan" style="height:24px;width:auto;display:block;">
            </a>
        </div>
        <!-- <div class="success-icon" id="success-anim" style="background: transparent; box-shadow: none; border: 2px solid #036ffc;">
            <svg id="success-svg" fill="none" viewBox="0 0 24 24">
                <circle id="success-circle" cx="12" cy="12" r="11" fill="none" stroke="#036ffc" stroke-width="2"/>
                <path id="success-check" d="M7 13.5L10.5 17L17 10" stroke="#036ffc" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                stroke-dasharray="16" stroke-dashoffset="16"/>
            </svg>
        </div> -->
        <div class="success-iconx" id="success-animx">
            <video height="140" autoplay muted>
                <source src="<?= base_url('/assets/posonet/img/success_animation.mp4') ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>

        </div>
        <script>
        // Animate the checkmark repeatedly
        // function animateSuccessIcon() {
        //     const check = document.getElementById('success-check');
        //     const circle = document.getElementById('success-circle');
        //     // Reset
        //     check.style.transition = 'none';
        //     check.style.strokeDashoffset = 16;
        //     circle.style.transition = 'none';
        //     circle.style.transform = 'scale(0.7)';
        //     // Animate
        //     setTimeout(() => {
        //         check.style.transition = 'stroke-dashoffset 0.7s cubic-bezier(.4,2,.6,1)';
        //         check.style.strokeDashoffset = 0;
        //         circle.style.transition = 'transform 0.4s cubic-bezier(.4,2,.6,1)';
        //         circle.style.transform = 'scale(1)';
        //     }, 500);
        //     // After animation, wait, then repeat
        //     // setTimeout(() => {
        //     //     check.style.transition = 'stroke-dashoffset 0.4s';
        //     //     check.style.strokeDashoffset = 16;
        //     //     circle.style.transition = 'transform 0.3s';
        //     //     circle.style.transform = 'scale(0.7)';
        //     // }, 1200);
        //     // setTimeout(animateSuccessIcon, 1700);
        // }
        // window.addEventListener('DOMContentLoaded', animateSuccessIcon);
        </script>

        <h1>Transaksi Berhasil!</h1>
        <div class="desc">
            <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 8px; text-align: center;">
                <div style="font-weight:600; color:#111827; font-size:0.92rem;"><small>#<?=$order_id ?> | <?= $settlement_time ?></small></div>
            </div>
            <?php 
                if ($is_production !== 'PRODUCTION') {
                    echo '<h2 style="color: red;"> TEST MODE </h2>';
                }
            ?>
            <!-- <div class="logo">
                
            </div> -->
        </div>
        <div class="details">
            <div style="flex:1 1 45%; min-width: 140px;">
                <div style="font-size:0.93rem; color:#6B7280; margin-bottom:4px;">Nama Pelanggan</div>
                <div style="font-weight:600; color:#111827;"><?=$nama_pelanggan?></div>
            </div>
            <div style="flex:1 1 45%; min-width: 140px;">
                <div style="font-size:0.93rem; color:#6B7280; margin-bottom:4px;">Nomor Internet</div>
                <div style="font-weight:600; color:#111827;"><?=$no_internet?></div>
            </div>
            <div style="flex:1 1 45%; min-width: 140px;">
                <div style="font-size:0.93rem; color:#6B7280; margin-bottom:4px;">WhatsApp</div>
                <div style="font-weight:600; color:#111827;"><?=$telp?></div>
            </div>
            <div style="flex:1 1 45%; min-width: 140px;">
                <div style="font-size:0.93rem; color:#6B7280; margin-bottom:4px;">Total</div>
                <div style="font-weight:600; color:#111827;">Rp<?=$gross_amount?></div>
            </div>
            <div style="flex:1 1 45%; min-width: 140px;">
                <div style="font-size:0.93rem; color:#6B7280; margin-bottom:4px;">Metode Pembayaran</div>
                <div style="font-size:0.83rem; font-weight:400; color:#111827;">
                    <img class="logo-payment-type" src="<?=$cstore_logo?>" 
                        alt="Payment Logo" loading="lazy" width="50px" height="20px">
                    <?=$payment_type?>
                </div>
            </div>
            <div style="flex:1 1 45%; min-width: 140px;">
                <div style="font-size:0.93rem; color:#6B7280; margin-bottom:4px;">Expired pada</div>
                <div style="font-weight:600; color:#111827;"><?=$expired?></div>
            </div>
        </div>
        <div style="display: flex; gap: 8px; justify-content: center; margin-bottom: 8px;">
            <a href="/bayarwifi/" id="dash-proof" class="btn btn-outline" style="flex:1;">Kembali</a>
            <button id="save-proof" class="btn" style="flex:1; margin-top:0; display: none;">Simpan</button>
            <button id="share-proof" class="btn" style="flex:1; margin-top:0;">Bagikan</button>
        </div>
        <div style="text-align: center; font-size: 0.9rem; color: #6B7280; margin-top: 16px;">
            <small>Jika ada pertanyaan, silakan hubungi kami di <a href="https://wa.me/<?=$telp_cs?>" style="color: #036ffc;">WhatsApp <?=$telp_cs?></a>.</small>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
        <script>
        document.getElementById('save-proof').addEventListener('click', function() {
            const container = document.querySelector('.container');
            this.style.display = 'none';
            document.getElementById('dash-proof').style.display = 'none';
            html2canvas(container).then(function(canvas) {
                document.getElementById('dash-proof').style.display = '';
                document.getElementById('save-proof').style.display = '';
                const link = document.createElement('a');
                link.download = 'bukti-transaksi-<?=$no_internet ?>.png';
                link.href = canvas.toDataURL('image/png');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });

        // Uncomment if you want to use share-proof button
        document.getElementById('share-proof').addEventListener('click', async function() {
            const container = document.querySelector('.container');
            this.style.display = 'none';
            // document.getElementById('save-proof').style.display = 'none';
            document.getElementById('dash-proof').style.display = 'none';
            html2canvas(container).then(async function(canvas) {
                document.getElementById('share-proof').style.display = '';
                document.getElementById('dash-proof').style.display = '';
                canvas.toBlob(async function(blob) {
                    if (navigator.canShare && navigator.canShare({ files: [new File([blob], 'bukti-transaksi.png', {type: blob.type})] })) {
                        try {
                            await navigator.share({
                                files: [new File([blob], 'bukti-transaksi.png', {type: blob.type})],
                                title: 'Bukti Transaksi',
                                text: 'Berikut bukti transaksi pembayaran Anda.'
                            });
                        } catch (err) {
                            alert('Gagal membagikan: ' + err);
                        }
                    } else {
                        const link = document.createElement('a');
                        link.download = 'bukti-transaksi.png';
                        link.href = URL.createObjectURL(blob);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        alert('Fitur bagikan tidak didukung di perangkat ini. File telah diunduh.');
                    }
                }, 'image/png');
            });
        });
        </script>
    </div>
</body>
</html>
