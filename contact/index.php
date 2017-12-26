<!DOCTYPE html>
<html>
    <head>
        <title>Carbon Sequestration | CREEC</title>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/head.php'); ?>
    </head>
    <body>
        <div id="page-wrapper">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/header.php'); ?>
            <?php
                $page = 'about';
                $load = true;
                $success = false;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $load = false;
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $message = $_POST['message'];
                    $to = 'vmatzek@scu.edu';
                    $alt = 'pearce.ropion@me.com';
                    $subject = 'CREEC Inquiry';
                    $headers = array('From: '.$name,'Reply-To: '.$email,'X-Mailer: PHP/'.phpversion());
                    $headers = implode("\r\n", $headers);
                    if (mail($alt, $subject, $message, $headers)) {
                        $success = true;
                    } else {
                        echo 'Mail Not Sent!';
                    }
                }
            ?>
            <div id="content">
                <noscript>
                    <div class="fallback">
                        <div class="logo"></div>
                        <section>
                            <h1>CREEC</h1>
                            <h2>Carbon in Riparian Ecosystems Estimator<br />for California</h2>
                            <p>
                                For full functionality of this website it is necessary to <strong>enable JavaScript</strong>.<br />
                                Here are the <a href="http://www.enable-javascript.com" target="_blank" rel="noopener noreferrer">instructions how to enable JavaScript in your web browser</a>.
                            </p>
                        </section>
                    </div>
                </noscript>
                <div id="content-wrapper" class="jscontent" style="display: none;">
                    <div id="display-wrapper">
                        <div id="contact">
                            <?php if ($success): ?>
                                <div id="notice" class="n-box n-success">
                                    <p><strong>Success</strong>: Thank you! We'll get back to you as soon as possible.</p>
                                    <a href="#" class="n-dismiss">X</a>
                                </div>
                            <?php elseif (!$success && !$load): ?>
                                <div id="notice" class="n-box n-error">
                                    <p><strong>Error</strong>: There was a problem sending your email.</p>
                                    <a href="#" class="n-dismiss">X</a>
                                </div>
                            <?php endif; ?>
                            <section class="one-forth left contact-error-box">
                                <p>
                                    <strong>Error</strong>:<br />
                                    <span class="error-display"></span>
                                </p>
                            </section>
                            <section class="one-half sec-def left" style="clear: none;">
                                <h1>Contact</h1>
                                <p class="paragraph">Questions about CREEC can be directed to Virginia Matzek at <a href="mailto:vmatzek@scu.edu?Subject=CREEC%20Inquiry" target="_top">vmatzek@scu.edu</a></p>
                                <form id="contact-form" name="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <input name="name" type="text" placeholder="Name" />
                                    <input name="email" type="email" placeholder="Email" />
                                    <textarea name="message" placeholder="Message..." style="height: 40px;"></textarea>
                                    <input type="submit" class="c-button" />
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <span class="clear"></span>
            </div>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/creec/includes/footer.php'); ?>
    </body>
</html>
