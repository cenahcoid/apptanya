<?php $this->getThemeElement('tanyajawab/style', $__forward); ?>
<div class="section">
  <div class="column">
    <div class="content">
      <div class="media">
        <a href="#" class="pull-left">
          <img src="<?=$this->display_picture_src($data->penanya->display_picture, 'https://skin.cenah.co.id/img/placeholders/avatars/avatar3.jpg')?>" alt="Foto profil <?=$data->penanya->nama?>" class="img-circle"  style="width: 64px; height: 64px;">
        </a>
        <div class="media-body">
          <p class="push-bit">
            <span class="text-muted pull-right">
              <small><?=$this->__dateIndonesia($data->tgl_tanya,'hari_tanggal_jam')?></small>
              <span class="text-danger" data-toggle="tooltip" title="" data-original-title="From Web"><i class="fa fa-globe"></i></span>
            </span>
            <strong><a href="#"><?=$data->penanya->nama?></a> bertanya.</strong>
          </p>
          <p><?=$data->tanya?></p>
          <a href="<?=base_url('voting/pertanyaan/like/'.$data->id)?>" class="btn btn-xs btn-success"><?=$this->rating_to_html($data->rating, 'positive')?> Vote <i class="fa fa-thumbs-up"></i></a>
          <a href="<?=base_url('voting/pertanyaan/dislike/'.$data->id)?>" class="btn btn-xs btn-danger"><?=$this->rating_to_html($data->rating, 'negative')?> Vote <i class="fa fa-thumbs-down"></i></a>
                    <a href="<?=base_url('voting/pertanyaan/neutral/'.$data->id)?>" class="btn btn-xs btn-default">Vote <i class="fa fa-minus"></i></a>

          <!-- Comments -->
          <?php if (count($data->jawabans) > 0): ?>
            <ul class="media-list push">
              <?php foreach ($data->jawabans as $k => $v): ?>
                <li class="media">
                  <a href="#" class="pull-left">
                    <img src="<?=$this->display_picture_src($v->display_picture, 'https://skin.cenah.co.id/img/placeholders/avatars/avatar4.jpg')?>" alt="Foto profil <?=$v->nama?>" class="img-circle" style="width: 64px; height: 64px;">
                  </a>
                  <div class="media-body">
                    <a href="#"><strong><?=$v->nama?></strong></a>
                    <span class="text-muted"><small><em><?=$this->__dateIndonesia($v->created_at, 'hari_tanggal_jam')?></em></small></span>
                    <p><?=$v->jawaban?></p>
                    <a href="<?=base_url('voting/jawaban/like/'.$data->id.'/'.$v->id)?>" class="btn btn-xs btn-success"><?=$this->rating_to_html($v->rating, 'positive')?> Vote <i class="fa fa-thumbs-up"></i></a>
                    <a href="<?=base_url('voting/jawaban/dislike/'.$data->id.'/'.$v->id)?>" class="btn btn-xs btn-danger"><?=$this->rating_to_html($v->rating, 'negative')?> Vote <i class="fa fa-thumbs-down"></i></a>
                    <a href="<?=base_url('voting/jawaban/neutral/'.$data->id.'/'.$v->id)?>" class="btn btn-xs btn-default">Vote <i class="fa fa-minus"></i></a>
                  </div>
                </li>
              <?php endforeach; ?>
              
            </ul>
          <?php else: ?>
            <p><em><small>Belum ada yang jawab</small></em></p>
          <?php endif; ?>
          
          <!-- END Comments -->

          <!-- Form -->
          <div class="block-top block-content-mini-padding">
            <form id="fjawab" action="<?=base_url()?>" method="post" onsubmit="return false;">
              <textarea id="ijawab" name="jawab" class="form-control push-bit" rows="3" placeholder="Tulis jawaban atas pertanyaan ini.." minlength="2" maxlength="254" required></textarea>
              <div class="clearfix">
                <button type="submit" class="btn btn-sm btn-primary btn-submit pull-right">Berikan jawaban <i class="fa fa-send icon-submit"></i> </button>
              </div>
            </form>
          </div>
          <!-- END Form -->
        </div>
      </div>
      
  </div>
</div>
