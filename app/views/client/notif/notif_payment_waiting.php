<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran Virtual Account</title>
    <!-- Bootstrap 3.7 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
        }
        
        .payment-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .payment-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        
        .payment-header h2 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .status-label {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .status-pending {
            background-color: #f39c12;
            color: white;
        }
        
        .status-paid {
            background-color: #2ecc71;
            color: white;
        }
        
        .status-expired {
            background-color: #e74c3c;
            color: white;
        }
        
        .payment-amount {
            font-size: 28px;
            text-align: center;
            margin: 20px 0;
            color: #e74c3c;
            font-weight: bold;
        }
        
        .detail-row {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            color: #7f8c8d;
            font-weight: 500;
        }
        
        .detail-value {
            font-weight: bold;
            text-align: right;
        }
        
        .bank-info {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .bank-logo {
            max-width: 150px;
            margin: 0 auto 15px;
            display: block;
        }
        
        .timer {
            text-align: center;
            font-size: 18px;
            color: #e74c3c;
            font-weight: bold;
            margin: 20px 0;
            padding: 10px;
            background-color: #fff9f9;
            border-radius: 5px;
            border: 1px solid #ffdddd;
        }
        
        .instructions {
            margin: 25px 0;
            padding: 0 20px;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #95a5a6;
            font-size: 14px;
            border-top: 1px solid #eee;
        }
        
        .btn-copy {
            margin-left: 10px;
        }
        
        @media (max-width: 768px) {
            .payment-container {
                margin: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="payment-container">
                    <div class="payment-header">
                        <h2>Detail Pembayaran</h2>
                        <span class="status-label status-pending">MENUNGGU PEMBAYARAN</span>
                    </div>
                    
                    <div class="payment-amount">
                        Rp 1.250.000
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Nomor Pesanan</span>
                        <span class="detail-value">INV-20230811-001</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Pesanan</span>
                        <span class="detail-value">11 Agustus 2023, 14:30 WIB</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Batas Waktu Pembayaran</span>
                        <span class="detail-value">11 Agustus 2023, 23:59 WIB</span>
                    </div>
                    
                    <div class="timer">
                        Sisa waktu: <span id="countdown-timer">08:25:14</span>
                    </div>
                    
                    <div class="bank-info">
                        <img src="https://via.placeholder.com/150x50?text=BANK+LOGO" alt="Bank Logo" class="bank-logo img-responsive">
                        
                        <div class="detail-row">
                            <span class="detail-label">Virtual Account Number</span>
                            <span class="detail-value">
                                8888801234567890
                                <button class="btn btn-success btn-xs btn-copy" onclick="copyToClipboard('8888801234567890')">
                                    <span class="glyphicon glyphicon-copy"></span> Salin
                                </button>
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Nama Bank</span>
                            <span class="detail-value">Bank Contoh</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">Atas Nama</span>
                            <span class="detail-value">PT. Contoh Pembayaran</span>
                        </div>
                    </div>
                    
                    <div class="instructions">
                        <h4><strong>Cara Pembayaran:</strong></h4>
                        <ol>
                            <li>Buka aplikasi mobile banking atau ATM bank Anda</li>
                            <li>Pilih menu "Transfer" atau "Pembayaran"</li>
                            <li>Masukkan nomor Virtual Account di atas</li>
                            <li>Masukkan jumlah pembayaran sesuai tagihan</li>
                            <li>Konfirmasi detail pembayaran dan masukkan PIN/MPIN</li>
                            <li>Simpan bukti pembayaran Anda</li>
                        </ol>
                    </div>
                    
                    <div style="padding: 0 20px 20px;">
                        <button class="btn btn-primary btn-block" onclick="checkPayment()">
                            <span class="glyphicon glyphicon-refresh"></span> CEK STATUS PEMBAYARAN
                        </button>
                    </div>
                    
                    <div class="footer">
                        Jika mengalami kesulitan, hubungi customer service kami di <br>
                        <strong>0800-1234-5678</strong> atau email <strong>cs@contoh.com</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script>
        function copyToClipboard(text) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
            
            // Show tooltip
            var btn = $(event.target).closest('button');
            btn.tooltip({title: 'Tersalin!', placement: 'right', trigger: 'manual'}).tooltip('show');
            
            setTimeout(function() {
                btn.tooltip('destroy');
            }, 1000);
        }
        
        function checkPayment() {
            // Show loading state
            var btn = $('.btn-primary');
            btn.html('<span class="glyphicon glyphicon-refresh glyphicon-spin"></span> Memeriksa...');
            btn.prop('disabled', true);
            
            // Simulate API call
            setTimeout(function() {
                btn.html('<span class="glyphicon glyphicon-ok"></span> Status Diperbarui');
                setTimeout(function() {
                    btn.html('<span class="glyphicon glyphicon-refresh"></span> CEK STATUS PEMBAYARAN');
                    btn.prop('disabled', false);
                }, 2000);
            }, 1500);
        }
        
        // Timer countdown
        function startTimer() {
            let time = 8 * 60 * 60 + 25 * 60 + 14; // 8 jam, 25 menit, 14 detik
            
            const interval = setInterval(() => {
                const hours = Math.floor(time / 3600);
                const minutes = Math.floor((time % 3600) / 60);
                const seconds = time % 60;
                
                $('#countdown-timer').text(
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
                );
                
                if (time <= 0) {
                    clearInterval(interval);
                    $('.status-label').removeClass('status-pending').addClass('status-expired').text('KADALUARSA');
                    $('#countdown-timer').parent().text('Waktu pembayaran telah habis');
                } else {
                    time--;
                }
            }, 1000);
        }
        
        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            startTimer();
        });
    </script>
</body>
</html>