<div class="section">
  <div class="column">
    <div class="content">
      <h1 class="text-center">Reset Passwrod</h1>
      <form id="flogin" method="post" class="form-horizontal">
        <div class="form-group">
          <label for="iusername" class="control-label">Username *</label>
          <input id="iusername" type="text" class="form-control" name="username" placeholder="Username" minlength="3" required />
        </div>
        <div class="form-group">
          <label for="ipassword_lama" class="control-label">Password Lama *</label>
          <input id="ipassword_lama" type="password_lama" class="form-control" name="password_lama" placeholder="password lama" required />
        </div>
        <div class="form-group">
          <label for="ipassword_baru" class="control-label">Password Baru*</label>
          <input id="ipassword_baru" type="password_baru" class="form-control" name="password_baru" placeholder="password baru" required />
        </div>
        <div class="form-group form-action">
          <button type="submit" class="btn btn-primary btn-submit">Konfirmasi <i class="icon-submit fa fa-sign-in"></i></button>
          <a href="<?=base_url("lupa")?>" class="btn btn-danger">Batal <i class="fa fa-times" aria-hidden="true"></i></a>
        </div>
      </form>
    </div>
  </div>
</div>
