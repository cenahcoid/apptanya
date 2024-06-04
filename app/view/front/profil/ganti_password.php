<div class="section">
  <div class="column">
    <div class="content">
      <h1 class="text-center">Reset Passwrod</h1>
      <form id="fganti" method="post" class="form-horizontal">
        <div class="form-group">
          <label for="ipassword_lama" class="control-label">Password Lama *</label>
          <input id="ipassword_lama" type="password" class="form-control" name="password_lama" placeholder="password lama" minlength="3" required />
        </div>
        <div class="form-group">
          <label for="ipassword_baru" class="control-label">Password Baru *</label>
          <input id="ipassword_baru" type="password" class="form-control" name="password_baru" placeholder="password baru" required />
        </div>
        <div class="form-group">
          <label for="iverifikasi_password_baru" class="control-label">Verifikasi Password Baru*</label>
          <input id="iverifikasi_password_baru" type="password" class="form-control" placeholder="verifikasi password baru" required />
        </div>
        <div class="form-group form-action">
          <button type="submit" class="btn btn-primary btn-submit">Simpan perubahan <i class="icon-submit fa fa-save"></i></button>
          <a href="<?=base_url("profil")?>" class="btn btn-danger">Batal <i class="fa fa-times" aria-hidden="true"></i></a>
        </div>
      </form>
    </div>
  </div>
</div>
