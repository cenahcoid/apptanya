<?php $this->getThemeElement('tanyajawab/style', $__forward); ?>

<?php foreach($pertanyaan as $k=>$v): ?>
  <div class="section" style="padding-top: 0px; padding-bottom: 0px;">
    <div class="column">
      <div class="content">
        <div class="media">
          <a href="<?=base_url('tanyajawab/detail/'.$v->id)?>" class="pull-left">
            <img src="<?=$this->display_picture_src($v->display_picture, 'https://skin.cenah.co.id/img/placeholders/avatars/avatar3.jpg')?>" alt="Foto profil <?=$v->nama?>" class="img-circle"  style="width: 64px; height: 64px;">
          </a>
          <div class="media-body">
            <p class="push-bit">
              <span class="text-muted pull-right">
                <small><?=$this->__dateIndonesia($v->tgl_tanya,'tanggal_jam')?></small>
                <span class="text-danger" data-toggle="tooltip" title="" data-original-title="From Web"><i class="fa fa-globe"></i></span>
              </span>
              <strong><a href="<?=base_url('tanyajawab/detail/'.$v->id)?>"><?=$v->nama?></a> bertanya.</strong>
            </p>
            <p><?=$v->tanya?></p>
            <a href="<?=base_url('tanyajawab/detail/'.$v->id)?>" class="btn btn-xs btn-success"><i class="fa fa-people"></i> <?=$v->jawaban_count?> jawaban</a>
            <a href="<?=base_url('tanyajawab/detail/'.$v->id)?>" class="btn btn-xs btn-default"><?=$this->rating_to_html_stars($v->rating)?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<div style="height: 25vh; ">&nbsp;</div>
