<?php
$query = $db->prepare("SELECT * FROM urun where sef=:sef AND aktif=:aktif LIMIT 1");
$urun = $query->execute(array(":sef"=>$_GET['sef'],":aktif"=>1));
$urun = $query->fetch(PDO::FETCH_ASSOC);

if(!$urun){
  echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}

$_title         =  $urun['baslik'];
$_description   =  $urun['kisa_aciklama'];


?>
<div class="dis">
	<div class="row mt-10 mb-10">
		<div class="col-md-12">
			<ul class="adres_cubugu">
				<li><a href="index.php"><i class="las la-home"></i> Anasayfa</a> <span><i class="las la-angle-right"></i></span></li>
				<li><a href="urun/<?php echo $urun['sef']; ?>"><?php echo $urun['baslik']; ?></a></li>
			</ul>
		</div>
	</div>
	<div class="row mt-10">
		<div class="col-md-<?php echo $urun['magaza_id'] == 0 ? '5' : '4' ?>">
			<div class="p15 bg2 border">
				<div id="sync1" class="owl-carousel mb-15">
					<?php
						$alt_img = '';
			            $query = $db->query("SELECT * FROM urun_img WHERE urun_id = '{$urun['id']}' ", PDO::FETCH_ASSOC);
			            if($query->rowCount()){
			              foreach($query as $row){
		          			echo '<div class="item"><img class="img-responsive" src="upload/'.$row['img'].'"></div>';
		          			$alt_img.= '<div class="item"><img class="img-responsive" src="upload/'.$row['img'].'"></div>';
		          		  }
		          		}
		          	?>
		       </div>
		       <div id="sync2" class="owl-carousel">
		          <?php echo $alt_img; ?>
		       </div>
	       </div>
		</div>
		<div class="col-md-<?php echo $urun['magaza_id'] == 0 ? '7' : '8' ?>">
			<div class="p15 bg2 border urun_detay">
				<div class="row border-b mb-10"><div class="col-md-12"><h1><?php echo $urun['baslik']; ?></h1></div></div>
				<div class="row">
					<div class="col-md-<?php echo $urun['magaza_id'] == 0 ? '12' : '7' ?>">
						<div class="degerlendirme_paylas mb-10">
							<div class="yildiz pull-left">   
				              <span class="aktif">★★★★★</span>
				            </div>
				            <div class="paylas pull-right">
		                        <a href="https://www.facebook.com/sharer.php?u=<?php echo $site.'urun/'.$urun['sef']; ?>" target="_blank">
		                        	<i class="lab la-facebook" data-toggle="tooltip" data-placement="bottom" title="Sosyal Medya'da Paylaş"></i>
		                        </a>
		                        <a href="https://twitter.com/intent/tweet?url=<?php echo $site.'urun/'.$urun['sef']; ?>" target="_blank"s>
		                        	<i class="lab la-twitter" data-toggle="tooltip" data-placement="bottom" title="Sosyal Medya'da Paylaş"></i>
		                        </a>
		                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $site.'urun/'.$urun['sef']; ?>" target="_blank">
		                        	<i class="lab la-linkedin" data-toggle="tooltip" data-placement="bottom" title="Sosyal Medya'da Paylaş"></i>
		                        </a>
		                        <a href="https://api.whatsapp.com/send?text=<?php echo $site.'urun/'.$urun['sef']; ?>" target="_blank">
		                        	<i class="lab la-whatsapp" data-toggle="tooltip" data-placement="bottom" title="Sosyal Medya'da Paylaş"></i>
		                        </a>
		                    </div>
						</div>
						<?php 
						if($urun['marka_id'] != 0){
							$marka = $db->query("SELECT * FROM marka WHERE id = '{$urun['marka_id']}' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="marka mb-10">
							<a href="#" data-toggle="tooltip" data-placement="bottom" title="<?php echo $marka['baslik']; ?>"><img src="upload/<?php echo $marka['img']; ?>" alt="<?php echo $marka['baslik']; ?>" title="<?php echo $marka['baslik']; ?>"></a>
						</div>
						<?php } ?>
						<div class="stok_kod_durum mb-10">
							<div><span>Stok Kodu : </span><strong><?php echo $urun['stok_kodu']; ?></strong></div>
							<div><span>Stok Durumu : </span><strong class="durum<?php echo $urun['stok']; ?>"><?php echo $urun['stok'] > 0 ? 'Mevcut' : 'Tükendi'; ?></strong></div>
						</div>
						<div class="fiyat">
							<?php if(!empty($urun['eski_fiyat'])){ ?>
							<div class="row eski_fiyat border-t">
								<div class="col-md-4">Önceki Fiyat <span class="pull-right">:</span></div>
								<div class="col-md-8"><span><?php echo fiyat($urun['eski_fiyat']); ?> TL</span></div>
							</div>
							<?php } ?>
							<div class="row yeni_fiyat border-t border-b">
								<div class="col-md-4"><i class="las la-tags"></i> Fiyat <span class="pull-right">:</span></div>
								<div class="col-md-8"><span data-guncel-fiyat="<?php echo $urun['fiyat']; ?>"><?php echo fiyat($urun['fiyat']); ?> TL</span></div>
							</div>
						</div>

						<?php
					      $renkler = $db->query("SELECT * FROM urun_renk WHERE urun_id = '{$urun['id']}' ", PDO::FETCH_ASSOC);
					      if($renkler->rowCount()){
					    ?>
						<div class="row">
							<div class="col-md-12">
								<span class="varyant_baslik">Diğer Renk Seçenekleri</span>
								<ul class="varyant_renk">
									<?php
							            foreach($renkler as $r){
							              $rurun = $db->query("SELECT * FROM urun WHERE id = '{$r['renk_urun_id']}' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
							              $img1 = $db->query("SELECT * FROM urun_img WHERE urun_id = '{$r['renk_urun_id']}' LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
							              echo '<li><a href="urun/'.$rurun['sef'].'"><img src="upload/'.$img1['img'].'" class="img-responsive"></a></li>';
							            }
							        ?>
								</ul>
								</div>
						</div>
						<?php } ?>

						<?php if($urun['kampanya_baslangic'] < $time AND $urun['kampanya_bitis'] > $time){ ?>
						<label class="mt-10">Kapanya Süresi</label>
		                <div class="geri_ticifast" <?php echo 'data-tarih="'.date('m d Y H:i:s', $urun['kampanya_bitis']).'"'; ?>>
		                    <span class="gun"></span>
		                    <span class="saat"></span>
		                    <span class="dakika"></span>
		                    <span class="saniye"></span>
		                    <span class="bitti"></<span>
		                </div>
		                <?php } ?>
						<?php
					      $query = $db->query("SELECT * FROM urun_secenek WHERE urun_id = '{$urun['id']}' ", PDO::FETCH_ASSOC);
					      if($query->rowCount()){
					        foreach( $query as $row ){
					    ?>
						<div class="row varyant mb-10 border-b pt-10 pb-10">
							<div class="col-md-12">
								<strong><?php echo $row['baslik']; ?></strong>
							</div>
							<div class="col-md-12">
								<ul>
									<?php
							          $query1 = $db->query("SELECT * FROM urun_secenek_alt WHERE urun_secenek_id = '{$row['id']}' ORDER BY id ASC", PDO::FETCH_ASSOC);
							          if($query1->rowCount()){
							            foreach( $query1 as $row1 ){
							            	echo '<li data-stok="'.$row1['stok'].'" data-fiyat="'.$row1['fiyat'].'" data-secenek-id="'.$row1['id'].'">'.$row1['baslik'].'</li>';
							            }
							          }
							        ?>
								</ul>
							</div>
						</div>
						<?php } } ?>
						<div class="row border-b pb-10" id="sepete_ekle_durum"></div>
						<div class="row border-b pb-10">
							<div class="adet_butonlar">
								<div class="col-md-3">
									<div class="adet">
										<input type="text" class="form-control"  name="adet" id="adet" value="1">
										<button class="btn arti" ><i class="las la-angle-up"></i></button>
										<button class="btn eksi" ><i class="las la-angle-down"></i></button>
									</div>
								</div>
								<div class="col-md-4">
									<button class="btn btn-primary" data-sepete-ekle="<?php echo $urun['id']; ?>"><i class="las la-shopping-cart"></i> Sepete Ekle</button>
								</div>
								<div class="col-md-5" style="padding-left: 0px">
									<a href="https://api.whatsapp.com/send?phone=9<?php echo $cek['whatsapp']; ?>&amp;text=<?php echo $site.'urun/'.$urun['sef']; ?> Merhaba, bu ürünü sipariş vermek istiyorum." class="btn btn-success" target="_blank"><i class="lab la-whatsapp"></i> Whatsapp İle Sipariş</a>
								</div>
							</div>
						</div>
						<div class="row pt-10">
							<?php echo $urun['kargo_fiyati'] == 0 ? '<div class="col-md-4"><span class="kargo_bedava"><i class="las la-shipping-fast"></i> Kargo Bedava</span></div>' : ''; ?>
							<div class="col-md-4"><span data-toggle="tooltip" data-placement="bottom" title="Favorilerime Ekle" data-favori-ekle="<?php echo $urun['id']; ?>"><i class="las la-heart"></i> Favorilere Ekle</span></div>
							<div class="col-md-4"><span data-toggle="tooltip" data-placement="bottom" title="Karşılaştır" data-karsilastir-ekle="<?php echo $urun['id']; ?>"><i class="las la-random"></i> Karşılaştır</span></div>
						</div>
					</div>

					<?php 
					if($urun['magaza_id'] != 0){
						$magaza = $db->query("SELECT kullanici_id,magaza_adi,magaza_sef,profil_fotografi,kayit_tarihi FROM magaza WHERE kullanici_id = '{$urun['magaza_id']}' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="col-md-5 border-l magaza_detay">
						<div class="row">
							<div class="col-md-3 col-xs-3">
								<a href="<?php echo $magaza['magaza_sef']; ?>/" class="magaza_profil"><img src="upload/<?php echo $magaza['profil_fotografi']; ?>" alt="<?php echo $magaza['magaza_adi']; ?>" class="img-responsive"></a>
							</div>
							<div class="col-md-9 col-xs-9">
								<h3><a href="<?php echo $magaza['magaza_sef']; ?>/"><?php echo $magaza['magaza_adi']; ?></a></h3>
								<div class="puan mb-10">
									<small>Mağaza Açılış Tarihi</small><br>
									<small><?php echo date('Y-m-d', $magaza['kayit_tarihi']); ?></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php if(isset($_SESSION['kullanici']['login'])){ echo 'magazaya-soru-sor/'.$magaza['kullanici_id']; }else{ echo 'javascript:sorusor();'; } ?>" class="btn btn-warning"><i class="las la-comments"></i> Mağazaya Soru Sor</a>
							</div>
						</div>
						<?php
							$query = $db->query("SELECT
												urun.baslik,
												urun.sef,
												urun.fiyat,
												urun_img.img
												FROM
												urun
												INNER JOIN urun_img ON urun.id = urun_img.urun_id
												WHERE
												urun.magaza_id = '{$urun['magaza_id']}' AND
												urun.aktif = 1
												GROUP BY
												urun_img.urun_id
												LIMIT 3
												", PDO::FETCH_ASSOC);
           	 				if($query->rowCount()){
           	 			?>
							<div class="row border-b">
								<div class="col-md-12 benzer_urun_baslik">
									<i class="las la-list-ol"></i> Mağazanın Diğer Ürünleri
								</div>
							</div>
							<div class="row benzer_urunler">
								<?php foreach($query as $row){ ?>
								<div class="row">
									<div class="col-md-3 col-xs-3">
										<a href="urun/<?php echo $row['sef']; ?>"><img src="upload/<?php echo $row['img']; ?>" alt="<?php echo $row['baslik']; ?>" class="img-responsive"></a>
									</div>
									<div class="col-md-9 col-xs-9">
										<a href="urun/<?php echo $row['sef']; ?>"><?php echo $row['baslik']; ?></a>
										<span><?php echo fiyat($row['fiyat']); ?> TL</span>
									</div>
								</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
	<?php

		if($_POST){
			$_POST['yorum'] = strip_tags($_POST['yorum']);
			$islem = $db->prepare("INSERT INTO urun_yorum SET kullanici_id = ?, urun_id = ?, yorum = ?, durum = ?, tarih = ?");
		    $islem = $islem->execute(array($_SESSION['kullanici']['id'],$urun['id'],$_POST['yorum'],0,$time));
		   
		    if($islem){
		       echo '<div class="row yorum_sonuc"><div classs="col-md-12"><center><img src="assets/images/basari.png" class="img-responsive" style="width:100px"><br>Yorumunuz başarı ile oluşturuldu, yönetici onaylandıktan sonra gösterilecektir.</center></div></div>';
		    }else{
		        echo '<div class="row yorum_sonuc"><div classs="col-md-12"><center><img src="assets/images/hata.png" class="img-responsive" style="width:100px"><br>Yorumunuz eklenirken bir hata oluştu.</center></div></div>';
		    }
		    ?>
		    <script type="text/javascript">
		    	$(function(){
		    		$([document.documentElement, document.body]).animate({
				        scrollTop: $(".yorum_sonuc").offset().top
				    }, 2000);
		    	});
		    </script>
		    <?php
		}
		

	?>
	<div class="col-md-12 bg2 border mt-20">
		<div class="row">
			<ul class="urun_detay_tab_1 border-b">
				<li data-utabdis="1">Ürün Açıklaması</li>
				<li data-utabdis="2">Ürün Yorumları</li>
				<li data-utabdis="3">İade Koşulları</li>
			</ul>
			<div class="urun_detay_tab_2">
				<div data-utabic="1"><?php echo $urun['aciklama']; ?></div>
				<div data-utabic="2">
						
						<ul class="media-list">
							<?php
			                  $query = $db->query("
			                  	SELECT
									kullanici.ad,
									urun_yorum.yorum,
									urun_yorum.tarih
									FROM
									urun_yorum
									INNER JOIN kullanici ON urun_yorum.kullanici_id = kullanici.id
									WHERE
									urun_yorum.urun_id = '{$urun['id']}' AND
									urun_yorum.durum = 1
									", PDO::FETCH_ASSOC);
			                  if($query->rowCount()){
			                    foreach($query as $row){
			                       echo'<li class="media">
				                            <div class="media-body">
				                                <h4 class="media-heading">'.$row['ad'].'<br><small>'.date('Y-m-d H:i', $row['tarih']).'</small></h4>
				                                <p>'.$row['yorum'].'</p>
				                            </div>
				                        </li>';
			                    }
			                  }else{
			                  	echo '<li><h3>Yorum bulunamadı..</h3></li>';
			                  }
			                ?>
	                    </ul>

	                    <?php 
	                    	if(isset($_SESSION['kullanici']['login'])){ ?><br><br><br><br>
	                    <form action="" method="post">
	                    	<div class="row">
	                    		<div class="col-md-6">
	                    			<textarea class="form-control" placeholder="Yorumunuzu Yazınız..." name="yorum" required=""></textarea>
	                    			<button class="btn btn-primary mt-10 pull-right" type="submit">Yorum Yaz</button>
	                    		</div>
	                    	</div>
	                    </form>
	                	<?php 
	                		}else{
	                			echo '<h5>Yorum atmak için giriş yapmanız gerekiyor...</h5>';
	                		}
	                	?>


				</div>
				<div data-utabic="3">
					<?php
						$iade_kosullari = $db->query("SELECT * FROM iade_kosullari LIMIT 1")->fetch(PDO::FETCH_ASSOC);
						echo $iade_kosullari['aciklama'];
					?>
				</div>
			</div>
		</div>
	</div>
 	
    <div class="vitrin_baslik mt-20"><span class="bg3">Popüler Ürünler</span></div>
    <div class="anasayfa_vitrin owl-carousel mb-15" style="width: 100;float: left;">
      <?php
        $query = $db->query("SELECT
							urun.id,
							urun.baslik,
							urun.sef,
							urun.fiyat,
							urun.eski_fiyat,
							urun.kampanya_baslangic,
							urun.kampanya_bitis,
							urun_img.img
							FROM
							urun
							INNER JOIN urun_img ON urun.id = urun_img.urun_id
							WHERE
							urun.aktif = 1
							GROUP BY
							urun_img.urun_id
							ORDER BY RAND()
							LIMIT 7

                  ", PDO::FETCH_ASSOC);
        if($query->rowCount()){
          foreach($query as $row){
      ?>
      <div class="item">
        <div class="urun mt-15">
          <div class="kontrol">
              <span data-toggle="tooltip" data-placement="bottom" title="Sepete Ekle"><a href="urun/<?php echo $row['sef']; ?>" title="<?php echo $row['baslik']; ?>"><i class="las la-shopping-cart"></i></a></span>
              <span data-toggle="tooltip" data-placement="bottom" title="Favorilerime Ekle" data-favori-ekle="<?php echo $row['id']; ?>"><i class="las la-heart"></i></span>
              <span data-toggle="tooltip" data-placement="bottom" title="Karşılaştır" data-karsilastir-ekle="<?php echo $row['id']; ?>"><i class="las la-random"></i></span>
            </div>
            <a href="urun/<?php echo $row['sef']; ?>" title="<?php echo $row['baslik']; ?>"><img src="upload/<?php echo $row['img']; ?>" alt="<?php echo $row['baslik']; ?>" title="<?php echo $row['baslik']; ?>"></a>
            <?php if($row['kampanya_baslangic'] < $time AND $row['kampanya_bitis'] > $time){ ?>
            <div class="geri_ticifast" <?php echo 'data-tarih="'.date('m d Y H:i:s', $row['kampanya_bitis']).'"'; ?>>
                <span class="gun"></span>
                <span class="saat"></span>
                <span class="dakika"></span>
                <span class="saniye"></span>
                <span class="bitti"></<span>
            </div>
            <?php } ?>
            <a href="urun/<?php echo $row['sef']; ?>" class="link"><?php echo $row['baslik']; ?></a>
            <div class="fiyat">
              <?php if(!empty($row['eski_fiyat'])){ ?>
                <div class="eski">
                  <span><?php echo fiyat($row['eski_fiyat']); ?> TL</span>
                  <span>%<?php echo ceil((((float)$row['eski_fiyat'] - (float)$row['fiyat']) / (float)$row['eski_fiyat']) * 100);  ?></span>
                </div>
              <?php } ?>
                  <span class="guncel"><?php echo fiyat($row['fiyat']); ?> TL</span>
            </div>
        </div>
      </div>
      <?php } } ?>
    </div>

</div>
<style type="text/css">
.varyant_baslik{
    float: left;
    width: 100%;
    font-weight: bold;
    color: #fe576a;
    font-size: 14px;
    margin-bottom: 10px;
    margin-top: 20px;
}
.varyant_renk{
    width: 100%;
}
.varyant_renk li{
    width: 100px;
    margin-right: 10px;
}
.varyant_renk li a{
    border: 1px solid #ddd;
    padding: 10px;
    float: left;
    width: 100%;
}
.varyant_renk li a:hover{
    border: 1px solid orange;
}
</style>