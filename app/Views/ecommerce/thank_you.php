<!DOCTYPE html>
<html>
<head>
    <title>Payment Gateway Integration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/mainDoc/css/paypal.css'); ?>">
</head>
<body>
    <div class="container">
        <?php if (!empty($paymentID)): ?>
            <h2 style="text-align: center; color: blue;">Thank You !!</h2>
            <h3 style="text-align: center; color: green;">Your Payment has been Successful.</h3>
        <?php else: ?>
            <h2 style="text-align: center; color: blue;">Sorry !!</h2>
        <?php endif; ?>

        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="status">
                    <?php if (!empty($paymentID)): ?>
                        <h4 class="heading">Payment Information - </h4>
                        <br>
                        <p><b>Order ID : </b> <strong><?= $order_id; ?></strong></p>
                        <p><b>Transaction ID : </b> <?= $paymentID; ?></p>
                        <p><b>Paid Amount : </b> <?= $amount; ?></p>
                        <p><b>Currency : </b> USD </p>
                        <p><b>Payment Status : </b> Success </p>

                        <h4 class="heading">Product Information - </h4>
                        <br>
                        <p><b>Name : </b> <?= $user_name; ?></p>

                        <h4 class="heading">Date & Time</h4>
                        <p><b>Pay Date : </b> <?= $date; ?></p>
                        <p><b>Pay Time : </b> <?= $time; ?></p>

                    <?php else: ?>
                        <h1 class="error">Sorry !! Your Payment has Failed.</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <h3 style="text-align: center;"><a href="<?= base_url('clear-cart'); ?>" class="btn-continue">Back to Home</a></h3>
    </div>
</body>
</html>
