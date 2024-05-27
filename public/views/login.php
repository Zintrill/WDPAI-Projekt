<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <title>LOGIN PAGE</title>
</head>
<body>
    <div class="container-login">
        <div class="box">
            <form class="login" action="login" method="POST">
                <img src="public/img/logo.svg">
                <input name="username" type="text" placeholder="USERNAME">
                <input name="password" type="password" placeholder="PASSWORD">
                <div class="meesages">
                    <?php if(isset($messages)) {
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <button type="submit" class="button-login">LOGIN</button></a>
                <p class="register-text">Don’t have account? <a href="#" class="link-register">Create here</a>.</p>
                <button class="register-button">JOIN NOW</button> 
            </form>
        </div>
    </div>
</body>