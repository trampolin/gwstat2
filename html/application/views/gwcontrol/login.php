<div class="middle-box text-center loginscreen">
    <div>
        <div>

            <h1 class="logo-name">GW</h1>

        </div>
        <h3>Login für GW</h3>

        <form method="post" class="m-t" role="form" action="<?= base_url().'gw/processLogin' ?>">
            <div class="form-group">
                <select name="uni" class="form-control">
                    <?php foreach ($unis as $uni) { ?>
                        <option value="<?= $uni->name ?>"><?= $uni->name ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <input name="user" type="text" class="form-control" placeholder="Benutzername" required="">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Passwort" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
        </form>
    </div>
</div>
<?php

var_dump($this->session);