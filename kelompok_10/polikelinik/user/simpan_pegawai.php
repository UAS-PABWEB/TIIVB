<?php
include "koneksi.php";
$NIP=$_POST['NIP'];
$namapeg=$_POST['namapeg'];
$almpeg=$_POST['almpeg'];
$telppeg=$_POST['telppeg'];
$tgllhrpeg=$_POST['tgllhrpeg'];
$jnskelpeg=$_POST['jnskelpeg'];

error_reporting (E_ALL ^ E_NOTICE);
if (empty($namapeg))

{	
	?><script language="javascript">alert("masukan nama!");location.href="javascript:history.back()";</script><?php 
} 
else
{
	$cekdata="select NIP from pegawai where NIP='$NIP'";
	$ada=mysql_query($cekdata) or die(mysql_error());
	if(mysql_num_rows($ada)>0)
	{ ?><script language="javascript">alert("NIP Pegawai Telah Terdaftar!");location.href="javascript:history.back()";</script><?php }
if (!empty($_FILES["photo"]["tmp_name"]))
				{
			$namafolder="photo/";  //tempat menyimpan file
    $jenis_gambar=$_FILES['photo']['type'];
    if($jenis_gambar=="image/jpeg"  || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png")
    {          
  $photo  = $namafolder . basename($_FILES['photo']['name']);      
  if  (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo))
  { die("Gambar gagal dikirim"); }
    } else  { die("Jenis gambar yang anda kirim salah. Harus .jpg .gif .png"); }
			}
		mysql_query("insert into pegawai(NIP, namapeg, almpeg, telppeg, tgllhrpeg, jnskelpeg)values('$NIP','$namapeg','$almpeg','$telppeg','$tgllhrpeg','$jnskelpeg')");
		?><script language="javascript">alert("Data berhasil di tambahkan!"); location.href="?page=data_pegawai";</script><?php
	}
?>		