<?php
session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
	if(!cek_login()){
		$_SESSION[login] = 0;
	}
}
if($_SESSION[login]==0){
  header('location:logout.php');
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Klinik dr. Nancy</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/template.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/themes/base/jquery.ui.dialog.css" />

<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />  
    <script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/blend/jquery.blend.js"></script>
	<script type="text/javascript" src="js/ui.sortable.js"></script>    
    <script type="text/javascript" src="js/ui.dialog.js"></script>
    <script type="text/javascript" src="js/effects.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.pack.js"></script>
<link rel="stylesheet" href="css/themes/base/jquery.ui.all.css" />
	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript">
        $(document).ready(function(){
  $('#eulaOpen').click(function() {
    openDialog('#eula');
  });
  $('#eula')
  .find('.ok, .cancel')
  .live('click', function() {
  	closeDialog(this);
  })
  .end()
  .find('.ok')
  .live( 'click', function(){
  	// Clicked Agree!
    console.log('clicked agree!');
  })
  .end()
  .find('.cancel')
  .live('click', function() {
  	// Clicked disagree!
    console.log('clicked disagree!');
  });
});

function openDialog(selector) {
	$(selector)
		.clone()
		.show()
		.appendTo('#overlay')
		.parent()
		.fadeIn('fast');
}
  
function closeDialog( selector ) {
$(selector)
	.parents('#overlay')
	.fadeOut('fast', function() {
		$(this)
			.find('.dialog')
			.remove();
	});
}
    </script>
 <script id="source" language="javascript" type="text/javascript" src="js/graphs.js"></script>
<style type="text/css">
.bungkus{
	width: 900px;
	margin-left: auto;
	margin-right: auto;	
	height: auto;
	}

</style>

</head>

<body>


<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Aplikasi Klinik dr. Nancy</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Assalamualaikum <a href="#" class="navbar-link"> <?php echo $_SESSION['user'];?> |  <a href="logout.php" class="btn-small btn-danger">Keluar</a></a>
            </p>
            <ul class="nav">
              <li class="active"><a href="media.php?mod=home">Beranda</a></li>
              <li><a href="mod.php?mod=pasien" >Pasien</a></li>
              <li><a href="mod.php?mod=obat" >Obat</a></li>
              <li><a href="mod.php?mod=riwayat">Riwayat Pasien</a></li>
              <li><a href="mod.php?mod=cari">Cari</a></li>
              <li><a href="mod.php?mod=cetak">Cetak</a></li>
              <li><a href="mod.php?mod=user" >Pengaturan</a></li>
<?php			  if($_SESSION["user"]=="admin"){ ?>
			  <li><a href="mod.php?mod=tambah">Tambah User</a></li>
<?php 			}?>			
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<!-- HIDDEN SUBMENU END -->  

<!-- CONTENT START -->
    <div class="grid_16" id="content">
    	<div class="bungkus">
    	<title>Riwayat Pasien</title>
<?
include("config/koneksi.php");
	$idpasien=$_GET['idpasien'];
	$noreg=$_GET['noreg'];
	$q=mysql_query("select * from tbl_pasien where noreg='$noreg' LIMIT 1");
	$dataku=mysql_fetch_object($q);
?>

<form action="aksiriwayat.php" method="post" enctype="multipart/form-data" name="FKoreksi">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#669900">
  <tr><p></p></tr>
    <tr>
      <td><p>-</p></td>
    </tr>
     <tr>
      <td><p></p></td>
    </tr>
        <tr>
     <td><strong><center><font color="#000" size="4px">Riwayat Pasien</font></center></strong></td>  </tr>
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-striped">
          <tr>
            <td width="99">noreg</td>
            <td width="9">:</td>
            <td width="287"><input name="noreg" type="text" id="noreg" size="10" maxlength="10" value="<?php echo $dataku->noreg?>" readonly=""></td>
      			 <td>alamat</td>
            <td>:</td>
            <td><input style="width:500px;height:30px;" type="alamat" name="alamat" id="alamat" value="<?php echo $dataku->alamat?>" readonly></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input name="namapasien" type="text" id="namapasien" size="30" maxlength="30" value="<?php echo $dataku->namapasien?>" readonly></td>
              <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
			
			<input name="jeniskel" id="jeniskel1" type="radio" value="laki-laki" <?php if($dataku->jeniskel=='laki-laki') echo "checked";?> ></input>
			<label for="jeniskel1">Laki - Laki</label>
			
              
              <input name="jeniskel" id="jeniskel2" type="radio" value="perempuan" <?php if($dataku->jeniskel=='perempuan') echo "checked";?> />
			  <label for="jeniskel1">Perempuan</label>
               </td>
          </tr>
          <tr>
           <tr>
      
  
            <td width="29%"><font size="2" face="verdana"><p>Telpon</p></font></td>
            <td>:</td>
            <td><input type="number" class="int" name="telpon" size="45" maxlength="45"/></td>
        </tr>
            
         <td>pekerjaan</td>
            <td>:</td>
            <td><input type="text" name="pekerjaan" id="pekerjaan" value="<?php echo $dataku->pekerjaan?>" readonly></td>
 				<td>nama kk</td>
            <td>:</td>
            <td><input type="text" name="namakk" id="namakk" value="<?php echo $dataku->namakk?> "readonly></td>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><input type="text" size="1" id="tgl" value="<?php echo $dataku->tgllhr?>" readonly></td>
            <td>Berat Badan</td>
            <td>:</td>
            <td><input type="text" name="berat" id="berat" value="<?php echo $dataku->berat?> "readonly></td>
          </tr>
   		<tr>
   		<td>Tinggi Badan</td>
            <td>:</td>
            <td><input type="text" name="tinggi" id="tinggi" value="<?php echo $dataku->tinggi?> "readonly></td>
            <td>Tanggal Daftar</td>
            <td>:</td>
            <td><input type="text" name="tgldaftar" id="tgldaftar" value="<?php echo $dataku->tgldaftar?> "readonly></td>
   		</tr>
        
          
      </table></td>
    </tr>
  </table>
</form>

<?php
    $aksi="aksiriwayat.php";
switch($_GET[act]){
  // Tampilkan pd tabel
  default:
include "config/koneksi.php";
 $idpasien=$_GET['idpasien'];
 $noreg=$_GET['noreg'];
 $idriwayat=$_GET['idriwayat'];
 $dataPerPage = 5;

// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut, 
// sedangkan apabila belum, nomor halamannya 1.

if(isset($_GET['page']))
{
    $noPage = $_GET['page'];
} 
else $noPage = 1;

// perhitungan offset

$offset = ($noPage - 1) * $dataPerPage;

// query SQL untuk menampilkan data perhalaman sesuai offset

$query = "SELECT  tbl_pasien.noreg,tbl_pasien.idpasien, tbl_riwayat.idriwayat, tbl_riwayat.riwayat, tbl_riwayat.keterangan from tbl_pasien,tbl_riwayat where tbl_pasien.idpasien='$idpasien' and tbl_riwayat.idpasien='$idpasien' LIMIT $offset, $dataPerPage";

$result = mysql_query($query) or die('Error');
 $jumq = "SELECT max(idriwayat) AS jumDataq FROM tbl_riwayat where idpasien='$_GET[idpasien]'";
$hasilxx = mysql_query($jumq);
$datamu=mysql_fetch_array($hasilxx);
$xx=$datamu['jumDataq'];
$jumqs="Select count(idriwayat) as jumDataqs from tbl_riwayat where idpasien='$_GET[idpasien]'";
$hasilqs=mysql_query($jumqs);
$datamuqs=mysql_fetch_array($hasilqs);
$qs=$datamuqs['jumDataqs'];
// menampilkan data 

echo "<table class='table table-striped'>";

echo "<th scope='col'>No.</th><th scope='col'>Riwayat</th><th scope='col'>Keterangan</th><th scope='col'>Aksi</th>";
while($data = mysql_fetch_array($result)){
$nomor++;
{
   echo "<tr><td>$nomor</td><td width=410>".$data['riwayat']."</td><td width=410>".$data['keterangan']."</td><td width=70 align=center><div class='btn-group'><a class=btn  href=view.php?act=edit&idriwayat=$data[idriwayat]&idpasien=$data[idpasien]&noreg=$data[noreg]>Edit</a> | 
	           <a class=btn href='$aksi?idriwayat=$data[idriwayat]&idpasien=$data[idpasien]&noreg=$data[noreg]&act=hapus' onClick=\"return confirm('Apakah Anda akan menghapusnya?')\">Hapus</a></div></td></tr>";
}}
echo"	 <div class='navbar'>
    <div class='navbar-inner'>
    
    <ul class='nav'>
    <li class='active'><a href='view.php?act=input&idpasien=$_GET[idpasien]&noreg=$_GET[noreg]&idriwayat=$xx' name=tambah type=submit>Tambah Riwayat</a></li>

	 <li><a href='#'> Jumlah Riwayat : $qs Riwayat</a></li>
    </ul>
    </div>
    </div>";
   
echo "</table>";


// mencari jumlah semua data dalam tabel guestbook

$query   = "SELECT COUNT(*) AS jumData FROM tbl_riwayat where idpasien='$idpasien'";
$hasil  = mysql_query($query);
$data     = mysql_fetch_array($hasil);

$jumData = $data['jumData'];

// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data

$jumPage = ceil($jumData/$dataPerPage);

// menampilkan link previous

if ($noPage > 1) echo  "<a href='".$_SERVER['PHP_SELF']."?idpasien=$idpasien&noreg=$noreg&page=".($noPage-1)."'>&lt;&lt; Prev</a>";

// memunculkan nomor halaman dan linknya

for($page = 1; $page <= $jumPage; $page++)
{
         if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) 
         {   
            if (($showPage == 1) && ($page != 2))  echo "..."; 
            if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
            if ($page == $noPage) echo " <b>".$page."</b> ";
            else echo " <a href='".$_SERVER['PHP_SELF']."?idpasien=$idpasien&noreg=$noreg&page=".$page."'>".$page."</a> ";
            $showPage = $page;          
         }
}

// menampilkan link next

if ($noPage < $jumPage) echo "<a href='".$_SERVER['PHP_SELF']."?idpasien=$idpasien&noreg=$noreg&page=".($noPage+1)."'>Next &gt;&gt;</a>";

break;
  case "edit":
  $noreg=$_GET['noreg'];
  $idpasien=$_GET['idpasien'];
  $edit = mysql_query("SELECT tbl_riwayat.riwayat,tbl_riwayat.idpasien,tbl_riwayat.idriwayat, tbl_riwayat.keterangan FROM tbl_riwayat WHERE  tbl_riwayat.idpasien='$_GET[idpasien]' and tbl_riwayat.idriwayat='$_GET[idriwayat]'");
    $r    = mysql_fetch_array($edit);
	
    echo "<h3 ><center>Edit Riwayat Pasien</center></h3>
          <form style='margin-left:30px;' method='POST' action='aksiriwayat.php?act=edit&idriwayat=$r[idriwayat]&idpasien=$r[idpasien]&noreg=$_GET[noreg]'>
          <input type=text name=idriwayat value=$r[idriwayat]>
          <input type=text name=idpasien value=$r[idpasien]>
          <input type=text name=noreg value=$regh[noreg]>
           <table>
   
		  <tr><td>Riwayat</td><td>     : </td><td><textarea name=riwayat style='width:600px;height:100px;'>$r[riwayat]</textarea></td></tr>
		  <tr><td>Keterangan</td><td>     : </td><td><textarea name=keterangan style='width:600px;height:100px;'>$r[keterangan]</textarea></td></tr>

		  ";
    echo "<tr><td></td><td><td colspan='2'><input type='submit' value='update' name=edit>
                            <input type='button' value='Batal' onclick='self.history.back()'></td></tr>
          </table>
		  </form>";
    break; 
    case "input":
  $noreg=$_GET['noreg'];
  $idpasien=$_GET['idpasien'];
  $yy=$_GET['idriwayat']+1;

	
    echo "<h3 ><center>Input Riwayat Pasien</center></h3>
          <form style='margin-left:30px;' method='POST' action='aksiriwayat.php?act=input&idpasien=$_GET[idpasien]&noreg=$_GET[noreg]'>
  
           <table>
           <input type=hidden name=idpasien value='$_GET[idpasien]'>
           <input type=hidden value='$_GET[noreg]'>
           <input type=hidden name=idriwayat value='$yy'>
		  <tr><td>Dokter</td><td>     : </td><td width=700><textarea name=dokter style='width:670px;height:100px;'></textarea></td></tr> 
		  <tr><td>Riwayat</td><td>     : </td><td width=700><textarea name=riwayat style='width:670px;height:100px;'></textarea></td></tr>
		  <tr><td>Keterangan</td><td>     : </td><td width=700><textarea name=keterangan style='width:670px;height:100px;'></textarea></td></tr>

		  ";
    echo "<tr><td></td><td><td colspan='2'><input type='submit' value='Save' name=input>
                            <input type='button' value='Batal' onclick='self.history.back()'></td></tr>
          </table>
		  </form>";
    break;   
}
?>

</div>
  <div class="clear"> </div>

  </div>


<div class="clear"> </div>

		<!-- This contains the hidden content for inline calls -->

</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<footer class="footer">
      <div class="container">
        <p>Designed and built with all the love in the world by <a href="http://twitter.com/gien_pratama" target="_blank">@gienpratama</a>.</p>
        <p>Code licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/" target="_blank">CC BY 3.0</a>.</p>
        <p><a href="http://glyphicons.com" target="_blank">Glyphicons Free</a> licensed under <a href="http://creativecommons.org/licenses/by/3.0/" target="_blank">CC BY 3.0</a>.</p>
        <ul class="footer-links">
          <li><a href="http://tokowigincommunity.blogspot.com" target="_blank">Blog</a></li>
          <li class="muted">&middot;</li>
          <li><a href="http://facebook.com/gien_rocklinux" target="_blank">Facebook</a></li>
          <li class="muted">&middot;</li>
          <li><a href="http://facebook.com/ngopre-x" target="_blank">Community</a></li>
        </ul>
      </div>
    </footer>

</body>
</html>

</body>
</html>