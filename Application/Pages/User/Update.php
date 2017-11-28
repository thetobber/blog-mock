<form action="/User/Update/<?php _e($model->id) ?>" method="POST" enctype="application/x-www-form-urlencoded">
    <input type="hidden" name="id" value="<?php _e($model->id) ?>">

    <label for="email">
        <span>E-mail</span>
        <span class="danger">
            <?php _b($errors['email']) ? _e($errors['email']) : '' ?>
        </span>
    </label>
    <input id="email" type="text" name="email" value="<?php _e($model->email) ?>">

    <label for="old_password">
        <span>Old password</span>
        <span class="danger">
            <?php _b($errors['old_password']) ? _e($errors['old_password']) : '' ?>
        </span>
    </label>
    <input id="old_password" type="password" name="old_password">

    <label for="password">
        <span>New password</span>
        <span class="danger">
            <?php _b($errors['password']) ? _e($errors['password']) : '' ?>
        </span>
    </label>
    <input id="password" type="password" name="password">

    <label for="confirm">
        <span>Confirm new password</span>
        <span class="danger">
            <?php _b($errors['confirm']) ? _e($errors['confirm']) : '' ?>
        </span>
    </label>
    <input id="confirm" type="password" name="confirm">

    <button type="submit">Update account</button>
</form>