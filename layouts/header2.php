<header class="header trans_300" id="headerss">

		<!-- Top Navigation -->

		<div class="top_nav">
			<div class="container">
				<div class="row">
					<div class="col-12 text-right">
						<div class="top_nav_right">
							<ul class="top_nav_menu">

								<!-- Currency / Language / My Account -->

								<li class="language">
									<a href="#">
										Olshop
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="language_selection">
										<li><a href="https://www.tokopedia.com/potmefarm">Tokopedia</a></li>
										<li><a href="https://shopee.co.id/potmefarm">Shopee</a></li>
										<li><a href="https://www.blibli.com/search?s=potme&o=10&b=Potme+Farm">Blibli</a></li>
										<li><a href="https://www.bukalapak.com/u/potmefarm">Bukalapak</a></li>
									</ul>
								</li>
								<li class="account">
									<a href="#">
										Akun Saya
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="account_selection">
										<?php
											if (!empty($_COOKIE['Username'])) {
												echo "<li><a href='edituser.php'><i class='fa fa-user' aria-hidden='true'></i>".$_COOKIE['Username']."</a></li>";
												if ($_COOKIE['Level'] == 1) {
													echo "<li><a href='dashboard.php' style='font-size:12px;'><i class='fa fa-tachometer' aria-hidden='true'></i>Dashboard</a></li>";
												}
												echo "<li><a href='../process/handler.php?action=logout'><i class='fa fa-sign-out' aria-hidden='true'></i>Logout</a></li>";
											}
											else{
												echo "
												<li><a href='#' data-toggle='modal' data-target='#ModalLogin'><i class='fa fa-sign-in' aria-hidden='true'></i>Log in</a></li>
												<li><a href='register.php'><i class='fa fa-user-plus' aria-hidden='true'></i>Register</a></li>
												";
											}
										?>
										<!-- <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Log in</a></li>
										<li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a></li> -->
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Main Navigation -->

		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<a href="home.php">Potme <span style="color: limegreen">Farm</span></a>
						</div>
						<nav class="navbar">
							<ul class="navbar_menu">
								<li><a href="home.php#">home</a></li>
								<li><a href="toko.php">toko</a></li>
								<li><a href="artikel.php">Artikel</a></li>
								<li><a href="home.php#kontakkami">Kontak Kami</a></li>
								<li><a href="paketkursus.php">Paket Kursus</a></li>
							</ul>
							<ul class="navbar_user">
								<li class="checkout">
										<?php
											error_reporting(0);
											$KodeUser = $_COOKIE['KodeUser'];
											if (empty($KodeUser)) {
												echo "
													<a href='javascript:void(0);' onclick='alert(`Login terlebih dahulu !`);' title='Keranjang'>
												";
											}
											else{
												echo "<a href='keranjang.php' title='Keranjang'>";
											}
											$sql = mysqli_query($process->cnt,"SELECT * FROM tbtransaksiproduk WHERE KodePelanggan = '$KodeUser' AND StatusTransaksi = '' ");
											$count = mysqli_num_rows($sql);
											if ($count > 0) {
												echo "<span id='checkout_items' class='checkout_items'>$count</span>";
											}
										?>
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
									</a>
								</li>
								<li class="checkout">
									<?php
										error_reporting(0);
										$KodeUser = $_COOKIE['KodeUser'];
					                    $sql = mysqli_query($process->cnt,"SELECT * FROM tbtransaksiproduk WHERE StatusTransaksi = 'Sudah Order' AND KodePelanggan = '$KodeUser' ORDER BY NoTransaksi DESC");
					                    $sql2 = mysqli_query($process->cnt,"SELECT * FROM tbpesankursus WHERE StatusKursus = 'Sudah Order' AND KodePelanggan = '$KodeUser' ORDER BY NoTransaksi DESC");
					                    $no = 0;
					                    $sementara = "";  

					                    while($res = mysqli_fetch_array($sql)){
					                      $time1 = date($res['TglOrder']);
					                      $time2 = date('Y-m-d',strtotime('+0 days', strtotime($time1)));
					                      $time4 = date('Y-m-d',strtotime('+1 days', strtotime($time1)));
					                      $time3 = date($process->ThisFullDate);

					                      if ( $time3 == $time2 || $time3 == $time4){
					                        $sementara = $res['NoTransaksi'];
					                        $no++;
					                        $link = 'tagihan';
					                      }
					                    }
					                    while($res2 = mysqli_fetch_array($sql2)){
					                      $time1 = date($res2['TglOrder']);
					                      $time2 = date('Y-m-d',strtotime('+0 days', strtotime($time1)));
					                      $time4 = date('Y-m-d',strtotime('+1 days', strtotime($time1)));
					                      $time3 = date($process->ThisFullDate);

					                      if ( $time3 == $time2 || $time3 == $time4){
					                        $sementara2 = $res2['NoTransaksi'];
					                        $no++;
					                        $link2 = 'pesananpaketkursus';
					                      }					                        
					                    }
										if ($no > 0) {
											echo "
												<a href='".$link.$link2.".php?nt=".$sementara.$sementara2."' title='Tagihan'>
												<span id='checkout_items' class='checkout_items'></span>";
										}
										else if (!empty($_COOKIE['KodeUser'])){
											echo "<a href='javascript:void(0);' onclick='alert(`Tagihan anda kosong !`);' title='Tagihan'>";
										}
										else{
											echo "<a href='javascript:void(0);' onclick='alert(`Login terlebih dahulu !`);' title='Tagihan'>";
										}
									?>
										<i class="fa fa-dollar-sign" aria-hidden="true"></i>
									</a>
								</li>

								<li class="checkout">
									<?php
										error_reporting(0);
										if (!empty($_COOKIE['KodeUser'])) {
											echo "
												<a href='datatransaksi.php' title='Transaksi'>
											";
										}
										else if(empty($_COOKIE['KodeUser'])){
											echo "<a href='javascript:void(0);' onclick='alert(`Login terlebih dahulu !`);' title='Transaksi'>";
										}
									?>
										<i class="fa fa-list-alt" aria-hidden="true"></i>
									</a>
								</li>
							</ul>
							<div class="hamburger_container">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>

	</header>

	<div class="fs_menu_overlay"></div>
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true" id="navbarResClose"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li class="menu_item has-children">
					<a href="#">
						Olshop
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="menu_selection">
						<li><a href="https://www.tokopedia.com/potmefarm">Tokopedia</a></li>
						<li><a href="https://shopee.co.id/potmefarm">Shopee</a></li>
						<li><a href="https://www.blibli.com/search?s=potme&o=10&b=Potme+Farm">Blibli</a></li>
						<li><a href="https://www.bukalapak.com/u/potmefarm">Bukalapak</a></li>
					</ul>
				</li>
				<li class="menu_item has-children">
					<a href="#">
						Akun Saya
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="menu_selection">
						<?php
							if (!empty($_COOKIE['Username'])) {
								echo "<li><a href='edituser.php'onclick=`$('#navbarResClose').click()`><i class='fa fa-user' aria-hidden='true'></i>".$_COOKIE['Username']."</a></li>";
								if ($_COOKIE['Level'] == 1) {
									echo "<li><a href='dashboard.php'onclick=`$('#navbarResClose').click()`><i class='fa fa-tachometer' aria-hidden='true'></i>Dashboard</a></li>";
								}
								echo "<li><a href='../process/handler.php?action=logout'><i class='fa fa-sign-out' aria-hidden='true'></i>Logout</a></li>";
							}
							else{
								echo "
								<li><a href='#' onclick=`$('#navbarResClose').click()` data-toggle='modal' data-target='#ModalLogin'><i class='fa fa-sign-in' aria-hidden='true'></i>Log in</a></li>
								<li><a href='register.php'><i class='fa fa-user-plus' aria-hidden='true'></i>Register</a></li>
								";
							}
						?>
					</ul>
				</li>
				<li class="menu_item has-children">
					<a href="#">
						Kategori
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="menu_selection">
							<?php
								$sql=mysqli_query($process->cnt, "SELECT NamaJenis,KodeJenis FROM tbjenisproduk");
								while ($res = mysqli_fetch_array($sql)) {
									echo "
										<li><a href='?k=$res[1]'>$res[0]</a></li>
									";
								}
							?>
					</ul>
				</li>
				<li class="menu_item"><a onclick="$('#navbarResClose').click()" aria-hidden='true' href="home.php#">home</a></li>
				<li class="menu_item"><a onclick="$('#navbarResClose').click()" aria-hidden='true' href="toko.php">toko</a></li>
				<li class="menu_item"><a onclick="$('#navbarResClose').click()" aria-hidden='true' href="artikel.php">Artikel</a></li>
				<li class="menu_item"><a onclick="$('#navbarResClose').click()" aria-hidden='true' href="home.php#kontakkami">Kontak Kami</a></li>
				<li class="menu_item"><a onclick="$('#navbarResClose').click()" aria-hidden='true' href="paketkursus.php">Paket Kursus</a></li>
			</ul>
		</div>
	</div>
