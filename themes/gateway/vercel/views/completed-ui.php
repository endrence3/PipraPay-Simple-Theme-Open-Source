<?php
    if (!defined('pp_allowed_access')) {
        die('Direct access not allowed');
    }
    
    $theme_slug = 'vercel';
    $settings = pp_get_theme_setting($theme_slug);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - <?php echo $setting['response'][0]['site_name']?></title>
    <link rel="icon" type="image/x-icon" href="<?php if(isset($setting['response'][0]['favicon'])){if($setting['response'][0]['favicon'] == "--"){echo 'https://cdn.piprapay.com/media/favicon.png';}else{echo $setting['response'][0]['favicon'];};}else{echo 'https://cdn.piprapay.com/media/favicon.png';}?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #6c757d;
            --glass-bg: rgba(255, 255, 255, 0.5);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #a8e063, #56ab2f);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .payment-container {
            max-width: 600px;
            width: 100%;
            margin: 2rem;
            background: var(--glass-bg);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            overflow: hidden;
            text-align: center;
            padding: 2rem;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 3rem;
            animation: bounceIn 0.5s ease-in-out;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .success-message {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .success-details {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .detail-label {
            font-weight: 500;
            color: var(--secondary-color);
        }

        .detail-value {
            font-weight: 500;
        }

        .btn-done {
            background: var(--primary-color);
            color: white;
            border: none;
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-done:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-print {
            background: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-print:hover {
            background: rgba(40, 167, 69, 0.1);
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">Your payment has been processed successfully.</p>
        
        <?php
            if(isset($settings['auto_redirect']) && $settings['auto_redirect'] == "Enable"){
        ?>
               <p class="countdown-message">Redirecting in <span id="countdown">4</span> seconds...</p>
        <?php
            }
        ?>
        
        <div class="success-details">
            <div class="detail-row">
                <div class="detail-label">Payment Method</div>
                <div class="detail-value"><?php echo $transaction_details['response'][0]['payment_method']?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Amount Paid</div>
                <div class="detail-value"><?php echo number_format($transaction_details['response'][0]['transaction_amount']+$transaction_details['response'][0]['transaction_fee'], 2).$transaction_details['response'][0]['transaction_currency']?></div>
            </div>
        </div>
        
        <form action="<?php echo $transaction_details['response'][0]['transaction_redirect_url']?>" method="<?php echo $transaction_details['response'][0]['transaction_return_type']?>">
            <input type="hidden" name="pp_id" value="<?php echo $transaction_details['response'][0]['pp_id']?>">
            <button class="btn-done" id="done-button">
                <i class="fas fa-check-circle"></i> Back to website
            </button>
        </form>
        
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Print Receipt
        </button>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        if(isset($settings['auto_redirect']) && $settings['auto_redirect'] == "Enable"){
    ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let countdown = 4;
                    const countdownElement = document.getElementById('countdown');
                    
                    const countdownInterval = setInterval(function() {
                        countdown--;
                        countdownElement.textContent = countdown;
                        
                        if (countdown <= 0) {
                            clearInterval(countdownInterval);
                            document.getElementById('done-button').click();
                        }
                    }, 1000);
                });
            </script>
    <?php
        }
    ?>
</body>
</html>