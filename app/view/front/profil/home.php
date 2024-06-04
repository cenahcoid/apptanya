<div class="section">
  <div class="column">
    <div class="content">
      <center>
        <amp-img id="display_picture_show" layout="fixed" width="100px" height="100px" src="<?=$this->display_picture_src($sess->user->display_picture)?>"></amp-img>
      </center>
      <h1><?=$sess->user->nama?></h1>
      <p><?=$sess->user->email?></p>
      <br>
      <div class="form-group form-action">
        <a href="#" class="btn btn-default btn-ganti-display-picture">Ganti Foto Profil <i class="icon-submit fa fa-image"></i></a>
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
<form id="display_picture_form" style="display: none;" method="post">
  <input type="file" id="idisplay_picture" accept="image/png, image/jpeg">
</form>
<img src="" id="idisplay_picture_original" style="display: none;" />
<img src="" id="idisplay_picture_resized" style="display: none;" />