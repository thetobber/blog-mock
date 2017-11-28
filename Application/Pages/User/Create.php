<section class="card">
    <div class="card-body">
        <form action="/User/Create" method="POST" enctype="application/x-www-form-urlencoded">
            <?php
            _input('Username', 'username', $model->username, 'text', $state->errors['username']);
            _input('E-mail', 'email', $model->email, 'text', $state->errors['email']);
            _input('Password', 'password', $model->password, 'password', $state->errors['password']);
            _input('Confirm password', 'confirm', $model->confirm, 'password', $state->errors['confirm']);
            ?>
        
            <button type="submit">Create user</button>
        </form>
    </div>
</section>