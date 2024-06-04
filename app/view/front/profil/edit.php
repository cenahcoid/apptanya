<div class="section">
  <div class="column">
    <div class="content">
      <h1 class="text-center">Edit Profil</h1>
      <form id="fganti2" method="post" class="form-horizontal">
        <div class="form-group">
          <label for="inama" class="control-label">Nama *</label>
          <input id="inama" type="text" class="form-control" name="nama" placeholder="nama" minlength="3" value="<?=$sess->user->nama?>" required />
        </div>
        <div class="form-group">
          <label for="iemail" class="control-label">Email *</label>
          <input id="iemail" type="text" class="form-control" name="email" placeholder="email" minlength="3" value="<?=$sess->user->email?>" equired />
        </div>
        <div class="form-group">
          <label class="control-label" for="ijk">Jenis Kelamin </label>
          <select id="ijk" name="jk" class="form-control">
            <option value="1" <?php if(!empty($sess->user->jk)) echo 'selected'; ?>>Laki-laki</option>
            <option value="0" <?php if(empty($sess->user->jk)) echo 'selected'; ?>>Perempuan</option>
          </select>
        </div>
        <div class="form-group">
          <label for="ialamat" class="control-label">Alamat *</label>
          <input id="ialamat" type="alamat" class="form-control" name="alamat" placeholder="almaat" value="<?=$sess->user->alamat?>" required />
        </div>
        <div class="form-group form-action">
          <button type="submit" class="btn btn-primary btn-submit">Simpan Perubahan <i class="icon-submit fa fa-save"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>
