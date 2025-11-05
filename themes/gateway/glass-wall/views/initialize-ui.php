<?php
    if (!defined('pp_allowed_access')) {
        die('Direct access not allowed');
    }
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --glass-bg: rgba(255, 255, 255, 0.5);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #a8c0ff, #3f2b96);
            color: var(--dark-color);
            line-height: 1.6;
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
        }

        .payment-header {
            display: flex;
            background: rgba(255, 255, 255, 0.2);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 1.5rem;
            align-items: center;
            justify-content: space-between;
        }

        .payment-logo img {
            height: 30px;
        }

        .payment-body {
            padding: 1.5rem;
        }

        .payment-amount {
            display: flex;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
            position: relative;
        }

        .merchant-logo {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 1rem;
            background: white;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .merchant-details {
            flex: 1;
        }

        .merchant-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .amount-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .amount-label {
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        .payment-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid var(--glass-border);
            color: var(--dark-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .method-tabs {
            display: flex;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 1rem;
        }

        .method-tab {
            padding: 0.75rem 1rem;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            color: var(--secondary-color);
        }

        .method-tab.active {
            border-bottom-color: var(--primary-color);
            color: var(--primary-color);
        }

        .method-content {
            display: none;
        }

        .method-content.active {
            display: block;
        }

        .grid-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .grid-box {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s ease;
            text-align: center;
            padding: 1rem;
        }

        .grid-box:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .grid-box img {
            height: 45px;
            max-width: 100%;
            margin-bottom: 0.5rem;
        }

        .grid-box-footer {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .btn-pay {
            width: 100%;
            padding: 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-pay:hover {
            background: #0056b3;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            transform: translateY(-2px);
        }

        .payment-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--glass-border);
            font-size: 0.8rem;
            color: var(--secondary-color);
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <i class="fas fa-times" style="cursor: pointer;" onclick="location.href='?cancel'"></i>
            <div class="payment-logo">
                <img src="<?php if(isset($setting['response'][0]['logo'])){if($setting['response'][0]['logo'] == "--"){echo 'https://cdn.piprapay.com/media/logo.png';}else{echo $setting['response'][0]['logo'];};}else{echo 'https://cdn.piprapay.com/media/logo.png';}?>" alt="Logo">
            </div>
            <div class="payment-actions">
                <button class="global-tab action-btn" data-tab="support-tab">
                    <i class="fas fa-headset"></i>
                </button>
                <button class="global-tab action-btn" data-tab="help-tab">
                    <i class="fas fa-question"></i>
                </button>
                <button class="global-tab action-btn" data-tab="information-tab">
                    <i class="fas fa-info"></i>
                </button>
            </div>
        </div>
        
        <div class="payment-body">
            <div class="payment-amount">
                <img src="<?php if(isset($setting['response'][0]['favicon'])){if($setting['response'][0]['favicon'] == "--"){echo 'https://cdn.piprapay.com/media/favicon.png';}else{echo $setting['response'][0]['favicon'];};}else{echo 'https://cdn.piprapay.com/media/favicon.png';}?>" alt="Merchant Logo" class="merchant-logo">
                <div class="merchant-details">
                    <div class="merchant-name"><?php echo $setting['response'][0]['site_name']?></div>
                    <div class="amount-value"><?php echo number_format($transaction_details['response'][0]['transaction_amount']+$transaction_details['response'][0]['transaction_fee'], 2).$transaction_details['response'][0]['transaction_currency']?></div>
                    <div class="amount-label">Invoice: <?php echo $transaction_details['response'][0]['pp_id']?></div>
                </div>
            </div>
            
            <div class="payment-methods">
                <div class="method-tabs">
                    <?php
                        $tabs = [
                            'mobile-banking' => [
                                'title' => 'Mobile Banking',
                                'gateways' => pp_get_payment_gateways('Mobile Banking', $payment_id),
                            ],
                            'ibanking' => [
                                'title' => 'IBanking',
                                'gateways' => pp_get_payment_gateways('IBanking', $payment_id),
                            ],
                            'international' => [
                                'title' => 'International',
                                'gateways' => pp_get_payment_gateways('International', $payment_id),
                            ],
                        ];
                        
                        $availableTabs = [];
                        foreach ($tabs as $key => $tab) {
                            if (!empty($tab['gateways']['response'])) {
                                $availableTabs[] = $key;
                            }
                        }
                    ?>
                    <?php foreach ($tabs as $key => $tab): ?>
                        <?php if (!empty($tab['gateways']['response'])): ?>
                            <div class="global-tab method-tab" data-tab="<?= $key ?>"><?= $tab['title'] ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                
                <?php foreach ($tabs as $key => $tab): ?>
                    <?php if (!empty($tab['gateways']['response'])): ?>
                    <div class="method-content" id="<?= $key ?>">
                        <div class="grid-wrapper">
                            <?php foreach ($tab['gateways']['response'] as $gateway): ?>
                                <div class="grid-box" onclick="location.href='?method=<?= $gateway['plugin_slug'] ?>'">
                                    <img src="<?= $gateway['plugin_logo'] ?>" alt="<?= $gateway['plugin_name'] ?>">
                                    <div class="grid-box-footer"><?= $gateway['plugin_name'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="method-content" id="support-tab">
                    <div class="netbanking-form rounded">
                        <div class="custom-contact-grid">
                            <?php foreach ($support_links as $key => $support_link): ?>
                                <?php $url = trim($support_link['url']); ?>
                                <?php if ($url !== '' && $url !== '--'): ?>
                                    <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" class="contact-box">
                                        <div class="contact-inner">
                                            <img src="<?php echo htmlspecialchars($support_link['image']); ?>" alt="icon">
                                            <span><?php echo htmlspecialchars($support_link['text']); ?></span>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="method-content" id="help-tab">
                    <div class="netbanking-form shadow-sm bg-white rounded">
                        <div class="accordion" id="accordionGroupExample">
                            <?php
                                foreach($faq_list['response'] as $faq){
                                    $rand_faq = rand();
                            ?>
                                    <div class="accordion-item border-0 mb-2" style="border-bottom: 1px solid #dddddd63 !important;">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapse<?php echo $rand_faq?>">
                                                <span class="text-secondary"><?php echo $faq['title'];?></span>
                                            </button>
                                        </div>
                                        <div id="collapse<?php echo $rand_faq?>" class="accordion-collapse collapse" 
                                             data-bs-parent="#accordionGroupExample">
                                            <div class="accordion-body text-muted small">
                                                <?php echo $faq['content'];?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="method-content" id="information-tab">
                    <div class="netbanking-form shadow-sm bg-white rounded">
                        <ul class="list-unstyled p-4" style="font-size: 15px;margin: 0;">
                            <li class="d-flex justify-content-between">
                                <span class="fw-semibold text-secondary">Name:</span>
                                <span class="fw-semibold text-secondary"><?php echo $transaction_details['response'][0]['c_name']?></span>
                            </li>
                            <hr class="my-2 border-secondary opacity-10">
                            <li class="d-flex justify-content-between">
                                <span class="fw-semibold text-secondary">Email or Mobile:</span>
                                <span class="fw-semibold text-secondary"><?php echo $transaction_details['response'][0]['c_email_mobile']?></span>
                            </li>
                            <hr class="my-2 border-secondary opacity-10">
                            <li class="d-flex justify-content-between">
                                <span class="fw-semibold text-secondary">Amount:</span>
                                <span class="fw-semibold" style="color:<?php echo $setting['response'][0]['global_text_color']?>"><?php echo number_format($transaction_details['response'][0]['transaction_amount'], 2).$transaction_details['response'][0]['transaction_currency']?></span>
                            </li>
                            <hr class="my-2 border-secondary opacity-10">
                            <li class="d-flex justify-content-between">
                                <span class="text-secondary">Fee:</span>
                                <span class="text-secondary"><?php echo number_format($transaction_details['response'][0]['transaction_fee'], 2).$transaction_details['response'][0]['transaction_currency']?></span>
                            </li>
                            <hr class="my-2 border-secondary opacity-10">
                            <li class="d-flex justify-content-between">
                                <span class="fw-semibold text-secondary">Total Payable Amount:</span>
                                <span class="fw-semibold" style="color:<?php echo $setting['response'][0]['global_text_color']?>"><?php echo number_format($transaction_details['response'][0]['transaction_amount']+$transaction_details['response'][0]['transaction_fee'], 2).$transaction_details['response'][0]['transaction_currency']?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="payment-footer">
            <div>Your payment is secured with 256-bit encryption</div>
            <div class="secure-badge">
                <span>Powered by <a href="https://piprapay.com/" target="blank" style="color: var(--primary-color); text-decoration: none"><strong style="cursor: pointer">PipraPay</strong></a></span>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.method-tab');
            const contents = document.querySelectorAll('.method-content');
        
            // Activate the first available tab
            if (tabs.length > 0 && contents.length > 0) {
                tabs[0].classList.add('active');
                const tabId = tabs[0].getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            }
        
            // Tab switching logic
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));
        
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabs = document.querySelectorAll('.global-tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.method-content').forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding content
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });

        });
    </script>
</body>
</html>