<form action="/SignIn" method="POST" enctype="application/x-www-form-urlencoded">
    <label for="username">
        <span>Username</span>
    </label>
    <input id="username" type="text" name="username" value="<?php _e($_POST['username']) ?>">

    <label for="password">
        <span>Password</span>
    </label>
    <input id="password" type="password" name="password">

    <?php
    if (_b($message)):
        echo '<p class="danger">'.$message.'</p>';
    endif;
    ?>

    <button type="submit">Sign in</button>
</form>

<form action="/SignOut" method="POST" enctype="application/x-www-form-urlencoded">
    <button type="submit">Sign out</button>
</form>