<div id="ModalLogin" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4>Login</h4>
        <a href="jenisproduk.php"><button type="button" class="close" data-dismiss="modal">&times;</button></a>
      </div>
      <form action="../process/handler.php?action=login" method="post">
        <div class="modal-body">
          <div class="inputBox" id="UsernameBox">
            <label for="Username" class="inputBoxLabel"><i class="fa fa-user"></i> Username</label>
            <input type="text" id="Username" name="Username" onblur="formAni('UsernameBox')" onfocus="formAni2('UsernameBox')" class="form form-control" required autocomplete="off" style="color: #000;">
          </div>
          <br>
          <div class="inputBox" id="PasswordBox" style="position: relative;">
            <label for="Password" class="inputBoxLabel"><i class="fa fa-lock"></i> Password</label>
            <input type="password" id="Password" name="Password" onblur="formAni('PasswordBox')" onfocus="formAni2('PasswordBox')" class="form form-control" required autocomplete="off" style="color: #000;">
            <i class="fa fa-eye" id="passwordeye" style="position: absolute;right: 15px;top: 12px;font-size: 16px;color: #aaa;cursor: pointer;`" onclick="showPassword('passwordeye')"></i>
          </div>
        </div>
        <div class="modal-body">
        	Lupa password ? <a href="lupapassword.php">klik sini</a><br>
        	Belum punya akun ? <a href="register.php">klik sini</a><br><br>
        	<a href="https://api.whatsapp.com/send?phone=6281398610805&text=Halo%20Potme%20Farm,%20mau%20bertanya%20tentang%20produknya" style="color: limegreen;padding: 5px;border: 1px solid limegreen;">
				<i class="fa fa-whatsapp"></i> &nbsp;Beli via Whatsapp
			</a>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-default">Login</button>
          <a href="jenisproduk.php"><button type="button" class="btn btn-default" data-dismiss="modal">Batal</button></a>
        </div>
      </form>
    </div>
  </div>
</div>
	<script>
		function showPassword(x){
			$('#'+x).toggleClass('fa-eye-slash');
			var z = $('#Password').attr('type');
			if (z == 'text') {
				$('#Password').attr('type','password');
			}
			else if (z == 'password') {
				$('#Password').attr('type','text');
			}
		}
	</script>
	<script src="../public/js/footer-script.js"></script>