<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/public/css/feedback.css">
    <title>Feedback</title>
</head>

<body>
    <div class="contact-form-wrapper">
        <?php         
            if(!empty($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                $to = "";
                $headers = "Name: ".$name . "\r\rEmail: " . $email . "\r\rSubject: " . $subject . "\r\rMessage: " . $message;
              
                if(mail($to, $name, $headers)) {
                    $success_message = "Feedback Successfully Received";
                }

            }
        ?>
        <form action="" method="post">
            <a href="home.php" class="back-btn">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="title-txt">
                <h1>Say hello to us 😀</h1>
                <p>
                    Share your thoughts with us so we can provide a better experience for you in the near future.
                </p>
            </div>
            <input name="name" id="name_txt" type="text" class="feedback-input" placeholder="Name" required />
            <input name="email" id="email_txt" type="text" class="feedback-input" placeholder="Email" required />
            <input name="subject" id="subject_txt" type="text" class="feedback-input" placeholder="Subject" required />
            <textarea name="message" id="message_txt" class="feedback-input" placeholder="Message" required></textarea>
            <input type="submit" name="submit" id="send" value="SUBMIT" />
            <?php 
            if(!empty($success_message)){ ?>
            <div class="success">
                <strong><?php echo $success_message;?></strong>
            </div>
            <?php }?>
        </form>

    </div>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="/public/js/sendFeedback.js"></script>
</body>

</html>