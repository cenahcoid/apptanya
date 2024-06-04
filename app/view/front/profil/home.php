<div class="section">
  <div class="column">
    <div class="content">
      <center>
        <amp-img layout="fixed" width="100px" height="100px" src="<?=base_url('media/user/default.png')?>"></amp-img>
      </center>
      <h1><?=$sess->user->nama?></h1>
      <p><?=$sess->user->email?></p>
      <br>
      <div class="form-group form-action">
        <a href="<?=base_url("profil/edit")?>" class="btn btn-default">Edit Profil <i class="icon-submit fa fa-pencil"></i></a>
        <a href="<?=base_url("profil/ganti_password")?>" class="btn btn-default">Ganti Password <i class="icon-submit fa fa-key"></i></a>
        <a href="<?=base_url("logout")?>" class="btn btn-warning">Logout <i class="icon-submit fa fa-sign-out"></i></a>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
